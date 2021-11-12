<template>
    <Head title="Tambah-Pegawai" />
    <admin-layouts>
        <div class="flex flex-wrap">
            <div class="w-full px-4">
                <CardUser
                    titleHead="Tambah Pegawai"
                    titleBottom="Silahkan Tambahkan Pegawai"
                >
                    <form @submit.prevent="submit">
                        <Avatar :image="url_image" size="xlarge" />
                        <FileUpload
                            chooseLabel="Browse"
                            name="demo[]"
                            url="./"
                            accept="image/*"
                            v-model="form.image"
                            @upload="onUpload"
                            :maxFileSize="2000000"
                        >
                            <template #empty>
                                <p>Upload Foto Pegawai Disini</p>
                            </template>
                        </FileUpload>
                        <Validation class="mb-4" :validate="errors.image" />
                        <div class="flex flex-wrap">
                            <Label title="Nama Lengkap"
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
                        <Button title="update" />
                    </form>
                </CardUser>
            </div>
        </div>
    </admin-layouts>
</template>
<script>
import Avatar from "primevue/avatar";
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
export default {
    props: [
        "errors",
        "employe",
        "position",
        "user",
        "selected_user",
        "selected_position",
        "url_image",
    ],
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
        Avatar,
    },
    data() {
        return {
            form: this.$inertia.form({
                _method: "PUT",
                image: this.employe.image,
                name: this.employe.name,
                birthdate: this.employe.birthdate,
                user_id: this.selected_user,
                position_id: this.selected_position,
                gender: this.employe.gender,
                nip: this.employe.nip,
            }),
        };
    },
    methods: {
        submit() {
            this.form.post(
                this.route("employe.update", { employe: this.employe.id }),
                {
                    preserveState: true,
                    replace: true,
                }
            );
        },
        onUpload(event) {
            this.form.image = event.files[0];
        },
    },
};
</script>
