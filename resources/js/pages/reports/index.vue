<template>
  <div class="container">
    <h1 class="mb-8 font-bold text-3xl">Laporan</h1>
    <div class="mb-6">
        <ul class="flex justify-between flex-wrap">
            <li class="mb-6 w-1/2 pr-3">
                <inertia-link :href="$route('reports.stock')" class="bg-white rounded shadow py-4 w-full block text-center mr-3">
                    Laporan Persediaan Barang
                </inertia-link>
            </li>
            <li class="mb-6 w-1/2">
                <inertia-link :href="$route('reports.demands')" class="bg-white rounded shadow py-4 w-full block text-center mr-3">
                    Laporan Permintaan Barang
                </inertia-link>
            </li>
            <li class="mb-6 w-1/2 pr-3">
                <inertia-link :href="$route('reports.barang-masuk')" class="bg-white rounded shadow py-4 w-full block text-center mr-3">
                    Laporan Barang Masuk
                </inertia-link>
            </li>
            <li class="mb-6 w-1/2">
                <inertia-link :href="$route('reports.pembelian')" class="bg-white rounded shadow py-4 w-full block text-center mr-3">
                    Laporan Pembelian Barang
                </inertia-link>
            </li>
        </ul>
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
  },
  data() {
    return {
      form: {
        // search: this.filters.search,
      },
    }
  },
  watch: {
    // form: {
    //   handler: throttle(function() {
    //     let query = pickBy(this.form)
    //     this.$inertia.replace(this.$route('deliveries', Object.keys(query).length ? query : { remember: 'forget' }))
    //   }, 150),
    //   deep: true,
    // },
  },
  methods: {
    // reset() {
    //   this.form = mapValues(this.form, () => null)
    // },
  },
}
</script>
