<template>
  <div class="w-full">
    <label :for="name" class="block mb-3 text-sm font-semibold text-gray-700">{{ label }}</label>
    <select 
      class="w-full px-4 py-3 text-sm border border-gray-300 rounded lg:text-sm focus:outline-none focus:ring-1 focus:ring-primary-600"
      :class="{ error : 'border-red-600' }"
      :ref="name"
      :required="required"
      @input="updateValue($event.target.value)">
        <option selected>{{ placeholder }}</option>
        <option v-for="option in options" :key="option.id" :label="option.name" :value="option.id" :selected="option.id == value">{{ option.name }}</option>
    </select>
    <span v-if="error" class="block text-red-600">{{ error }}</span>
  </div>
</template>

<script>
export default {
  props: {
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
    options: {
      required: true
    },
    value: {
      required: true
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