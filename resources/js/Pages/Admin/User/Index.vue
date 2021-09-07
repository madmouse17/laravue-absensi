<template>
    <admin-layouts>
        <Head title="User" />
        <div class="flex flex-wrap mt-4">
            <div class="w-full mb-12 px-4">
                <div
                    class="
                        relative
                        flex flex-col
                        min-w-0
                        break-words
                        w-full
                        mb-6
                        shadow-lg
                        rounded
                        bg-white
                    "
                >
                    <div :alert="Alert"></div>
                    <div class="rounded-t mb-0 px-4 py-3 border-0">
                        <div class="flex flex-wrap items-center">
                            <div
                                class="
                                    relative
                                    w-full
                                    px-4
                                    max-w-full
                                    flex-grow flex-1
                                "
                            >
                                <h3
                                    class="
                                        font-semibold
                                        text-lgtext-blueGray-700
                                    "
                                >
                                    User Tables
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class="block w-full overflow-x-auto">
                        <!-- Projects table -->
                        <table class="display" id="users-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Tanggal Buat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </admin-layouts>
</template>
<script>
import AdminLayouts from "@/Layouts/Admin.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Head } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
export default {
    props: ["flash"],
    components: {
        AdminLayouts,
        Link,
        Head,
    },
    created() {
        $(document).ready(function () {
            $("#users-table").DataTable({
                processing: true,
                serverside: true,
                ajax: "/admin/user/json",
                columns: [
                    { data: "rownum", name: "rownum" },
                    { data: "name", name: "name" },
                    { data: "created_at", name: "created_at" },
                    {
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false,
                    },
                ],
                dom: "Blfrtip",
                lengthMenu: [
                    [10, 25, 50, -1],
                    ["10 Filas", "25 Filas", "50 Filas", "Show All"],
                ],

                dom: "Bfrtip",
                buttons: [
                    "pageLength",
                    {
                        extend: "collection",
                        text: "Export",
                        buttons: ["copy", "excel", "csv", "pdf", "print"],
                    },
                    {
                        text: "Tambah Data",
                        action: function (e, dt, button, config) {
                            Inertia.get("/admin/user/create");
                        },
                    },
                ],
            });
        });
    },
    computed: {
        Alert() {
            if (this.flash.message) {
                const swall = this.$swal({
                    toast: !0,
                    position: "top-end",
                    showConfirmButton: !1,
                    timer: 3e3,
                    icon: "success",
                    text: this.flash.message,
                });
                return swall;
            }
        },
    },
};
</script>
