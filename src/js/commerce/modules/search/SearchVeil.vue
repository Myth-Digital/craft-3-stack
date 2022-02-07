<template>
  <div class="search-veil" :class="{ '_open' : isOpen }">
    <div class="max-w-xl my-16 mx-auto">
      <form class="relative">
        <svg width="20" height="20" fill="currentColor" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-black">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" />
        </svg>
        <input v-model="searchQuery" @change="doSearch" class="focus:border-light-blue-500 focus:ring-b-1 focus:ring-light-blue-500 focus:outline-none w-full text-lg text-black placeholder-black border-b border-gray-500 py-4" type="text" aria-label="Search" placeholder="Search" />
      </form>
    </div>

    <div class="container mt-8 mb-16 mx-auto">
      <span v-if="!isValidQuery" class="text-xl w-full block mb-5">Search for your favourites</span>
      <span v-if="isValidQuery && !isLoading" class="text-xl w-full block mb-5">{{products.length}} results</span>
      <span v-if="isValidQuery && isLoading" class="text-xl w-full block mb-5">Searching...</span>
      <div class="grid gap-3 gap-y-9 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <div v-for="(prod, index) in products" :key="index" class="product-card max-w-sm">
          <div class="bg-white border-gray-200 hover:shadow-xl flex flex-col justify-between">
            <a href="/">
              <figure class="product-card_img">
                <img v-if="prod.imageUrls && prod.imageUrls.length > 0" :src="prod.imageUrls[0]" />
              </figure>
            </a>
            <div class="p-6">
              <a href="">
                <span class="text-xl font-display uppercase">{{prod.title}}</span>
                <span class="text-lg font-display text-primary uppercase block mt-4">{{prod.priceAsCurrency}}</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <span class="absolute top-10 right-10" @click="closeSearch()">
      Close
    </span>
  </div>
</template>

<script>
export default {
  data() {
    return {
      searchQuery: null,
      products: [],
      isLoading: false
    }
  },
  computed: {
    isOpen() {
      return this.$store.state.cart.searchOpen;
    },
    isValidQuery() {
      return this.searchQuery && this.searchQuery.length >= 3;
    }
  },
  methods: {
    closeSearch() {
      this.$store.dispatch('cart/hideSearchVeil');
    },
    doSearch() {
      if (!this.isValidQuery) {
        this.products = [];
        return;
      }

      this.isLoading = true;

      this.$store.dispatch('products/searchProducts', this.searchQuery)
        .then(res => {
          this.products = res.products;
        })
        .finally(res => {
          this.isLoading = false;
        });
    }
  }
}
</script>
