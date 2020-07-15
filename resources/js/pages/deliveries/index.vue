<template>
  <div class="container">
    <h1 class="mb-8 font-bold text-3xl">Penyerahan</h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
        <label class="block text-gray-700">Role:</label>
        <select v-model="form.role" class="mt-1 w-full form-select">
          <option :value="null" />
          <option value="user">User</option>
          <option value="owner">Owner</option>
        </select>
      </search-filter>
      <inertia-link class="btn-indigo" :href="$route('deliveries.create')">
        <span>Tambah</span>
        <span class="hidden md:inline">Penyerahan</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-no-wrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Nomor Permintaan</th>
          <th class="px-6 pt-6 pb-4">Tanggal Penyerahan</th>
          <th class="px-6 pt-6 pb-4">Jumlah</th>
          <th class="px-6 pt-6 pb-4">Action</th>
        </tr>
        <tr v-for="delivery in deliveries" :key="delivery.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="$route('orders.index')">
              {{ delivery.order_id.toString().padStart(7, '0') }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="$route('deliveries.show', delivery.id)">
              {{ delivery.tanggal_penyerahan }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="$route('orders.index')">
              {{ delivery.order.jumlah }}
            </inertia-link>
          </td>
          <td class="border-t">
              Delete
          </td>
        </tr>
        <tr v-if="deliveries.length === 0">
          <td class="border-t px-6 py-4" colspan="4">No Delivery found.</td>
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
  metaInfo: { title: 'Penyerahan' },
  layout: Layout,
  components: {
    Icon,
    SearchFilter,
  },
  props: {
    deliveries: Array,
    filters: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
      },
    }
  },
  watch: {
    form: {
      handler: throttle(function() {
        let query = pickBy(this.form)
        this.$inertia.replace(this.$route('deliveries', Object.keys(query).length ? query : { remember: 'forget' }))
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
