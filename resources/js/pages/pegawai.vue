<template>
    <div class="max-w-md lg:max-w-3xl bg-white rounded-lg shadow mx-auto p-8">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-gray-700 text-lg uppercase tracking-wide font-bold">Daftar Pegawai</h3>
            <button class="btn-primary" @click="$inertia.visit($route('pegawai.form'))">Tambah Pegawai</button>
        </div>
        <table id="example" class="table-1">
            <thead>
                <tr>
                    <th class="px-4 py-2" data-priority="1">Name</th>
                    <th class="px-4 py-2" data-priority="2">Position</th>
                    <th class="px-4 py-2" data-priority="3">Office</th>
                    <th class="px-4 py-2" data-priority="4">Phone</th>
                    <th class="px-4 py-2" data-priority="5">Email</th>
                    <th class="px-4 py-2" data-priority="6">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="p in pegawai" :key="p.id">
                    <td class="border px-4 py-2">{{ p.name }}</td>
                    <td class="capitalize">{{ p.jabatan }}</td>
                    <td class="capitalize">{{ p.division }}</td>
                    <td>{{ p.phone }}</td>
                    <td>{{ p.email }}</td>
                    <td>
                        <inertia-link :href="$route('pegawai.edit', p.id)">Edit</inertia-link>
                    </td>
                </tr>

            </tbody>

        </table>
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
            user: Object,
            pegawai: Array,
        },
    }
</script>
