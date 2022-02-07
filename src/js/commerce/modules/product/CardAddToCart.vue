<template>
    <button type="submit" class="w-full p-2 font-bold border-2 border-black" @click="addToCart()">
        <span>Add To Cart</span>
    </button>
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
    data() {
        return {
            isLoading: false,
            quantity: 1
        }
    },
    mounted() {
        this.$nextTick(() =>{
            this.isLoading = false;
        });
    },
    computed: {
        cart() {
            return this.$store.state.cart.cart;
        }
    },
    methods: {
        addToCart() {
            this.$store.dispatch('cart/isIsLoading');

            this.$store.dispatch('cart/addToCartWithQty', { purchasableId: this.product.defaultVariantId, qty: this.quantity })
                .then(res => { 
                    this.$store.dispatch('cart/showCartPane');
                    this.$store.dispatch('cart/isNotLoading');
                });
        }
    }
}
</script>

<style>

</style>
