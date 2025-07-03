<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AppController
{

    public function app(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('app');
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $archived = $request->query('archived', 0);
        $query = User::query()->where('archived', $archived);
        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone_number', 'LIKE', "%{$search}%");
            });
        }
        $sortBy = $request->query('sort_by');
        $sortOrder = strtolower($request->query('sort_order', 'asc')) === 'desc' ? 'desc' : 'asc';
        $allowedSorts = ['id', 'name', 'email', 'phone_number'];

        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('id', $sortOrder);
        }
        $limit = 20;
        $perPage = (int) $request->query('per_page', $limit);
        if ($perPage < 1) {
            $perPage = $limit;
        }
        $users = $query->paginate($perPage);
        return response()->json($users);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = Str::uuid().'.'.$image->getClientOriginalExtension();
            $path = $image->storeAs('images', $filename, 'public');
            $validated['image'] = $path;
        }

        $user = User::create($validated);

        return response()->json([
            'message' => 'User created successfully',
            'data' => $user,
        ]);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:users,email,' . $id,
            'phone_number' => 'nullable|string',
            'image' => 'nullable',
            'remove_image' => 'nullable|boolean',
        ]);
        if ($request->has('remove_image') && $request->remove_image) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            $validated['image'] = null;
        }
        if ($request->hasFile('image')) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            $image = $request->file('image');
            $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('images', $filename, 'public');
            $validated['image'] = $path;
        }
        $user->update($validated);
        return response()->json([
            'message' => 'User updated successfully',
            'data' => $user,
        ]);
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $user = User::findOrFail($id);
        if ($user->image && Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }
        $user->delete();
        return response()->json([
            'message' => 'User deleted successfully',
        ]);
    }

    public function archive($id): \Illuminate\Http\JsonResponse
    {
        $user = User::findOrFail($id);
        $user->archived = true;
        $user->save();

        return response()->json([
            'message' => 'User archived successfully.',
        ]);
    }

    public function unArchive($id): \Illuminate\Http\JsonResponse
    {
        $user = User::findOrFail($id);
        $user->archived = false;
        $user->save();

        return response()->json([
            'message' => 'User unarchived successfully.',
        ]);
    }

    public function clear(): \Illuminate\Http\JsonResponse
    {
        $users = User::all();
        foreach ($users as $user) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
        }
        User::truncate();
        return response()->json([
            'message' => 'All users deleted successfully.',
        ]);
    }

}
