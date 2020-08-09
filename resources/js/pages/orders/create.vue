<template>
  <div class="container">
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="$route('orders.index')">Permintaan</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Tambah
    </h1>
    <div class="bg-white rounded shadow overflow-hidden">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
            <input type="hidden" v-model="form.user_id" />
            <div class="my-checkboxes mb-3">
                <span class="block text-gray-700 text-sm font-bold mb-2">Pilih Barang</span>
                <label class="flex items-center mb-2 border rounded p-3 bg-gray-200 hover:bg-gray-300 cursor-pointer" v-for="product in products" :key="`key-${product.id}`">
                    <input class="border rounded py-3 bg-gray-100 px-3 focus:outline-none focus:shadow-outline mr-3"
                        type="radio"
                        :value="product.id"
                        :class="{ 'border-red-500 mb-1': $page.errors.product_id }"
                        v-model="form.product_id">
                    <div class="block text-gray-700 text-sm">
                        <span v-text="product.name"></span>
                        <span> ({{ product.stock.jumlah }} in stock)</span>
                    </div>
                </label>
                <p v-if="$page.errors.product_id" class="text-red-500 text-xs italic pl-1" v-text="$page.errors.product_id[0]"></p>
            </div>
            <form-input class="w-full" v-model="form.jumlah" :errors="$page.errors.jumlah" required label="Jumlah Barang" />
            <div class="mt-5">
                <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Permintaan</label>
                <datetime v-model="form.tanggal_permintaan" class="w-full" />
            </div>
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
        user_id: this.$page.user.id,
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
