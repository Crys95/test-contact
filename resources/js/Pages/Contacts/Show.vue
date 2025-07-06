<template>
  <div class="p-6 bg-white dark:bg-gray-800 rounded shadow max-w-lg mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-100">Detalhes do Contato</h1>
    <div class="mb-4">
      <strong>Nome:</strong> {{ contact.name }}
    </div>
    <div class="mb-4">
      <strong>Email:</strong> {{ contact.email }}
    </div>
    <div class="mb-4">
      <strong>Telefone:</strong> {{ contact.phone }}
    </div>
    <Link href="/contacts" class="px-4 py-2 border rounded text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700">
      Voltar
    </Link>
  </div>
</template>

<script setup>
import { usePage, Link } from '@inertiajs/inertia-vue3'

const { props } = usePage()
const contact = props.value.contact
</script>
