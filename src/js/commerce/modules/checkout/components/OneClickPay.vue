<template>
  <div class="labeled-box modelName">
      <span class="box-header">Quick checkout</span>
      <div class="labeled-box_content">
            <div class="row">
                <div class="col-xs-12">
                    <h4 class="mt20 mb10">Payment Type</h4>
                    <select :disabled="disabled" id="paymentMethod" class="address-country" ref="cardId" v-model="paymentMethod" required>
                        <option v-for="source in paymentSources" :selected="cart.paymentSourceId == source.id" :key="source.id" :value="source.id">{{ source.description }}</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <h4 class="mt20 mb10">Delivery Address</h4>
                    <span>{{ shippingAddress.address1 }}<br />
                    {{ shippingAddress.address2 }}<br />
                    {{ shippingAddress.city }}<br />
                    {{ shippingAddress.countryText }}<br />
                    {{ shippingAddress.zipCode }}</span>
                </div>
            </div>
            <p v-if="paymentErrorMessage">{{paymentErrorMessage}}</p>

            <button v-if="!isLoading" v-bind:class="{ isLoading: isLoading }" :disabled="isLoading" class="btn mb20 _solid _full" id="pay_button" @click="submitOrder()">
                <v-icon name="lock" /> Finish &amp; Pay
            </button>

            <loading-bar v-if="isLoading" :isLoading="isLoading"></loading-bar>

            <p class="small">By proceeding I accept the <a href="/terms" target="_blank">Terms &amp; Conditions</a></p>
      </div>
  </div>
</template>

<script>

export default {
    created() {
        this.$store.dispatch('cart/init')
        .then(res => {
            this.shippingAddress = res.shippingAddress ? res.shippingAddress : {};
            return this.$store.dispatch('paymentSources/getPaymentSources');
        })
        .then(res => {
            if (this.cart.paymentSourceId) {
                this.paymentMethod = this.cart.paymentSourceId;
                return Promise.resolve();
            } else {
                let primaryCard = this.paymentSources.find(p => p.primary);
                this.paymentMethod = primaryCard.id;
                return this.$store.dispatch('cart/setPaymentSourceId', primaryCard.id);
            }
        })
        .catch(res => {
            this.paymentErrorMessage = "An error occurred whilst fetching your Quick Pay details";
            this.paymentMethod = null;
            this.shippingAddress = {};
        })
        .finally(res => {
            this.isLoading = false;
        })
    },
    data() {
        return {
            isLoading: true,
            paymentMethod: null,
            paymentErrorMessage: null,
            shippingAddress: {}
        }
    },
    computed: {
        paymentSources() {
            return this.$store.state.paymentSources.paymentSources;
        },
        cart() {
            return this.$store.state.cart.cart;
        }
    },
    methods: {
        submitOrder() {
            let cartUpdateAction = 'cart/setPaymentSourceId';
            let cartUpdateActionParam = this.paymentMethod;

            this.$store.dispatch(cartUpdateAction, cartUpdateActionParam)
                .then(res => {

                    let paymentPayload = {
                        orderEmail: this.cart.email
                    };

                    this.$store.dispatch('cart/submitOrder', paymentPayload)
                        .then(res => {
                            if (res.error) {
                                this.paymentErrorMessage = res.error;
                            }
                            else if (res.success) {
                                window.location = `/checkout/confirmation?number=${this.cart.number}`;
                            }
                        });

                });
        }
    }
}
</script>

<style>

</style>
