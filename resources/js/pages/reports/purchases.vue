<template>
  <div class="container">
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="$route('reports.index')">Laporan</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Pembelian
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
          <a :href="pdfurl" target="_blank" class="text-center rounded shadow b-1 py-2 px-6 ml-5 bg-indigo-600 text-white">Download PDF</a>
        </div>
        <inertia-link class="btn-indigo" :href="$route('reports.index')">
            <span>Laporan</span>
            <span class="hidden md:inline">Pembelian Barang Periode {{ months[bulan.toString().replace(/^[0]+/g,"")-1] }} {{ tahun }}</span>
        </inertia-link>
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-no-wrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Nama Barang</th>
          <th class="px-6 pt-6 pb-4">Nama Toko</th>
          <th class="px-6 pt-6 pb-4">Jumlah</th>
          <th class="px-6 pt-6 pb-4">Total Harga</th>
        </tr>
        <tr v-for="purchase in purchases" :key="purchase.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="$route('products.index')">
              {{ purchase.product.name }}
            </inertia-link>
          </td>
          <td class="border-t">
              {{ purchase.nama_toko }}
          </td>
          <td class="border-t">
              {{ purchase.jumlah }}
          </td>
          <td class="border-t">
              {{ purchase.total_harga }}
          </td>
        </tr>
        <tr v-if="purchases.length === 0">
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
  props: ['purchases','bulan','tahun'],
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
        this.$inertia.replace(this.$route('reports.pembelian', Object.keys(query).length ? query : { remember: 'forget' }))
      }, 150),
      deep: true,
    },
  },
  computed: {
      pdfurl() {
          return this.$route('pdf.pembelian', [this.form.bulan, this.form.tahun]);
      }
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>
