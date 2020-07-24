<template>
  <div class="container">
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="$route('reports.index')">Laporan</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Persediaan Barang
    </h1>
    <div class="mb-6 flex justify-between items-center">
        <inertia-link class="btn-indigo" :href="$route('reports.index')">
            <span>Laporan</span>
            <span class="hidden md:inline">Persediaan Barang Periode {{ months[bulan.toString().replace(/^[0]+/g,"")-1] }} {{ tahun }}</span>
        </inertia-link>
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-no-wrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Nama Barang</th>
          <th class="px-6 pt-6 pb-4">Stock Awal</th>
          <th class="px-6 pt-6 pb-4">Masuk</th>
          <th class="px-6 pt-6 pb-4">Keluar</th>
          <th class="px-6 pt-6 pb-4">Stock Akhir</th>
        </tr>
        <tr v-for="report in reports" :key="report.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="$route('products.edit', report.id )">
              {{ report.product_name }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="$route('products.edit', report.id )">
              {{ report.jumlah_sebelum }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="$route('products.edit', report.id )">
              {{ report.jumlah_masuk }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="$route('products.edit', report.id )">
              {{ report.jumlah_keluar }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="$route('products.edit', report.id )">
              {{ report.stock }}
            </inertia-link>
          </td>
        </tr>
        <tr v-if="reports.length === 0">
          <td class="border-t px-6 py-4" colspan="4">No Data found.</td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
import Icon from '@/shared/Icon'
import Layout from '../../layouts/pdf'
import mapValues from 'lodash/mapValues'
import pickBy from 'lodash/pickBy'
import SearchFilter from '@/shared/SearchFilter'
import throttle from 'lodash/throttle'

export default {
  metaInfo: { title: 'Laporan Persediaan Barang' },
  layout: Layout,
  components: {
    Icon,
    SearchFilter,
  },
  props: ['incomings','products','outgoings','bulan','tahun'],
  data() {
    return {
        months: ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
        reports: [],
        form: {
            bulan: this.bulan,
            tahun: this.tahun,
        },
    }
  },
  mounted() {
      const incomings = this.incomings.reduce((result, current) => {
          result[current.product_id] = current;
          return result;
      }, {});
      const outgoings = this.outgoings.reduce((result, current) => {
          result[current.product_id] = current;
          return result;
      }, {});
      this.reports = this.products.map(p => {
        const jlh_sebelum = incomings[p.id] ? incomings[p.id].jumlah_sebelum : 0;
        const jlh_masuk = incomings[p.id] ? incomings[p.id].jlh_total : 0;
        const jlh_keluar= outgoings[p.id] ? outgoings[p.id].jlh_total : 0;
        return {
            id: p.id,
            product_name: p.name,
            jumlah_sebelum: jlh_sebelum,
            jumlah_masuk: jlh_masuk,
            jumlah_keluar: jlh_keluar,
            stock: jlh_sebelum + jlh_masuk - jlh_keluar,
        }
      })
  },
  watch: {
    form: {
      handler: throttle(function() {
        let query = pickBy(this.form)
        this.$inertia.replace(this.$route('reports.stock', Object.keys(query).length ? query : { remember: 'forget' }))
      }, 150),
      deep: true,
    },
  },
  computed: {
      pdfurl() {
          return this.$route('pdf.stock', [this.form.bulan, this.form.tahun]);
      }
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>
