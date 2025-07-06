<template>
  <div class="p-6 bg-white dark:bg-gray-800 rounded shadow max-w-lg mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-100">Novo Contato</h1>
    <form @submit.prevent="submit">
      <div class="mb-4">
        <label class="block text-gray-700 dark:text-gray-300 mb-1">Nome</label>
        <input v-model="form.name" type="text" class="w-full p-2 border rounded" required />
        <p v-if="errors.name" class="text-red-600 mt-1">{{ errors.name[0] }}</p>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 dark:text-gray-300 mb-1">Email</label>
        <input v-model="form.email" type="email" class="w-full p-2 border rounded" required />
        <p v-if="errors.email" class="text-red-600 mt-1">{{ errors.email[0] }}</p>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 dark:text-gray-300 mb-1">Telefone</label>
        <input type="text" class="w-full p-2 border rounded" :value="form.phone" @input="onPhoneInput"
          placeholder="(99) 99999-9999" required />
        <p v-if="errors.phone" class="text-red-600 mt-1">{{ errors.phone[0] }}</p>
      </div>

      <div class="flex space-x-4">
        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
          Salvar
        </button>
        <Link href="/contacts"
          class="px-4 py-2 border rounded text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700">
        Cancelar
        </Link>
      </div>
    </form>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { Link } from '@inertiajs/inertia-vue3'
import { usePage } from '@inertiajs/inertia-vue3'

const { props } = usePage()
const errors = ref(props.value.errors || {})

const form = reactive({
  name: '',
  email: '',
  phone: '',
})

function onPhoneInput(event) {
  let input = event.target.value
  input = input.replace(/\D/g, '')
  if (input.length > 11) input = input.substring(0, 11)

  if (input.length > 6) {
    form.phone = `(${input.substring(0, 2)}) ${input.substring(2, 7)}-${input.substring(7)}`
  } else if (input.length > 2) {
    form.phone = `(${input.substring(0, 2)}) ${input.substring(2)}`
  } else if (input.length > 0) {
    form.phone = `(${input}`
  } else {
    form.phone = ''
  }
}

function submit() {
  Inertia.post('/contacts', form, {
    onError: (errs) => {
      errors.value = errs
    },
  })
}
</script>
