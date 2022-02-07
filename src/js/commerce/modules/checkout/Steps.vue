<template>
  <div>
    <span class="mb-8 md:text-2xl text-heading">{{ currentStepVal.label }}</span>
    <nav>
      <ol class="border border-gray-300 rounded-md divide-y divide-gray-300 md:flex md:divide-y-0">

        <li class="relative md:flex-1 md:flex" v-for="(step, index) in workflowSteps" :key="index">
          <button class="group flex items-center w-full" @click="goToWorkflow(step.name)">
            <span class="px-6 py-4 flex items-center text-sm font-medium">
              <span class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full border-2" :class="(step.name === currentStepVal.name ? 'border-primary text-primary' : (step.name < currentStepVal.name ? 'bg-primary group-hover:bg-primary' : ' text-gray-400 border-gray-300 group-hover:border-gray-600'))">
                <svg v-if="step.name < currentStepVal.name" class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                <span v-else>0{{ index+1 }}</span>
              </span>
              <span class="ml-4 text-sm font-medium" :class="(step.name === currentStepVal.name ? 'text-primary' : (step.name < currentStepVal.name ? 'text-black' : 'text-gray-500 group-hover:text-gray-600'))">{{ step.label }}</span>
            </span>
          </button>
          <div v-if="index+1 != workflowSteps.length" class="hidden md:block absolute top-0 right-0 h-full w-5" aria-hidden="true">
            <svg class="h-full w-full text-gray-300" viewBox="0 0 22 80" fill="none" preserveAspectRatio="none">
              <path d="M0 -2L20 40L0 82" vector-effect="non-scaling-stroke" stroke="currentcolor" stroke-linejoin="round" />
            </svg>
          </div>
        </li>

      </ol>
    </nav>
  </div>
</template>

<script>
export default {
  props: {
    showAccount: String
  },
  data() {
    return {
      showAccountFlag: false
    }
  },
  created() {
    this.showAccountFlag = this.showAccount === 'true';

    if(this.showAccountFlag) {
      this.goToWorkflow('account')
    } else {
      this.goToWorkflow('delivery')
    }
  },
  computed: {
    currentStepVal() {
      return this.$store.state.cart.currentCheckoutState
    },
    workflowSteps() {
      if(!this.showAccountFlag) {
        return this.$store.state.cart.cartWorkflow.filter(w => w.guestCheckout == this.showAccountFlag)
      }else {
        return this.$store.state.cart.cartWorkflow
      }
    }
  },
  methods: {
    goToWorkflow(state) {
      var newWorkflowState = this.$store.state.cart.cartWorkflow.filter(i => i.name == state)
      this.$store.dispatch("cart/setCheckoutState", newWorkflowState[0])
    }
  }
}
</script>

<style>

</style>