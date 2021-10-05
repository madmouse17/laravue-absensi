<template>
    <Menubar />
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
                <form action="">
                    <template v-if="distance.d <= locate.distance">
                        <Button icon="pi pi-arrow-right" label="Masuk" />
                    </template>
                </form>

                <Button
                    icon="pi pi-calendar-plus"
                    label="Ijin"
                    class="p-button-warning"
                    style="margin-left: 0.5em"
                />
                <template v-if="distance.d <= locate.distance">
                    <Button
                        icon="pi pi-arrow-left"
                        class="p-button-secondary"
                        label="Pulang"
                        style="margin-left: 0.5em"
                    />
                </template>
            </template>
        </Card>
    </center>
</template>
<script>
import Menubar from "@/Layouts/Guest/Menubar";
import Card from "primevue/card";
import Avatar from "primevue/avatar";
import Button from "primevue/button";
export default {
    props: { presen: Object, url: Object, locate: Object },
    components: {
        Menubar,
        Card,
        Avatar,
        Button,
    },
    data() {
        return {
            coords: {},
            distance: {},
            in: "masuk",
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
    },
};
</script>
