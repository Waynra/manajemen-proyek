<script setup>
const props = defineProps({
  variant: {
    type: String,
    default: 'default'
  }
})

const variantClass = {
  'default': 'bg-gray-100 text-gray-800',
  'primary': 'bg-blue-100 text-blue-800',
  'success': 'bg-green-100 text-green-800',
  'warning': 'bg-yellow-100 text-yellow-800',
  'danger': 'bg-red-100 text-red-800'
}
</script>

<template>
  <span
    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
    :class="variantClass[variant] || variantClass.default"
  >
    <slot />
  </span>
</template>
