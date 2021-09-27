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
                <Button icon="pi pi-arrow-right" label="Masuk" />
                <Button
                    icon="pi pi-calendar-plus"
                    label="Ijin"
                    class="p-button-warning"
                    style="margin-left: 0.5em"
                />
                <Button
                    icon="pi pi-arrow-left"
                    class="p-button-secondary"
                    label="Pulang"
                    style="margin-left: 0.5em"
                />
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
    props: { presen: Object, url: Object },
    components: {
        Menubar,
        Card,
        Avatar,
        Button,
    },
    methods: {},
};
</script>
