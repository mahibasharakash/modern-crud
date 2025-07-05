<template>

    <div class="w-full px-10 mx-auto py-5">

        <!-- header -->
        <div class="w-full sm:flex justify-between items-center mb-5">
            <div class="text-[21px] font-bold mb-4 sm:mb-0">
                <router-link :to="{name:'index'}" class="decoration-0 text-black"> Crud </router-link>
            </div>
            <div class="flex justify-end gap-2 flex-wrap">

                <template v-if="tableData.length > 0 && !loading && selectUserId.length > 0">
                    <div class="flex justify-end items-center gap-3">
                        <button type="button" v-if="archived === 0" class="min-w-[45px] max-w-[45px] min-h-[45px] max-h-[45px] rounded-lg bg-blue-200 duration-500 hover:bg-blue-600 group inline-flex cursor-pointer justify-center items-center" @click="openArchiveModal()">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="stroke-blue-500 duration-500 group-hover:stroke-white min-w-[21px] max-w-[21px] min-h-[21px] max-h-[21px]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                            </svg>
                        </button>
                        <button type="button" v-if="archived === 1" class="min-w-[45px] max-w-[45px] min-h-[45px] max-h-[45px] rounded-lg bg-blue-200 duration-500 hover:bg-blue-600 group inline-flex cursor-pointer justify-center items-center" @click="openUnArchiveModal()">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="stroke-blue-500 duration-500 group-hover:stroke-white min-w-[21px] max-w-[21px] min-h-[21px] max-h-[21px]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                            </svg>
                        </button>
                        <button type="button" class="min-w-[45px] max-w-[45px] min-h-[45px] max-h-[45px] rounded-lg bg-red-300 duration-500 hover:bg-red-600 group inline-flex cursor-pointer justify-center items-center" @click="openDeleteModal()">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="stroke-rose-500 duration-500 group-hover:stroke-white min-w-[21px] max-w-[21px] min-h-[21px] max-h-[21px]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                            </svg>
                        </button>
                    </div>
                </template>

                <input type="text" name="search" v-model="search" @input="searchData()" class="w-full text-[14px] w-full sm:min-w-[210px] sm:max-w-[210px] text-[13px] border border-gray-200 min-h-[45px] max-h-[45px] duration-500 ring-0 outline-0 focus-within:ring-2 focus-within:ring-gray-400 rounded-md px-3 appearance-none" required autocomplete="off" placeholder="Search Here" />

                <div class="relative w-full sm:min-w-[90px] sm:max-w-[90px]">
                    <select name="limit" v-model="perPage" @change="limitChange()" class="w-full text-[14px] border border-gray-200 min-h-[45px] max-h-[45px] duration-500 ring-0 outline-0 focus-within:ring-2 focus-within:ring-gray-400 rounded-md px-3 cursor-pointer appearance-none">
                        <option v-for="n in limits" :key="n" :value="n"> {{ n }} </option>
                    </select>
                    <div class="absolute end-0 top-0 bottom-0 pe-4 flex justify-end items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" class="stroke-gray-700 min-w-[15px] min-h-[15px] max-w-[15px] max-h-[15px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </div>

                <div class="relative w-full sm:min-w-[210px] sm:max-w-[210px]">
                    <select name="sort_by" v-model="sort_by" @change="sortChange()" class="w-full text-[14px] border border-gray-200 min-h-[45px] max-h-[45px] duration-500 ring-0 outline-0 focus-within:ring-2 focus-within:ring-gray-400 rounded-md px-3 cursor-pointer appearance-none">
                        <option :value="''"> Select Sort Column </option>
                        <option :value="'name'"> Name </option>
                        <option :value="'email'"> Email </option>
                        <option :value="'phone_number'"> Phone Number </option>
                    </select>
                    <div class="absolute end-0 top-0 bottom-0 pe-4 flex justify-end items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" class="stroke-gray-700 min-w-[15px] min-h-[15px] max-w-[15px] max-h-[15px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </div>

                <div class="relative w-full sm:min-w-[210px] sm:max-w-[210px]">
                    <select name="archived" v-model="archived" @change="sortChange()" class="w-full text-[14px] border border-gray-200 min-h-[45px] max-h-[45px] duration-500 ring-0 outline-0 focus-within:ring-2 focus-within:ring-gray-400 rounded-md px-3 cursor-pointer appearance-none">
                        <option :value="0"> Normal List </option>
                        <option :value="1"> Archive List </option>
                    </select>
                    <div class="absolute end-0 top-0 bottom-0 pe-4 flex justify-end items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" class="stroke-gray-700 min-w-[15px] min-h-[15px] max-w-[15px] max-h-[15px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </div>

                <div class="relative w-full sm:min-w-[210px] sm:max-w-[210px]">
                    <select name="sort_order" v-model="sort_order" @change="sortChange()" class="w-full text-[14px] border border-gray-200 min-h-[45px] max-h-[45px] duration-500 ring-0 outline-0 focus-within:ring-2 focus-within:ring-gray-400 rounded-md px-3 cursor-pointer appearance-none">
                        <option value="asc"> Ascending </option>
                        <option value="desc"> Descending </option>
                    </select>
                    <div class="absolute end-0 top-0 bottom-0 pe-4 flex justify-end items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" class="stroke-gray-700 min-w-[15px] min-h-[15px] max-w-[15px] max-h-[15px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </div>

                <button type="button" class="bg-red-400 text-white outline-0 border-0 w-full sm:max-w-[100px] sm:min-w-[100px] cursor-pointer py-2 inline-block rounded-lg text-white" @click="openTruncateModal()">
                    <span class="text-[14px]"> Clear </span>
                </button>

                <button type="button" class="bg-gray-700 text-white outline-0 border-0 w-full sm:max-w-[100px] sm:min-w-[100px] cursor-pointer py-2 inline-block rounded-lg" @click="openManageModal(null)">
                    <span class="text-[14px]"> Create </span>
                </button>

            </div>
        </div>

        <div class="w-full flex justify-start items-center gap-2">
            <router-link :to="{name:'login'}" class="decoration-0 text-black">
                login
            </router-link>
            <router-link :to="{name:'registration'}" class="decoration-0 text-black">
                registration
            </router-link>
            <router-link :to="{name:'forgot'}" class="decoration-0 text-black">
                forgot
            </router-link>
            <router-link :to="{name:'reset'}" class="decoration-0 text-black">
                reset
            </router-link>
            <router-link :to="{name:'verification'}" class="decoration-0 text-black">
                verification
            </router-link>
        </div>

        <template v-if="!loading & tableData.length > 0">

            <!-- table data -->
            <div class="w-full max-h-[calc(100vh-200px)] min-h-[calc(100vh-200px)] overflow-y-auto pe-2">
                <table class="table-auto w-full text-[14px]">
                    <thead>
                    <tr>
                        <th class="font-medium text-[14px]" colspan="4">
                            <div class="flex justify-start items-center">
                                <div class="px-5 max-h-[70px] min-h-[70px] flex justify-start items-center rounded-s-xl bg-gray-100 min-w-1/4">
                                    <label for="check-all" class="inline-flex mb-0 justify-start items-center">
                                        <input id="check-all" type="checkbox" hidden="hidden" :checked="allData.length > 0 && allData.length === selectUserId.length" @change="selectAllUser($event)">
                                        <span class="min-w-[20px] min-h-[20px] max-w-[20px] max-h-[20px] p-0 m-0 inline-flex justify-center items-center rounded-md border border-gray-400">
                                            <svg v-if="allData.length > 0 && allData.length === selectUserId.length" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 25 25" stroke-width="6" stroke="currentColor" class="stroke-gray-600 min-w-[14px] min-h-[14px] max-w-[14px] max-h-[14px]">
                                                          <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                                        </svg>
                                        </span>
                                        <span class="ms-3"> Name </span>
                                    </label>
                                </div>
                                <div class="px-5 max-h-[70px] min-h-[70px] flex justify-start items-center rounded-0 bg-gray-100 min-w-1/4">
                                    Email
                                </div>
                                <div class="px-5 max-h-[70px] min-h-[70px] flex justify-start items-center rounded-0 bg-gray-100 min-w-1/4">
                                    Phone Number
                                </div>
                                <div class="px-5 max-h-[70px] min-h-[70px] flex justify-end items-center rounded-e-xl bg-gray-100 min-w-1/4">
                                    Action
                                </div>
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(each, index) in tableData" :key="each.id">
                        <td class="font-normal text-[14px]" colspan="4">
                            <div class="flex justify-start items-center mt-2">
                                <div class="px-5 flex justify-start items-center max-h-[70px] min-h-[70px] rounded-s-xl bg-gray-100 min-w-1/4">
                                    <label :for="'check-separated-'+each.id" class="inline-flex mb-0 justify-start items-center">
                                        <input :id="'check-separated-'+each.id" type="checkbox" hidden="hidden" :checked="checkIfChecked(each.id)" @change="selectUser($event, each.id)">
                                        <span class="min-w-[20px] min-h-[20px] max-w-[20px] max-h-[20px] p-0 m-0 inline-flex justify-center items-center rounded-md border border-gray-400">
                                            <template v-if="checkIfChecked(each.id)">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 25 25" stroke-width="6" stroke="currentColor" class="stroke-gray-600 min-w-[14px] min-h-[14px] max-w-[14px] max-h-[14px]">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                                </svg>
                                            </template>
                                        </span>
                                        <span class="ms-3 inline-flex justify-start items-center">
                                            <span v-if="!each.image" class="min-w-[55px] min-h-[55px] max-w-[55px] max-h-[55px] bg-gray-300 rounded-full text-[15px] inline-flex justify-center items-center">
                                                {{shortName(each.name)}}
                                            </span>
                                            <img v-if="each.image" :src="'storage/'+each.image" class="min-w-[55px] min-h-[55px] max-w-[55px] max-h-[55px] object-cover bg-cover rounded-full" alt="image" />
                                            <span class="ms-3"> {{ each.name }} </span>
                                        </span>
                                    </label>
                                </div>
                                <div class="px-5 flex justify-start items-center max-h-[70px] min-h-[70px] rounded-0 bg-gray-100 min-w-1/4">
                                    {{ each.email }}
                                </div>
                                <div class="px-5 flex justify-start items-center max-h-[70px] min-h-[70px] rounded-0 bg-gray-100 min-w-1/4">
                                    {{ each.phone_number }}
                                </div>
                                <div class="px-5 flex justify-end items-center max-h-[70px] min-h-[70px] rounded-e-xl bg-gray-100 min-w-1/4">
                                    <div class="relative">
                                        <button type="button" class="min-w-[45px] max-w-[45px] min-h-[45px] max-h-[45px] bg-gray-200 duration-500 hover:bg-gray-900 group inline-flex justify-center items-center rounded-full cursor-pointer" @click.stop="toggleDropdown(index)">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="stroke-gray-600 duration-500 group-hover:stroke-white min-w-[18px] max-w-[18px] min-h-[18px] max-h-[18px]">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                                            </svg>
                                        </button>
                                        <div class="absolute top-auto end-0 bg-white mt-2 rounded-xl z-3 min-w-[150px] overflow-hidden duration-500 shadow-sm" :class="{ 'max-h-[0]' : !isDropdownActive(index), 'max-h-[300px]' : isDropdownActive(index) }">
                                            <ul class="p-2">
                                                <li>
                                                    <button type="button" v-if="archived === 1" class="w-full outline-0 text-start cursor-pointer py-2 px-3 block duration-500 bg-transparent duration-500 hover:bg-gray-300 rounded-md" @click="openUnArchiveModal(each.id)">
                                                        UnArchive
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" v-if="archived === 0" class="w-full outline-0 text-start cursor-pointer py-2 px-3 block duration-500 bg-transparent duration-500 hover:bg-gray-300 rounded-md" @click="openArchiveModal(each.id)">
                                                        Archive
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" v-if="archived === 0" class="w-full outline-0 text-start cursor-pointer py-2 px-3 block duration-500 bg-transparent duration-500 hover:bg-gray-300 rounded-md" @click="openManageModal(each.id)">
                                                        Edit
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" v-if="archived === 0" class="w-full outline-0 text-start cursor-pointer py-2 px-3 block duration-500 bg-transparent duration-500 hover:bg-gray-300 rounded-md" @click="openDeleteModal(each.id)">
                                                        Delete
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </template>

        <div v-if="!loading & tableData.length === 0">

            <!-- no records found -->
            <div class="w-full min-h-[calc(100vh-200px)] text-[21px] bg-gray-100 rounded-xl text-gray-600 flex justify-center items-center">
                No records found.
            </div>

        </div>

        <template v-if="loading">

            <!-- loading -->
            <div class="w-full min-h-[calc(100vh-200px)] bg-gray-100 rounded-xl text-gray-600 flex justify-center items-center">
                <span class="inline-block rounded-full min-w-[45px] max-w-[45px] min-h-[45px] max-h-[45px] border-2 border-green-800 border-t-transparent animate-spin"></span>
            </div>

        </template>

        <template v-if="!loading & tableData.length > 0">

            <div class="w-full flex justify-between gap-3 mt-5">

                <!-- pagination -->
                <div class="flex justify-center items-center gap-2">
                    <button type="button" class="cursor-pointer min-w-[45px] min-h-[45px] max-w-[45px] max-h-[45px] inline-flex justify-center items-center rounded-full bg-gray-200 outline-0" :class="{ 'pointer-events-none' : currentPage <= 1 }" @click="goPrevious()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="min-w-[15px] min-h-[15px] max-w-[15px] max-h-[15px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                        </svg>
                    </button>
                    <template v-if="pageCount <= 4">
                        <button v-for="page in pageCount" :key="page" type="button" class="cursor-pointer min-w-[45px] min-h-[45px] max-w-[45px] max-h-[45px] inline-flex justify-center items-center rounded-full outline-0" :class="page === currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200 text-black'" @click="changePage(page)">
                            {{ page }}
                        </button>
                    </template>
                    <template v-else>
                        <button type="button" :key="1" class="cursor-pointer min-w-[45px] min-h-[45px] max-w-[45px] max-h-[45px] inline-flex justify-center items-center rounded-full outline-0" :class="1 === currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200 text-black'" @click="changePage(1)">
                            1
                        </button>
                        <template v-if="currentPage <= 3">
                            <button v-for="page in [2,3]" :key="page" type="button" class="cursor-pointer min-w-[45px] min-h-[45px] max-w-[45px] max-h-[45px] inline-flex justify-center items-center rounded-full outline-0" :class="page === currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200 text-black'" @click="changePage(page)">
                                {{ page }}
                            </button>
                            <span class="px-2">…</span>
                        </template>
                        <template v-else-if="currentPage >= pageCount - 2">
                            <span class="px-2">…</span>
                            <button v-for="page in [pageCount - 2, pageCount - 1]" :key="page" type="button" class="cursor-pointer min-w-[45px] min-h-[45px] max-w-[45px] max-h-[45px] inline-flex justify-center items-center rounded-full outline-0" :class="page === currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200 text-black'" @click="changePage(page)">
                                {{ page }}
                            </button>
                        </template>
                        <template v-else>
                            <span class="px-2">…</span>
                            <button :key="currentPage - 1" type="button" class="cursor-pointer min-w-[45px] min-h-[45px] max-w-[45px] max-h-[45px] inline-flex justify-center items-center rounded-full outline-0" :class="(currentPage - 1) === currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200 text-black'" @click="changePage(currentPage - 1)">
                                {{ currentPage - 1 }}
                            </button>
                            <button :key="currentPage" type="button" class="cursor-pointer min-w-[45px] min-h-[45px] max-w-[45px] max-h-[45px] inline-flex justify-center items-center rounded-full outline-0" :class="currentPage === currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200 text-black'" @click="changePage(currentPage)">
                                {{ currentPage }}
                            </button>
                            <span class="px-2">…</span>
                        </template>
                        <button :key="pageCount" type="button" class="cursor-pointer min-w-[45px] min-h-[45px] max-w-[45px] max-h-[45px] inline-flex justify-center items-center rounded-full outline-0" :class="pageCount === currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200 text-black'" @click="changePage(pageCount)">
                            {{ pageCount }}
                        </button>
                    </template>
                    <button type="button" class="cursor-pointer min-w-[45px] min-h-[45px] max-w-[45px] max-h-[45px] inline-flex justify-center items-center rounded-full bg-gray-200 outline-0" :class="{ 'pointer-events-none' : currentPage >= pageCount }" @click="goNext()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                             stroke="currentColor" class="min-w-[15px] min-h-[15px] max-w-[15px] max-h-[15px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                        </svg>
                    </button>
                </div>

                <!-- count page -->
                <div> {{ from }} – {{ to }} of {{ total }} </div>

            </div>

        </template>

    </div>

    <!-- manage modal -->
    <section class="fixed inset-0 grid sm:justify-center items-center duration-500 z-50 p-5 overflow-y-auto" :class="{ 'invisible bg-black/35' : !isManageModalActive, 'visible bg-black/65' : isManageModalActive }" @click="closeManageModal()">
        <form @submit.prevent="manageApi()" class="bg-white rounded-3xl w-full sm:max-w-[550px] sm:min-w-[550px] p-10 duration-500 origin-top" :class="{ 'translate-y-0 opacity-100' : isManageModalActive, '-translate-y-1/2 opacity-0' : !isManageModalActive }" @click.stop>
            <div class="flex justify-between items-center">
                <div class="font-medium text-[21px]">
                    <template v-if="!formData.id"> Create</template> <template v-if="formData.id"> Edit</template> Crud
                </div>
                <button type="button" class="bg-transparent duration-500 hover:bg-gray-200 text-white min-w-[45px] max-w-[45px] min-h-[45px] max-h-[45px] rounded-full inline-flex justify-center items-center cursor-pointer" @click="closeManageModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#000" class="min-w-[20px] max-w-[20px] min-h-[20px] max-h-[20px]">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="w-full block mb-3">
                <div class="flex justify-center items-center">
                    <label for="upload-file" class="min-w-[190px] max-w-[190px] min-h-[190px] max-h-[190px] rounded-full cursor-pointer bg-gray-200 duration-500 hover:bg-gray-300 max-h-[250px] inline-flex justify-center items-center" v-if="!attach_preview">
                        <input type="file" name="upload-file" id="upload-file" hidden="hidden" @change="attachFile($event)">
                        <span class="text-[14px] font-medium"> Upload File </span>
                    </label>
                    <div class="relative" v-if="attach_preview">
                        <img :src="attach_preview" class="min-w-[190px] max-w-[190px] min-h-[190px] max-h-[190px] rounded-full cursor-pointer bg-gray-200 duration-500 hover:bg-gray-300 max-h-[250px] object-cover bg-cover" alt="uploaded-image"/>
                        <div class="absolute inset-0 w-full h-full flex justify-center items-center bg-white/25">
                            <button type="button" class="min-w-[45px] max-w-[45px] min-h-[45px] max-h-[45px] bg-rose-200 inline-flex justify-center items-center rounded-full cursor-pointer" @click="removeFile()">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="stroke-rose-600 min-w-[15px] max-w-[15px] min-h-[15px] max-h-[15px]">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="w-full block mb-3">
                    <label for="name" class="block mb-1 text-[13px] font-medium"> Name </label>
                    <input id="name" type="text" name="name" v-model="formData.name" class="w-full text-[13px] border border-gray-200 min-h-[45px] max-h-[45px] duration-500 ring-0 outline-0 focus-within:ring-2 focus-within:ring-blue-400 rounded-md px-3" autocomplete="off"/>
                    <div class="text-rose-600 mt-2 text-[14px] font-medium" v-if="error?.name"> {{ error?.name[0] }} </div>
                </div>
                <div class="w-full block mb-3">
                    <label for="email" class="block mb-1 text-[13px] font-medium"> Email </label>
                    <input id="email" type="email" name="email" v-model="formData.email" class="w-full text-[13px] border border-gray-200 min-h-[45px] max-h-[45px] duration-500 ring-0 outline-0 focus-within:ring-2 focus-within:ring-blue-400 rounded-md px-3" autocomplete="off"/>
                    <div class="text-rose-600 mt-2 text-[14px] font-medium" v-if="error?.email"> {{ error?.email[0] }} </div>
                </div>
                <div class="w-full block">
                    <label for="phone_number" class="block mb-1 text-[13px] font-medium"> Phone Number </label>
                    <input id="phone_number" type="text" name="phone_number" v-model="formData.phone_number" class="w-full text-[13px] border border-gray-200 min-h-[45px] max-h-[45px] duration-500 ring-0 outline-0 focus-within:ring-2 focus-within:ring-blue-400 rounded-md px-3" autocomplete="off"/>
                    <div class="text-rose-600 mt-2 text-[14px] font-medium" v-if="error?.phone_number"> {{ error?.phone_number[0] }} </div>
                </div>
            </div>
            <div class="flex justify-end items-center gap-3">
                <button type="button" class="bg-gray-200 duration-500 text-gray-900 inline-flex justify-center items-center gap-1 hover:bg-gray-300 min-h-[45px] max-h-[45px] min-w-[100px] max-w-[100px] rounded-xl text-[14px] font-medium cursor-pointer" @click="closeManageModal()">
                    Cancel
                </button>
                <button type="submit" class="bg-green-200 duration-500 inline-flex justify-center items-center gap-1 hover:bg-green-300 text-green-800 min-h-[45px] max-h-[45px] min-w-[100px] max-w-[100px] rounded-xl text-[14px] font-medium cursor-pointer" v-if="!manageLoading">
                    <template v-if="!formData.id">
                        Save
                    </template>
                    <template v-if="formData.id">
                        Update
                    </template>
                </button>
                <button type="button" class="bg-green-200 duration-500 inline-flex justify-center items-center gap-1 hover:bg-green-300 text-green-800 min-h-[45px] max-h-[45px] min-w-[100px] max-w-[100px] rounded-xl text-[14px] font-medium cursor-pointer" v-if="manageLoading">
                    <span class="inline-block rounded-full min-w-[16px] max-w-[16px] min-h-[16px] max-h-[16px] border-2 border-green-800 border-t-transparent animate-spin"></span>
                </button>
            </div>
        </form>
    </section>

    <!-- delete modal -->
    <section class="fixed inset-0 grid sm:justify-center items-center duration-500 z-50 p-5 overflow-y-auto" :class="{ 'invisible bg-black/35' : !isDeleteModalActive, 'visible bg-black/65' : isDeleteModalActive }" @click="closeDeleteModal()">
        <form @submit.prevent="deleteApi()" class="bg-white rounded-3xl w-full sm:max-w-[400px] sm:min-w-[400px] py-10 px-5 duration-500 origin-top" :class="{ 'translate-y-0 opacity-100' : isDeleteModalActive, '-translate-y-1/2 opacity-0' : !isDeleteModalActive }" @click.stop>
            <div class="w-full flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="stroke-rose-500 min-w-[45px] max-w-[45px] min-h-[45px] max-h-[45px]">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                </svg>
            </div>
            <div class="text-center text-[18px] my-5"> Are you Permanent <br> Delete surely? </div>
            <div class="w-full flex justify-center items-center gap-3">
                <button type="button" class="bg-gray-200 duration-500 text-gray-900 inline-flex justify-center items-center gap-1 hover:bg-gray-300 min-h-[45px] max-h-[45px] min-w-[100px] max-w-[100px] rounded-xl text-[14px] font-medium cursor-pointer" @click="closeDeleteModal()">
                    Cancel
                </button>
                <button type="submit" class="bg-red-200 duration-500 text-red-900 inline-flex justify-center items-center gap-1 hover:bg-red-300 min-h-[45px] max-h-[45px] min-w-[100px] max-w-[100px] rounded-xl text-[14px] font-medium cursor-pointer" v-if="!deleteLoading">
                    Confirm
                </button>
                <button type="button" class="bg-red-200 duration-500 inline-flex justify-center items-center gap-1 hover:bg-red-300 text-green-800 min-h-[45px] max-h-[45px] min-w-[100px] max-w-[100px] rounded-xl text-[14px] font-medium cursor-pointer" v-if="deleteLoading">
                    <span class="inline-block rounded-full min-w-[16px] max-w-[16px] min-h-[16px] max-h-[16px] border-2 border-red-800 border-t-transparent animate-spin"></span>
                </button>
            </div>
        </form>
    </section>

    <!-- archive modal -->
    <section class="fixed inset-0 grid sm:justify-center items-center duration-500 z-50 p-5 overflow-y-auto" :class="{ 'invisible bg-black/35' : !isArchiveModalActive, 'visible bg-black/65' : isArchiveModalActive }" @click="closeArchiveModal()">
        <form @submit.prevent="archiveApi()" class="bg-white rounded-3xl w-full sm:max-w-[400px] sm:min-w-[400px] py-10 px-5 duration-500 origin-top" :class="{ 'translate-y-0 opacity-100' : isArchiveModalActive, '-translate-y-1/2 opacity-0' : !isArchiveModalActive }" @click.stop>
            <div class="w-full flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="stroke-rose-500 min-w-[45px] max-w-[45px] min-h-[45px] max-h-[45px]">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                </svg>
            </div>
            <div class="text-center text-[18px] my-5"> Are you <br> archive surely?</div>
            <div class="w-full flex justify-center items-center gap-3">
                <button type="button" class="bg-gray-200 duration-500 text-gray-900 inline-flex justify-center items-center gap-1 hover:bg-gray-300 min-h-[45px] max-h-[45px] min-w-[100px] max-w-[100px] rounded-xl text-[14px] font-medium cursor-pointer" @click="closeArchiveModal()">
                    Cancel
                </button>
                <button type="submit" class="bg-red-200 duration-500 text-red-900 inline-flex justify-center items-center gap-1 hover:bg-red-300 min-h-[45px] max-h-[45px] min-w-[100px] max-w-[100px] rounded-xl text-[14px] font-medium cursor-pointer" v-if="!archiveLoading">
                    Confirm
                </button>
                <button type="button" class="bg-red-200 duration-500 inline-flex justify-center items-center gap-1 hover:bg-red-300 text-green-800 min-h-[45px] max-h-[45px] min-w-[100px] max-w-[100px] rounded-xl text-[14px] font-medium cursor-pointer" v-if="archiveLoading">
                    <span class="inline-block rounded-full min-w-[16px] max-w-[16px] min-h-[16px] max-h-[16px] border-2 border-red-800 border-t-transparent animate-spin"></span>
                </button>
            </div>
        </form>
    </section>

    <!-- unArchive modal -->
    <section class="fixed inset-0 grid sm:justify-center items-center duration-500 z-50 p-5 overflow-y-auto" :class="{ 'invisible bg-black/35' : !isUnArchiveModalActive, 'visible bg-black/65' : isUnArchiveModalActive }" @click="closeUnArchiveModal()">
        <form @submit.prevent="unArchiveApi()" class="bg-white rounded-3xl w-full sm:max-w-[400px] sm:min-w-[400px] py-10 px-5 duration-500 origin-top" :class="{ 'translate-y-0 opacity-100' : isUnArchiveModalActive, '-translate-y-1/2 opacity-0' : !isUnArchiveModalActive }" @click.stop>
            <div class="w-full flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="stroke-rose-500 min-w-[45px] max-w-[45px] min-h-[45px] max-h-[45px]">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                </svg>
            </div>
            <div class="text-center text-[18px] my-5"> Are you <br> unArchive surely?</div>
            <div class="w-full flex justify-center items-center gap-3">
                <button type="button" class="bg-gray-200 duration-500 text-gray-900 inline-flex justify-center items-center gap-1 hover:bg-gray-300 min-h-[45px] max-h-[45px] min-w-[100px] max-w-[100px] rounded-xl text-[14px] font-medium cursor-pointer" @click="closeUnArchiveModal()">
                    Cancel
                </button>
                <button type="submit" class="bg-red-200 duration-500 text-red-900 inline-flex justify-center items-center gap-1 hover:bg-red-300 min-h-[45px] max-h-[45px] min-w-[100px] max-w-[100px] rounded-xl text-[14px] font-medium cursor-pointer" v-if="!unArchiveLoading">
                    Confirm
                </button>
                <button type="button" class="bg-red-200 duration-500 inline-flex justify-center items-center gap-1 hover:bg-red-300 text-green-800 min-h-[45px] max-h-[45px] min-w-[100px] max-w-[100px] rounded-xl text-[14px] font-medium cursor-pointer" v-if="unArchiveLoading">
                    <span class="inline-block rounded-full min-w-[16px] max-w-[16px] min-h-[16px] max-h-[16px] border-2 border-red-800 border-t-transparent animate-spin"></span>
                </button>
            </div>
        </form>
    </section>

    <!-- truncate modal -->
    <section class="fixed inset-0 grid sm:justify-center items-center duration-500 z-50 p-5 overflow-y-auto" :class="{ 'invisible bg-black/35' : !isTruncateModalActive, 'visible bg-black/65' : isTruncateModalActive }" @click="closeTruncateModal()">
        <form @submit.prevent="truncateApi()" class="bg-white rounded-3xl w-full sm:max-w-[400px] sm:min-w-[400px] py-10 px-5 duration-500 origin-top" :class="{ 'translate-y-0 opacity-100' : isTruncateModalActive, '-translate-y-1/2 opacity-0' : !isTruncateModalActive }" @click.stop>
            <div class="w-full flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="stroke-rose-500 min-w-[45px] max-w-[45px] min-h-[45px] max-h-[45px]">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                </svg>
            </div>
            <div class="text-center text-[18px] my-5"> Are you <br> clear all data surely?</div>
            <div class="w-full flex justify-center items-center gap-3">
                <button type="button" class="bg-gray-200 duration-500 text-gray-900 inline-flex justify-center items-center gap-1 hover:bg-gray-300 min-h-[45px] max-h-[45px] min-w-[100px] max-w-[100px] rounded-xl text-[14px] font-medium cursor-pointer" @click="closeTruncateModal()">
                    Cancel
                </button>
                <button type="submit" class="bg-red-200 duration-500 text-red-900 inline-flex justify-center items-center gap-1 hover:bg-red-300 min-h-[45px] max-h-[45px] min-w-[100px] max-w-[100px] rounded-xl text-[14px] font-medium cursor-pointer" v-if="!truncateLoading">
                    Confirm
                </button>
                <button type="button" class="bg-red-200 duration-500 inline-flex justify-center items-center gap-1 hover:bg-red-300 text-green-800 min-h-[45px] max-h-[45px] min-w-[100px] max-w-[100px] rounded-xl text-[14px] font-medium cursor-pointer" v-if="truncateLoading">
                    <span class="inline-block rounded-full min-w-[16px] max-w-[16px] min-h-[16px] max-h-[16px] border-2 border-red-800 border-t-transparent animate-spin"></span>
                </button>
            </div>
        </form>
    </section>

</template>

<script>

import axios from 'axios';
import apiRoute from '../../apiController/apiRoute.js';
import apiService from '../../apiController/apiService.js';

export default {
    computed: {
        isAllChecked() {
            return this.allData.length > 0 && this.allData.length === this.selectUserId.length;
        },
        isIndeterminate() {
            return this.selectUserId.length > 0 && this.selectUserId.length < this.allData.length;
        }
    },
    data() {
        return {
            // Data Properties
            isManageModalActive: false,
            manageLoading: false,
            isDeleteModalActive: false,
            deleteLoading: false,
            isArchiveModalActive: false,
            archiveLoading: false,
            isTruncateModalActive: false,
            truncateLoading: false,
            isUnArchiveModalActive: false,
            unArchiveLoading: false,
            singleLoading: false,
            controlType: 'check',
            tableData: [],
            allData: [],
            activeDropdownIndex: null,
            loading: false,
            currentPage: 1,
            perPage: 20,
            limits: Array.from({ length: 10 }, (_, i) => (i + 1) * 20),
            total: 0,
            pageCount: 0,
            from: 0,
            to: 0,
            archived: 0,
            sort_order: 'asc',
            sort_by: '',
            search: null,
            searchTimeout: null,
            selectUserId: [],
            formData: {
                id: null,
                image: null,
                name: '',
                email: '',
                phone_number: '',
            },
            error: {},
            attach_preview: null,
        }
    },
    async mounted() {
        await this.readApiAll();
        await this.readApi(1);
    },
    beforeMount() {
        window.addEventListener("click", this.handleClickOutside);
    },
    beforeUnmount() {
        window.removeEventListener("click", this.handleClickOutside);
    },
    methods: {

        // === === === Manage Crud === === ===

        /*** open manage modal ***/
        openManageModal(data = null) {
            this.formData.remove_image = false;
            if (data !== null) {
                this.singleApi(data);
            } else {
                this.attach_preview = null;
                this.formData = {
                    id: null,
                    image: null,
                    name: '',
                    email: '',
                    phone_number: '',
                    remove_image: false,
                }
            }
            this.error = {};
            this.isManageModalActive = true;
        },

        /*** close manage modal ***/
        closeManageModal() {
            this.isManageModalActive = false;
            this.formData.remove_image = false;
        },

        /*** single api ***/
        async singleApi(data) {
            try {
                this.singleLoading = true;
                const response = await axios.get(apiRoute.crud + '/' + data, this.formData, {headers: apiService.mediaHeaderContent});
                this.formData = response?.data;
                if (response?.data?.image) {
                    this.attach_preview = `/storage/${response?.data?.image}`;
                } else {
                    this.attach_preview = null;
                }
            } catch (error) {
                this.error = error?.response?.data?.errors;
            } finally {
                this.singleLoading = false;
            }
        },

        /*** attach file ***/
        attachFile(event) {
            const file = event.target.files[0];
            this.attach_preview = URL.createObjectURL(file);
            this.formData.image = file;
        },

        /*** remove file ***/
        removeFile() {
            this.attach_preview = null;
            this.formData.image = null;
            this.formData.remove_image = true;
        },

        /*** manage api - create and update ***/
        manageApi() {
            if (this.formData.id !== null) {
                this.updateApi();
            } else {
                this.createApi();
            }
        },

        /*** create api ***/
        async createApi() {
            try {
                this.manageLoading = true;
                let form = new FormData();
                form.append('name', this.formData.name);
                form.append('email', this.formData.email);
                form.append('phone_number', this.formData.phone_number);
                if (this.formData.image instanceof File) { form.append('image', this.formData.image); }
                if (this.formData.remove_image) { form.append('remove_image', '1'); }
                await axios.post(apiRoute.crud, form, {headers: apiService.mediaHeaderContent});
                this.closeManageModal();
                await this.readApi();
            } catch (error) {
                this.error = error?.response?.data?.errors;
            } finally {
                this.manageLoading = false;
            }
        },

        /*** update api ***/
        async updateApi() {
            try {
                this.manageLoading = true;
                let form = new FormData();
                form.append('name', this.formData.name);
                form.append('email', this.formData.email);
                form.append('phone_number', this.formData.phone_number);
                if (this.formData.image instanceof File) { form.append('image', this.formData.image); }
                if (this.formData.remove_image) { form.append('remove_image', '1'); }
                form.append('_method', 'PUT');
                await axios.post(apiRoute.crud + '/' + this.formData.id, form, {headers: apiService.mediaHeaderContent});
                this.closeManageModal();
                await this.readApi();
            } catch (error) {
                this.error = error?.response?.data?.errors;
            } finally {
                this.manageLoading = false;
            }
        },

        // === === === list Crud === === ===

        /*** read api all ***/
        async readApiAll() {
            try {
                this.loading = true;
                const response = await axios.get(`${apiRoute.crud}`,
                    {
                        params:
                            {
                                archived: this.archived,
                                paginate: 1
                            },
                        headers: apiService.headerContent
                    }
                );
                this.allData = response.data;
            } catch (error) {
                this.error = error?.response?.data?.errors;
            } finally {
                this.loading = false;
            }
        },

        /*** read api ***/
        async readApi(page = 1) {
            try {
                this.loading = true;
                const response = await axios.get(`${apiRoute.crud}`,
                    {
                        params:
                            {
                                page,
                                per_page: this.perPage,
                                sort_by: this.sort_by,
                                sort_order: this.sort_order,
                                search: this.search || '',
                                archived: this.archived,
                                paginate: 0
                            },
                        headers: apiService.headerContent
                    }
                );
                const res = response.data;
                this.tableData = res.data;
                this.currentPage = Number(res.current_page);
                this.perPage = Number(res.per_page);
                this.total = Number(res.total);
                this.from = Number(res.from) || 0;
                this.to = Number(res.to) || 0;
                this.pageCount = Math.max(1, Number(res.last_page));
            } catch (error) {
                this.error = error?.response?.data?.errors;
            } finally {
                this.loading = false;
            }
        },

        /*** toggle dropdown as active dropdown index ***/
        toggleDropdown(index) {
            this.activeDropdownIndex = this.activeDropdownIndex === index ? null : index;
        },

        /*** is dropdown active dropdown index ***/
        isDropdownActive(index) {
            return this.activeDropdownIndex === index;
        },

        /*** handle click outside ***/
        handleClickOutside() {
            if (this.activeDropdownIndex !== null) {
                this.activeDropdownIndex = null;
            }
        },

        /*** select all user to push all id ***/
        selectAllUser(e) {
            if (e.target.checked) {
                this.selectUserId = this.allData.map(v => v.id);
                this.controlType = 'check';
            } else {
                this.selectUserId = [];
                this.controlType = '';
            }
            this.selectUserId = [...this.selectUserId];
        },

        /*** select user to push id ***/
        selectUser(e, id) {
            if (e.target.checked) {
                if (!this.selectUserId.includes(id)) {
                    this.selectUserId.push(id);
                }
            } else {
                const index = this.selectUserId.indexOf(id);
                if (index > -1) {
                    this.selectUserId.splice(index, 1);
                }
            }
            this.selectUserId = [...this.selectUserId];
        },

        /*** check if checked ***/
        checkIfChecked(id) {
            return this.selectUserId.includes(id);
        },

        /*** short name ***/
        shortName(name) {
            if (name) {
                const words = name.trim().split(/\s+/);
                let initials = '';
                if (words.length >= 2) {
                    initials = words[0][0] + words[1][0];
                } else {
                    initials = words[0].substring(0, 2);
                }
                return initials.toUpperCase();
            }
        },

        /*** filter sort change read api ***/
        sortChange() {
            this.readApiAll();
            this.readApi(1);
        },

        /*** take me previous page if apply read api ***/
        goPrevious() {
            this.changePage(this.currentPage - 1);
        },

        /*** take me next page if apply read api ***/
        goNext() {
            this.changePage(this.currentPage + 1);
        },

        /*** change page if apply read api ***/
        changePage(page) {
            page = Number(page);
            if (isNaN(page)) page = 1;
            if (page < 1) page = 1;
            if (page > this.pageCount) page = this.pageCount;
            if (page === this.currentPage) return;
            this.readApi(page);
        },

        /*** search data if apply read api ***/
        searchData() {
            if (this.searchTimeout) {
                clearTimeout(this.searchTimeout);
            }
            this.searchTimeout = setTimeout(() => {
                this.readApi(1);
            }, 500);
        },

        /*** custom limit if apply read api ***/
        limitChange() {
            if (this.searchTimeout) {
                clearTimeout(this.searchTimeout);
            }
            this.searchTimeout = setTimeout(() => {
                this.readApi(1);
            }, 500);
        },

        // === === === delete Crud === === ===

        /*** open delete modal ***/
        openDeleteModal(data) {
            this.formData.id = data
            this.isDeleteModalActive = true;
        },

        /*** close delete modal ***/
        closeDeleteModal() {
            this.isDeleteModalActive = false;
            this.formData.remove_image = false;
        },

        /*** delete Maintain ***/
        deleteApi() {
            if(this.controlType === 'check') {
                this.selectedDeleteApi();
            } else {
                this.normalDeleteApi();
            }
        },

        /*** delete api ***/
        async normalDeleteApi() {
            try {
                this.deleteLoading = true;
                await axios.delete(apiRoute.crud + '/' + this.formData.id, {headers: apiService.headerContent});
                this.closeDeleteModal();
                await this.readApi();
            } catch (error) {
                this.error = error?.response?.data?.errors;
            } finally {
                this.deleteLoading = false;
            }
        },

        /*** selected delete api ***/
        async selectedDeleteApi() {
            try {
                this.deleteLoading = true;
                await axios.post(apiRoute.crud+'/selected?ids='+this.selectUserId, {headers: apiService.headerContent});
                this.selectUserId = [];
                this.closeDeleteModal();
                await this.readApi();
            } catch (error) {
                this.error = error?.response?.data?.errors;
            } finally {
                this.deleteLoading = false;
            }
        },

        // === === === archive Crud === === ===

        /*** open delete modal ***/
        openArchiveModal(data) {
            this.formData.id = data
            this.isArchiveModalActive = true;
        },

        /*** close delete modal ***/
        closeArchiveModal() {
            this.isArchiveModalActive = false;
        },

        /*** archive Maintain ***/
        archiveApi() {
            if(this.controlType === 'check') {
                this.selectArchiveApi();
            } else {
                this.normalArchiveApi();
            }
        },

        /*** archive api ***/
        async normalArchiveApi() {
            try {
                this.archiveLoading = true;
                await axios.post(apiRoute.crud + '/' + this.formData.id + '/archive', null, { headers: apiService.headerContent });
                this.closeArchiveModal();
                await this.readApi();
            } catch (error) {
                this.error = error?.response?.data?.errors;
            } finally {
                this.archiveLoading = false;
            }
        },

        /*** select archive api ***/
        async selectArchiveApi() {
            try {
                this.archiveLoading = true;
                await axios.post(apiRoute.crud + '/selected/' + this.selectUserId + '/archive', { ids: this.selectUserId }, { headers: apiService.headerContent });
                this.selectUserId = [];
                this.closeArchiveModal();
                this.archived = 0
                await this.readApi();
            } catch (error) {
                this.error = error?.response?.data?.errors;
            } finally {
                this.archiveLoading = false;
            }
        },

        // === === === unArchive Crud === === ===

        /*** open delete modal ***/
        openUnArchiveModal(data) {
            this.formData.id = data
            this.isUnArchiveModalActive = true;
        },

        /*** close delete modal ***/
        closeUnArchiveModal() {
            this.isUnArchiveModalActive = false;
        },

        /*** unArchive Maintain ***/
        unArchiveApi() {
            if(this.controlType === 'check') {
                this.selectUnArchiveApi();
            } else {
                this.normalUnArchiveApi();
            }
        },

        /*** archive api ***/
        async normalUnArchiveApi() {
            try {
                this.unArchiveLoading = true;
                await axios.post(apiRoute.crud + '/' + this.formData.id + '/unArchive', null, {headers: apiService.headerContent});
                this.closeUnArchiveModal();
                this.archived = 0;
                await this.readApi();
            } catch (error) {
                this.error = error?.response?.data?.errors;
            } finally {
                this.unArchiveLoading = false;
            }
        },

        /*** select unArchive api ***/
        async selectUnArchiveApi() {
            try {
                this.unArchiveLoading = true;
                await axios.post(apiRoute.crud + '/selected/' + this.selectUserId + '/unArchive', { ids: this.selectUserId }, { headers: apiService.headerContent });
                this.selectUserId = [];
                this.closeUnArchiveModal();
                this.archived = 0;
                await this.readApi();
            } catch (error) {
                this.error = error?.response?.data?.errors;
            } finally {
                this.unArchiveLoading = false;
            }
        },

        // === === === truncate Crud === === ===

        /*** open delete modal ***/
        openTruncateModal() {
            this.isTruncateModalActive = true;
        },

        /*** close delete modal ***/
        closeTruncateModal() {
            this.isTruncateModalActive = false;
        },

        /*** delete api ***/
        async truncateApi() {
            try {
                this.truncateLoading = true;
                await axios.post(apiRoute.crud + '/truncate', {headers: apiService.headerContent});
                this.closeTruncateModal();
                await this.readApi();
            } catch (error) {
                this.error = error?.response?.data?.errors;
            } finally {
                this.truncateLoading = false;
            }
        },

    }
}

</script>
