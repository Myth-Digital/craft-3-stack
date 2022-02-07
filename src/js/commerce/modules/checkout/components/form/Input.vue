<template>
  <div class="w-full">
    <label :for="name" class="block mb-2 text-sm font-semibold">{{ label }}</label>
    <input
      class="w-full px-4 py-3 text-sm border border-gray-300 rounded lg:text-sm focus:outline-none focus:ring-1 focus:ring-primary-600"
      :class="{ error : 'border-red-600' }"
      :type="type"
      :placeholder="placeholder"
      :value="value"
      :name="name"
      :ref="name"
      :required="required"
      @input="updateValue($event.target.value)">
    <span v-if="error" class="block text-red-600">{{ error }}</span>
  </div>
</template>

<script>
export default {
  props: {
    type: {
      type: String
    },
    error: {
      type: String
    },
    name: {
      type: String,
      required: true
    },
    placeholder: {
      type: String,
      required: true
    },
    label: {
      type: String,
      required: true
    },
    value: {
      type: String
    },
    required: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    updateValue(value) {
      this.$emit('input', value)
    }
  }
}
</script>

<style>

</style>