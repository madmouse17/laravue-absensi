<template>
    <Toast />
    <Menu />
    <Card>
        <template #content>
            <DataTable
                :value="absensis"
                stripedRows
                :paginator="true"
                :rows="10"
                paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                :rowsPerPageOptions="[10, 20, 50]"
                responsiveLayout="scroll"
                currentPageReportTemplate="Showing {first} to {last} of {totalRecords}"
                sortField="rownum"
                :sortOrder="-1"
                v-model:filters="filters1"
                dataKey="id"
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
                    style="min-width: 10rem"
                ></Column>
                <Column
                    filterField="attended_at"
                    header="Tanggal"
                    dataType="date"
                    style="min-width: 10rem"
                >
                    <template #body="{ data }">
                        {{ formatDate(data.attended_at) }}
                    </template>
                    <template #filter="{ filterModel }">
                        <Calendar
                            v-model="filterModel.value"
                            dateFormat="mm/dd/yy"
                            placeholder="mm/dd/yyyy"
                            inputClass="attend"
                        />
                    </template>
                </Column>
                <Column
                    field="in"
                    header="Masuk"
                    :sortable="true"
                    style="min-width: 10rem"
                ></Column>
                <Column
                    field="permission"
                    header="Ijin"
                    :sortable="true"
                    style="min-width: 10rem"
                >
                    <!-- <template #body="slotProps">
                                    <Badge
                                        :value="slotProps.data.roles"
                                        :severity="
                                            slotProps.data.roles ==
                                            '[&quot;Manager&quot;]'
                                                ? 'succes'
                                                : slotProps.data.roles ==
                                                  '[&quot;admin&quot;]'
                                                ? 'warning'
                                                : 'info'
                                        "
                                    ></Badge> </template> -->
                </Column>
                <Column
                    field="out"
                    header="Pulang"
                    :sortable="true"
                    style="min-width: 10rem"
                ></Column>
                <Column
                    field="desc"
                    header="Keterangan"
                    :sortable="true"
                    style="min-width: 10rem"
                ></Column>
            </DataTable>
        </template>
    </Card>
</template>
<script>
import AbsenService from "../Admin/Service/Service";
import Menu from "@/Layouts/Guest/Menu";
import Toast from "primevue/toast";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Card from "primevue/card";
import Calendar from "primevue/calendar";
import { FilterMatchMode, FilterOperator } from "primevue/api";
export default {
    props: { flash: Object },
    components: {
        Menu,
        Toast,
        DataTable,
        Column,
        Card,
        Calendar,
    },
    data() {
        return {
            absensis: null,
            loading: true,
            filters1: null,
        };
    },
    created() {
        this.absenService = new AbsenService();
        this.initFilters();
    },
    mounted() {
        this.alert();
        this.absenService.getAbsensi().then((data) => {
            this.absensis = data;
            this.loading = false;
            this.absensis.forEach(
                (absensi) =>
                    (absensi.attended_at = new Date(absensi.attended_at))
            );
        });
    },
    methods: {
        formatDate(value) {
            return value.toLocaleDateString("en-US", {
                day: "2-digit",
                month: "2-digit",
                year: "numeric",
            });
        },
        alert() {
            if (this.flash.message != null) {
                this.$toast.add({
                    severity: "success",
                    summary: "Success Message",
                    detail: this.flash.message,
                    life: 3000,
                });
            }
        },
        initFilters() {
            this.filters1 = {
                attended_at: {
                    operator: FilterOperator.AND,
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.DATE_IS },
                    ],
                },
            };
        },
    },
};
</script>
<style>
.p-datepicker {
    height: 10px !important;
}
.p-datepicker table {
    height: 10px !important;
}
</style>
