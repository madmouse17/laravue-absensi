<template>
    <admin-layouts navbarTitle="Laporan Absensi">
        <Head title="Laporan Absensi" />
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
                    <div class="card">
                        <Toolbar class="p-mb-4">
                            <template #left>
                                <Calendar
                                    id="range"
                                    v-model="form.date"
                                    selectionMode="range"
                                    :manualInput="false"
                                    placeholder="Tanggal Laporan"
                                />
                                <Button
                                    type="submit"
                                    label="Download"
                                    icon="pi pi-download"
                                    class="p-button-success"
                                    @click="submit()"
                                ></Button>
                            </template>
                        </Toolbar>

                        <Toolbar>
                            <template #left>
                                <Button
                                    label="Export CSV"
                                    icon="pi pi-download"
                                    class="p-button-help"
                                    @click="exportCSV($event)"
                                />
                            </template>
                            <template #right>
                                <span class="p-mr-2 p-mb-2 p-input-icon-left">
                                    <i class="pi pi-search" />
                                    <InputText
                                        v-model="filters['global'].value"
                                        placeholder="Keyword Search"
                                    />
                                </span>
                            </template>
                        </Toolbar>
                        <!-- Projects table -->
                        <DataTable
                            :value="attendances"
                            stripedRows
                            :paginator="true"
                            :rows="10"
                            paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                            :rowsPerPageOptions="[10, 20, 50]"
                            responsiveLayout="scroll"
                            currentPageReportTemplate="Showing {first} to {last} of {totalRecords}"
                            sortField="rownum"
                            :sortOrder="-1"
                            :globalFilterFields="['employe.name']"
                            dataKey="id"
                            v-model:filters="filters"
                            filterDisplay="menu"
                            :loading="loading"
                            :scrollable="true"
                            scrollHeight="400px"
                            ref="dt"
                            :resizableColumns="true"
                            columnResizeMode="fit"
                            showGridlines
                        >
                            <template #empty> Data Absensi tidak ada </template>
                            <template #loading>
                                Sedang Memuat Data Absensi.Mohon Tunggu.
                            </template>
                            <Column
                                field="rownum"
                                header="No"
                                :sortable="true"
                            ></Column>
                            <Column
                                field="employe.name"
                                header="Nama Pegawai"
                                :sortable="true"
                            ></Column>
                            <Column
                                field="attended_at"
                                header="Tanggal"
                                :sortable="true"
                            ></Column>
                            <Column
                                field="in"
                                header="Masuk"
                                :sortable="true"
                            ></Column>
                            <Column header="Ijin">
                                <template #body="slotProps">
                                    <img
                                        :src="slotProps.data.url"
                                        :alt="slotProps.data.permission"
                                        class="table-image"
                                    />
                                </template>
                            </Column>
                            <Column
                                field="out"
                                header="Pulang"
                                :sortable="true"
                            ></Column>

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
import AttendanceService from "../Service/Service";
import { Link } from "@inertiajs/inertia-vue3";
import { Head } from "@inertiajs/inertia-vue3";
import Button from "primevue/button";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import Toolbar from "primevue/toolbar";
import InputText from "primevue/inputtext";
import Calendar from "primevue/calendar";

export default {
    components: {
        AdminLayouts,
        Link,
        Head,
        Button,
        DataTable,
        Column,
        Toolbar,
        InputText,
        Calendar,
    },
    data() {
        return {
            form: this.$inertia.form({
                date: null,
            }),
            attendances: null,
            filters: null,
            loading: true,
            selectedAttendances: null,
            attendance: {},
            expandedRows: [],
            selectedColumns: null,
            columns: null,
        };
    },
    created() {
        this.attendanceService = new AttendanceService();
        this.initFilters();
    },
    mounted() {
        this.attendanceService.getAttendance().then((data) => {
            this.attendances = data;
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
        submit() {
            this.form.post(this.route("report.store"), {
                preserveState: true,
                replace: true,
            });
        },
    },
};
</script>
