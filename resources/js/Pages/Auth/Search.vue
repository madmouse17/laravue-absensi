<template>
    <Head title="Cari NIP" />

    <div class="mb-4 text-sm text-gray-600">
        Silahkan Masukkan NIP untuk mendaftar.
    </div>

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
        {{ status }}
    </div>

    <BreezeValidationErrors class="mb-4" />

    <form @submit.prevent="submit">
        <div>
            <BreezeInput
                id="nip"
                type="text"
                class="mt-1 block w-full"
                v-model="form.nip"
                required
                autofocus
            />
        </div>

        <div class="flex items-center justify-end mt-4">
            <BreezeButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Cari
            </BreezeButton>
        </div>
    </form>
    <div v-if="data">
        <div v-if="data.user_id">
            <tr>
                <th>Akun Sudah Dibuat</th>
            </tr>
        </div>
        <div v-else>
            <table>
                <tr>
                    <th>NIP</th>
                    <th>:</th>
                    <td>{{ data.nip }}</td>
                </tr>
                <tr>
                    <th>Nama</th>
                    <th>:</th>
                    <td>{{ data.name }}</td>
                </tr>
                <tr>
                    <th>Jabatan</th>
                    <th>:</th>
                    <td>{{ data.position.name }}</td>
                </tr>
            </table>
            <form @submit.prevent="create">
                <BreezeButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Buat Akun
                </BreezeButton>
            </form>
        </div>
    </div>
</template>

<script>
import BreezeButton from "@/Components/Button.vue";
import BreezeGuestLayout from "@/Layouts/Guest.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

export default {
    layout: BreezeGuestLayout,

    components: {
        BreezeButton,
        BreezeInput,
        BreezeLabel,
        BreezeValidationErrors,
        Head,
        Link,
    },

    props: {
        data: Object,
    },

    data() {
        return {
            form: this.$inertia.form({
                nip: "",
            }),
        };
    },

    methods: {
        submit() {
            this.form.get(this.route("search"), {
                preserveState: true,
                replace: true,
            });
        },
        create() {
            Inertia.get(
                this.route("register"),
                { nip: this.data.nip },
                {
                    preserveState: true,
                    replace: true,
                }
            );
        },
    },
};
</script>
