<template>
  <div class="container">
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="$route('products.index')">Products</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded shadow overflow-hidden">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <form-input v-model="form.name" :errors="$page.errors.name" required label="Product name" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center mt-6">
          <loading-button :loading="sending" class="btn-indigo" type="submit">Create Product</loading-button>
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
  data() {
    return {
      sending: false,
      form: {
        name: null,
      },
    }
  },
  methods: {
    submit() {
      this.sending = true
      var data = new FormData()
      this.$inertia.post(this.$route('products.store'), this.form)
        .then(() => this.sending = false)
    },
  },
}
</script>
