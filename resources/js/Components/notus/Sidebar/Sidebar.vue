<template>
    <nav
        class="
            md:left-0
            md:block
            md:fixed
            md:top-0
            md:bottom-0
            md:overflow-y-auto
            md:flex-row
            md:flex-nowrap
            md:overflow-hidden
            shadow-xl
            bg-white
            flex flex-wrap
            items-center
            justify-between
            relative
            md:w-64
            z-10
            py-4
            px-6
        "
    >
        <div
            class="
                md:flex-col md:items-stretch md:min-h-full md:flex-nowrap
                px-0
                flex flex-wrap
                items-center
                justify-between
                w-full
                mx-auto
            "
        >
            <!-- Toggler -->
            <button
                class="
                    cursor-pointer
                    text-black
                    opacity-50
                    md:hidden
                    px-3
                    py-1
                    text-xl
                    leading-none
                    bg-transparent
                    rounded
                    border border-solid border-transparent
                "
                type="button"
                v-on:click="toggleCollapseShow('bg-white m-2 py-3 px-6')"
            >
                <i class="fas fa-bars"></i>
            </button>
            <!-- Brand -->
            <inertia-link
                class="
                    md:block
                    text-left
                    md:pb-2
                    text-blueGray-600
                    mr-0
                    inline-block
                    whitespace-nowrap
                    text-sm
                    uppercase
                    font-bold
                    p-4
                    px-0
                "
                to="/"
            >
                Sistem Absensi VerMuk
            </inertia-link>
            <!-- User -->
            <ul class="md:hidden items-center flex flex-wrap list-none">
                <li class="inline-block relative">
                    <notification-dropdown />
                </li>
                <li class="inline-block relative">
                    <user-dropdown />
                </li>
            </ul>
            <!-- Collapse -->
            <div
                class="
                    md:flex
                    md:flex-col
                    md:items-stretch
                    md:opacity-100
                    md:relative
                    md:mt-4
                    md:shadow-none
                    shadow
                    absolute
                    top-0
                    left-0
                    right-0
                    z-40
                    overflow-y-auto overflow-x-hidden
                    h-auto
                    items-center
                    flex-1
                    rounded
                "
                v-bind:class="collapseShow"
            >
                <!-- Collapse header -->
                <div
                    class="
                        md:min-w-full md:hidden
                        block
                        pb-4
                        mb-4
                        border-b border-solid border-blueGray-200
                    "
                >
                    <div class="flex flex-wrap">
                        <div class="w-6/12">
                            <inertia-link
                                class="
                                    md:block
                                    text-left
                                    md:pb-2
                                    text-blueGray-600
                                    mr-0
                                    inline-block
                                    whitespace-nowrap
                                    text-sm
                                    uppercase
                                    font-bold
                                    p-4
                                    px-0
                                "
                                to="/"
                            >
                                Vue Notus
                            </inertia-link>
                        </div>
                        <div class="w-6/12 flex justify-end">
                            <button
                                type="button"
                                class="
                                    cursor-pointer
                                    text-black
                                    opacity-50
                                    md:hidden
                                    px-3
                                    py-1
                                    text-xl
                                    leading-none
                                    bg-transparent
                                    rounded
                                    border border-solid border-transparent
                                "
                                v-on:click="toggleCollapseShow('hidden')"
                            >
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Form -->
                <form class="mt-6 mb-4 md:hidden">
                    <div class="mb-3 pt-0">
                        <input
                            type="text"
                            placeholder="Search"
                            class="
                                px-3
                                py-2
                                h-12
                                border border-solid border-blueGray-500
                                placeholder-blueGray-300
                                text-blueGray-600
                                bg-white
                                rounded
                                text-base
                                leading-snug
                                shadow-none
                                outline-none
                                focus:outline-none
                                w-full
                                font-normal
                            "
                        />
                    </div>
                </form>

                <!-- Divider -->
                <hr class="my-4 md:min-w-full" />
                <!-- Heading -->
                <h6
                    class="
                        md:min-w-full
                        text-blueGray-500 text-xs
                        uppercase
                        font-bold
                        block
                        pt-1
                        pb-4
                        no-underline
                    "
                >
                    Admin Layout Pages
                </h6>
                <!-- Navigation -->

                <ul class="md:flex-col md:min-w-full flex flex-col list-none">
                    <li class="items-center">
                        <NavbarLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                            class="text-xs uppercase py-3 font-bold block"
                        >
                            <IconLink
                                :href="route('dashboard')"
                                :active="route().current('dashboard')"
                                class="fas fa-tv mr-2 text-sm"
                            >
                            </IconLink>
                            Dashboard
                        </NavbarLink>
                    </li>

                    <li class="items-center">
                        <NavbarLink
                            :href="route('user.index')"
                            :active="route().current('user.*')"
                            class="text-xs uppercase py-3 font-bold block"
                        >
                            <IconLink
                                :href="route('user.index')"
                                :active="route().current('user.*')"
                                class="fas fa-user mr-2 text-sm"
                            >
                            </IconLink>
                            User
                        </NavbarLink>
                    </li>

                    <li class="items-center">
                        <NavbarLink
                            :href="route('position.index')"
                            :active="route().current('position.*')"
                            class="text-xs uppercase py-3 font-bold block"
                        >
                            <IconLink
                                :href="route('position.index')"
                                :active="route().current('position.*')"
                                class="fas fa-sitemap mr-2 text-sm"
                            >
                            </IconLink>
                            Jabatan
                        </NavbarLink>
                    </li>

                    <li class="items-center">
                        <NavbarLink
                            :href="route('employe.index')"
                            :active="route().current('employe.*')"
                            class="text-xs uppercase py-3 font-bold block"
                        >
                            <IconLink
                                :href="route('employe.index')"
                                :active="route().current('employe.*')"
                                class="fas fa-users mr-2 text-sm"
                            >
                            </IconLink>
                            Pegawai
                        </NavbarLink>
                    </li>
                    <li class="items-center">
                        <NavbarLink
                            :href="route('location.index')"
                            :active="route().current('location.*')"
                            class="text-xs uppercase py-3 font-bold block"
                        >
                            <IconLink
                                :href="route('location.index')"
                                :active="route().current('location.*')"
                                class="fas fa-map mr-2 text-sm"
                            >
                            </IconLink>
                            Lokasi
                        </NavbarLink>
                    </li>
                </ul>
                <hr class="my-4 md:min-w-full" />
                <h6
                    class="
                        md:min-w-full
                        text-blueGray-500 text-xs
                        uppercase
                        font-bold
                        block
                        pt-1
                        pb-4
                        no-underline
                    "
                >
                    Laporan
                </h6>
                <ul class="md:flex-col md:min-w-full flex flex-col list-none">
                    <li class="items-center">
                        <NavbarLink
                            :href="route('report.index')"
                            :active="route().current('report.*')"
                            class="text-xs uppercase py-3 font-bold block"
                        >
                            <IconLink
                                :href="route('report.index')"
                                :active="route().current('report.*')"
                                class="fas fa-calendar mr-2 text-sm"
                            >
                            </IconLink>
                            Absensi
                        </NavbarLink>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import NotificationDropdown from "@/Components/notus/Dropdowns/NotificationDropdown.vue";
import UserDropdown from "@/Components/notus/Dropdowns/UserDropdown.vue";
import NavbarLink from "@/Components/notus/Navbars/NavLink";
import IconLink from "@/Components/notus/IconLink/Iconlink.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default {
    data() {
        return {
            collapseShow: "hidden",
        };
    },
    methods: {
        toggleCollapseShow: function (classes) {
            this.collapseShow = classes;
        },
    },
    components: {
        NotificationDropdown,
        UserDropdown,
        Link,
        NavbarLink,
        IconLink,
    },
};
</script>
