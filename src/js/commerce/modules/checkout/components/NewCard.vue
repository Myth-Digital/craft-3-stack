<template>
    <div class="col-sm-12">
        <span v-if="paymentErrorMessage" class="error">{{paymentErrorMessage}}</span>

        <card-form ref="newCardForm" :publishableId="publishableId" :apiEndpoint="apiEndpoint" :promptSaveCard="false" :userHasOtherCards="hasOtherCardFlag" :onTokenizeComplete="handleTokenizeComplete" :onTokenizeFailure="handleTokenizeFailure"></card-form>

        <div class="mt-2">
            <button v-bind:class="{ isLoading: isLoading }" class="btn btn-secondary btn-solid" @click="addNewPaymentSource()">Add card</button>
        </div>
    </div>
</template>

<script>
import CardForm from './CardForm';

export default {
    components: {
        CardForm
    },
    props: {
        gatewayId: String,
        hasOtherCard: String,
        publishableId: String,
        apiEndpoint: String
    },
    data() {
        return {                      
            paymentErrorMessage: null,
            isLoading: false,
            setPrimaryPaymentSource: null,
            hasOtherCardFlag: false
        }
    },
    created() {
        this.hasOtherCardFlag = this.hasOtherCard === 'true';
    },
    methods: {
        addNewPaymentSource() {
            this.$refs.newCardForm.tokenizePaymentSource();
        },
        handleTokenizeComplete(res) {

            res.gatewayId = this.gatewayId;

            this.isLoading = true;

            return this.$store.dispatch('paymentSources/addPaymentSource', res)
                .then(res => {
                    if (res.success === true) {
                        window.location = `/customer/cards?newcard=success`;
                    }  else {
                        throw res;
                    }       
                })
                .catch(res => {
                    this.paymentErrorMessage = res.error;
                })
                .finally(res => {
                    this.isLoading = false;
                });             
        },
        handleTokenizeFailure(res) {
            this.paymentErrorMessage = res.message;
            this.isLoading = false;
        }
    }
}
</script>

<style>



</style>
