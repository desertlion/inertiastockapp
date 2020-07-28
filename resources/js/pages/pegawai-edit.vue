<template>
    <div class="max-w-md lg:max-w-3xl bg-white rounded-lg shadow mx-auto p-8">
        <div class="flex justify-between items-center mb-4">
            <h3 class="section-title">Edit Pegawai</h3>
            <button class="btn-primary" @click="$inertia.visit($route('pegawai'))">&laquo;</button>
        </div>
        <form method="post" @submit.prevent="submit">
            <form-input class="mb-6"
                label="Nama"
                placeholder="Nama Pegawai"
                v-model="form.name"
                :errors="$page.errors.name"
                required
                autofocus />
            <form-input class="mb-6"
                label="Email"
                placeholder="Email Pegawai"
                v-model="form.email"
                :errors="$page.errors.email"
                required />
            <form-input class="mb-6"
                label="Nomor Telepon"
                placeholder="Nomor Telepon Pegawai"
                v-model="form.phone"
                :errors="$page.errors.phone"
                required />
            <form-select class="mb-6"
                label="Jabatan"
                placeholder="Pilih Jabatan"
                v-model="form.jabatan"
                :errors="$page.errors.jabatan"
                required>
                <option>staff</option>
                <option>kepala</option>
            </form-select>
            <form-select class="mb-6"
                label="Divisi"
                placeholder="Pilih Divisi"
                v-model="form.division"
                :errors="$page.errors.division"
                required>
                <option>rumah tangga</option>
                <option>keuangan</option>
                <option>kepegawaian</option>
                <option>fasilitas</option>
                <option>kepatuhan internal</option>
                <option>pabean</option>
                <option>penindakan dan penyelidikan</option>
            </form-select>
            <button class="w-full bg-gray-800 hover:bg-gray-900 text-white text-sm font-semibold rounded focus:outline-none focus:shadow-outline py-3">Submit</button>
        </form>
    </div>
</template>

<script>
    export default {
        /**
         * Layout of the page.
         *
         * @type {Object}
         */
        layout: require('../layouts/dashboard').default,

        /**
         * Component properties.
         *
         * @type {Object}
         */
        props: {
            edited_user: Object,
        },
        data: () => ({
            form: {
                name: '',
                jabatan: '',
                division: '',
                email: '',
                phone: '',
            },
        }),
        mounted() {
            this.form = {
                name: this.edited_user.name,
                jabatan: this.edited_user.jabatan,
                division: this.edited_user.division,
                email: this.edited_user.email,
                phone: this.edited_user.phone,
            }
        },
        methods: {
            submit() {
                this.$page.errors = {}

                this.$inertia.put(
                    `/pegawai/${this.edited_user.id}`, { ...this.form }
                )
            },
        }
    }
</script>
