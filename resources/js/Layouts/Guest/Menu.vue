<template>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <nav class="bg-gray-800">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <div
                    class="
                        absolute
                        inset-y-0
                        left-0
                        flex
                        items-center
                        lg:hidden
                    "
                >
                    <!-- Mobile menu button-->
                    <button
                        @click="toggle"
                        type="button"
                        class="
                            inline-flex
                            items-center
                            justify-center
                            p-2
                            rounded-md
                            text-gray-400
                            hover:text-white hover:bg-gray-700
                            focus:outline-none
                            focus:ring-2
                            focus:ring-inset
                            focus:ring-white
                        "
                        aria-controls="mobile-menu"
                        aria-expanded="false"
                    >
                        <span class="sr-only">Open main menu</span>
                        <!--
            Icon when menu is closed.

            Heroicon name: outline/menu

            Menu open: "hidden", Menu closed: "block"
          -->
                        <svg
                            class="block h-6 w-6"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                        </svg>
                        <!--
            Icon when menu is open.

            Heroicon name: outline/x

            Menu open: "block", Menu closed: "hidden"
          -->
                        <svg
                            class="hidden h-6 w-6"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
                <div
                    class="
                        flex-1 flex
                        items-center
                        justify-start
                        sm:items-stretch sm:justify-start
                    "
                >
                    <div class="hidden sm:block sm:ml-6">
                        <div class="flex space-x-4">
                            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                            <MenuLink
                                :href="route('presensi.index')"
                                :active="route().current('presensi.*')"
                                class="px-3 py-2 rounded-md text-sm font-medium"
                                aria-current="page"
                                >Dashboard</MenuLink
                            >

                            <MenuLink
                                :href="route('absensi.index')"
                                :active="route().current('absensi.*')"
                                class="px-3 py-2 rounded-md text-sm font-medium"
                                >Data Absensi</MenuLink
                            >
                        </div>
                    </div>
                </div>
                <div
                    class="
                        absolute
                        inset-y-0
                        right-0
                        flex
                        items-center
                        pr-2
                        sm:static sm:inset-auto sm:ml-6 sm:pr-0
                    "
                >
                    <!-- Profile dropdown -->
                    <div class="ml-3 relative">
                        <div>
                            <button
                                type="button"
                                class="
                                    bg-gray-800
                                    flex
                                    text-sm
                                    rounded-full
                                    focus:outline-none
                                    focus:ring-2
                                    focus:ring-offset-2
                                    focus:ring-offset-gray-800
                                    focus:ring-white
                                "
                                id="user-menu-button"
                                aria-expanded="false"
                                aria-haspopup="true"
                                @click="drop"
                            >
                                <span class="sr-only">Open user menu</span>
                                <h1
                                    class="
                                        px-3
                                        py-2
                                        rounded-md
                                        text-sm
                                        font-medium
                                        text-gray-300
                                    "
                                >
                                    {{ $page.props.auth.user.name }}
                                </h1>
                                <!-- <img
                                    class="h-8 w-8 rounded-full"
                                    src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                    alt=""
                                /> -->
                            </button>
                        </div>

                        <!--
            Dropdown menu, show/hide based on menu state.

            Entering: "transition ease-out duration-100"
              From: "transform opacity-0 scale-95"
              To: "transform opacity-100 scale-100"
            Leaving: "transition ease-in duration-75"
              From: "transform opacity-100 scale-100"
              To: "transform opacity-0 scale-95"
          -->
                        <div
                            :class="
                                dropdown
                                    ? 'block transition ease-out duration-100 transform opacity-100 scale-95'
                                    : 'hidden transition ease-in duration-75'
                            "
                            class="
                                origin-top-right
                                absolute
                                right-0
                                mt-2
                                w-48
                                rounded-md
                                shadow-lg
                                py-1
                                bg-white
                                ring-1 ring-black ring-opacity-5
                                focus:outline-none
                                z-40
                            "
                            role="menu"
                            aria-orientation="vertical"
                            aria-labelledby="user-menu-button"
                            tabindex="-1"
                        >
                            <!-- Active: "bg-gray-100", Not Active: "" -->
                            <MenuLink
                                href="#"
                                class="block px-4 py-2 text-sm text-gray-700"
                                role="menuitem"
                                tabindex="-1"
                                id="user-menu-item-0"
                                >Akun</MenuLink
                            >
                            <MenuLink
                                href="#"
                                class="block px-4 py-2 text-sm text-gray-700"
                                role="menuitem"
                                tabindex="-1"
                                id="user-menu-item-1"
                                >Ubah Password</MenuLink
                            >
                            <MenuLink
                                href="#"
                                class="block px-4 py-2 text-sm text-gray-700"
                                role="menuitem"
                                tabindex="-1"
                                id="user-menu-item-2"
                                >Keluar</MenuLink
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div
            :class="open ? 'block' : 'hidden'"
            class="sm:hidden"
            id="mobile-menu"
        >
            <div class="px-2 pt-2 pb-3 space-y-1">
                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                <MenuLink
                    :href="route('presensi.index')"
                    :active="route().current('presensi.*')"
                    class="block px-3 py-2 rounded-md text-base font-medium"
                    aria-current="page"
                    >Dashboard</MenuLink
                >

                <MenuLink
                    :href="route('absensi.index')"
                    :active="route().current('absensi.*')"
                    class="block px-3 py-2 rounded-md text-base font-medium"
                    >Data Absensi</MenuLink
                >
            </div>
        </div>
    </nav>
</template>
<script>
import MenuLink from "@/Components/notus/Navbars/MenuLink";
export default {
    components: {
        MenuLink,
    },
    data() {
        return {
            open: false,
            dropdown: false,
        };
    },
    methods: {
        toggle() {
            this.open = !this.open;
        },
        drop() {
            this.dropdown = !this.dropdown;
        },
    },
};
</script>
