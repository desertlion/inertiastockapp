<template>
  <div class="container">
    <h1 class="mb-8 font-bold text-3xl">Produk yang Harus di Beli</h1>
    <div class="mb-6 flex justify-between items-center">
      <inertia-link class="btn-indigo" :href="$route('purchases.create')">
        <span>Tambah</span>
        <span class="hidden md:inline">Pembelian</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-no-wrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Nama Produk</th>
          <th class="px-6 pt-6 pb-4">Jumlah Stock</th>
          <th class="px-6 pt-6 pb-4">Action</th>
        </tr>
        <tr v-for="stock in stocks" :key="stock.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="$route('purchases.create')">
              {{ stock.product.name }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="$route('purchases.create')">
              {{ stock.jumlah }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="shadow rounded text-white bg-indigo-500 cursor-pointer px-6 py-1" :href="$route('purchases.create', stock.product.id)">
              Beli
            </inertia-link>
          </td>
        </tr>
        <tr v-if="stocks.length === 0">
          <td class="border-t px-6 py-4" colspan="4">No products found.</td>
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
import throttle from 'lodash/throttle'

export default {
  metaInfo: { title: 'Stocks' },
  layout: Layout,
  components: {
    Icon,
  },
  props: {
    stocks: Array,
  },
  data() {
    return {
    }
  },
  methods: {
  },
}
</script>
