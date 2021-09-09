<template>
    <div>
        <sidebar />
        <div class="relative md:ml-64 bg-blueGray-100">
            <admin-navbar :navbarTitle="navbarTitle" />
            <header-stats />
            <div class="px-4 md:px-10 mx-auto w-full -m-24">
                <slot />
                <footer-admin />
            </div>
        </div>
    </div>
</template>
<script>
import AdminNavbar from "@/Components/notus/Navbars/AdminNavbar";
import Sidebar from "@/Components/notus/Sidebar/Sidebar";
import HeaderStats from "@/Components/notus/Headers/HeaderStats";
import FooterAdmin from "@/Components/notus/Footers/FooterAdmin";
export default {
    props: ["navbarTitle"],
    name: "admin-layout",
    components: {
        AdminNavbar,
        Sidebar,
        HeaderStats,
        FooterAdmin,
    },
};
</script>
