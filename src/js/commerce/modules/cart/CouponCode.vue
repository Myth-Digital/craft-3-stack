<template>
    <div>
        <label :for="couponCode" class="block mb-2 text-sm font-semibold">Add discount code</label>
        <div class="flex w-full">
            <input v-model="couponCode" type="text" name="couponCode" value="couponCode" class="bg-gray-100 border p-2 w-full">
            <button v-if="cartHasCoupon" @click="applyCouponCode()" :disabled="isLoading" class="h-full" type="submit">{{ cartHasCoupon ? 'Change' : 'Apply'}}</button>
        </div>
        <span v-if="errorMessage">{{errorMessage}}</span>
    </div>
</template>

<script>
export default {
    created() {
        this.$store.dispatch('cart/init')
            .then(res => this.couponCode = res.couponCode);
    },
    data() {
        return {
            errorMessage: null,
            couponCode: null,
            isLoading: false
        }
    },
    computed: {
        cartHasCoupon() {
            return this.$store.state.cart.cart.couponCode !== null && this.$store.state.cart.cart.couponCode !== undefined && this.$store.state.cart.cart.couponCode !== '';
        }
    },
    methods: {
        applyCouponCode() {
            this.isLoading = true;
            this.errorMessage = null;

            this.$store.dispatch('cart/applyCouponCode', this.couponCode)
                .then(res => {
                    if (res.errors && res.errors.couponCode.length > 0) {
                        this.errorMessage = res.errors.couponCode[0];
                    }
                })
                .finally(res => this.isLoading = false);
        }
    }
}
</script>