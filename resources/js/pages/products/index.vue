<template>
  <div class="container">
    <h1 class="mb-8 font-bold text-3xl">Barang</h1>
    <div class="mb-6 flex justify-between items-center">
        <div class="flex flex-start items-center">
            <form-input v-model="form.search" :errors="$page.errors.search" required label="Search Product" />
            <button class="ml-3 text-sm text-gray-500 hover:text-gray-700 focus:text-indigo-500" type="button" @click="reset">Reset</button>
        </div>
      <inertia-link class="btn-indigo" :href="$route('products.create')">
        <span>Tambah</span>
        <span class="hidden md:inline">Barang</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-no-wrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Name</th>
          <th class="px-6 pt-6 pb-4">Satuan</th>
          <th class="px-6 pt-6 pb-4">Stock</th>
          <th class="px-6 pt-6 pb-4">Action</th>
        </tr>
        <tr v-for="product in products" :key="product.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="$route('products.edit', product.id)">
              {{ product.name }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="$route('products.edit', product.id)">
              {{ product.satuan }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="$route('incomingwares.index')">
              {{ product.stock.jumlah}}
            </inertia-link>
          </td>
          <td class="border-t">
            <span class="px-6 py-4 flex items-center text-red-600 cursor-pointer" @click="destroy">
              Delete
            </span>
          </td>
        </tr>
        <tr v-if="products.length === 0">
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
import SearchFilter from '@/shared/SearchFilter'
import throttle from 'lodash/throttle'

export default {
  metaInfo: { title: 'Products' },
  layout: Layout,
  components: {
    Icon,
    SearchFilter,
  },
  props: {
    products: Array,
    filters: Object,
  },
  data() {
    return {
      form: {
        search: '',
      },
    }
  },
  watch: {
    form: {
      handler: throttle(function() {
        let query = pickBy(this.form)
        this.$inertia.replace(this.$route('products.index', Object.keys(query).length ? query : {}))
      }, 150),
      deep: true,
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
    destroy(id) {
      if (confirm('Are you sure you want to delete this product?')) {
        this.$inertia.delete(this.$route('products.destroy', id))
      }
    },
  },
}
</script>
