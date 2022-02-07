<template>
  <div :class="[ isSectionActive ? 'block' : 'hidden', isLoading ? 'opacity-20' : '' ]">
    <!--
      Delivery address selection
    -->
    <div v-show="showDeliveryAddresses">
      <div v-if="customerAddresses.length > 0 && !guestCheckoutFlag">
        <span class="font-semibold text-lg my-5 block">Delivery address</span>

        <div v-if="selectedShippingAddressId != -1 && selectedShippingAddress.id" class="relative bg-white border rounded-lg p-4 flex gap-4">
          <svg class="h-5 w-5 text-primary-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
          </svg>
          <div class="flex-1">
            <span id="shipping-0-label" class="block text-sm font-medium text-gray-900">
              Deliver to
            </span>
            <div id="shipping-0-description-0" class="flex text-sm text-black">
              <span class="font-bold" v-show="selectedShippingAddress.fullName">{{ selectedShippingAddress.fullName }}</span>
              <span v-show="selectedShippingAddress.address1">, {{ selectedShippingAddress.address1 }}</span>
              <span v-show="selectedShippingAddress.address2">, {{ selectedShippingAddress.address2 }}</span>
              <span v-show="selectedShippingAddress.city">, {{ selectedShippingAddress.city }}</span>
              <span v-show="selectedShippingAddress.zipCode">, {{ selectedShippingAddress.zipCode }}</span>
              <span v-show="selectedShippingAddress.countryText">, {{ selectedShippingAddress.countryText }}</span>
            </div>
          </div>
          <button v-if="selectedShippingAddressId != -1" @click="selectedShippingAddressId = -1" class="text-primary-500 font-semibold text-xs block">Change</button>
        </div>
      </div>

      <div v-if="!addNewAddress && (customerAddresses.length > 0 && !guestCheckoutFlag && selectedShippingAddressId == -1)">
        <c-select v-model="selectedShippingAddressId" :options="customerAddresses" :error="getError('shippingAddressId')" :required="true" name="shippingAddressId" placeholder="Please select an address" label="Select a shipping address" />
        <button @click="addNewAddress = true" class="font-semibold text-sm block mt-2">+ Add a new address</button>
      </div>

      <div v-if="addNewAddress || guestCheckoutFlag">
        <span class="font-semibold text-base my-5 block">Enter your shipping address</span>
        <delivery-address error-root="shippingAddress" v-model="shippingAddress"></delivery-address>
      </div>

      <div class="flex justify-end gap-4 mt-6 pt-6 border-t border-gray-200">
        <c-button v-if="guestCheckoutFlag" @click.native="goToWorkflow('account')" label="Go back" type="text" :loading="isLoading" />
        <c-button @click.native="submitDeliveryAddress()" label="Save and continue" type="solid" :disabled="selectedShippingAddressId == -1 && !addNewAddress" :loading="isLoading" />
      </div>
    </div>

    <!--
      Delivery method selection
    -->
    <div v-show="showDeliveryMethods">
      <span class="font-semibold text-lg my-5 block">Choose a delivery method</span>
      <delivery-methods error-root="shippingMethods" v-model="selectedShippingMethod" :methods="shippingMethods"></delivery-methods>
      
      <div class="flex justify-end gap-4 mt-6 pt-6 border-t border-gray-200">
        <c-button v-if="guestCheckoutFlag" @click.native="goToWorkflow('account')" label="Go back" type="text" :loading="isLoading" />
        <c-button @click.native="submitDeliveryMethod()" label="Save and continue" type="solid" :disabled="!selectedShippingMethod" :loading="isLoading" />
      </div>
    </div>
  </div>
</template>


<script>
import DeliveryAddress from './components/DeliveryAddress'
import DeliveryMethods from './components/DeliveryMethods'

