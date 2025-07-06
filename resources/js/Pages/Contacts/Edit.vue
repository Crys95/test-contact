<template>
  <div class="p-6 bg-white dark:bg-gray-800 rounded shadow max-w-lg mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-100">Editar Contato</h1>
    <form @submit.prevent="submit">
      <div class="mb-4">
        <label class="block text-gray-700 dark:text-gray-300 mb-1">Nome</label>
        <input v-model="form.name" type="text"
          class="w-full p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600"
          required />
        <p v-if="errors.name" class="text-red-600 text-sm mt-1">{{ errors.name[0] }}</p>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 dark:text-gray-300 mb-1">Email</label>
        <input v-model="form.email" type="email"
          class="w-full p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600"
          required disabled />
        <p v-if="errors.email" class="text-red-600 text-sm mt-1">{{ errors.email[0] }}</p>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 dark:text-gray-300 mb-1">Telefone</label>
        <input placeholder="(99) 99999-9999" :value="form.phone" @input="onPhoneInput" @keydown="onPhoneKeydown"
          type="text" inputmode="numeric"
          class="w-full p-2 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600" />
        <p v-if="errors.phone" class="text-red-600 text-sm mt-1">{{ errors.phone[0] }}</p>
      </div>

      <div class="flex space-x-4">
        <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded">
          Atualizar
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
import { ref } from 'vue'
import { usePage, Link } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import { useToast } from 'vue-toastification'

const toast = useToast()

const { props } = usePage()
const contact = props.value.contact

const errors = ref({})

const form = ref({
  name: contact.name || '',
  email: contact.email || '',
  phone: contact.phone || '',
})

function onPhoneInput(event) {
  let input = event.target.value
  input = input.replace(/\D/g, '')
  if (input.length > 11) input = input.substring(0, 11)

  if (input.length > 6) {
    form.value.phone = `(${input.substring(0, 2)}) ${input.substring(2, 7)}-${input.substring(7)}`
  } else if (input.length > 2) {
    form.value.phone = `(${input.substring(0, 2)}) ${input.substring(2)}`
  } else if (input.length > 0) {
    form.value.phone = `(${input}`
  } else {
    form.value.phone = ''
  }
}

function submit() {
  Inertia.post(`/contacts/${contact.id}`, {
    ...form.value,
    _method: 'PUT'
  }, {
    onSuccess: () => {
      errors.value = {}
      toast.success('Contato atualizado com sucesso!')
    },
    onError: (errs) => {
      errors.value = errs
      toast.error('Erro ao atualizar contato. Verifique os dados e tente novamente.')
    },
  })
}

function onPhoneKeydown(e) {
  const allowedKeys = [
    'Backspace', 'ArrowLeft', 'ArrowRight', 'Delete', 'Tab'
  ]

  if (
    (e.key >= '0' && e.key <= '9') ||
    allowedKeys.includes(e.key)
  ) {
    const numbers = form.value.phone.replace(/\D/g, '')
    if (numbers.length >= 11 && e.key >= '0' && e.key <= '9') {
      e.preventDefault()
    }
  } else {
    e.preventDefault()
  }
}

</script>
