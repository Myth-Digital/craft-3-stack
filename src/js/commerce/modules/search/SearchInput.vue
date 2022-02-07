<template>
  <input class="focus:border-light-blue-500 focus:ring-1 focus:ring-light-blue-500 focus:outline-none w-full text-sm text-black placeholder-black border border-gray-300 py-2 px-4" @click="openSearch()" type="text" aria-label="Search" placeholder="Search" />
</template>

<script>
export default {
  methods: {
    openSearch() {
      this.$store.dispatch('cart/showSearchVeil');
    }
  }
}
</script>
