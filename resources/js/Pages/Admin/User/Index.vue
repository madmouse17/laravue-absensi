<template>
    <admin-layouts navbarTitle="user">
        <Toast />
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
                                        !selectedUsers || !selectedUsers.length
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
                                <div class="table-header">User Tables</div>
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
                            :value="users"
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
                            v-model:selection="selectedUsers"
                            :resizableColumns="true"
                            columnResizeMode="fit"
                            showGridlines
                        >
                            <template #empty> Data User tidak ada </template>
                            <template #loading>
                                Sedang Memuat Data User.Mohon Tunggu.
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
                                field="email"
                                header="Email"
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
                                        @click="editUser(slotProps.data)"
                                    />
                                    <Button
                                        icon="pi pi-trash"
                                        class="
                                            p-button-rounded p-button-warning
                                        "
                                        @click="
                                            confirmDeleteUser(slotProps.data)
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
            v-model:visible="deleteUserDialog"
            :style="{ width: '450px' }"
            header="Confirm"
            :modal="true"
        >
            <div class="confirmation-content">
                <i
                    class="pi pi-exclamation-triangle p-mr-3"
                    style="font-size: 2rem"
                />
                <span v-if="user"
                    >Are you sure you want to delete <b>{{ user.name }}</b
                    >?</span
                >
            </div>
            <template #footer>
                <Button
                    label="No"
                    icon="pi pi-times"
                    class="p-button-text"
                    @click="deleteUserDialog = false"
                />
                <Button
                    label="Yes"
                    icon="pi pi-check"
                    class="p-button-text"
                    @click="deleteUser"
                />
            </template>
        </Dialog>

        <Dialog
            v-model:visible="deleteUsersDialog"
            :style="{ width: '450px' }"
            header="Confirm"
            :modal="true"
        >
            <div class="confirmation-content">
                <i
                    class="pi pi-exclamation-triangle p-mr-3"
                    style="font-size: 2rem"
                />
                <span v-if="user"
                    >Are you sure you want to delete the selected Users?</span
                >
            </div>
            <template #footer>
                <Button
                    label="No"
                    icon="pi pi-times"
                    class="p-button-text"
                    @click="deleteUsersDialog = false"
                />
                <Button
                    label="Yes"
                    icon="pi pi-check"
                    class="p-button-text"
                    @click="deleteSelectedUsers"
                />
            </template>
        </Dialog>
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
            users: null,
            filters: null,
            loading: true,
            selectedUsers: null,
            userDialog: false,
            deleteUserDialog: false,
            deleteUsersDialog: false,
            user: {},
        };
    },
    created() {
        this.userService = new UserService();
        this.initFilters();
    },
    mounted() {
        this.successAlert();
        this.userService.getUser().then((data) => {
            this.users = data;
            this.loading = false;
        });
    },
    methods: {
        openNew() {
            Inertia.get(route("user.create"));
        },
        editUser(data) {
            Inertia.get(route("user.edit", { user: data.id }));
        },
        confirmDeleteUser(user) {
            this.user = user;
            this.deleteUserDialog = true;
        },
        deleteUser() {
            Inertia.delete(route("user.destroy", { user: this.user.id }));
            this.users = this.users.filter((val) => val.id !== this.user.id);
            this.deleteUserDialog = false;
            this.user = {};
            this.$toast.add({
                severity: "success",
                summary: "Successful",
                detail: "Users Deleted",
                life: 3000,
            });
        },
        confirmDeleteSelected() {
            this.deleteUsersDialog = true;
        },
        deleteSelectedUsers() {
            let lists = [];
            $.each(this.selectedUsers, function (key, value) {
                lists.push(value.id);
            });
            Inertia.delete(route("user.deleteAll", { id: lists }));

            this.users = this.users.filter(
                (val) => !this.selectedUsers.includes(val)
            );
            this.deleteUsersDialog = false;
            this.selectedUsers = null;
            this.$toast.add({
                severity: "success",
                summary: "Successful",
                detail: "Users Deleted",
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
