<template>
    <footer class="footer bg-dark text-white text-center py-4">
      <div class="container">
        <p class="mb-0">
          &copy; {{ currentYear }} Agenda telefônica. Criado por <strong><a :href="'https://github.com/LimaHenriqueDev'" target="_blank" class="text-white">Henrique de Lima Sousa</a>.</strong>
        </p>
      </div>
    </footer>
  </template>
  
  <script setup>
  const currentYear = new Date().getFullYear();
  </script>
  
  <style scoped>
  .footer {
    background-color: #343a40; /* Cor de fundo escura */
  }
  
  .footer a {
    color: #ffffff; /* Cor do texto do link */
    text-decoration: none;
  }
  
  .footer a:hover {
    text-decoration: underline; /* Adiciona sublinhado no hover */
  }
  </style>
  