<script setup>
import { computed } from 'vue'

const props = defineProps({
  variant: {
    type: String,
    default: 'primary'
  },
  size: {
    type: String,
    default: 'md'
  },
  disabled: Boolean,
})

const buttonClass = computed(() => {
  const baseClass = 'inline-flex items-center justify-center font-medium rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2'
  
  let sizeClass = 'px-4 py-2 text-base'
  if (props.size === 'sm') sizeClass = 'px-3 py-1.5 text-sm'
  if (props.size === 'lg') sizeClass = 'px-6 py-3 text-lg'
  
  let variantClass = 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500'
  if (props.variant === 'secondary') variantClass = 'bg-gray-200 text-gray-900 hover:bg-gray-300 focus:ring-gray-400'
  if (props.variant === 'outline') variantClass = 'border border-gray-300 text-gray-900 hover:bg-gray-50 focus:ring-gray-300'
  if (props.variant === 'ghost') variantClass = 'text-gray-900 hover:bg-gray-100'
  if (props.variant === 'destructive') variantClass = 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500'
  
  const disabledClass = props.disabled ? 'opacity-50 cursor-not-allowed' : ''
  
  return `${baseClass} ${sizeClass} ${variantClass} ${disabledClass}`
})
</script>

<template>
  <button
    :disabled="disabled"
    :class="buttonClass"
    v-bind="$attrs"
  >
    <slot />
  </button>
</template>
