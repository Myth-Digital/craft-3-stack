<template>
    <button class="cart-icon" @click="openCart()"><span class="bg-secondary rounded-full w-4 h-4 text-dark text-xs font-bold">{{ totalLineItems }}</span></button>
</template>

<script>
export default {
    data() {
        return {
        }
    },
    computed: {
        cart() {
            return this.$store.state.cart.cart;
        },
        totalLineItems() {
            if (!this.cart || !this.cart.lineItems) return 0;

            return this.cart.lineItems.length;
        }
    },
    methods: {
        openCart() {
            this.$store.dispatch('cart/showCartPane');
        }
    }
}
</script>

<style>

</style>
