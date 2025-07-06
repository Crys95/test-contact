<template>
  <div class="p-6 bg-white dark:bg-gray-800 rounded shadow max-w-5xl mx-auto relative">

    <div v-if="loading" class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50 rounded">
      <div class="text-white text-lg font-semibold">Carregando...</div>
    </div>

    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Contatos</h1>
      <Link href="/contacts/create" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
      Novo Contato
      </Link>
    </div>

    <div class="overflow-x-auto rounded border border-gray-300 dark:border-gray-600">
      <table class="min-w-full border-collapse text-left">
        <thead>
          <tr class="bg-gray-100 dark:bg-gray-700">
            <th class="p-3 border border-gray-300 dark:border-gray-600 whitespace-nowrap">Nome</th>
            <th class="p-3 border border-gray-300 dark:border-gray-600 whitespace-nowrap">Email</th>
            <th class="p-3 border border-gray-300 dark:border-gray-600 whitespace-nowrap">Telefone</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="contact in contacts.data" :key="contact.id"
            class="hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
            <td @click="goToContact(contact.id)"
              class="p-3 border border-gray-300 dark:border-gray-600 text-blue-600 dark:text-blue-400 hover:underline whitespace-nowrap">
              {{ contact.name }}
            </td>
            <td @click="goToContact(contact.id)"
              class="p-3 border border-gray-300 dark:border-gray-600 text-blue-600 dark:text-blue-400 hover:underline whitespace-nowrap">
              {{ contact.email }}
            </td>
            <td @click="goToContact(contact.id)"
              class="p-3 border border-gray-300 dark:border-gray-600 whitespace-nowrap">
              {{ formatPhone(contact.phone) }}
            </td>
          </tr>
          <tr v-if="contacts.data.length === 0">
            <td colspan="3" class="p-3 text-center text-gray-500 dark:text-gray-400 whitespace-nowrap">
              Nenhum contato cadastrado.
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="mt-4 flex justify-center space-x-3 text-gray-700 dark:text-gray-300">
      <button :disabled="!contacts.prev_page_url" @click="goToPage(contacts.current_page - 1)"
        class="px-3 py-1 bg-gray-200 dark:bg-gray-700 rounded disabled:opacity-50">
        Anterior
      </button>
      <span class="px-3 py-1 bg-gray-300 dark:bg-gray-600 rounded">{{ contacts.current_page }}</span>
      <button :disabled="!contacts.next_page_url" @click="goToPage(contacts.current_page + 1)"
        class="px-3 py-1 bg-gray-200 dark:bg-gray-700 rounded disabled:opacity-50">
        Próximo
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { usePage, Link } from '@inertiajs/inertia-vue3'

const { props } = usePage()
const contacts = ref(props.value.contacts)
const loading = ref(false)

function destroy(id) {
  if (confirm('Deseja realmente deletar este contato?')) {
    loading.value = true
    Inertia.post(`/contacts/${id}`, {
      _method: 'DELETE',
    }, {
      onSuccess: () => {
        loading.value = false
        Inertia.visit('/contacts')
      },
      onError: () => {
        loading.value = false
      }
    })
  }
}

function goToPage(page) {
  loading.value = true
  Inertia.get(`/contacts?page=${page}`, {
    onFinish: () => {
      loading.value = false
    }
  })
}

function goToContact(id) {
  Inertia.get(`/contacts/${id}`)
}

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
</script>
