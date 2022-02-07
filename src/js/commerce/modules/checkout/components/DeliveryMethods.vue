<template>
  <fieldset>
    <legend class="sr-only">
      Delivery option
    </legend>
    <div class="relative bg-white rounded-md -space-y-px">

      <!-- Checked: "bg-indigo-50 border-indigo-200 z-10", Not Checked: "border-gray-200" -->
      <label v-for="method in methods" :key="method.id" class="rounded-tl-md rounded-tr-md relative border p-4 flex flex-col cursor-pointer md:pl-4 md:pr-6 md:grid md:grid-cols-3 focus:outline-none">
        <div class="flex items-center text-sm">
          <input type="radio" :name="method.name" :value="method.handle" @input="updateValue($event.target.value)" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
          <!-- Checked: "text-indigo-900", Not Checked: "text-gray-900" -->
          <span class="font-medium">{{ method.name }}</span>
        </div>
        <!-- Checked: "text-indigo-700", Not Checked: "text-gray-500" -->
        <span>{{ method.price > 0 ? method.priceAsCurrency : 'FREE' }}</span>
      </label>
      
    </div>
  </fieldset>
</template>

<script>
export default {
  name: 'delivery-methods',
  props: {
    methods: {
      required: true
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