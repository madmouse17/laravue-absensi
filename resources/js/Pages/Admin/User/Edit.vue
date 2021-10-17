<template>
    <admin-layouts>
        <div class="flex flex-wrap">
            <div class="w-full px-4">
                <CardUser
                    titleHead="Tambah User"
                    titleBottom="Silahkan Tambahkan User"
                >
                    <form @submit.prevent="submit">
                        <div class="flex flex-wrap">
                            <Label title="Nama"
                                ><Input
                                    placeholder="Masukkan Nama"
                                    type="text"
                                    v-model="users.name"
                                />
                                <Validation
                                    class="mb-4"
                                    :validate="errors.name"
                                />
                            </Label>

                            <Label title="Alamat Email"
                                ><Input
                                    placeholder="Masukkan Email"
                                    type="email"
                                    v-model="users.email" />
                                <Validation
                                    class="mb-4"
                                    :validate="errors.email"
                            /></Label>

                            <Label title="password"
                                ><Input
                                    placeholder="Masukkan Password"
                                    type="password"
                                    v-model="users.password"
                                />
                                <Validation
                                    class="mb-4"
                                    :validate="errors.password"
                                />
                            </Label>

                            <Label title="Konfirmasi Password"
                                ><Input
                                    placeholder="Ulangi Password"
                                    type="password"
                                    v-model="users.password_confirmation" />
                                <Validation
                                    class="mb-4"
                                    :validate="errors.password_confirmation"
                            /></Label>
                            <Label title="Role"
                                ><Listbox
                                    v-model="users.role"
                                    :options="roles"
                                    optionLabel="name"
                                    listStyle="max-height:200px"
                                />
                                <Validation
                                    class="mb-4"
                                    :validate="errors.role"
                                />
                            </Label>
                            <Button title="simpan" />
                        </div>
                    </form>
                </CardUser>
            </div>
        </div>
    </admin-layouts>
</template>
<script>
import CardUser from "@/Components/notus/Cards/CardForm.vue";
import Input from "@/Components/notus/FormComponent/Input.vue";
import Validation from "@/Components/notus/Validation/ValidationError.vue";
import Label from "@/Components/notus/FormComponent/Label.vue";
import Button from "@/Components/notus/FormComponent/Button.vue";
import AdminLayouts from "@/Layouts/Admin.vue";
import Listbox from "primevue/listbox";
import { Link } from "@inertiajs/inertia-vue3";
import { Head } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
export default {
    props: {
        errors: Object,
        user: Object,
        roles: Object,
        selected_role: Object,
    },
    components: {
        AdminLayouts,
        Link,
        Head,
        CardUser,
        Input,
        Label,
        Validation,
        Button,
        Listbox,
    },
    data() {
        return {
            users: this.$inertia.form({
                name: this.user.name,
                email: this.user.email,
                password: null,
                password_confirmation: null,
                role: this.selected_role,
            }),
        };
    },
    methods: {
        submit() {
            this.users.put(this.route("user.update", { user: this.user.id }), {
                preserveState: true,
                replace: true,
            });
        },
    },
};
</script>
