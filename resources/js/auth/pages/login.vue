<template>

    <form @submit.prevent="loginApi()" class="w-full">
        <div class="w-full block mb-3">
            <label for="email" class="block mb-1 w-full font-medium text-[14px]"> Email </label>
            <input id="email" type="email" name="email" v-model="formData.email" class="font-medium text-[14px] outline-0 px-4 duration-500 min-h-[45px] max-h-[45px] w-full border border-gray-200 focus-within:ring-2 focus-within:ring-blue-400 rounded-lg bg-gray-200" autocomplete="off" />
            <div class="mt-2 text-red-500 text-[12px] font-medium" v-if="error.email"> {{error.email[0]}} </div>
        </div>
        <div class="w-full block mb-3">
            <label for="password" class="flex justify-between items-center mb-1 w-full font-medium text-[14px]">
                <span> Password </span>
                <span>
                    <router-link :to="{name:'forgot'}" class="decoration-0 text-red-600 text-[13px]">
                        Forgot Password?
                    </router-link>
                </span>
            </label>
            <input id="password" type="password" name="password" v-model="formData.password" class="font-medium text-[14px] outline-0 px-4 duration-500 min-h-[45px] max-h-[45px] w-full border border-gray-200 focus-within:ring-2 focus-within:ring-blue-400 rounded-lg bg-gray-200" autocomplete="off" />
            <div class="mt-2 text-red-500 text-[12px] font-medium" v-if="error.password"> {{error.password[0]}} </div>
        </div>
        <div class="w-full block mb-3">
            <button type="submit" class="min-h-[45px] font-medium max-h-[45px] w-full bg-blue-400 duration-500 hover:bg-blue-600 text-white cursor-pointer rounded-lg" v-if="!loading">
                Login
            </button>
            <button type="button" class="min-h-[45px] font-medium max-h-[45px] w-full bg-blue-400 duration-500 hover:bg-blue-600 text-white cursor-pointer rounded-lg" v-if="loading">
                <span class="max-w-[20px] min-w-[20px] max-h-[20px] min-h-[20px] inline-block rounded-full border-2 border-white border-t-transparent animate-spin"></span>
            </button>
        </div>
        <div class="text-center text-[14px]">
            <div class="mb-2 text-center"> Don't have any account </div>
            <router-link :to="{name:'registration'}" class="decoration-0 text-black text-[14px] duration-500 hover:text-blue-500">
                Sign Up
            </router-link>
        </div>
    </form>

</template>

<script>

import axios from "axios";
import cookiesServices from "../../apiController/cookiesServices.js";
import apiRoute from "../../apiController/apiRoute.js";
import apiService from "../../apiController/apiService.js";

export default {
    data() {
        return {
            formData: {
                email: '',
                password: '',
            },
            error: {},
            loading: false,
        }
    },
    mounted() {

    },
    methods: {

        async loginApi() {
            try {
                this.loading = true;
                const response = await axios.post(apiRoute.auth+'/login', this.formData, {headers: apiService.authHeaderContent});
                cookiesServices.set('auth_token', response.data.auth_token);
                this.formData = { email: '', password: '' };
                this.$router.push({name: 'details'});
            } catch (error) {
                this.error = error.response.data.errors
            } finally {
                this.loading = false;
            }
        }

    }
}

</script>
