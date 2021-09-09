<template>
    <Head title="Dashboard" />
    <admin-layouts navbarTitle="Dashboard">
        <div>
            <div class="flex flex-wrap">
                <div class="w-full xl:w-8/12 mb-12 xl:mb-0 px-4">
                    <card-line-chart />
                </div>
                <div class="w-full xl:w-4/12 px-4">
                    <card-bar-chart />
                </div>
            </div>
            <div class="flex flex-wrap mt-4">
                <div class="w-full xl:w-8/12 mb-12 xl:mb-0 px-4">
                    <card-page-visits />
                </div>
                <div class="w-full xl:w-4/12 px-4">
                    <card-social-traffic />
                </div>
            </div>
        </div>
    </admin-layouts>
</template>
<script>
import CardLineChart from "@/Components/notus/Cards/CardLineChart.vue";
import CardBarChart from "@/Components/notus/Cards/CardBarChart.vue";
import CardPageVisits from "@/Components/notus/Cards/CardPageVisits.vue";
import CardSocialTraffic from "@/Components/notus/Cards/CardSocialTraffic.vue";
import AdminLayouts from "@/Layouts/Admin.vue";
import { Head } from "@inertiajs/inertia-vue3";
export default {
    components: {
        CardLineChart,
        CardBarChart,
        CardPageVisits,
        CardSocialTraffic,
        AdminLayouts,
        Head,
    },
};
</script>
