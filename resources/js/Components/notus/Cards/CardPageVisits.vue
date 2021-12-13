<template>
    <div
        class="
            relative
            flex flex-col
            min-w-0
            break-words
            bg-white
            w-full
            mb-6
            shadow-lg
            rounded
        "
    >
        <div class="rounded-t mb-0 px-4 py-3 border-0">
            <div class="flex flex-wrap items-center">
                <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                    <h3 class="font-semibold text-base text-blueGray-700">
                        Absensi Hari ini
                    </h3>
                </div>
                <div
                    class="
                        relative
                        w-full
                        px-4
                        max-w-full
                        flex-grow flex-1
                        text-right
                    "
                >
                    <Link
                        class="
                            bg-indigo-500
                            text-white
                            active:bg-indigo-600
                            text-xs
                            font-bold
                            uppercase
                            px-3
                            py-1
                            rounded
                            outline-none
                            focus:outline-none
                            mr-1
                            mb-1
                            ease-linear
                            transition-all
                            duration-150
                        "
                        :href="route('report.index')"
                    >
                        Lihat Semua
                    </Link>
                </div>
            </div>
        </div>
        <div class="block w-full overflow-x-auto">
            <!-- Projects table -->
            <table class="items-center w-full bg-transparent border-collapse">
                <thead>
                    <tr>
                        <th
                            class="
                                px-6
                                bg-blueGray-50
                                text-blueGray-500
                                align-middle
                                border border-solid border-blueGray-100
                                py-3
                                text-xs
                                uppercase
                                border-l-0 border-r-0
                                whitespace-nowrap
                                font-semibold
                                text-left
                            "
                        >
                            Nama Pegawai
                        </th>
                        <th
                            class="
                                px-6
                                bg-blueGray-50
                                text-blueGray-500
                                align-middle
                                border border-solid border-blueGray-100
                                py-3
                                text-xs
                                uppercase
                                border-l-0 border-r-0
                                whitespace-nowrap
                                font-semibold
                                text-left
                            "
                        >
                            Masuk
                        </th>
                        <th
                            class="
                                px-6
                                bg-blueGray-50
                                text-blueGray-500
                                align-middle
                                border border-solid border-blueGray-100
                                py-3
                                text-xs
                                uppercase
                                border-l-0 border-r-0
                                whitespace-nowrap
                                font-semibold
                                text-left
                            "
                        >
                            Ijin
                        </th>
                        <th
                            class="
                                px-6
                                bg-blueGray-50
                                text-blueGray-500
                                align-middle
                                border border-solid border-blueGray-100
                                py-3
                                text-xs
                                uppercase
                                border-l-0 border-r-0
                                whitespace-nowrap
                                font-semibold
                                text-left
                            "
                        >
                            Pulang
                        </th>
                        <th
                            class="
                                px-6
                                bg-blueGray-50
                                text-blueGray-500
                                align-middle
                                border border-solid border-blueGray-100
                                py-3
                                text-xs
                                uppercase
                                border-l-0 border-r-0
                                whitespace-nowrap
                                font-semibold
                                text-left
                            "
                        >
                            Ket
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="absensi in absensis" :key="absensi.id">
                        <th
                            class="
                                border-t-0
                                px-6
                                align-middle
                                border-l-0 border-r-0
                                text-xs
                                whitespace-nowrap
                                p-4
                                text-left
                            "
                        >
                            {{ absensi.employe.name }}
                        </th>
                        <td
                            class="
                                border-t-0
                                px-6
                                align-middle
                                border-l-0 border-r-0
                                text-xs
                                whitespace-nowrap
                                p-4
                            "
                        >
                            {{ absensi.in }}
                        </td>
                        <td
                            class="
                                border-t-0
                                px-6
                                align-middle
                                border-l-0 border-r-0
                                text-xs
                                whitespace-nowrap
                                p-4
                            "
                        >
                            {{ absensi.out }}
                        </td>
                        <td
                            class="
                                border-t-0
                                px-6
                                align-middle
                                border-l-0 border-r-0
                                text-xs
                                whitespace-nowrap
                                p-4
                            "
                        >
                            {{ absensi.out }}
                        </td>
                        <td
                            class="
                                border-t-0
                                px-6
                                align-middle
                                border-l-0 border-r-0
                                text-xs
                                whitespace-nowrap
                                p-4
                            "
                        >
                            {{ absensi.desc }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
import { Link } from "@inertiajs/inertia-vue3";
export default {
    props: ["absensis"],
    components: {
        Link,
    },
};
</script>
