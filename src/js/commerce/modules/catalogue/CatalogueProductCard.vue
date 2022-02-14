<template>
  
  <div class="products--card relative">
    <div class="relative mb-4">
      <a class="products--card-link-overlay absolute block inset-0 z-10 text-0" :href="product.url"></a>
      <a :href="product.url">
          <img :src="imageUrl"/>
      </a>
      <div class="products--card--info space-y-2">
        <div class="font-bold">{{ product.title }}</div>
        <div class="">{{ product.price }}</div>
      </div>
    </div>
    <card-add-to-cart :product="product"></card-add-to-cart>
  </div>

</template>

<script>
export default {
    props: {
        product: {
            type: Object,
            quantity: 1,
            default: {}
        },        
    },
    computed: {
        imageUrl() {
            if (this.product.imageUrls.length > 0) return this.product.imageUrls[0];

            return '/images/image-placeholder-base.png';
        }
    }
}
</script>

<style>

</style>