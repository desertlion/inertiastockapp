<template>
  <div class="container">
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="$route('reports.index')">Laporan</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Permintaan
    </h1>
    <div class="mb-6 flex justify-between items-center">
        <div class="flex items-center justify-between">
            <form-select class="w-full mr-6"
                label="Pilih Bulan"
                placeholder="Pilih Bulan"
                v-model="form.bulan"
                :errors="$page.errors.bulan">
                <option v-for="(b,index) in months" :key="`b-${b}`" :value="`${(index+1).toString().padStart(2, '0')}`">{{ b }}</option>
            </form-select>
          <form-input class="w-full" v-model="form.tahun" :errors="$page.errors.tahun" label="Pilih Tahun" />
        </div>
        <inertia-link class="btn-indigo" :href="$route('reports.index')">
            <span>Laporan</span>
            <span class="hidden md:inline">Permintaan Barang Periode {{ months[bulan.toString().replace(/^[0]+/g,"")-1] }} {{ tahun }}</span>
        </inertia-link>
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-no-wrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Nama Barang</th>
          <th class="px-6 pt-6 pb-4">Pegawai</th>
          <th class="px-6 pt-6 pb-4">Jumlah</th>
          <th class="px-6 pt-6 pb-4">Tanggal Permintaan</th>
          <th class="px-6 pt-6 pb-4">Status</th>
        </tr>
        <tr v-for="demand in demands" :key="demand.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="$route('products.index')">
              {{ demand.product.name }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="$route('pegawai.edit', demand.pegawai.id )">
              {{ demand.pegawai.name }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="$route('orders.index')">
              {{ demand.jumlah }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="$route('orders.index')">
              {{ demand.tanggal_permintaan }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="$route('orders.index' )">
              {{ demand.status ? 'Done' : 'Processing' }}
            </inertia-link>
          </td>
        </tr>
        <tr v-if="demands.length === 0">
          <td class="border-t px-6 py-4" colspan="4">No Data found.</td>
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
  metaInfo: { title: 'Laporan Permintaan' },
  layout: Layout,
  components: {
    Icon,
    SearchFilter,
  },
  props: ['demands','bulan','tahun'],
  data() {
    return {
        months: ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
        form: {
            bulan: this.bulan,
            tahun: this.tahun,
        },
    }
  },
  watch: {
    form: {
      handler: throttle(function() {
        let query = pickBy(this.form)
        this.$inertia.replace(this.$route('reports.demands', Object.keys(query).length ? query : { remember: 'forget' }))
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
