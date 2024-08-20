<template>
  <nav class="navbar_size navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Agenda telefônica</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item fs-5">
          <div class="d-flex align-items-center">
        
          <router-link to="/" class="nav-link">
            <i class="fas fa-home bg-dark"></i>
            Início</router-link>

          </div>
             

        </li>
       
      </ul>
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown fs-5">
            <li>
              <button @click="logout" class="btn btn-danger w-100">
                <i class="fa-solid fa-right-from-bracket"></i>
            Sair</button>
            </li>
        </li>
      </ul>
    </div>
  </nav>
</template>
<script setup>
import { useRouter } from 'vue-router';
import auth from '../../Plugins/Sdk/auth';
const router = useRouter();

async function logout(){
  try {
    await auth.logout();
  } catch (error) {
    
  } 
 router.push('/login')
} 

function onRemoved(cookie) {
  console.log(`Removed: ${cookie}`);
}

function onError(error) {
  console.log(`Error removing cookie: ${error}`);
}

function removeCookie(tabs) {
  let removing = browser.cookies.remove({
    url: tabs[0].url,
    name: "XSRF-TOKEN",
  });
  removing.then(onRemoved, onError);
}

</script>
<style scoped>
.navbar {
  padding: 0 2rem;
}

.navbar-nav .nav-item {
  margin: 0 0.5rem; /* Adiciona margem horizontal entre os itens do menu */
}

.dropdown-menu {
  min-width: 100px; /* Ajusta a largura mínima do menu dropdown */
}

.navbar_size{
  padding: 13px !important;
}
</style>