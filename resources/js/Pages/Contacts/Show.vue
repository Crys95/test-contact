<template>
  <div class="p-6 bg-white dark:bg-gray-800 rounded shadow max-w-lg mx-auto relative">
    <div v-if="loading" class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50 rounded">
      <div class="text-white text-lg font-semibold">Carregando...</div>
    </div>

    <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-100">Detalhes do Contato</h1>
    <div class="mb-4">
      <strong>Nome:</strong> {{ contact.name }}
    </div>
    <div class="mb-4">
      <strong>Email:</strong> {{ contact.email }}
    </div>
    <div class="mb-4">
      <strong>Telefone:</strong> {{ formatPhone(contact.phone) }}
    </div>

    <div class="flex space-x-4">
      <Link :href="`/contacts/${contact.id}/edit`" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded"
        :class="{ 'opacity-50 cursor-not-allowed': loading }" :aria-disabled="loading">
      Editar
      </Link>

      <button @click="destroy" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded" :disabled="loading">
        {{ loading ? 'Excluindo...' : 'Excluir' }}
      </button>

      <Link href="/contacts"
        class="px-4 py-2 border rounded text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700"
        :class="{ 'opacity-50 cursor-not-allowed': loading }" :aria-disabled="loading">
      Voltar
      </Link>
    </div>
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

const loading = ref(false)

function formatPhone(phone) {
  if (!phone) return ''
  const cleaned = phone.replace(/\D/g, '')
  if (cleaned.length === 11) {
    return cleaned.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3')
  } else if (cleaned.length === 10) {
    return cleaned.replace(/^(\d{2})(\d{4})(\d{4})$/, '($1) $2-$3')
  }
  return phone
}

function destroy() {
  loading.value = true
  Inertia.post(`/contacts/${contact.id}`, {
    _method: 'DELETE',
  }, {
    onSuccess: () => {
      loading.value = false
      toast.success('Contato excluído com sucesso!')
      Inertia.visit('/contacts')
    },
    onError: (errs) => {
      loading.value = false
      toast.error('Erro ao excluir contato. Tente novamente.')
      console.error(errs)
    }
  })
}
</script>
