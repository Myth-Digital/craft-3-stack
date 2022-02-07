<template>
  <div :class="[ isSectionActive ? 'block' : 'hidden', isLoading ? 'opacity-20' : '' ]">
    <span class="font-semibold text-lg my-5 block">Payment method</span>
    
    <label class="block mb-3 text-sm font-semibold">Choose a way to pay</label>
    <div @click="paymentMethodType = 'card'" class="cursor-pointer flex justify-between items-center w-full flex-col md:flex-row text-sm text-heading border-gray-300 border px-4 py-3 rounded bg-gray-100">
      <span class="text-md text-gray-700 font-semibold">Pay with card</span>
      <svg width="210" height="24" viewBox="0 0 210 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mt-2 md:mt-0">
        <rect x="132.5" y="0.5" width="33" height="23" rx="3.5" fill="white" stroke="#D9D9D9"/>
        <path fill-rule="evenodd" clip-rule="evenodd" d="M150.268 8.14192L148.541 8.52349V7.08202L150.268 6.70752V8.14192ZM153.86 8.94038C153.186 8.94038 152.752 9.26542 152.511 9.49153L152.422 9.05344H150.908V17.2924L152.628 16.9179L152.635 14.9183C152.883 15.102 153.248 15.3634 153.853 15.3634C155.085 15.3634 156.206 14.3459 156.206 12.106C156.199 10.0568 155.064 8.94038 153.86 8.94038ZM153.447 13.8089C153.041 13.8089 152.8 13.6605 152.635 13.4768L152.628 10.8553C152.807 10.6504 153.055 10.509 153.447 10.509C154.073 10.509 154.507 11.2298 154.507 12.1554C154.507 13.1023 154.08 13.8089 153.447 13.8089ZM161.629 12.1766C161.629 10.3677 160.775 8.94038 159.145 8.94038C157.507 8.94038 156.516 10.3677 156.516 12.1625C156.516 14.2894 157.686 15.3634 159.365 15.3634C160.184 15.3634 160.803 15.1726 161.271 14.9041V13.4909C160.803 13.7312 160.266 13.8795 159.585 13.8795C158.918 13.8795 158.326 13.6393 158.25 12.8055H161.615C161.615 12.7666 161.617 12.6782 161.62 12.5763L161.62 12.5761C161.624 12.4377 161.629 12.2743 161.629 12.1766ZM158.229 11.5054C158.229 10.7069 158.704 10.3748 159.138 10.3748C159.557 10.3748 160.005 10.7069 160.005 11.5054H158.229ZM148.541 9.06052H150.268V15.2433H148.541V9.06052ZM146.58 9.06051L146.69 9.5834C147.096 8.82026 147.901 8.97572 148.121 9.06051V10.6857C147.908 10.608 147.22 10.509 146.814 11.0531V15.2433H145.094V9.06051H146.58ZM143.25 7.52717L141.571 7.8946L141.564 13.5545C141.564 14.6003 142.327 15.3705 143.346 15.3705C143.91 15.3705 144.323 15.2645 144.55 15.1373V13.7029C144.33 13.7947 143.243 14.1198 143.243 13.074V10.5656H144.55V9.0605H143.243L143.25 7.52717ZM139.183 10.4737C138.818 10.4737 138.598 10.5797 138.598 10.8553C138.598 11.1562 138.977 11.2885 139.447 11.4527C140.214 11.7204 141.222 12.0728 141.227 13.3779C141.227 14.6427 140.243 15.3705 138.811 15.3705C138.22 15.3705 137.573 15.2504 136.933 14.9677V13.286C137.511 13.611 138.24 13.8513 138.811 13.8513C139.197 13.8513 139.472 13.7453 139.472 13.4203C139.472 13.087 139.061 12.9346 138.565 12.7507C137.81 12.4706 136.857 12.1173 136.857 10.9401C136.857 9.6894 137.786 8.9404 139.183 8.9404C139.754 8.9404 140.318 9.03225 140.889 9.26543V10.926C140.366 10.6362 139.706 10.4737 139.183 10.4737Z" fill="#6461FC"/>
        <rect x="88.5" y="0.5" width="33" height="23" rx="3.5" fill="white" stroke="#D9D9D9"/>
        <path fill-rule="evenodd" clip-rule="evenodd" d="M105.179 16.8294C103.995 17.8275 102.459 18.43 100.781 18.43C97.0358 18.43 94 15.4303 94 11.73C94 8.02966 97.0358 5.02997 100.781 5.02997C102.459 5.02997 103.995 5.63247 105.179 6.63051C106.363 5.63247 107.899 5.02997 109.577 5.02997C113.322 5.02997 116.358 8.02966 116.358 11.73C116.358 15.4303 113.322 18.43 109.577 18.43C107.899 18.43 106.363 17.8275 105.179 16.8294Z" fill="#ED0006"/>
        <path fill-rule="evenodd" clip-rule="evenodd" d="M105.179 16.8294C106.637 15.6005 107.561 13.7719 107.561 11.73C107.561 9.68801 106.637 7.85941 105.179 6.63051C106.363 5.63247 107.899 5.02997 109.577 5.02997C113.322 5.02997 116.358 8.02966 116.358 11.73C116.358 15.4303 113.322 18.43 109.577 18.43C107.899 18.43 106.363 17.8275 105.179 16.8294Z" fill="#F9A000"/>
        <path fill-rule="evenodd" clip-rule="evenodd" d="M105.179 16.8294C106.637 15.6005 107.561 13.7719 107.561 11.73C107.561 9.68804 106.637 7.85945 105.179 6.63054C103.721 7.85945 102.797 9.68804 102.797 11.73C102.797 13.7719 103.721 15.6005 105.179 16.8294Z" fill="#FF5E00"/>
        <rect x="44" width="34" height="24" rx="4" fill="#1F72CD"/>
        <path fill-rule="evenodd" clip-rule="evenodd" d="M50.0954 8.5L46.9143 15.7467H50.7225L51.1947 14.5913H52.2738L52.7459 15.7467H56.9377V14.8649L57.3112 15.7467H59.4795L59.8531 14.8462V15.7467H68.5709L69.6309 14.6213L70.6235 15.7467L75.1011 15.7561L71.91 12.1436L75.1011 8.5H70.6929L69.661 9.60463L68.6997 8.5H59.2159L58.4015 10.3704L57.568 8.5H53.7677V9.35186L53.345 8.5H50.0954ZM50.8323 9.52905H52.6886L54.7986 14.4431V9.52905H56.8322L58.4619 13.0524L59.9639 9.52905H61.9873V14.7291H60.7561L60.746 10.6544L58.9511 14.7291H57.8498L56.0448 10.6544V14.7291H53.512L53.0319 13.5633H50.4377L49.9585 14.728H48.6015L50.8323 9.52905ZM68.1198 9.52905H63.1137V14.726H68.0423L69.6309 13.0036L71.1621 14.726H72.7627L70.4362 12.1426L72.7627 9.52905H71.2315L69.651 11.2316L68.1198 9.52905ZM51.7353 10.4089L50.8806 12.4856H52.589L51.7353 10.4089ZM64.3499 11.555V10.6057V10.6048H67.4736L68.8366 12.1229L67.4132 13.6493H64.3499V12.613H67.081V11.555H64.3499Z" fill="white"/>
        <rect x="0.5" y="0.5" width="33" height="23" rx="3.5" fill="white" stroke="#D9D9D9"/>
        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.7503 15.8582H8.69056L7.146 9.79237C7.07269 9.51334 6.91703 9.26666 6.68806 9.1504C6.11664 8.85823 5.48696 8.6257 4.80005 8.50843V8.27489H8.11813C8.57607 8.27489 8.91953 8.6257 8.97677 9.03313L9.77817 13.4086L11.8369 8.27489H13.8394L10.7503 15.8582ZM14.9843 15.8582H13.039L14.6408 8.27489H16.5861L14.9843 15.8582ZM19.1028 10.3757C19.16 9.96728 19.5035 9.73374 19.9042 9.73374C20.5338 9.6751 21.2197 9.79238 21.7922 10.0835L22.1356 8.45081C21.5632 8.21727 20.9335 8.1 20.3621 8.1C18.4741 8.1 17.1003 9.15041 17.1003 10.6082C17.1003 11.7173 18.0734 12.2996 18.7603 12.6504C19.5035 13.0002 19.7897 13.2337 19.7324 13.5835C19.7324 14.1082 19.16 14.3418 18.5886 14.3418C17.9017 14.3418 17.2147 14.1669 16.5861 13.8747L16.2426 15.5085C16.9295 15.7996 17.6727 15.9169 18.3596 15.9169C20.4766 15.9745 21.7922 14.9251 21.7922 13.35C21.7922 11.3665 19.1028 11.2502 19.1028 10.3757ZM28.6 15.8582L27.0555 8.27489H25.3965C25.053 8.27489 24.7095 8.50843 24.5951 8.85823L21.7349 15.8582H23.7374L24.1371 14.7502H26.5976L26.8265 15.8582H28.6ZM25.6827 10.3171L26.2541 13.1751H24.6523L25.6827 10.3171Z" fill="#172B85"/>
        <rect x="176.5" y="0.5" width="33" height="23" rx="3.5" fill="white" stroke="#D9D9D9"/>
        <path d="M190 23L209 17.25V20C209 21.6569 207.657 23 206 23H190Z" fill="#FD6020"/>
        <path fill-rule="evenodd" clip-rule="evenodd" d="M205.394 9.11084C206.439 9.11084 207.014 9.59438 207.014 10.5077C207.066 11.2062 206.596 11.7972 205.969 11.9046L207.38 13.8925H206.282L205.08 11.9584H204.976V13.8925H204.087V9.11084H205.394ZM204.976 11.3137H205.237C205.812 11.3137 206.073 11.045 206.073 10.5615C206.073 10.1317 205.812 9.86304 205.237 9.86304H204.976V11.3137ZM201.003 13.8925H203.512V13.0866H201.892V11.7972H203.46V10.9913H201.892V9.91674H203.512V9.11084H201.003V13.8925ZM198.39 12.3345L197.188 9.11084H196.247L198.181 14H198.652L200.585 9.11084H199.645L198.39 12.3345ZM187.78 11.5286C187.78 12.8717 188.826 14 190.132 14C190.551 14 190.916 13.8925 191.282 13.7314V12.6568C191.021 12.9792 190.655 13.1941 190.237 13.1941C189.401 13.1941 188.721 12.5494 188.721 11.6897V11.5823C188.669 10.7227 189.348 9.97048 190.185 9.91675C190.603 9.91675 191.021 10.1317 191.282 10.454V9.37948C190.969 9.16458 190.551 9.11085 190.185 9.11085C188.826 9.0034 187.78 10.1317 187.78 11.5286ZM186.16 10.9376C185.638 10.7227 185.481 10.6152 185.481 10.3466C185.533 10.0242 185.794 9.75557 186.108 9.8093C186.369 9.8093 186.631 9.97048 186.84 10.1854L187.31 9.54066C186.944 9.2183 186.474 9.00339 186.003 9.00339C185.272 8.94967 184.645 9.54066 184.592 10.2928V10.3466C184.592 10.9913 184.854 11.3674 185.69 11.636C185.899 11.6897 186.108 11.7972 186.317 11.9046C186.474 12.0121 186.578 12.1733 186.578 12.3882C186.578 12.7643 186.265 13.0866 185.951 13.0866H185.899C185.481 13.0866 185.115 12.818 184.958 12.4419L184.383 13.0329C184.697 13.6239 185.324 13.9463 185.951 13.9463C186.787 14 187.467 13.3553 187.519 12.4956V12.3345C187.467 11.6897 187.206 11.3674 186.16 10.9376ZM183.129 13.8925H184.017V9.11084H183.129V13.8925ZM179 9.11086H180.307H180.568C181.822 9.16458 182.815 10.2391 182.763 11.5286C182.763 12.227 182.449 12.8717 181.927 13.3553C181.456 13.7314 180.882 13.9463 180.307 13.8926H179V9.11086ZM180.15 13.0866C180.568 13.1404 181.038 12.9792 181.352 12.7105C181.666 12.3882 181.822 11.9584 181.822 11.4748C181.822 11.045 181.666 10.6152 181.352 10.2928C181.038 10.0242 180.568 9.86302 180.15 9.91674H179.889V13.0866H180.15Z" fill="black"/>
        <path fill-rule="evenodd" clip-rule="evenodd" d="M193.948 9C192.641 9 191.544 10.0745 191.544 11.4714C191.544 12.8146 192.589 13.9429 193.948 13.9966C195.307 14.0503 196.352 12.9221 196.404 11.5252C196.352 10.1283 195.307 9 193.948 9V9Z" fill="#FD6020"/>
      </svg>
    </div>

    <div v-if="paymentMethodType === 'card'">
      <div v-if="paymentSources.length">
        <span class="font-semibold text-lg my-5 block">Select a payment method</span>
        <label class="py-2 px-4 text-red-900 bg-red-200 block my-4" v-if="paymentErrorMessage">{{ paymentErrorMessage }}</label>
        <c-select v-model="paymentMethod" :options="paymentSources" :required="true" name="cardId" placeholder="Select a card or add a new one" label="Saved cards" />
        <button v-if="existingShippingAddressId != -1" @click="existingShippingAddressId = -1">Add a new credit/debit card</button>
      </div>
      
      <div class="my-5" v-if="!paymentSources.length || isNewPaymentSource">
          <card
            class="stripe-card p-2 border border-gray-200"
            :stripe="stripePublishableKey"
            :options="stripeOptions"
            ref="cardElement"
          />
      </div>
    </div>

    <div class="flex justify-between mt-6">
      <c-button @click="goBack()" label="Go back" type="text" :loading="isLoading" />
      <c-button @click="submitOrder()" :label="'Pay' + cart.totalPrice | currency" type="solid" :disabled="!selectedShippingMethod" :loading="isLoading" />
    </div>
  </div>
