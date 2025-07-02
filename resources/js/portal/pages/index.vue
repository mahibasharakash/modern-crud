<template>

    <div class="w-full max-w-[1024px] mx-auto py-5">
        <div class="w-full flex justify-between items-center mb-4">
            <div class="text-[25px] font-bold"> Crud </div>
            <button type="button" class="bg-gray-700 text-white outline-0 border-0 px-7 cursor-pointer py-2 inline-block rounded-lg" @click="openManageModal(null)">
                Create
            </button>
        </div>

        <div class="w-full block">

            <!-- list -->
            <table class="table-auto w-full text-[14px]">
                <thead class="bg-gray-300">
                    <tr>
                        <th class="px-4 py-2 text-start font-medium">
                            Name
                        </th>
                        <th class="px-4 py-2 text-start font-medium">
                            Email
                        </th>
                        <th class="px-4 py-2 text-start font-medium">
                            Phone Number
                        </th>
                        <th class="px-4 py-2 text-end font-medium">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-gray-200">
                <tr v-for="each in tableData" :key="each.id">
                    <td class="px-4 py-2 text-start font-normal">
                        {{ each.name }}
                    </td>
                    <td class="px-4 py-2 text-start font-normal">
                        {{ each.email }}
                    </td>
                    <td class="px-4 py-2 text-start font-normal">
                        {{ each.phone_number }}
                    </td>
                    <td class="px-4 py-2 text-start font-normal">
                        <div class="flex justify-end items-center gap-2">
                            <button type="button" class="min-w-[35px] max-w-[35px] min-h-[35px] max-h-[35px] bg-gray-300 inline-flex justify-center items-center rounded-full cursor-pointer" @click="openManageModal(each.id)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="stroke-gray-600 min-w-[15px] max-w-[15px] min-h-[15px] max-h-[15px]">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                </svg>
                            </button>
                            <button type="button" class="min-w-[35px] max-w-[35px] min-h-[35px] max-h-[35px] bg-rose-200 inline-flex justify-center items-center rounded-full cursor-pointer" @click="openDeleteModal(each.id)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="stroke-rose-600 min-w-[15px] max-w-[15px] min-h-[15px] max-h-[15px]">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr v-if="tableData.length === 0">
                    <td colspan="4" class="text-center py-4 text-gray-600">
                        No records found.
                    </td>
                </tr>
                </tbody>

            </table>

            <div class="w-full flex justify-between gap-3 mt-5">
                <div class="flex justify-center items-center gap-2">
                    <!-- Previous -->
                    <button
                        type="button"
                        class="cursor-pointer min-w-[35px] min-h-[35px] max-w-[35px] max-h-[35px] inline-flex justify-center items-center rounded-full bg-gray-200 outline-0"
                        :disabled="currentPage <= 1"
                        @click="goPrevious()"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="min-w-[15px] min-h-[15px] max-w-[15px] max-h-[15px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                        </svg>
                    </button>

                    <!-- Page Numbers -->
                    <!-- Page Numbers -->
                    <template v-if="pageCount <= 4">
                        <button
                            v-for="page in pageCount"
                            :key="page"
                            type="button"
                            class="cursor-pointer min-w-[35px] min-h-[35px] max-w-[35px] max-h-[35px] inline-flex justify-center items-center rounded-full outline-0"
                            :class="page === currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200 text-black'"
                            @click="changePage(page)"
                        >
                            {{ page }}
                        </button>
                    </template>

                    <template v-else>
                        <!-- Always show first page -->
                        <button
                            type="button"
                            :key="1"
                            class="cursor-pointer min-w-[35px] min-h-[35px] max-w-[35px] max-h-[35px] inline-flex justify-center items-center rounded-full outline-0"
                            :class="1 === currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200 text-black'"
                            @click="changePage(1)"
                        >
                            1
                        </button>

                        <!-- Decide if to show page 2 or ellipsis -->
                        <template v-if="currentPage <= 3">
                            <button
                                v-for="page in [2,3]"
                                :key="page"
                                type="button"
                                class="cursor-pointer min-w-[35px] min-h-[35px] max-w-[35px] max-h-[35px] inline-flex justify-center items-center rounded-full outline-0"
                                :class="page === currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200 text-black'"
                                @click="changePage(page)"
                            >
                                {{ page }}
                            </button>
                            <span class="px-2">…</span>
                        </template>

                        <template v-else-if="currentPage >= pageCount - 2">
                            <span class="px-2">…</span>
                            <button
                                v-for="page in [pageCount - 2, pageCount - 1]"
                                :key="page"
                                type="button"
                                class="cursor-pointer min-w-[35px] min-h-[35px] max-w-[35px] max-h-[35px] inline-flex justify-center items-center rounded-full outline-0"
                                :class="page === currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200 text-black'"
                                @click="changePage(page)"
                            >
                                {{ page }}
                            </button>
                        </template>

                        <template v-else>
                            <span class="px-2">…</span>
                            <button
                                :key="currentPage - 1"
                                type="button"
                                class="cursor-pointer min-w-[35px] min-h-[35px] max-w-[35px] max-h-[35px] inline-flex justify-center items-center rounded-full outline-0"
                                :class="(currentPage - 1) === currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200 text-black'"
                                @click="changePage(currentPage - 1)"
                            >
                                {{ currentPage - 1 }}
                            </button>
                            <button
                                :key="currentPage"
                                type="button"
                                class="cursor-pointer min-w-[35px] min-h-[35px] max-w-[35px] max-h-[35px] inline-flex justify-center items-center rounded-full outline-0"
                                :class="currentPage === currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200 text-black'"
                                @click="changePage(currentPage)"
                            >
                                {{ currentPage }}
                            </button>
                            <span class="px-2">…</span>
                        </template>

                        <!-- Always show last page -->
                        <button
                            :key="pageCount"
                            type="button"
                            class="cursor-pointer min-w-[35px] min-h-[35px] max-w-[35px] max-h-[35px] inline-flex justify-center items-center rounded-full outline-0"
                            :class="pageCount === currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200 text-black'"
                            @click="changePage(pageCount)"
                        >
                            {{ pageCount }}
                        </button>
                    </template>

                    <!-- Next -->
                    <button
                        type="button"
                        class="cursor-pointer min-w-[35px] min-h-[35px] max-w-[35px] max-h-[35px] inline-flex justify-center items-center rounded-full bg-gray-200 outline-0"
                        :disabled="currentPage >= pageCount"
                        @click="goNext()"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="min-w-[15px] min-h-[15px] max-w-[15px] max-h-[15px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                </div>

                <!-- Page Info -->
                <div>
                    {{ from }}
                    –
                    {{ to }}
                    of
                    {{ total }}
                </div>
            </div>


        </div>

    </div>

    <!-- manage modal -->
    <section class="fixed inset-0 grid sm:justify-center items-center duration-500 z-50 p-5 overflow-y-auto" :class="{ 'invisible bg-black/35' : !isManageModalActive, 'visible bg-black/65' : isManageModalActive }" @click="closeManageModal()">
        <form @submit.prevent="manageApi()" class="bg-white rounded-3xl w-full sm:max-w-[550px] sm:min-w-[550px] p-10 duration-500 origin-top" :class="{ 'translate-y-0 opacity-100' : isManageModalActive, '-translate-y-1/2 opacity-0' : !isManageModalActive }" @click.stop>
            <div class="flex justify-between items-center">
                <div class="font-medium text-[21px]"> Crud <template v-if="!formData.id"> Create </template> <template v-if="formData.id"> Edit </template> </div>
                <button type="button" class="bg-transparent duration-500 hover:bg-gray-200 text-white min-w-[45px] max-w-[45px] min-h-[45px] max-h-[45px] rounded-full inline-flex justify-center items-center cursor-pointer" @click="closeManageModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#000" class="min-w-[20px] max-w-[20px] min-h-[20px] max-h-[20px]">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
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
                        <img :src="attach_preview" class="min-w-[190px] max-w-[190px] min-h-[190px] max-h-[190px] rounded-full cursor-pointer bg-gray-200 duration-500 hover:bg-gray-300 max-h-[250px] object-cover bg-cover" alt="uploaded-image" />
                        <div class="absolute inset-0 w-full h-full flex justify-center items-center bg-white/25">
                            <button type="button" class="min-w-[35px] max-w-[35px] min-h-[35px] max-h-[35px] bg-rose-200 inline-flex justify-center items-center rounded-full cursor-pointer" @click="removeFile()">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="stroke-rose-600 min-w-[15px] max-w-[15px] min-h-[15px] max-h-[15px]">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="w-full block mb-3">
                    <label for="name" class="block mb-1 text-[13px] font-medium"> Name </label>
                    <input id="name" type="text" name="name" v-model="formData.name" class="w-full text-[13px] border border-gray-200 min-h-[45px] max-h-[45px] duration-500 ring-0 outline-0 focus-within:ring-2 focus-within:ring-blue-400 rounded-md px-3" autocomplete="off" />
                    <div class="text-rose-600 mt-2 text-[12px] font-medium" v-if="error?.name"> {{error?.name[0]}} </div>
                </div>
                <div class="w-full block mb-3">
                    <label for="email" class="block mb-1 text-[13px] font-medium"> Email </label>
                    <input id="email" type="email" name="email" v-model="formData.email" class="w-full text-[13px] border border-gray-200 min-h-[45px] max-h-[45px] duration-500 ring-0 outline-0 focus-within:ring-2 focus-within:ring-blue-400 rounded-md px-3" autocomplete="off" />
                    <div class="text-rose-600 mt-2 text-[12px] font-medium" v-if="error?.email"> {{error?.email[0]}} </div>
                </div>
                <div class="w-full block">
                    <label for="phone_number" class="block mb-1 text-[13px] font-medium"> Phone Number </label>
                    <input id="phone_number" type="text" name="phone_number" v-model="formData.phone_number" class="w-full text-[13px] border border-gray-200 min-h-[45px] max-h-[45px] duration-500 ring-0 outline-0 focus-within:ring-2 focus-within:ring-blue-400 rounded-md px-3" autocomplete="off" />
                    <div class="text-rose-600 mt-2 text-[12px] font-medium" v-if="error?.phone_number"> {{error?.phone_number[0]}} </div>
                </div>
            </div>
            <div class="flex justify-end items-center gap-3">
                <button type="button" class="bg-gray-200 duration-500 hover:bg-gray-300 min-h-[45px] max-h-[45px] min-w-[100px] max-w-[100px] rounded-xl text-[12px] font-medium cursor-pointer" @click="closeManageModal()">
                    Cancel
                </button>
                <button type="submit" class="bg-gray-200 duration-500 hover:bg-gray-300 min-h-[45px] max-h-[45px] min-w-[100px] max-w-[100px] rounded-xl text-[12px] font-medium cursor-pointer">
                    <template v-if="!formData.id"> Save </template>
                    <template v-if="formData.id"> Update </template>
                </button>
            </div>
        </form>
    </section>

    <!-- delete modal -->
    <section class="fixed inset-0 grid sm:justify-center items-center duration-500 z-50 p-5 overflow-y-auto" :class="{ 'invisible bg-black/35' : !isDeleteModalActive, 'visible bg-black/65' : isDeleteModalActive }" @click="closeDeleteModal()">
        <form @submit.prevent="deleteApi()" class="bg-white rounded-3xl w-full sm:max-w-[350px] sm:min-w-[350px] py-10 px-5 duration-500 origin-top" :class="{ 'translate-y-0 opacity-100' : isDeleteModalActive, '-translate-y-1/2 opacity-0' : !isDeleteModalActive }" @click.stop>
            <div class="w-full flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="stroke-rose-500 min-w-[65px] max-w-[65px] min-h-[65px] max-h-[65px]">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
            </div>
            <div class="text-center text-[21px] my-4"> Are you sure? </div>
            <div class="w-full flex justify-center items-center gap-3">
                <button type="button" class="bg-gray-200 duration-500 hover:bg-gray-300 min-h-[45px] max-h-[45px] min-w-[110px] max-w-[110px] rounded-xl text-[12px] font-medium cursor-pointer" @click="closeDeleteModal()">
                    Cancel
                </button>
                <button type="submit" class="bg-rose-200 duration-500 hover:bg-rose-300 text-rose-600 min-h-[45px] max-h-[45px] min-w-[110px] max-w-[110px] rounded-xl text-[12px] font-medium cursor-pointer">
                    Confirm
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
    data() {
        return {
            isManageModalActive: false,
            isDeleteModalActive: false,
            manageLoading: false,
            deleteLoading: false,
            singleLoading: false,
            loading: false,
            formData: {
                id: null,
                image: null,
                name: '',
                email: '',
                phone_number: '',
            },
            tableData: [],
            currentPage: 1,
            perPage: 10,
            total: 0,
            pageCount: 0,
            from: 0,
            to: 0,
            error: {},
            attach_preview: null,
        }
    },
    async mounted() {
        await this.readApi(1);
    },
    methods: {

        /*** open manage modal ***/
        openManageModal(data = null) {
            this.formData.remove_image = false;
            if(data !== null) {
                this.singleApi(data);
            } else {
                this.attach_preview = null;
                this.formData = {
                    id: null,
                    image: null,
                    name: '',
                    email: '',
                    phone_number: '',
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
            if(this.formData.id !== null) {
                this.updateApi();
            } else {
                this.createApi();
            }
        },

        /*** create api ***/
        async createApi() {
            try {
                this.manageLoading = true;
                const response = await axios.post(apiRoute.crud, this.formData, {headers: apiService.mediaHeaderContent});
                this.closeManageModal();
                await this.readApi();
            } catch (error) {
                this.error = error?.response?.data?.errors;
            } finally {
                this.manageLoading = false;
            }
        },

        /*** read api ***/
        async readApi(page = 1) {
            try {
                this.loading = true;
                const response = await axios.get(`${apiRoute.crud}?page=${page}`, {
                    headers: apiService.headerContent
                });

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

        goPrevious() {
            this.changePage(this.currentPage - 1);
        },

        goNext() {
            this.changePage(this.currentPage + 1);
        },

        changePage(page) {
            page = Number(page);
            if (isNaN(page)) page = 1;
            if (page < 1) page = 1;
            if (page > this.pageCount) page = this.pageCount;
            if (page === this.currentPage) return;
            this.readApi(page);
        },

        /*** single api ***/
        async singleApi(data) {
            try {
                this.singleLoading = true;
                const response = await axios.get(apiRoute.crud+'/'+data, this.formData, {headers: apiService.mediaHeaderContent});
                this.formData = response?.data;
                if(response?.data?.image) {
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

        /*** update api ***/
        async updateApi() {
            try {
                this.manageLoading = true;
                let form = new FormData();
                form.append('name', this.formData.name);
                form.append('email', this.formData.email);
                form.append('phone_number', this.formData.phone_number);
                if (this.formData.image instanceof File) {
                    form.append('image', this.formData.image);
                }
                if (this.formData.remove_image) {
                    form.append('remove_image', '1');
                }
                form.append('_method', 'PUT');
                const response = await axios.post(apiRoute.crud + '/' + this.formData.id, form, { headers: apiService.mediaHeaderContent });
                this.closeManageModal();
                await this.readApi();
            } catch (error) {
                this.error = error?.response?.data?.errors;
            } finally {
                this.manageLoading = false;
            }
        },

        /*** delete api ***/
        async deleteApi() {
            try {
                this.deleteLoading = true;
                const response = await axios.delete(apiRoute.crud+'/'+this.formData.id, {headers: apiService.headerContent});
                this.closeDeleteModal();
                await this.readApi();
            } catch (error) {
                this.error = error?.response?.data?.errors;
            } finally {
                this.deleteLoading = false;
            }
        },

    }
}

</script>
