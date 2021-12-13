<template>
    <Head title="Dashboard" />
    <admin-layouts navbarTitle="Dashboard">
        <div>
            <div class="flex flex-wrap">
                <div class="w-full xl:w-12 mb-12 xl:mb-0 px-4">
                    <card-line-chart
                        :data="count"
                        :month="month"
                        :year="now"
                        :permission="permission"
                    />
                </div>
            </div>
            <div class="flex flex-wrap mt-4">
                <div class="w-full xl:w-12 mb-12 xl:mb-0 px-4">
                    <card-page-visits :absensis="absensi" />
                </div>
            </div>
        </div>
    </admin-layouts>
</template>
<script>
import CardLineChart from "@/Components/notus/Cards/CardLineChart.vue";
import CardPageVisits from "@/Components/notus/Cards/CardPageVisits.vue";
import AdminLayouts from "@/Layouts/Admin.vue";
import { Head } from "@inertiajs/inertia-vue3";
export default {
    props: ["count", "month", "now", "permission", "absensi"],
    components: {
        CardLineChart,
        CardPageVisits,
        AdminLayouts,
        Head,
    },
};
</script>
