<template>
    <div class="w-full flex items-start justify-start">
        <section class="min-w-[320px] h-screen bg-gray-200">
            <div class="w-full flex justify-center items-center min-h-[80px] text-[21px]">
                Admin Panel
            </div>
            <div class="w-full min-h-[calc(100vh-80px)] px-4">
                <a href="javascript:void(0)" class="block mb-1 w-full py-3 px-5 bg-transparent duration-500 hover:bg-gray-300 rounded-md">
                    Dashboard
                </a>
            </div>
        </section>
        <main class="min-w-[calc(100%-320px)] h-screen bg-white">
            <div class="w-full flex justify-end items-center min-h-[80px] max-h-[80px] px-4">
                <div class="relative group">
                    <button type="button" class="min-w-[45px] max-w-[45px] min-h-[45px] max-h-[45px] bg-gray-200 rounded-full cursor-pointer inline-flex justify-center items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="min-w-[20px] min-h-[20px] max-w-[20px] max-h-[20px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </button>
                    <ul class="min-w-[180px] h-auto bg-gray-100 absolute end-0 duration-500 mt-2 rounded-md max-h-[0px] group-hover:max-h-[450px] overflow-hidden">
                        <li class="p-2">
                            <a href="javascript:void(0)" class="cursor-pointer mb-1 flex justify-start items-center w-full decoration-0 block px-4 py-2 duration-500 bg-transparent hover:bg-gray-300 rounded-md">
                                Profile
                            </a>
                            <a href="javascript:void(0)" class="cursor-pointer mb-1 flex justify-start items-center w-full decoration-0 block px-4 py-2 duration-500 bg-transparent hover:bg-gray-300 rounded-md">
                                Settings
                            </a>
                            <button type="button" class="cursor-pointer flex justify-start items-center w-full decoration-0 block px-4 py-2 duration-500 bg-transparent hover:bg-gray-300 rounded-md" @click="logout()">
                                Logout
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="w-full min-h-[calc(100vh-80px)] p-4">
                <router-view/>
            </div>
        </main>
    </div>
</template>

<script>

import axios from "axios";
import apiRoute from "../../apiController/apiRoute.js";
import apiService from "../../apiController/apiService.js";
import cookiesServices from "../../apiController/cookiesServices.js";

export default {
    data() {
        return {
            logoutLoading: false,
        }
    },
    mounted() {

    },
    methods: {

        async logout() {
            try {
                this.logoutLoading = true;
                await axios.post(apiRoute.profile+'/logout', null, {headers: apiService.authHeaderContent});
                cookiesServices.remove('auth_token', null);
                this.$router.push({name: 'login'});
            } catch (error) {
                this.error = error.response.data.errors
            } finally {
                this.logoutLoading = false;
            }
        }

    }
}

</script>
