<template>
    <admin-layouts navbarTitle="Pegawai">
        <Toast />
        <Head title="Pegawai" />
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
                    <div class="card">
                        <Toolbar class="p-mb-4">
                            <template #left>
                                <Button
                                    label="New"
                                    icon="pi pi-plus"
                                    class="p-button-success p-mr-2"
                                    @click="openNew"
                                />
                                <Button
                                    label="Delete"
                                    icon="pi pi-trash"
                                    class="p-button-danger"
                                    @click="confirmDeleteSelected"
                                    :disabled="
                                        !selectedEmployes ||
                                        !selectedEmployes.length
                                    "
                                />
                            </template>

                            <template #right>
                                <Button
                                    label="Export CSV"
                                    icon="pi pi-download"
                                    class="p-button-help"
                                    @click="exportCSV($event)"
                                />
                            </template>
                        </Toolbar>
                        <Toolbar>
                            <template #left>
                                <div class="table-header">Pegawai Tables</div>
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
                            :value="employes"
                            stripedRows
                            :paginator="true"
                            :rows="10"
                            paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                            :rowsPerPageOptions="[10, 20, 50]"
                            responsiveLayout="scroll"
                            currentPageReportTemplate="Showing {first} to {last} of {totalRecords}"
                            sortField="rownum"
                            :sortOrder="-1"
                            :globalFilterFields="[
                                'name',
                                'user.name',
                                'position.name',
                            ]"
                            dataKey="id"
                            v-model:filters="filters"
                            filterDisplay="menu"
                            :loading="loading"
                            :scrollable="true"
                            scrollHeight="400px"
                            ref="dt"
                            v-model:selection="selectedEmployes"
                            :resizableColumns="true"
                            columnResizeMode="fit"
                            showGridlines
                        >
                            <template #empty> Data Pegawai tidak ada </template>
                            <template #loading>
                                Sedang Memuat Data Pegawai.Mohon Tunggu.
                            </template>
                            <template #header>
                                <div style="text-align: left">
                                    <MultiSelect
                                        :modelValue="selectedColumns"
                                        :options="columns"
                                        optionLabel="header"
                                        @update:modelValue="onToggle"
                                        placeholder="Select Columns"
                                        style="width: 20em"
                                    />
                                </div>
                            </template>
                            <Column
                                selectionMode="multiple"
                                style="width: 1rem"
                                :exportable="false"
                            />
                            <Column
                                field="rownum"
                                header="No"
                                :sortable="true"
                            ></Column>
                            <Column header="Image">
                                <template #body="slotProps">
                                    <img
                                        :src="slotProps.data.url"
                                        :alt="slotProps.data.image"
                                        class="table-image"
                                    />
                                </template>
                            </Column>
                            <Column
                                field="user.name"
                                header="NIP"
                                :sortable="true"
                            ></Column>
                            <Column
                                field="name"
                                header="Nama"
                                :sortable="true"
                            ></Column>
                            <Column
                                field="position.name"
                                header="Jabatan"
                                :sortable="true"
                            ></Column>
                            <Column
                                v-for="(col, index) of selectedColumns"
                                :field="col.field"
                                :header="col.header"
                                :key="col.field + '_' + index"
                            ></Column>
                            <Column
                                field="created_at"
                                header="Tanggal Buat"
                                :sortable="true"
                            ></Column>
                            <Column :exportable="false" header="Aksi">
                                <template #body="slotProps">
                                    <Button
                                        icon="pi pi-pencil"
                                        class="
                                            p-button-rounded
                                            p-button-success
                                            p-mr-2
                                        "
                                        @click="editEmploye(slotProps.data)"
                                    />
                                    <Button
                                        icon="pi pi-trash"
                                        class="
                                            p-button-rounded p-button-warning
                                        "
                                        @click="
                                            confirmDeleteEmploye(slotProps.data)
                                        "
                                    />
                                </template>
                            </Column>
                            <!-- <Column field="color" header="Color"></Column> -->
                        </DataTable>
                    </div>
                </div>
            </div>
        </div>
        <Dialog
            v-model:visible="deleteEmployeDialog"
            :style="{ width: '450px' }"
            header="Confirm"
            :modal="true"
        >
            <div class="confirmation-content">
                <i
                    class="pi pi-exclamation-triangle p-mr-3"
                    style="font-size: 2rem"
                />
                <span v-if="employe"
                    >Apakah Kamu Yakin Ingin Menghapus <b>{{ employe.name }}</b
                    >?</span
                >
            </div>
            <template #footer>
                <Button
                    label="No"
                    icon="pi pi-times"
                    class="p-button-text"
                    @click="deleteEmployeDialog = false"
                />
                <Button
                    label="Yes"
                    icon="pi pi-check"
                    class="p-button-text"
                    @click="deleteEmploye"
                />
            </template>
        </Dialog>

        <Dialog
            v-model:visible="deleteEmployesDialog"
            :style="{ width: '450px' }"
            header="Confirm"
            :modal="true"
        >
            <div class="confirmation-content">
                <i
                    class="pi pi-exclamation-triangle p-mr-3"
                    style="font-size: 2rem"
                />
                <span v-if="employe"
                    >Apakah Kamu Yakin Ingin Menghapus Employes Yang
                    Dipilih?</span
                >
            </div>
            <template #footer>
                <Button
                    label="No"
                    icon="pi pi-times"
                    class="p-button-text"
                    @click="deleteEmployesDialog = false"
                />
                <Button
                    label="Yes"
                    icon="pi pi-check"
                    class="p-button-text"
                    @click="deleteSelectedEmployes"
                />
            </template>
        </Dialog>
    </admin-layouts>
