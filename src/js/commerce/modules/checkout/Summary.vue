<template>
    <div class="flex flex-col w-full bg-gray-100 p-6 rounded">
        <div class="flex items-center justify-between border-gray-300 border-b">
            <span class="text-lg font-bold flex items-center">{{ totalLineItems }} items</span>
            <span class="text-lg font-bold"><span v-html="currencySymbol(cart.currency)"></span>{{ cart.totalPrice | currency }}</span>
        </div>

        <div class="flex justify-between">
            <span>Subtotal</span>
            <span><i v-html="currencySymbol(cart.currency)"></i>{{ cart.itemSubtotal|currency }}</span>
        </div>
        <div class="flex justify-between" v-if="cart.totalTax">
            <span>Tax</span>
            <span><i v-html="currencySymbol(cart.currency)"></i>{{ cart.totalTax|currency }}</span>
        </div>
        <div class="flex justify-between" v-if="hasDiscountAdjustment">
            <span>Discount</span>
            <span><i v-html="currencySymbol(cart.currency)"></i>{{ cart.totalDiscount|currency }}</span>
        </div>
        <div class="flex justify-between" v-if="hasDiscountAdjustment">
            <span>Total</span>
            <span><i v-html="currencySymbol(cart.currency)"></i>{{ cart.totalPrice|currency }}</span>
        </div>

        <div class="flex justify-between border-t-gray-300 border-t">
            <coupon-code></coupon-code>
        </div>

        <div class="p-4" v-if="totalLineItems > 0">
            <div v-for="(lineItem, key) in cart.lineItems" :key="key" class="product-compact py-5 border-b border-gray-100 grid grid-cols-3 items-center justify-between">
                <img class="product-compact_img w-20 h-auto mr-3 col-span-1" :src="`/api/product/${lineItem.snapshot.productId}/thumb/`" :alt="lineItem.snapshot.title" />
                <div class="product-compact_details col-span-2">
                    <span class="product-compact_details_title block font-bold mb-2">{{ lineItem.snapshot.title }}</span>
                    <span class="product-compact_details_title block mb-2">Qty: {{ lineItem.qty }}</span>
                    <span class="product-compact_price font-bold text-lg"><span v-html="currencySymbol(cart.currency)"></span>{{ lineItem.subtotal | currency }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {    
    data() {
        return {
            isLoading: false,
            productInfo: []
        }
    },
    computed: {
        cart() {
            return this.$store.state.cart.cart;
        },
        totalLineItems() {
            if (!this.cart || !this.cart.lineItems) return 0;
            return this.cart.lineItems.length;
        },
        hasDiscountAdjustment() {
            if (!this.cart || !this.cart.orderAdjustments || this.cart.orderAdjustments.length === 0) return false;
            return this.cart.orderAdjustments.some(a => a.type === 'discount');
        }
    }
}
</script>

<style>

</style>
