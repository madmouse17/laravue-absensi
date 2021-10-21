<template>
    <Menu />
    <center>
        <Card
            style="width: 25rem; margin-bottom: 2em"
            class="p-m-0 p-d-flex p-jc-center"
        >
            <template #title> Data Pegawai </template>
            <template #content>
                <Avatar :image="url" size="xlarge" />
                <table>
                    <tr>
                        <th>Nama</th>
                        <th>:</th>
                        <td>{{ presen.name }}</td>
                    </tr>
                    <tr>
                        <th>Jabatan</th>
                        <th>:</th>
                        <td>{{ presen.position.name }}</td>
                    </tr>
                </table>
            </template>
            <template #footer>
                <div v-if="attend == null">
                    <template v-if="distance.d <= locate.radius">
                        <form @submit.prevent="submitIn">
                            <Button
                                icon="pi pi-arrow-right"
                                label="Masuk"
                                type="submit"
                            />
                        </form>
                    </template>
                    <form @submit.prevent="submitPermission">
                        <Button
                            icon="pi pi-calendar-plus"
                            label="Ijin"
                            class="p-button-warning"
                            style="margin-top: 0.5em"
                            type="submit"
                        />
                    </form>
                </div>
                <template v-if="distance.d <= locate.radius && attend">
                    <div v-if="attend.in && attend.out">
                        <h1 style="font-weght: bold">
                            Sudah Melakukan Absensi Hari ini
                        </h1>
                    </div>
                    <div v-else-if="attend.permission">
                        <h1 style="font-weght: bold">Anda Ijin hari ini</h1>
                    </div>
                    <div v-else>
                        <form @submit.prevent="submitOut">
                            <Button
                                icon="pi pi-arrow-left"
                                class="p-button-secondary"
                                label="Pulang"
                                style="margin-left: 0.5em"
                                type="submit"
                            />
                        </form>
                    </div>
                </template>
            </template>
        </Card>
    </center>
</template>
<script>
import Menu from "@/Layouts/Guest/Menu";
import Card from "primevue/card";
import Avatar from "primevue/avatar";
import Button from "primevue/button";
import { Inertia } from "@inertiajs/inertia";
export default {
    props: { presen: Object, url: Object, locate: Object, attend: Object },
    components: {
        Menu,
        Card,
        Avatar,
        Button,
    },
    data() {
        return {
            coords: {},
            distance: {},
            in: { employe_id: this.presen.id },
        };
    },
    mounted() {
        this.getLocation();
        if (localStorage.getItem("reloaded")) {
            localStorage.removeItem("reloaded");
        } else {
            localStorage.setItem("reloaded", "1");
            location.reload();
        }
    },
    methods: {
        rad(x) {
            return (x * Math.PI) / 180;
        },
        getDistance(position) {
            var R = 6378137;
            var dLat = this.rad(position.coords.latitude - this.locate.lat);
            var dLong = this.rad(position.coords.longitude - this.locate.lng);
            var a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(this.rad(this.locate.lat)) *
                    Math.cos(this.rad(position.coords.latitude)) *
                    Math.sin(dLong / 2) *
                    Math.sin(dLong / 2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            var d = R * c;
            var vm = this;
            vm.distance = { d };
        },
        getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(this.getDistance);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        },
        submitIn() {
            Inertia.post(route("attendance.store"), this.in, {
                preserveState: true,
                replace: true,
            });
        },
        submitOut() {
            Inertia.post(route("attendance.out"), this.in, {
                preserveState: true,
                replace: true,
            });
        },
        submitPermission() {
            Inertia.get(route("presensi.permission"), this.presen.id);
        },
    },
};
</script>
