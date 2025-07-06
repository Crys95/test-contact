<script setup>
import { computed } from 'vue'

defineProps({
  modelValue: [String, Number],
  type: {
    type: String,
    default: 'text'
  },
  error: String
})

const emit = defineEmits(['update:modelValue'])

const inputValue = computed({
  get() {
    return modelValue
  },
  set(value) {
    emit('update:modelValue', value)
  }
})
</script>

<template>
  <input
    :type="type"
    v-model="inputValue"
    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
    :class="{ 'border-red-500': error }"
  />
  <p v-if="error" class="text-red-500 text-sm mt-1">{{ error }}</p>
</template>
