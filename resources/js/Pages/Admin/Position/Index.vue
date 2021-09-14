<template>
    <admin-layouts navbarTitle="jabatan">
        <Toast />
        <Head title="Jabatan" />
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
                                        !selectedPositions ||
                                        !selectedPositions.length
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
                                <div class="table-header">Jabatan Tables</div>
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
                            :value="positions"
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
                            v-model:selection="selectedPositions"
                            :resizableColumns="true"
                            columnResizeMode="fit"
                            showGridlines
                        >
                            <template #empty> Data Jabatan tidak ada </template>
                            <template #loading>
                                Sedang Memuat Data Jabatan.Mohon Tunggu.
                            </template>
                            <Column
                                selectionMode="multiple"
                                style="width: 1rem"
                                :exportable="false"
                            ></Column>
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
                                field="gaji"
                                header="Gaji"
                                :sortable="true"
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
                                        @click="editPosition(slotProps.data)"
                                    />
                                    <Button
                                        icon="pi pi-trash"
                                        class="
                                            p-button-rounded p-button-warning
                                        "
                                        @click="
                                            confirmDeletePosition(
                                                slotProps.data
                                            )
                                        "
                                    />
                                </template>
                            </Column>
                        </DataTable>
                    </div>
                </div>
            </div>
        </div>

        <Dialog
            v-model:visible="positionDialog"
            :style="{ width: '450px' }"
            header="Position Details"
            :modal="true"
            class="p-fluid"
        >
            <div class="p-field">
                <label for="name">Jabatan</label>
                <InputText
                    id="name"
                    v-model.trim="position.name"
                    required="true"
                    autofocus
                    :class="{ 'p-invalid': submitted && !position.name }"
                />
                <small class="p-error" v-if="submitted && !position.name"
                    >Name is required.</small
                >
            </div>
            <div class="p-field">
                <label for="gaji">Gaji</label>
                <InputText
                    id="gaji"
                    type="number"
                    v-model.trim="position.gaji"
                    required="true"
                    autofocus
                    :class="{ 'p-invalid': submitted && !position.gaji }"
                />
                <small class="p-error" v-if="submitted && !position.gaji"
                    >Gaji is required.</small
                >
            </div>
            <template #footer>
                <Button
                    label="Cancel"
                    icon="pi pi-times"
                    class="p-button-text"
                    @click="hideDialog"
                />
                <Button
                    label="Save"
                    icon="pi pi-check"
                    class="p-button-text"
                    @click="savePosition"
                />
            </template>
        </Dialog>

        <Dialog
            v-model:visible="deletePositionDialog"
            :style="{ width: '450px' }"
            header="Confirm"
            :modal="true"
        >
            <div class="confirmation-content">
                <i
                    class="pi pi-exclamation-triangle p-mr-3"
                    style="font-size: 2rem"
                />
                <span v-if="position"
                    >Apakah Kamu Yakin Ingin Menghapus <b>{{ position.name }}</b
                    >?</span
                >
            </div>
            <template #footer>
                <Button
                    label="No"
                    icon="pi pi-times"
                    class="p-button-text"
                    @click="deletePositionDialog = false"
                />
                <Button
                    label="Yes"
                    icon="pi pi-check"
                    class="p-button-text"
                    @click="deletePosition"
                />
            </template>
        </Dialog>

        <Dialog
            v-model:visible="deletePositionsDialog"
            :style="{ width: '450px' }"
            header="Confirm"
            :modal="true"
        >
            <div class="confirmation-content">
                <i
                    class="pi pi-exclamation-triangle p-mr-3"
                    style="font-size: 2rem"
                />
                <span v-if="position"
                    >Apakah Kamu Yakin Ingin Menghapus Jabatan Yang
                    Dipilih?</span
                >
            </div>
            <template #footer>
                <Button
                    label="No"
                    icon="pi pi-times"
                    class="p-button-text"
                    @click="deletePositionsDialog = false"
                />
                <Button
                    label="Yes"
                    icon="pi pi-check"
                    class="p-button-text"
                    @click="deleteSelectedPositions"
                />
            </template>
        </Dialog>
    </admin-layouts>
</template>
<script>
import AdminLayouts from "@/Layouts/Admin.vue";
import PositionService from "../Service/Service";
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
    },
    data() {
        return {
            positions: null,
            filters: null,
            loading: true,
            selectedPositions: null,
            positionDialog: false,
            deletePositionDialog: false,
            deletePositionsDialog: false,
            position: {},
            submitted: false,
        };
    },
    created() {
        this.positionService = new PositionService();
        this.initFilters();
    },
    mounted() {
        this.successAlert();
        this.positionService.getPosition().then((data) => {
            this.positions = data;
            this.loading = false;
        });
    },
    methods: {
        currentDate() {
            const monthNames = [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
            ];

            const current = new Date();
            const date =
                current.getDate() +
                "-" +
                monthNames[current.getMonth()] +
                "-" +
                current.getFullYear();
            return date;
        },
        findIndexById(id) {
            let index = -1;
            for (let i = 0; i < this.positions.length; i++) {
                if (this.positions[i].id === id) {
                    index = i;
                    break;
                }
            }

            return index;
        },
        savePosition() {
            this.submitted = true;

            if (this.position.name.trim()) {
                if (this.position.id) {
                    // this.position.inventoryStatus = this.position
                    //     .inventoryStatus.value
                    //     ? this.position.inventoryStatus.value
                    //     : this.position.inventoryStatus;
                    this.positions[this.findIndexById(this.position.id)] =
                        this.position;
                    console.log(" this.position :>> ", this.position);
                    Inertia.put(
                        route("position.update", {
                            position: this.position.id,
                        }),
                        this.position
                    );
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful",
                        detail: "Position Updated",
                        life: 3000,
                    });
                } else {
                    this.position.rownum = this.positions.length + 1;
                    this.position.name = this.position.name;
                    this.position.gaji = this.position.gaji;
                    this.position.created_at = this.currentDate();
                    this.positions.push(this.position);
                    Inertia.post(route("position.store"), this.position);
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful",
                        detail:
                            "Jabatan " + this.position.name + " Ditambahkan",
                        life: 3000,
                    });
                }

                this.positionDialog = false;
                this.position = {};
            }
        },
        hideDialog() {
            this.positionDialog = false;
            this.submitted = false;
        },
        openNew() {
            this.position = {};
            this.submitted = false;
            this.positionDialog = true;
        },
        editPosition(position) {
            this.position = { ...position };
            this.positionDialog = true;
        },
        confirmDeletePosition(position) {
            this.position = position;
            this.deletePositionDialog = true;
        },
        deletePosition() {
            Inertia.delete(
                route("position.destroy", { position: this.position.id })
            );
            this.positions = this.positions.filter(
                (val) => val.id !== this.position.id
            );
            this.deletePositionDialog = false;
            this.position = {};
            this.$toast.add({
                severity: "success",
                summary: "Successful",
                detail: "Position Deleted",
                life: 3000,
            });
        },
        confirmDeleteSelected() {
            this.deletePositionsDialog = true;
        },
        deleteSelectedPositions() {
            let lists = [];
            $.each(this.selectedPositions, function (key, value) {
                lists.push(value.id);
            });
            Inertia.delete(route("position.deleteAll", { id: lists }));

            this.positions = this.positions.filter(
                (val) => !this.selectedPositions.includes(val)
            );
            this.deletePositionsDialog = false;
            this.selectedPositions = null;
            this.$toast.add({
                severity: "success",
                summary: "Successful",
                detail: "Positions Deleted",
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
</style>
