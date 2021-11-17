<template>
    <Menu />
    <Head title="Akun" />
    <form @submit.prevent="submit">
        <center>
            <Card
                style="width: 25rem; margin-bottom: 2em"
                class="p-m-0 p-d-flex p-jc-center"
            >
                <template #title> Akun Saya </template>
                <template #content>
                    <Avatar :image="url" size="xlarge" />
                    <table>
                        <tr>
                            <th>Nama</th>
                            <th>:</th>
                            <td>{{ employe.name }}</td>
                        </tr>
                        <tr>
                            <th>NIP</th>
                            <th>:</th>
                            <td>{{ employe.nip }}</td>
                        </tr>
                        <tr>
                            <th>Jabatan</th>
                            <th>:</th>
                            <td>{{ employe.position.name }}</td>
                        </tr>

                        <tr>
                            <th>Email</th>
                            <th>:</th>
                            <td>
                                <InputText type="email" v-model="form.email" />
                                <Validation
                                    class="mb-4"
                                    :validate="errors.email"
                                />
                            </td>
                        </tr>
                    </table>
                </template>
                <template #footer>
                    <Button
                        icon="pi pi-save"
                        class="p-button-secondary"
                        label="Ubah"
                        style="margin-left: 0.5em"
                        type="submit"
                    />
                </template>
            </Card>
        </center>
    </form>
</template>
<script>
import Menu from "@/Layouts/Guest/Menu";
import { Head } from "@inertiajs/inertia-vue3";
import Card from "primevue/card";
import Avatar from "primevue/avatar";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import Validation from "@/Components/notus/Validation/ValidationError";
export default {
    props: { employe: Object, url: Object, errors: Object },
    components: {
        Menu,
        Head,
        Card,
        Avatar,
        InputText,
        Button,
        Validation,
    },
    data() {
        return {
            form: this.$inertia.form({
                _method: "PUT",
                email: this.employe.user.email,
            }),
        };
    },
    methods: {
        submit() {
            this.form.post(
                this.route("account.update", { account: this.employe.user.id }),
                {
                    preserveState: true,
                    replace: true,
                }
            );
        },
    },
};
</script>
