<template>
  <div class="container">
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="$route('orders.index')">Permintaan</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Tambah
    </h1>
    <div class="bg-white rounded shadow overflow-hidden">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
            <form-select class="mb-6 w-full"
                label="Pilih Pegawai"
                placeholder="Pilih Pegawai"
                v-model="form.user_id"
                :errors="$page.errors.user_id"
                required>
                <option v-for="user in users" :key="`u-${user.id}`" :value="user.id">{{ user.name }}</option>
            </form-select>
            <form-select class="mb-6 w-full"
                label="Pilih Barang"
                placeholder="Pilih Barang"
                v-model="form.product_id"
                :errors="$page.errors.product_id"
                required>
                <option v-for="product in products" :key="`p-${product.id}`" :value="product.id">{{ product.name }}</option>
            </form-select>
            <form-input class="w-full" v-model="form.jumlah" :errors="$page.errors.jumlah" required label="Jumlah Barang" />
            <form-input class="w-full" v-model="form.tanggal_permintaan" :errors="$page.errors.tanggal_permintaan" required label="Tanggal Permintaan" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center mt-6">
          <loading-button :loading="sending" class="btn-indigo" type="submit">Tambah Permintaan</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/layouts/dashboard'
import LoadingButton from '@/shared/LoadingButton'
export default {
  metaInfo: { title: 'Tambah Permintaan' },
  layout: Layout,
  components: {
    LoadingButton,
  },
  remember: 'form',
  props: {
      products: Array,
      users: Array,
  },
  data() {
    return {
      sending: false,
      form: {
        product_id: null,
        jumlah: null,
        tanggal_permintaan: null,
        user_id: null,
      },
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.post(this.$route('orders.store'), this.form)
        .then(() => this.sending = false)
    },
  },
}
</script>
