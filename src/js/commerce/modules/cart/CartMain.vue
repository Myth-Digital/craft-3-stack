<template>
    <section class="cart-page"> 
        <div class="container-small">
            <div class="row">
                <div class="col-xs-12 col-md-8">
                    <div class="cart-page_list" v-if="totalLineItems > 0">
                        
                        <div class="row cart-page_list_item middle-xs" v-for="(lineItem, key) in cart.lineItems" :key="key">
                            <div class="col-xs-12 col-md-2">
                                <a :href="lineItem.snapshot.url"><img class="product-image" :src="`api/product/${lineItem.snapshot.productId}/thumb/`" :alt="lineItem.snapshot.title" /></a>
                            </div>
                            <div class="col-xs-12 col-md-3"> 
                                <span class="h6">
                                    <span class="cart-title">{{ lineItem.snapshot.description }}</span><br />
                                    <span class="cart-category" v-if="getSize(lineItem)">{{ getSize(lineItem) }}</span><br />
                                    <span class="cart-category" v-if="getPlan(lineItem)">{{ getPlan(lineItem) }} Plan</span>
                                    <span class="cart-quantity">x {{ lineItem.qty }}</span>
                                </span>
                            </div>
                            <div class="col-xs-12 col-md-3">
                                <input class="quantity" type="number" v-model="lineItem.quantity">
                                <button class="cta_btn outline slide__link _small" @click="updateCart(lineItem.id)">Update</button>
                            </div>
                            <div class="col-xs-12 col-md-2">
                                <span class="delete" @click="removeItem(lineItem.id)">Delete</span>
                            </div>
                            <div class="col-xs-12 col-md-2">
                                <span class="price">{{ lineItem.subtotal  }}</span>
                            </div>
                        </div>
                        
                    </div>
                    <div v-if="totalLineItems === 0">
                        <p>Sorry you have nothing in your cart.<br />
                        <a href="/products">Add something...</a></p>
                    </div>
                </div>

                <div class="col-xs-12 col-md-4">
                    <div class="cart-page_bag">
                        <h4>Your Bag</h4>
                        <div class="cart-page_bag_item">
                            Subtotal: <b>{{ cart.itemSubtotal  }}</b>
                        </div>
                        <a href="/checkout/payment" class="cta_btn slide__link"><i class="fa fa-lock"></i> Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {    
    data() {
        return {
            isLoading: false,
        }
    },
    created() {
        this.$store.dispatch('cart/init');
    },
    computed: {
        cart() {
            return this.$store.state.cart.cart;
        },
        isOpen() {
            return this.$store.state.cart.cartOpen;
        },
        totalLineItems() {
            if (!this.cart || !this.cart.lineItems) return 0;

            return this.cart.lineItems.length;
        }
    },
    methods: {
        closeCart() {
            this.$store.dispatch('cart/hideCartPane');
        },
        removeItem(lineItemId) {
            this.$store.dispatch('cart/removeFromCart', lineItemId);
        },
        updateCart(lineItemId) {
            this.$store.dispatch('cart/updateCartQty', {lineItemId, qty: this.lineItem.quantity });
        }   
    }
}
</script>

<style>

</style>
