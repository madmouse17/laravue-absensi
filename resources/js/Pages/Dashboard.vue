<template>
    <Head title="Dashboard" />
    <Sirah></Sirah>
    <Coba> </Coba>
</template>

<script>
// import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import Coba from "@/Layouts/sidebar.vue";
import Sirah from "@/Layouts/sirah.vue";
import { Head } from "@inertiajs/inertia-vue3";

export default {
    components: {
        // BreezeAuthenticatedLayout,
        Coba,
        Sirah,
        Head,
    },
};
</script>
