<template>
    <Menu />
    <Head title="Ubah Password" />
    <form @submit.prevent="submit">
        <center>
            <Card
                style="width: 25rem; margin-bottom: 2em"
                class="p-m-0 p-d-flex p-jc-center"
            >
                <template #title> Ubah Password </template>
                <template #content>
                    <table>
                        <tr>
                            <th>Password Lama</th>
                            <th>:</th>
                            <td>
                                <InputText
                                    type="password"
                                    v-model="form.password_lama"
                                    required
                                />
                                <Validation
                                    class="mb-4"
                                    :validate="errors.password_lama"
                                />
                            </td>
                        </tr>
                        <tr>
                            <th>Password Baru</th>
                            <th>:</th>
                            <td>
                                <InputText
                                    type="password"
                                    v-model="form.password_baru"
                                    required
                                />
                                <Validation
                                    class="mb-4"
                                    :validate="errors.password_baru"
                                />
                            </td>
                        </tr>
                        <tr>
                            <th>Confirm Password Baru</th>
                            <th>:</th>
                            <td>
                                <InputText
                                    type="password"
                                    v-model="form.confirm_password_baru"
                                    required
                                />
                                <Validation
                                    class="mb-4"
                                    :validate="errors.confirm_password_baru"
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
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import Validation from "@/Components/notus/Validation/ValidationError";
export default {
    props: { errors: Object },
    components: {
        Menu,
        Head,
        Card,
        InputText,
        Button,
        Validation,
    },
    data() {
        return {
            form: this.$inertia.form({
                password_lama: null,
                password_baru: null,
                confirm_password_baru: null,
            }),
        };
    },
    methods: {
        submit() {
            this.form.post(this.route("account.store"), {
                preserveState: true,
                replace: true,
            });
        },
    },
};
</script>
