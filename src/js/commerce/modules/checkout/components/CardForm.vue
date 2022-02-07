<template>
    <form class="sub-form space-y-6" v-if="!isLoading">

        <c-input v-model="cardHolderName" :required="true" name="cardHolderName" type="text" placeholder="Name as it appears on your card" label="Name on the card" />
        <c-input v-model="cardNumber" :required="true" name="cardNumber" type="text" placeholder="•••• •••• •••• ••••" label="Card number" />

        <div class=" flex items-center gap-5">
            <div class="w-1/2">
                <label class="font-bold w-full block mb-2" for="cardExpiry">Expiry date</label>
                <input id="cardExpiry" class="w-full placeholder-gray-400" type="text" v-model="cardExpiry" name="cardExpiry" placeholder="MM/YYYY" v-payment:formatCardExpiry>
            </div>
            <div class="w-1/2 field double no-pd">
                <label class="font-bold w-full block mb-2" for="cvc">CVC</label>
                <input id="cvc" class="placeholder-gray-400" type="text" :maxlength="3" v-model="cardCvv" name="cvc" placeholder="•••" required v-payment:formatCardCVC>
            </div>
        </div>


        <div class="flex items-center gap-5 pb-4 md:h-10" v-if="promptSaveCard">
            <input class="block placeholder-gray-400" type="checkbox" v-model="savePaymentSource" required>
            <span class="block">Save this card for future use</span>
        </div>

        <div class="flex items-center gap-5 pb-6 md:h-10" v-if="cardBeingSaved && userHasOtherCards">
            <input class="block placeholder-gray-400" type="checkbox" v-model="setPrimaryPaymentSource" required>
            <span class="block">Make this my primary payment source</span>
        </div>

    </form>

    <div v-else>
        <p>Please wait</p>
    </div>

</template>

<script>
export default {
    props: {
        publishableId: String,
        apiEndpoint: String,
        userHasOtherCards: Boolean,
        promptSaveCard: Boolean,
        onTokenizeComplete: Function,
        onTokenizeFailure: Function
    },
    data() {
        return {
            publicPath: process.env.SITE_URL,
            isLoading: false,
            cardHolderName: '',
            cardNumber: '',
            cardExpiry: '',
            cardCvv: '',
            setPrimaryPaymentSource: false,
            savePaymentSource: false
        }
    },
    watch: {
        'cardNumber': function() {
            this.cardNumber = this.cardNumber.replace(/[^0-9]/g, '').replace(/(.{4})/g, '$1 ').trim();
        }
    },
    computed: {
        cardBeingSaved() {
            return this.savePaymentSource || !this.promptSaveCard;
        }
    },
    methods: {
        tokenizePaymentSource() {
            this.isLoading = true;

            let joinedCardNumber = this.cardNumber.split(' ').join('').trim();

            let card = {
                publishableId: this.publishableId,
                pan: joinedCardNumber,
                cvv: this.cardCvv
            };        

            this.$store.dispatch('paymentSources/tokenizeCard', {card: card, apiEndpoint: this.apiEndpoint})
                .then(res => {

                    if (res.status != "S00") {
                        throw res;
                    }

                    let month = this.cardExpiry.split("/").join('').slice(0,2).trim();
                    let year = this.cardExpiry.split("/").join('').slice(4,6).trim();
                    let combinedExpiry = `${month}${year}`;
                    let lastFourDigits = joinedCardNumber.slice(joinedCardNumber.length -4);
                    let defaultCard = this.cardBeingSaved && (!this.userHasOtherCards || this.setPrimaryPaymentSource);
                
                    let cardDetails = {
                        token: res.token,
                        tokenType: 'cardlock',
                        expiryDate: combinedExpiry,
                        cardHolderName: this.cardHolderName,
                        nickname: `Card ending ${lastFourDigits}`,
                        savePaymentSource: this.cardBeingSaved,
                        defaultCard: defaultCard
                    };

                    this.onTokenizeComplete(cardDetails);
            
                })
                .catch(res => {
                    this.onTokenizeFailure(res);
                })
                .finally(res => {
                    this.isLoading = false;
                });       
        }
    }        
}
</script>

<style>

</style>