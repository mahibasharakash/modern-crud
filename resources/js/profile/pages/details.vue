<template>

    <div class="w-full flex justify-center items-center text-[14px]">
        <div class="w-full max-w-[450px] p-5 border border-gray-200 rounded-xl">
            <div class="flex justify-center mb-3">
                <img :src="'/storage/'+profileData?.image" class="max-w-[200px] min-w-[200px] max-h-[200px] min-h-[200px] rounded-full bg-cover object-cover" alt="profile Image" v-if="profileData?.image" />
                <div class="max-w-[200px] min-w-[200px] max-h-[200px] min-h-[200px] rounded-full inline-flex justify-center items-center bg-gray-200" v-if="!profileData?.image">
                    <span class="text-[35px]"> {{shortName(profileData?.name)}} </span>
                </div>
            </div>
            <div class="w-full mb-3 block">
                <div class="w-full block font-semibold"> Full Name </div>
                <div class="w-full block font-medium"> {{profileData?.name ?? 'N/A'}} </div>
            </div>
            <div class="w-full mb-3 block">
                <div class="w-full block font-semibold"> Email </div>
                <div class="w-full block font-medium"> {{profileData?.email ?? 'N/A'}} </div>
            </div>
            <div class="w-full mb-3 block">
                <div class="w-full block font-semibold"> Phone Number </div>
                <div class="w-full block font-medium"> {{profileData?.phone_number ?? 'N/A'}} </div>
            </div>
            <div class="w-full mb-3 block">
                <div class="w-full block font-semibold"> Address </div>
                <div class="w-full block font-medium"> {{profileData?.address ?? 'N/A'}} </div>
            </div>
            <div class="w-full flex justify-between items-center gap-2 font-semibold">
                <button type="button" class="cursor-pointer bg-gray-200 duration-500 hover:bg-gray-800 hover:text-white flex justify-center items-center w-full min-h-[45px] max-h-[45px] rounded-xl" @click="openEditProfileModal()">
                    Edit Profile
                </button>
                <button type="button" class="cursor-pointer bg-gray-200 duration-500 hover:bg-gray-800 hover:text-white flex justify-center items-center w-full min-h-[45px] max-h-[45px] rounded-xl" @click="openChangePasswordModal()">
                    Change Password
                </button>
            </div>
        </div>
    </div>

    <!-- Edit Details -->
    <aside class="fixed inset-0 grid sm:justify-center items-center duration-500 z-50 p-5 overflow-y-auto" :class="{ 'invisible bg-black/35' : !isActiveEditDetails, 'visible bg-black/65' : isActiveEditDetails }" @click="closeEditProfileModal()">
        <form @submit.prevent="changeDetails()" class="bg-white rounded-3xl w-full sm:max-w-[400px] sm:min-w-[400px] px-10 py-7 duration-500 origin-top" :class="{ 'translate-y-0 opacity-100' : isActiveEditDetails, '-translate-y-1/2 opacity-0' : !isActiveEditDetails }" @click.stop>
            <div class="w-full flex justify-between items-center">
                <div class="text-[19px] font-medium"> Edit Details </div>
                <button type="button" class="min-w-[45px] max-w-[45px] min-h-[45px] max-h-[45px] inline-flex justify-center items-center rounded-full bg-transparent duration-500 hover:bg-gray-300 cursor-pointer" @click="closeEditProfileModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="stroke-black min-w-[25px] max-w-[25px] min-h-[25px] max-h-[25px]">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex justify-center items-center mb-3">
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
                <label for="name" class="block mb-1 w-full text-[14px]"> Name </label>
                <input id="name" type="text" name="name" v-model="profileParam.name" class="duration-500 rounded-xl outline-0 ring-0 focus-within:ring-2 focus-within:ring-blue-400 w-full block min-h-[45px] max-h-[45px] border border-gray-200 bg-gray-200 px-4 text-[13px]" autocomplete="off" />
                <div class="text-red-500 mt-1 text-[11px] font-medium" v-if="error?.name"> {{ error?.name[0] }} </div>
            </div>
            <div class="w-full block mb-3">
                <label for="email" class="block mb-1 w-full text-[14px]"> Email </label>
                <input id="email" type="email" name="email" v-model="profileParam.email" class="duration-500 rounded-xl outline-0 ring-0 focus-within:ring-2 focus-within:ring-blue-400 w-full block min-h-[45px] max-h-[45px] border border-gray-200 bg-gray-200 px-4 text-[13px]" autocomplete="off" />
                <div class="text-red-500 mt-1 text-[11px] font-medium" v-if="error?.email"> {{ error?.email[0] }} </div>
            </div>
            <div class="w-full block mb-3">
                <label for="phone_number" class="block mb-1 w-full text-[14px]"> Phone Number </label>
                <input id="phone_number" type="text" name="phone_number" v-model="profileParam.phone_number" class="duration-500 rounded-xl outline-0 ring-0 focus-within:ring-2 focus-within:ring-blue-400 w-full block min-h-[45px] max-h-[45px] border border-gray-200 bg-gray-200 px-4 text-[13px]" autocomplete="off" />
                <div class="text-red-500 mt-1 text-[11px] font-medium" v-if="error?.phone_number"> {{ error?.phone_number[0] }} </div>
            </div>
            <div class="w-full block mb-3">
                <label for="address" class="block mb-1 w-full text-[14px]"> Address </label>
                <input id="address" type="text" name="address" v-model="profileParam.address" class="duration-500 rounded-xl outline-0 ring-0 focus-within:ring-2 focus-within:ring-blue-400 w-full block min-h-[45px] max-h-[45px] border border-gray-200 bg-gray-200 px-4 text-[13px]" autocomplete="off" />
                <div class="text-red-500 mt-1 text-[11px] font-medium" v-if="error?.address"> {{ error?.address[0] }} </div>
            </div>
            <div class="flex justify-end items-center gap-3">
                <button type="button" class="bg-gray-200 duration-500 text-gray-900 inline-flex justify-center items-center gap-1 hover:bg-gray-300 min-h-[45px] max-h-[45px] min-w-[100px] max-w-[100px] rounded-xl text-[14px] font-medium cursor-pointer" @click="closeEditProfileModal()">
                    Cancel
                </button>
                <button type="submit" class="bg-green-200 duration-500 inline-flex justify-center items-center gap-1 hover:bg-green-300 text-green-800 min-h-[45px] max-h-[45px] min-w-[100px] max-w-[100px] rounded-xl text-[14px] font-medium cursor-pointer" v-if="!profileLoading">
                    Update
                </button>
                <button type="button" class="bg-green-200 duration-500 inline-flex justify-center items-center gap-1 hover:bg-green-300 text-green-800 min-h-[45px] max-h-[45px] min-w-[100px] max-w-[100px] rounded-xl text-[14px] font-medium cursor-pointer" v-if="profileLoading">
                    <span class="inline-block rounded-full min-w-[16px] max-w-[16px] min-h-[16px] max-h-[16px] border-2 border-green-800 border-t-transparent animate-spin"></span>
                </button>
            </div>
        </form>
    </aside>

    <!-- Change Password -->
    <aside class="fixed inset-0 grid sm:justify-center items-center duration-500 z-50 p-5 overflow-y-auto" :class="{ 'invisible bg-black/35' : !isActiveChangePassword, 'visible bg-black/65' : isActiveChangePassword }" @click="closeChangePasswordModal()">
        <form @submit.prevent="changePassword()" class="bg-white rounded-3xl w-full sm:max-w-[400px] sm:min-w-[400px] px-10 py-7 duration-500 origin-top" :class="{ 'translate-y-0 opacity-100' : isActiveChangePassword, '-translate-y-1/2 opacity-0' : !isActiveChangePassword }" @click.stop>
            <div class="w-full flex justify-between items-center">
                <div class="text-[19px] font-medium"> Change Password </div>
                <button type="button" class="min-w-[45px] max-w-[45px] min-h-[45px] max-h-[45px] rounded-full inline-flex justify-center items-center bg-transparent duration-500 hover:bg-gray-300 cursor-pointer" @click="closeChangePasswordModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="stroke-black min-w-[25px] max-w-[25px] min-h-[25px] max-h-[25px]">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="w-full block mb-3">
                <label for="current_password" class="block mb-1 w-full text-[14px]"> Current Password </label>
                <input id="current_password" type="password" name="current_password" v-model="passwordParam.current_password" class="duration-500 rounded-xl outline-0 ring-0 focus-within:ring-2 focus-within:ring-blue-400 w-full block min-h-[45px] max-h-[45px] border border-gray-200 bg-gray-200 px-4 text-[13px]" autocomplete="off" />
                <div class="text-red-500 mt-1 text-[11px] font-medium" v-if="error?.current_password"> {{ error?.current_password[0] }} </div>
            </div>
            <div class="w-full block mb-3">
                <label for="new_password" class="block mb-1 w-full text-[14px]"> New Password </label>
                <input id="new_password" type="password" name="new_password" v-model="passwordParam.new_password" class="duration-500 rounded-xl outline-0 ring-0 focus-within:ring-2 focus-within:ring-blue-400 w-full block min-h-[45px] max-h-[45px] border border-gray-200 bg-gray-200 px-4 text-[13px]" autocomplete="off" />
                <div class="text-red-500 mt-1 text-[11px] font-medium" v-if="error?.new_password"> {{ error?.new_password[0] }} </div>
            </div>
            <div class="w-full block mb-3">
                <label for="new_confirm_password" class="block mb-1 w-full text-[14px]"> New Confirm Password </label>
                <input id="new_confirm_password" type="password" name="new_password_confirmation" v-model="passwordParam.new_password_confirmation" class="duration-500 rounded-xl outline-0 ring-0 focus-within:ring-2 focus-within:ring-blue-400 w-full block min-h-[45px] max-h-[45px] border border-gray-200 bg-gray-200 px-4 text-[13px]" autocomplete="off" />
                <div class="text-red-500 mt-1 text-[11px] font-medium" v-if="error?.new_password_confirmation"> {{ error?.new_password_confirmation[0] }} </div>
            </div>
            <div class="flex justify-end items-center gap-3">
                <button type="button" class="bg-gray-200 duration-500 text-gray-900 inline-flex justify-center items-center gap-1 hover:bg-gray-300 min-h-[45px] max-h-[45px] min-w-[100px] max-w-[100px] rounded-xl text-[14px] font-medium cursor-pointer" @click="closeChangePasswordModal()">
                    Cancel
                </button>
                <button type="submit" class="bg-green-200 duration-500 inline-flex justify-center items-center gap-1 hover:bg-green-300 text-green-800 min-h-[45px] max-h-[45px] min-w-[100px] max-w-[100px] rounded-xl text-[14px] font-medium cursor-pointer" v-if="!passwordLoading">
                    Update
                </button>
                <button type="button" class="bg-green-200 duration-500 inline-flex justify-center items-center gap-1 hover:bg-green-300 text-green-800 min-h-[45px] max-h-[45px] min-w-[100px] max-w-[100px] rounded-xl text-[14px] font-medium cursor-pointer" v-if="passwordLoading">
                    <span class="inline-block rounded-full min-w-[16px] max-w-[16px] min-h-[16px] max-h-[16px] border-2 border-green-800 border-t-transparent animate-spin"></span>
                </button>
            </div>
        </form>
    </aside>

