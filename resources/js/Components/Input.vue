<script setup>
import { computed } from 'vue'

const props = defineProps({
  modelValue: [String, Number],
  type: { type: String, default: 'text' },
  placeholder: String,
  disabled: Boolean,
  errors: Array,
  label: String,
  required: Boolean,
})

const emit = defineEmits(['update:modelValue'])
const hasError = computed(() => props.errors && props.errors.length > 0)
</script>

<template>
  <div class="w-full">
    <label v-if="label" class="block text-sm font-medium text-gray-700 mb-1">
      {{ label }}
      <span v-if="required" class="text-red-500">*</span>
    </label>
    <input
      :value="modelValue"
      :type="type"
      :placeholder="placeholder"
      :disabled="disabled"
      @input="emit('update:modelValue', $event.target.value)"
      class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent disabled:bg-gray-50 disabled:text-gray-500 disabled:cursor-not-allowed border-gray-300"
      :class="{ 'border-red-500': hasError }"
    />
    <p v-if="hasError" class="mt-1 text-sm text-red-500">{{ errors?.[0] }}</p>
  </div>
</template>
