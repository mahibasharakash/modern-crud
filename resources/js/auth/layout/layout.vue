<template>
    <section class="w-full h-screen flex justify-center items-center p-10">
        <div class="w-full max-w-[480px] p-10 border border-gray-200 rounded-lg bg-cover object-cover" :style="{ backgroundImage: 'url(/images/authentication.png)' }">
            <div class="text-center mb-5 font-bold text-[25px]"> UBOLD </div>
            <router-view/>
        </div>
    </section>
</template>

<script>

export default {
    data() {
        return {

        }
    },
    mounted() {

    },
    methods: {

    }
}

</script>