export default {
  components: {
    DeliveryAddress,
    DeliveryMethods
  },
  props: {
    guestCheckout: String
  },
  data() {
    return {
      isLoading: false,
      guestCheckoutFlag: false,
      addNewAddress: false,
      selectedShippingAddress: {},
      selectedShippingAddressId: -1,
      selectedShippingMethod: null,
      showDeliveryMethods: false,
      showDeliveryAddresses: true,
      shippingMethods: [],
      shippingAddress: {},
      email: null
    }
  },
  created() {
    this.isLoading = true

    this.guestCheckoutFlag = this.guestCheckout === 'true'
    this.$store.dispatch('standingData/getAddresses')
    
    this.$store.dispatch("cart/init").then((res) => {
      this.getSelectedShippingAddress(res.shippingAddressId)
      this.selectedShippingMethod = null
      this.selectedShippingAddressId = this.selectedShippingAddress.id
      this.email = res.email
      this.isLoading = false
    })
  },
  watch: {
    selectedShippingAddressId() {
      return this.getSelectedShippingAddress(this.selectedShippingAddressId)
    }
  },
  computed: {
    cart() {
      return this.$store.state.cart.cart
    },
    workflowStep() {
      return this.$store.state.cart.cartWorkflow.indexOf({name: 'delivery'});
    }, 
    isSectionActive() {
      return this.$store.state.cart.currentCheckoutState.name === "delivery"
    },
    customerAddresses() {
        return this.$store.state.standingData.addresses
    },
    shippingMethodRuleDescription() {
      return this.cart.shippingMethodRuleDescription
    }
  },
  methods: {
    getError(path) {
        if (!this.cart.errors) return null
        if (!this.cart.errors[path]) return null
        return this.cart.errors[path][0]
    },
    goToWorkflow(state) {
      var newWorkflowState = this.$store.state.cart.cartWorkflow.filter(i => i.name == state)
      this.$store.dispatch("cart/setCheckoutState", newWorkflowState[0])
    },
    getSelectedShippingAddress(id) {
      this.selectedShippingAddress = this.customerAddresses.filter(a => a.id == id)[0]
    },
    fetchShippingMethods() {
      this.showDeliveryAddresses = false
      this.showDeliveryMethods = true

      this.$store.dispatch("cart/init")
      .then(res => {
        this.showDeliveryMethods = true
        this.shippingMethods = res.availableShippingMethodOptions
      })
    },
    updateShippingMethod() {
      let payload = {
        shippingMethodHandle: this.selectedShippingMethod,
      }
      this.$store.dispatch('cart/isIsLoading')
      this.$store
        .dispatch("cart/updateCart", payload)
        .then((res) => {
          return this.$store.dispatch('cart/isNotLoading')
        })
    },
    submitDeliveryAddress() {
      this.isLoading = true

      delete this.shippingAddress.id
      delete this.shippingAddress.fullName
      delete this.shippingAddress.countryText
      delete this.shippingAddress.stateText
      delete this.shippingAddress.abbreviationText
      
      let payload = {
          email: this.email,
          billingSameAsShipping: 1
      }

      if (this.guestCheckoutFlag || this.selectedShippingAddressId == -1) {
        payload.shippingAddress = this.shippingAddress;
        // ???
        // if (this.existingShippingAddressSameAsBilling == this.shippingAddressSameAsBilling) {
        //     payload.shippingAddress.id = this.selectedShippingAddressId;
        // }
      } else {
        payload.shippingAddressId = this.selectedShippingAddressId;
      }

      this.$store.dispatch('cart/updateCart', payload)
          .then(res => {
            if (!res.errors) this.fetchShippingMethods();
          })
          .finally(res => this.isLoading = false);
    },
    submitDeliveryMethod() {
      this.isLoading = true

      let payload = {
        shippingMethodHandle: this.selectedShippingMethod,
      };

      this.$store.dispatch('cart/updateCart', payload)
        .then(res => {
          if (!res.errors) this.goToWorkflow('payment');
        })
        .finally(res => this.isLoading = false);
    }
  },
}
</script>
