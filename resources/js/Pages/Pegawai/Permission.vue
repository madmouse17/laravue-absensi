<template>
    <Toast />
    <Menubar />
    <center>
        <form @submit.prevent="Submit">
            <Card style="width: 50rem; margin-bottom: 2em; margin-top: 5em">
                <template #title> Form Ijin </template>
                <template #content>
                    <div>
                        <label for="multiple">Pilih Tanggal</label>
                    </div>
                    <Calendar
                        id="multiple"
                        v-model="form.attend"
                        selectionMode="multiple"
                        :manualInput="false"
                        :minDate="minDate"
                        placeholder="silahkan pilih tanggal ijin"
                        :showButtonBar="true"
                        style="margin-bottom: 3em"
                        required
                    />
                    <h5>Upload Bukti Ijin</h5>
                    <FileUpload
                        chooseLabel="Browse"
                        name="demo[]"
                        url="./"
                        @upload="onUpload"
                        :multiple="false"
                        accept="image/*"
                        :maxFileSize="2000000"
                        required
                    >
                        <template #empty>
                            <p>Seret dan lepas bukti ijin disini.</p>
                        </template>
                    </FileUpload>
                    <div>
                        <label for="desc" style="margin-top: 3em"
                            >Keterangan</label
                        >
                    </div>
                    <Textarea
                        id="desc"
                        v-model="form.desc"
                        :autoResize="true"
                        rows="5"
                        cols="100"
                        required
                    />
                </template>
                <template #footer>
                    <Button
                        icon="pi pi-check"
                        label="Simpan"
                        class="p-button-success"
                        type="submit"
                    />
                </template>
            </Card>
        </form>
    </center>
</template>
<script>
import Menubar from "@/Layouts/Guest/Menubar";
import Calendar from "primevue/calendar";
import FileUpload from "primevue/fileupload";
import Toast from "primevue/toast";
import Card from "primevue/card";
import Button from "primevue/button";
import Textarea from "primevue/textarea";
export default {
    components: {
        Menubar,
        Calendar,
        FileUpload,
        Toast,
        Card,
        Button,
        Textarea,
    },
    props: { presen: Object },
    data() {
        return {
            form: this.$inertia.form({
                attend: null,
                image: null,
                desc: null,
                employe_id: this.presen.id,
            }),
            minDate: null,
        };
    },
    created() {
        let today = new Date();
        let date = today.getDate();
        this.minDate = new Date();
        this.minDate.setDate(date);
    },
    methods: {
        onUpload(event) {
            this.form.image = event.files[0];
            this.$toast.add({
                severity: "info",
                summary: "Success",
                detail: "File Uploaded",
                life: 3000,
            });
        },
        Submit() {
            this.form.post(this.route("attendance.permission"), {
                preserveState: true,
                replace: true,
            });
        },
    },
};
</script>
