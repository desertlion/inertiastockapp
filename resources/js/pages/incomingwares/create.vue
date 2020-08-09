<template>
  <div class="container">
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="$route('incomingwares.index')">Barang Masuk</inertia-link>
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
                <option v-for="product in products" :key="`p-${product.id}`" :value="product.id">{{ product.name }}</option>
            </form-select>
            <form-input class="w-full mb-6" v-model="form.jumlah" :errors="$page.errors.jumlah" required label="Jumlah Barang" />
            <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Masuk</label>
            <datetime class="w-full mb-6" v-model="form.tanggal_masuk" input-class="w-full" />
            <form-input class="w-full mb-6" v-model="form.nama_toko" :errors="$page.errors.nama_toko" required label="Nama Toko" />
            <input type="hidden" v-model="form.penerima" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center mt-6">
          <loading-button :loading="sending" class="btn-indigo" type="submit">Tambah Barang Masuk</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/layouts/dashboard'
import LoadingButton from '@/shared/LoadingButton'
export default {
  metaInfo: { title: 'Create Product' },
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
        tanggal_masuk: null,
        nama_toko: null,
        penerima: this.$page.auth.user.id,
      },
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.post(this.$route('incomingwares.store'), this.form)
        .then(() => this.sending = false)
    },
  },
}
</script>
