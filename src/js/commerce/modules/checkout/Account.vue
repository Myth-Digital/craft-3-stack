<template>
    <div :class="[ isSectionActive ? 'block' : 'hidden', isLoading ? 'opacity-20' : '' ]">
        <div v-if="!oneClickPay && guestCheckoutFlag">
            <span class="font-semibold text-lg my-5 block">Create an account</span>
            <c-input v-model="email" :error="getError('email')" name="email"  type="email" placeholder="email@domain.com" label="Email Address" />
            <div class="flex mt-2 items-center">
                <input class="mr-4 w-6 h-6" type="checkbox" v-model="userCreateAccount">
                <label for="userCreateAccount" class="text-sm">Click here if you'd like to register an account</label><br>
            </div>
            <div class="grid gap-3 gap-y-6 grid-cols-1 sm:grid-cols-2 relative my-5" v-if="userCreateAccount">
                <c-input v-model="valuepassword" :error="getError('password')" name="password" type="password" placeholder="**********" label="Create a password" :required="true" @input="updateData()" />
                <c-input v-model="valueconfirmPassword" :error="getError('confirmPassword')" name="confirmPassword"  type="password" placeholder="**********" label="Confirm your password" :required="true" @input="updateData()" />
            </div>

            <div class="mt-6 flex">
                <c-button label="Create account and continue" type="solid" />
                <c-button label="Continue as guest" type="outline" />
            </div>
        </div>

        <div v-if="canOneClickPay">
            <input :disabled="!isSectionActive" type="checkbox" id="oneClickPay" v-model="oneClickPay">
            <label for="oneClickPay" class="oneClickPay">
                <div class="toggle">
                    <div class="indicator"></div>
                </div>
                <div class="prompt">
                    <div class="default">
                        <span>Quick-pay</span>
                        I'd like to pay using quickpay.
                    </div>
                    <div class="event">
                        <span>Quick-pay</span>
                        You're just a click away.
                    </div>
                </div>
            </label>
            <checkout-oneclickpay v-model="oneClickPay"></checkout-oneclickpay>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        guestCheckout: String
    },
    data() {
        return {
            isLoading: false,
            userCreateAccount: false,
            guestCheckoutFlag: false,
            existingBillingAddressId: -1,
            existingShippingAddressId: -1,
            existingShippingAddressSameAsBilling: true,
            billingAddress: {},
            shippingAddress: {},
            shippingAddressSameAsBilling: true,
            email: null,
            oneClickPay: false
        }
    },
    created() {
        this.guestCheckoutFlag = this.guestCheckout === 'true';

        this.$store.dispatch('cart/init')
        .then(res => {

            this.existingBillingAddressId = res.billingAddressId;
            this.existingShippingAddressId = res.shippingAddressId;

            if (res.billingAddressId !== res.shippingAddressId) {
                this.shippingAddressSameAsBilling = false;
                this.existingShippingAddressSameAsBilling = false;
            }
            this.email = res.email;
        });

        this.$store.dispatch('paymentSources/getPaymentSources');
        this.$store.dispatch('standingData/getAddresses');
    },
    computed: {
        cart() {
            return this.$store.state.cart.cart;
        },
        workflowStep() {
            return this.$store.state.cart.cartWorkflow.indexOf({name: 'account'});
        },
        paymentSources() {
            return this.$store.state.paymentSources.paymentSources;
        },
        addresses() {
            return this.$store.state.standingData.addresses;
        },
        isSectionActive() {
            return this.$store.state.cart.currentCheckoutState.name === 'account';
        },
        canOneClickPay() {
            return this.paymentSources.length > 0 && this.addresses.length > 0;
        }
    },
    watch: {
        oneClickPay(newVal) {
            this.$store.dispatch('cart/setIsOneClickPay', newVal);
        }
    },
    methods: {
        getError(path) {
            if (!this.cart.errors) return null;
            if (!this.cart.errors[path]) return null;
            return this.cart.errors[path][0];
        },
        goNext() {
            var newWorkflowState = this.$store.state.cart.cartWorkflow[this.workflowStep + 1];
            this.$store.dispatch('cart/setCheckoutState', newWorkflowState);
        }
    }
}
</script>

<style>

</style>
