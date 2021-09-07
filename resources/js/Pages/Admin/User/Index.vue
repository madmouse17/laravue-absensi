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
                    <div class="block w-full overflow-x-auto">
                        <!-- Projects table -->
                        <DataTable
                            :value="users"
                            showGridlines
                            stripedRows
                            :paginator="true"
                            :rows="10"
                            paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                            :rowsPerPageOptions="[10, 20, 50]"
                            responsiveLayout="scroll"
                            currentPageReportTemplate="Showing {first} to {last} of {totalRecords}"
                            sortField="rownum"
                            :sortOrder="-1"
                            :globalFilterFields="['name', 'email']"
                            dataKey="id"
                            v-model:filters="filters"
                            filterDisplay="menu"
                            :loading="loading"
                            :scrollable="true"
                            scrollHeight="400px"
                            ref="dt"
                        >
                            <template #header>
                                <div class="table-header">User Tables</div>
                                <div class="p-d-flex p-flex-wrap">
                                    <Button
                                        icon="pi pi-external-link"
                                        label="Export"
                                        class="p-button-success"
                                        @click="exportCSV($event)"
                                    />
                                    <span
                                        class="p-mr-2 p-mb-2 p-input-icon-left"
                                    >
                                        <i class="pi pi-search" />
                                        <InputText
                                            v-model="filters['global'].value"
                                            placeholder="Keyword Search"
                                        />
                                    </span>
                                    <Button
                                        label="Tambah Data"
                                        class="p-mr-2 p-mb-2"
                                    />
                                </div>
                            </template>
                            <template #empty> Data User tidak ada </template>
                            <template #loading>
                                Sedang Memuat Data User.Mohon Tunggu.
                            </template>
                            <Column
                                field="rownum"
                                header="No"
                                :sortable="true"
                            ></Column>
                            <Column
                                field="name"
                                header="Nama"
                                :sortable="true"
                            ></Column>
                            <Column
                                field="email"
                                header="Email"
                                :sortable="true"
                            ></Column>
                            <Column
                                field="created_at"
                                header="Tanggal"
                                :sortable="true"
                            ></Column>
                            <template #paginatorLeft>
                                <Button
                                    type="button"
                                    icon="pi pi-refresh"
                                    class="p-button-text"
                                />
                            </template>
                            <template #paginatorRight>
                                <Button
                                    type="button"
                                    icon="pi pi-cloud"
                                    class="p-button-text"
                                />
                            </template>
                            <!-- <Column field="color" header="Color"></Column> -->
                        </DataTable>
                    </div>
                </div>
            </div>
        </div>
    </admin-layouts>
</template>
<script>
import AdminLayouts from "@/Layouts/Admin.vue";
import UserService from "../Service/Service";
import { Link } from "@inertiajs/inertia-vue3";
import { Head } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import Button from "primevue/button";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import { ref, onMounted } from "vue";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import InputText from "primevue/inputtext";
export default {
    props: ["flash"],
    components: {
        AdminLayouts,
        Link,
        Head,
        Button,
        DataTable,
        Column,
        InputText,
    },
    data() {
        return {
            users: null,
            filters: null,
            loading: true,
        };
    },
    created() {
        this.userService = new UserService();
        this.initFilters();
    },
    mounted() {
        this.userService.getUser().then((data) => {
            this.users = data;
            this.loading = false;
        });
    },
    methods: {
        initFilters() {
            this.filters = {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
            };
        },
        exportCSV() {
            this.$refs.dt.exportCSV();
        },
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
