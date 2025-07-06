<template>
  <div class="p-6 bg-white dark:bg-gray-800 rounded shadow">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Contatos</h1>
      <Link href="/contacts/create" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
      Novo Contato
      </Link>
    </div>

    <table class="w-full border-collapse text-left">
      <thead>
        <tr class="bg-gray-100 dark:bg-gray-700">
          <th class="p-3 border border-gray-300 dark:border-gray-600">Nome</th>
          <th class="p-3 border border-gray-300 dark:border-gray-600">Email</th>
          <th class="p-3 border border-gray-300 dark:border-gray-600">Telefone</th>
          <th class="p-3 border border-gray-300 dark:border-gray-600 w-48">Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="contact in contacts.data" :key="contact.id" class="hover:bg-gray-50 dark:hover:bg-gray-700">
          <td class="p-3 border border-gray-300 dark:border-gray-600">{{ contact.name }}</td>
          <td class="p-3 border border-gray-300 dark:border-gray-600">{{ contact.email }}</td>
          <td class="p-3 border border-gray-300 dark:border-gray-600">{{ contact.phone }}</td>
          <td class="p-3 border border-gray-300 dark:border-gray-600 space-x-3">
            <Link :href="`/contacts/${contact.id}`" class="text-blue-600 dark:text-blue-400 hover:underline">
            Ver
            </Link>
            <Link :href="`/contacts/${contact.id}/edit`" class="text-green-600 dark:text-green-400 hover:underline">
            Editar
            </Link>
            <button @click="destroy(contact.id)" class="text-red-600 dark:text-red-400 hover:underline">
              Deletar
            </button>
          </td>
        </tr>
        <tr v-if="contacts.data.length === 0">
          <td colspan="4" class="p-3 text-center text-gray-500 dark:text-gray-400">
            Nenhum contato cadastrado.
          </td>
        </tr>
      </tbody>
    </table>

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

function destroy(id) {
  if (confirm('Deseja realmente deletar este contato?')) {
    Inertia.post(`/contacts/${id}`, {
      _method: 'DELETE',
    }, {
      onSuccess: () => {
        Inertia.visit('/contacts');
      },
    })
  }
}

function goToPage(page) {
  Inertia.get(`/contacts?page=${page}`)
}
</script>
