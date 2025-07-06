<template>
    <div
        class="min-h-screen flex flex-col bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-colors duration-500">
        <!-- Header -->
        <header
            class="flex items-center justify-between px-6 py-4 bg-blue-100 dark:bg-gray-800 shadow-md sticky top-0 z-50">
            <h1 class="text-2xl font-bold text-blue-700 dark:text-blue-300 select-none">
                Consulta CEP
            </h1>
            <button @click="toggleTheme" :aria-label="`Trocar para modo ${theme === 'dark' ? 'claro' : 'escuro'}`"
                class="p-2 rounded-full bg-blue-200 dark:bg-blue-700 hover:bg-blue-300 dark:hover:bg-blue-600 transition">
                <svg v-if="theme === 'dark'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-100"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 3v1m0 16v1m8-9h1M3 12H2m15.364-6.364l.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-800" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path d="M10 2a8 8 0 100 16 8 8 0 000-16z" />
                </svg>
            </button>
        </header>

        <!-- Conteúdo da página -->
        <main class="flex-grow px-6 py-8 max-w-2xl mx-auto w-full">
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-blue-100 dark:bg-gray-800 text-blue-900 dark:text-blue-400 text-center p-4 text-sm">
            Consulta CEP © 2025
        </footer>
    </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'

const theme = ref(localStorage.getItem('tema') || 'light')

watch(theme, (newVal) => {
    document.documentElement.classList.toggle('dark', newVal === 'dark')
    localStorage.setItem('tema', newVal)
})

onMounted(() => {
    document.documentElement.classList.toggle('dark', theme.value === 'dark')
})

function toggleTheme() {
    theme.value = theme.value === 'dark' ? 'light' : 'dark'
}
</script>
