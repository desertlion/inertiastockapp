<template>
  <div class="container">
    <h1 class="mb-8 font-bold text-3xl">Permintaan</h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
        <label class="block text-gray-700">Role:</label>
        <select v-model="form.role" class="mt-1 w-full form-select">
          <option :value="null" />
          <option value="user">Nama Barang</option>
          <option value="user">Nama Toko</option>
        </select>
      </search-filter>
      <inertia-link class="btn-indigo" :href="$route('orders.create')">
        <span>Tambah</span>
        <span class="hidden md:inline">Permintaan</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-no-wrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Nama Barang</th>
          <th class="px-6 pt-6 pb-4">Tanggal Permintaan</th>
          <th class="px-6 pt-6 pb-4">Pegawai</th>
          <th class="px-6 pt-6 pb-4">Jumlah</th>
          <th class="px-6 pt-6 pb-4">Status</th>
        </tr>
        <tr v-for="order in orders" :key="order.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="$route('products.edit', order.product.id)">
              {{ order.product.name }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="$route('orders.edit', order.id)">
              {{ order.tanggal_permintaan }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="$route('pegawai.edit', order.pegawai.id)">
              {{ order.pegawai.name }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="$route('orders.edit', order.id)">
              {{ order.jumlah }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="$route('orders.edit', order.id)">
              {{ status[order.status] }}
            </inertia-link>
          </td>
        </tr>
        <tr v-if="orders.length === 0">
          <td class="border-t px-6 py-4" colspan="5">Tidak ada permintaan barang.</td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
import Icon from '@/shared/Icon'
import Layout from '../../layouts/dashboard'
import mapValues from 'lodash/mapValues'
import pickBy from 'lodash/pickBy'
import SearchFilter from '@/shared/SearchFilter'
import throttle from 'lodash/throttle'

export default {
  metaInfo: { title: 'Barang Masuk' },
  layout: Layout,
  components: {
    Icon,
    SearchFilter,
  },
  props: {
    orders: Array,
    status: Array,
    filters: Object,
  },
  data() {
    return {
      form: {
        // search: this.filters.search,
      },
    }
  },
  watch: {
    form: {
      handler: throttle(function() {
        let query = pickBy(this.form)
        this.$inertia.replace(this.$route('orders.index', Object.keys(query).length ? query : { remember: 'forget' }))
      }, 150),
      deep: true,
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>
