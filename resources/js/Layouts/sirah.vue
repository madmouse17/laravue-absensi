<template>
    <Head title="Header" />
    <div
        class="
            fixed
            w-full
            flex
            items-center
            justify-between
            h-14
            text-white
            z-10
        "
    >
        <div
            class="
                flex
                items-right
                justify-start
                md:justify-right
                pl-3
                w-14
                md:w-64
                h-14
                bg-blue-800
                dark:bg-gray-800
                border-none
            "
        >
            <img
                class="w-7 h-7 md:w-10 md:h-10 mr-2 rounded-md overflow-hidden"
                src="https://therminic2018.eu/wp-content/uploads/2018/07/dummy-avatar.jpg"
            />
            <span class="hidden md:block">{{
                $page.props.auth.user.name
            }}</span>
        </div>
        <div
            class="
                flex
                justify-between
                items-center
                h-14
                bg-blue-800
                dark:bg-gray-800
                header-right
            "
        >
            <div
                class="
                    bg-white
                    rounded
                    flex
                    items-center
                    w-full
                    max-w-xl
                    mr-4
                    p-2
                    shadow-sm
                    border border-gray-200
                "
            >
                <button class="outline-none focus:outline-none">
                    <svg
                        class="w-5 text-gray-600 h-5 cursor-pointer"
                        fill="none"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                        ></path>
                    </svg>
                </button>
                <input
                    type="search"
                    name=""
                    id=""
                    placeholder="Search"
                    class="
                        w-full
                        pl-3
                        text-sm text-black
                        outline-none
                        focus:outline-none
                        bg-transparent
                        search
                    "
                />
            </div>
            <ul class="flex items-center">
                <li>
                    <div
                        class="block w-px h-6 mx-3 bg-gray-400 dark:bg-gray-700"
                    ></div>
                </li>
                <li>
                    <a
                        href="#"
                        class="flex items-center mr-4 hover:text-blue-100"
                    >
                        <span class="inline-flex mr-1">
                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                ></path>
                            </svg>
                        </span>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
import { Head } from "@inertiajs/inertia-vue3";

export default {
    components: {
        Head,
    },
};
</script>