</template>
<script>
import AdminLayouts from "@/Layouts/Admin.vue";
import EmployeService from "../Service/Service";
import { Link } from "@inertiajs/inertia-vue3";
import { Head } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import Button from "primevue/button";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import InputText from "primevue/inputtext";
import Toolbar from "primevue/toolbar";
import Dialog from "primevue/dialog";
import Toast from "primevue/toast";
import MultiSelect from "primevue/multiselect";
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
        Toolbar,
        Dialog,
        Toast,
        MultiSelect,
    },
    data() {
        return {
            employes: null,
            filters: null,
            loading: true,
            selectedEmployes: null,
            employeDialog: false,
            deleteEmployeDialog: false,
            deleteEmployesDialog: false,
            employe: {},
            expandedRows: [],
            selectedColumns: null,
            columns: null,
        };
    },
    created() {
        this.employeService = new EmployeService();
        this.initFilters();
        this.columns = [
            { field: "birthdate", header: "Tanggal Lahir" },
            { field: "gender", header: "Jenis Kelamin" },
        ];
    },
    mounted() {
        this.successAlert();
        this.employeService.getEmploye().then((data) => {
            this.employes = data;
            this.loading = false;
        });
    },
    methods: {
        onToggle(value) {
            this.selectedColumns = this.columns.filter((col) =>
                value.includes(col)
            );
        },
        openNew() {
            Inertia.get(route("employe.create"));
        },
        editEmploye(data) {
            Inertia.get(route("employe.edit", { employe: data.id }));
        },
        confirmDeleteEmploye(employe) {
            this.employe = employe;
            this.deleteEmployeDialog = true;
        },
        deleteEmploye() {
            Inertia.delete(
                route("employe.destroy", { employe: this.employe.id })
            );
            this.employes = this.employes.filter(
                (val) => val.id !== this.employe.id
            );
            this.deleteEmployeDialog = false;
            this.employe = {};
            this.$toast.add({
                severity: "success",
                summary: "Successful",
                detail: "Employes Deleted",
                life: 3000,
            });
        },
        confirmDeleteSelected() {
            this.deleteEmployesDialog = true;
        },
        deleteSelectedEmployes() {
            let lists = [];
            $.each(this.selectedEmployes, function (key, value) {
                lists.push(value.id);
            });
            Inertia.delete(route("employe.deleteAll", { id: lists }));

            this.employes = this.employes.filter(
                (val) => !this.selectedEmployes.includes(val)
            );
            this.deleteEmployesDialog = false;
            this.selectedEmployes = null;
            this.$toast.add({
                severity: "success",
                summary: "Successful",
                detail: "Pegawai Deleted",
                life: 3000,
            });
        },
        initFilters() {
            this.filters = {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
            };
        },
        exportCSV() {
            this.$refs.dt.exportCSV();
        },
        successAlert() {
            if (this.flash.message != null) {
                this.$toast.add({
                    severity: "success",
                    summary: "Success Message",
                    detail: this.flash.message,
                    life: 3000,
                });
            }
        },
    },
};
</script>
<style scoped lang="scss">
@media screen and (max-width: 960px) {
    ::v-deep(.p-toolbar) {
        flex-wrap: wrap;

        .p-button {
            margin-bottom: 0.25rem;
        }
    }
}
.orders-subtable {
    padding: 1rem;
}
.table-image {
    width: 50px;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
}
</style>
