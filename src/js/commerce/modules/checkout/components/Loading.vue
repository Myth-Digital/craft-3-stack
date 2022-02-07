<template>
    <div v-if="cartLoading" class="fixed top-0 left-0 z-50 bg-white w-screen h-screen flex items-center justify-center">
      <div style="border-top-color:transparent" class="w-40 h-40 border-10 border-blue-400 border-solid rounded-full animate-spin"></div>
    </div>
</template>

<script>

export default {
    computed: {
      cartLoading() {
        return this.$store.state.cart.isLoading
      }
    }
}
</script>

<style>

</style>
