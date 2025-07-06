# 📇 Contact Management System

Sistema completo de gerenciamento de contatos (CRUD) utilizando **Laravel**, **Vue 3**, **Inertia.js** e **TailwindCSS**.
link da porta http://localhost:8000/contacts

---

## 🎯 Objetivo

- ✅ **Back-end**: Fazer todos os testes passarem, aplicando os princípios do Laravel, SOLID, Clean Architecture e boas práticas.
- ✅ **Front-end**: Implementar a interface utilizando **Vue 3**, **Inertia.js** e **TailwindCSS**.
- 🎨 **Tema**: A interface possui **modo claro e escuro**, que se adapta automaticamente com base nas preferências do sistema do usuário.
- ➕ **Plus**: Enviar um email ao contato quando ele for excluído do sistema.
- 📌 O envio está utilizando [Mailtrap](https://mailtrap.io), uma ferramenta de teste para e-mails em ambiente de desenvolvimento. A conta deve estar ativa e os dados do .env válidos.

## ⚙️ Tecnologias utilizadas

- Laravel 10+
- Vue 3
- Inertia.js
- TailwindCSS
- Vite
- PHPUnit

---

## 🚀 Instalação

```bash

npm run setup
##  composer install → Back-end (Laravel) npm install → Front-end (Vue + Inertia)

php artisan migrate
## 🚀 criar um arquivo .env e pergar tudo que esta no .env.exemple

npm run dev
## 🚀 	Roda Laravel + Vite simultaneamente

php artisan test --testsuite=Feature
## 🚀 Todos os testes devem passar para validar a aplicação.