</template>


<script>
import { Card, createPaymentMethod, instance, elements } from "vue-stripe-elements-plus"

export default {
  components: { Card },
  props: {
    guestCheckout: String,
    gatewayId: String,
    stripePublishableKey: String
  },
  created() {
    this.guestCheckoutFlag = this.guestCheckout === 'true';

    this.$store.dispatch("paymentSources/getPaymentSources");
    this.$store.dispatch("cart/init").then((res) => {
      this.selectedShippingMethod = null
    });

    if (this.guestCheckout) {
      this.paymentMethod = "new"
    }
  },
  data() {
    return {
      isLoading: false,
      paymentMethod: null,
      paymentMethodType: null,
      selectedShippingMethod: null,
      guestCheckoutFlag: false,
      stripeOptions: {},
      newCardFirstName: null,
      newCardLastName: null,
      newCardSavePaymentSource: false,
      newCardSetPrimaryPaymentSource: false,
      paymentErrorMessage: null,
      showAuthFrame: false
    };
  },
  computed: {
    paymentSources() {
      return this.$store.state.paymentSources.paymentSources
    },
    cart() {
      return this.$store.state.cart.cart
    },
    workflowStep() {
      return this.$store.state.cart.cartWorkflow.indexOf("payment")
    },
    workflowStepDisplay() {
      return this.workflowStep + 1
    },
    isSectionActive() {
      return this.$store.state.cart.currentCheckoutState.name === 'payment'
    },
    isNewPaymentSource() {
      return this.paymentMethod === "new"
    },
  },
  methods: {
    goBack() {
      var newWorkflowState = this.$store.state.cart.cartWorkflow[
        this.workflowStep - 1
      ];

      this.$store.dispatch("cart/setCheckoutState", newWorkflowState)
    },
    submitOrder() {
      this.$store.dispatch('cart/isIsLoading')

      this.isNewPaymentSource
        ? this.submitOrderNewPaymentSource()
        : this.submitOrderExistingPaymentSource();
    },
    submitOrderNewPaymentSource() {
      this.$store.dispatch('cart/isIsLoading')

      createPaymentMethod('card').then(data => {
        let cartUpdateAction = 'cart/setGatewayId'
        let cartUpdateActionParam = this.gatewayId

        this.$store.dispatch(cartUpdateAction, cartUpdateActionParam)
          .then(res => {
              let paymentPayload = {
                  orderEmail: this.cart.email,
                  firstName: this.newCardFirstName,
                  lastName: this.newCardLastName,
                  savePaymentSource: this.newCardSavePaymentSource ? 1 : 0,
                  paymentMethodId: data.paymentMethod.id,
                  redirect: this.returnUrl,
                  cancelUrl: this.cancelUrl
              }

              this.$store.dispatch('cart/submitOrder', paymentPayload)
                .then(res => {
                    if (res.error) {
                        this.isLoading = false
                        this.paymentErrorMessage = res.error
                    }
                    else if (res.redirect) {
                      window.location = res.redirect
                    }
                    else {
                        window.location = `/checkout/confirmation?number=${this.cart.number}`
                    }
                })
          })
      })
    },
    submitOrderExistingPaymentSource() {
      this.$store.dispatch('cart/isIsLoading')

      let cartUpdateAction = 'cart/setPaymentSourceId'
      let cartUpdateActionParam = this.paymentMethod

      this.$store.dispatch(cartUpdateAction, cartUpdateActionParam)
        .then(res => {
        let paymentPayload = {
            orderEmail: this.cart.email,
            redirect: this.returnUrl,
            cancelUrl: this.cancelUrl
        };
        this.$store.dispatch('cart/submitOrder', paymentPayload)
            .then(res => {
                if (res.error) {
                    this.isLoading = false;
                    this.paymentErrorMessage = res.error;
                }
                else if (res.redirect) {
                  window.location = res.redirect;
                }                        
                else {
                    window.location = `/checkout/confirmation?number=${this.cart.number}`;
                }
            });
        });
      }
    }
};
</script>