</template>

<script>

import axios from "axios";
import apiRoute from "../../apiController/apiRoute.js";
import apiService from "../../apiController/apiService.js";

export default {
    data() {
        return {
            isActiveEditDetails: false,
            isActiveChangePassword: false,
            getLoading: false,
            profileLoading: false,
            passwordLoading: false,
            profileData: null,
            attach_preview: null,
            profileParam: {
                name: '',
                email: '',
                phone_number: '',
                image: null,
                address: '',
                remove_image: false,
            },
            passwordParam: {
                current_password: '',
                password: '',
                password_confirmation: '',
            },
            error: {},
        }
    },
    async mounted() {
        await this.getProfileApi();
    },
    methods: {

        openEditProfileModal() {
            this.error = {};
            if(this.profileParam.image !== null) {
                this.attach_preview = `/storage/${this.profileParam?.image}`;
            } else {
                this.attach_preview = null;
            }
            this.isActiveEditDetails = true;
        },

        closeEditProfileModal() {
            this.isActiveEditDetails = false
        },

        openChangePasswordModal() {
            this.error = {};
            this.isActiveChangePassword = true;
        },

        closeChangePasswordModal() {
            this.isActiveChangePassword = false
        },

        /*** attach file ***/
        attachFile(event) {
            const file = event.target.files[0];
            this.attach_preview = URL.createObjectURL(file);
            this.profileParam.image = file;
        },

        /*** remove file ***/
        removeFile() {
            this.attach_preview = null;
            this.profileParam.image = null;
            this.profileParam.remove_image = true;
        },

        async getProfileApi() {
            try {
                this.getLoading = true;
                const response  = await axios.get(apiRoute.profile+'/details', this.profileData, {headers: apiService.authHeaderContent});
                this.profileData = response?.data?.user;
                this.profileParam = JSON.parse(JSON.stringify(response?.data?.user));
            } catch (error) {
                this.error = error.response.data.errors;
            } finally {
                this.getLoading = false;
            }
        },

        async changeDetails() {
            try {
                this.profileLoading = true;
                let form = new FormData();
                form.append('name', this.profileParam.name);
                form.append('email', this.profileParam.email);
                form.append('phone_number', this.profileParam.phone_number);
                form.append('address', this.profileParam.address);
                if (this.profileParam.image instanceof File) { form.append('image', this.profileParam.image); }
                if (this.profileParam.remove_image) { form.append('remove_image', '1'); }
                form.append('_method', 'PUT');
                await axios.post(apiRoute.profile + '/change-Details', form, {headers: apiService.authHeaderMediaContent});
                this.closeEditProfileModal();
                await this.getProfileApi();
            } catch (error) {
                this.error = error?.response?.data?.errors;
            } finally {
                this.profileLoading = false;
            }
        },

        async changePassword() {
            try {
                this.passwordLoading = true;
                await axios.put(apiRoute.profile+'/change-Password', this.passwordParam, {headers: apiService.authHeaderContent});
                this.closeChangePasswordModal();
                await this.getProfileApi();
            } catch (error) {
                this.error = error.response.data.errors;
            } finally {
                this.passwordLoading = false;
            }
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

    }
}

</script>
