export default {
    methods: {
        getCartError(field) {
            if (!this.$store.state.cart.cart.errors) return null;
            if (!this.$store.state.cart.cart.errors[field]) return null;
            return this.$store.state.cart.cart.errors[field][0];
        }
    }
}
