<template>
    <div class="products grid gap-3 gap-y-9 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
        <catalogue-product-card v-for="product in searchResults.products" :key="product.productId" :product="product"></catalogue-product-card>
    </div>

</template>

<script>
export default {
    computed: {
        searchResults() {
            return this.$store.state.catalogue.searchResults;
        }
    }
}
</script>

<style>

</style>