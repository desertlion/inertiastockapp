<template>
  <div class="container">
    <div class="mb-8 flex justify-start">
      <h1 class="font-bold text-3xl">
        <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="$route('products.index')">Products</inertia-link>
        <span class="text-indigo-400 font-medium">/</span>
        {{ form.name }}
      </h1>
    </div>
    <div class="bg-white rounded shadow overflow-hidden">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <form-input v-model="form.name" :errors="$page.errors.name" required label="Nama Barang" class="w-full" />
          <form-input v-model="form.satuan" :errors="$page.errors.satuan" required label="Satuan Barang" class="w-full" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center mt-6">
          <button class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Product</button>
          <loading-button :loading="sending" class="btn-indigo ml-auto" type="submit">Update Product</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/layouts/dashboard'
import LoadingButton from '@/shared/LoadingButton'
export default {
  metaInfo() {
    return {
      title: `${this.form.first_name} ${this.form.last_name}`,
    }
  },
  layout: Layout,
  components: {
    LoadingButton,
  },
  props: {
    product: Object,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        name: this.product.name,
        satuan: this.product.satuan,
      },
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.put(this.$route('products.update', this.product.id), this.form)
        .then(() => {
          this.sending = false
        })
    },
    destroy() {
      if (confirm('Are you sure you want to delete this product?')) {
        this.$inertia.delete(this.$route('products.destroy', this.product.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this user?')) {
        this.$inertia.put(this.route('users.restore', this.user.id))
      }
    },
  },
}
</script>
