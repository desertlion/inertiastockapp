<template>
  <div class="container">
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="$route('purchases.index')">Pembelian</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Tambah
    </h1>
    <div class="bg-white rounded shadow overflow-hidden">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
            <form-select class="mb-6 w-full"
                label="Pilih Barang"
                placeholder="Pilih Barang"
                v-model="form.product_id"
                :errors="$page.errors.product_id"
                required>
                <option v-for="product in products" :key="`p-${product.id}`" :value="product.id" :selected="product_id == product.id">{{ product.name }}</option>
            </form-select>
          <form-input class="w-full" v-model="form.jumlah" :errors="$page.errors.jumlah" required label="Jumlah Barang" />
          <form-input class="w-full" v-model="form.nama_toko" :errors="$page.errors.nama_toko" required label="Nama Toko" />
          <form-input class="w-full" v-model="form.total_harga" :errors="$page.errors.total_harga" required label="Total Harga" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center mt-6">
          <loading-button :loading="sending" class="btn-indigo" type="submit">Tambah Pembelian</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/layouts/dashboard'
import LoadingButton from '@/shared/LoadingButton'
export default {
  metaInfo: { title: 'Tambah Pembelian' },
  layout: Layout,
  components: {
    LoadingButton,
  },
  props: ['products', 'product_id'],
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        product_id: this.product_id || null,
        nama_toko: null,
        total_harga: 0,
        jumlah: 0,
      },
    }
  },
  methods: {
    submit() {
      this.sending = true
      var data = new FormData()
      this.$inertia.post(this.$route('purchases.store'), this.form)
        .then(() => this.sending = false)
    },
  },
}
</script>
