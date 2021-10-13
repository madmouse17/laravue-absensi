<template>
    <Head title="Tambah-Pegawai" />
    <Toast />
    <admin-layouts>
        <div class="flex flex-wrap">
            <div class="w-full px-4">
                <CardUser
                    titleHead="Tambah Pegawai"
                    titleBottom="Silahkan Tambahkan Pegawai"
                >
                    <form @submit.prevent="submit">
                        <FileUpload
                            chooseLabel="Browse"
                            name="demo[]"
                            url="./"
                            @upload="onUpload"
                            accept="image/*"
                            v-model="form.image"
                            :maxFileSize="2000000"
                        >
                            <template #empty>
                                <p>Upload Foto Pegawai Disini</p>
                            </template>
                        </FileUpload>
                        <Validation class="mb-4" :validate="errors.image" />
                        <div class="flex flex-wrap">
                            <Label title="Nama"
                                ><Input
                                    placeholder="Masukkan Nama"
                                    type="text"
                                    v-model="form.name" />
                                <Validation
                                    class="mb-4"
                                    :validate="errors.name"
                            /></Label>
                            <Label title="NIP"
                                ><Input
                                    placeholder="Masukkan NIP"
                                    type="text"
                                    v-model="form.nip" />
                                <Validation class="mb-4" :validate="errors.nip"
                            /></Label>
                            <Label title="Jenis Kelamin">
                                <RadioButton
                                    id="gender1"
                                    name="gender"
                                    value="laki-laki"
                                    v-model="form.gender" />
                                <label for="gender1">Laki-laki</label>
                                <div class="p-field-radiobutton">
                                    <RadioButton
                                        id="gender2"
                                        name="gender"
                                        value="perempuan"
                                        v-model="form.gender"
                                    />
                                    <label for="gender2">Perempuan</label>
                                    <Validation
                                        class="mb-4"
                                        :validate="errors.gender"
                                    /></div
                            ></Label>
                            <Label title="Tanggal Lahir">
                                <Calendar
                                    id="icon"
                                    v-model="form.birthdate"
                                    :showIcon="true"
                                    :monthNavigator="true"
                                    :yearNavigator="true"
                                    dateFormat="yy-mm-dd"
                                    yearRange="1950:3000" />
                                <Validation
                                    class="mb-4"
                                    :validate="errors.birthdate"
                            /></Label>
                            <Label title="Email"
                                ><Listbox
                                    v-model="form.user_id"
                                    :options="user"
                                    optionLabel="email"
                                    :filter="true"
                                    filterPlaceholder="Cari"
                                    listStyle="max-height:100px"
                                />

                                <Validation
                                    class="mb-4"
                                    :validate="errors.user_id"
                                />
                            </Label>

                            <Label title="Jabatan"
                                ><Listbox
                                    v-model="form.position_id"
                                    :options="position"
                                    optionLabel="name"
                                    listStyle="max-height:200px"
                                />
                                <Validation
                                    class="mb-4"
                                    :validate="errors.position_id"
                                />
                            </Label>
                        </div>
                        <Button title="simpan" />
                    </form>
                </CardUser>
            </div>
        </div>
    </admin-layouts>
</template>
<script>
import Listbox from "primevue/listbox";
import Calendar from "primevue/calendar";
import RadioButton from "primevue/radiobutton";
import FileUpload from "primevue/fileupload";
import CardUser from "@/Components/notus/Cards/CardForm.vue";
import Input from "@/Components/notus/FormComponent/Input.vue";
import Validation from "@/Components/notus/Validation/ValidationError.vue";
import Label from "@/Components/notus/FormComponent/Label.vue";
import Button from "@/Components/notus/FormComponent/Button.vue";
import AdminLayouts from "@/Layouts/Admin.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Head } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import Toast from "primevue/toast";
export default {
    props: ["errors", "user", "position", "employe"],
    components: {
        AdminLayouts,
        Link,
        Head,
        CardUser,
        Input,
        Label,
        Validation,
        Button,
        FileUpload,
        RadioButton,
        Calendar,
        Listbox,
        Toast,
    },
    data() {
        return {
            form: this.$inertia.form({
                image: null,
                name: null,
                birthdate: null,
                user_id: null,
                position_id: null,
                gender: null,
                nip: null,
            }),
        };
    },
    methods: {
        submit() {
            this.form.post(this.route("employe.store"), {
                preserveState: true,
                replace: true,
            });
        },
        onUpload(event) {
            this.form.image = event.files[0];
            this.$toast.add({
                severity: "info",
                summary: "Success",
                detail: "File Uploaded",
                life: 3000,
            });
        },
    },
};
</script>
