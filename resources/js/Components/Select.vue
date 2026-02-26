<script setup>
import { computed } from 'vue'

const props = defineProps({
  modelValue: [String, Number, Array],
  options: { type: Array, required: true },
  label: String,
  disabled: Boolean,
  errors: Array,
  multiple: Boolean,
  placeholder: String,
})

const emit = defineEmits(['update:modelValue'])
const hasError = computed(() => props.errors && props.errors.length > 0)

const updateValue = (e) => {
  if (props.multiple) {
    emit('update:modelValue', Array.from(e.target.selectedOptions, opt => opt.value))
  } else {
    emit('update:modelValue', e.target.value)
  }
}
</script>

<template>
  <div class="w-full">
    <label v-if="label" class="block text-sm font-medium text-gray-700 mb-1">{{ label }}</label>
    <select
      :value="modelValue"
      :disabled="disabled"
      :multiple="multiple"
      @change="updateValue"
      class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent disabled:bg-gray-50 disabled:text-gray-500 disabled:cursor-not-allowed border-gray-300"
      :class="{ 'border-red-500': hasError }"
    >
      <option v-if="placeholder && !multiple" value="">{{ placeholder }}</option>
      <option v-for="opt in options" :key="opt.value" :value="opt.value">
        {{ opt.label }}
      </option>
    </select>
    <p v-if="hasError" class="mt-1 text-sm text-red-500">{{ errors?.[0] }}</p>
  </div>
</template>
