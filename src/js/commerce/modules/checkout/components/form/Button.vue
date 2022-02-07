<template>
  <button 
    class="inline-flex items-center px-5 py-3 font-medium rounded text-sm border focus:outline-none focus:ring-2 focus:ring-offset-2"
    :class="[ disabled ? 'opacity-40' : '', (type == 'solid' ? 'border-transparent text-white bg-primary-500 hover:bg-primary-700 focus:ring-primary' : (type === 'outline' ? 'border-primary text-primary hover:text-white bg-white hover:bg-primary-700 focus:ring-primary' : '')) ]"
    :disabled="disabled || loading">
    <svg v-show="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
    {{ label }}
  </button>
</template>

<script>
export default {
  props: {
    label: String,
    type: String,
    loading: {
      type: Boolean,
      default: false
    },
    disabled: {
      type: Boolean,
      default: false
    }
  }
}
</script>