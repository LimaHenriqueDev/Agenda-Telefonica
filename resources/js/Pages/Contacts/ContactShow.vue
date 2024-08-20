<template>
  <div class="container col-lg-6 mt-5" style="min-height: calc(100vh - 144px);">
    <div class="card border-0 mt-3">
      <div class="card-body py-5 mt-5">
        <h3 class="text-center mb-2">Detalhes do Contato</h3>
        <div v-if="contact" class="col-lg-12 ">
          <div class=" text-center rounded">
            <div class="d-flex flex_mobile   align-items-center ">
              <div class="p-3">
                <img v-if="contact.image" :src="`/storage/${contact.image.path}`" alt="Imagem do Contato"
                  class="img-fluid fixed-size-image rounded" />
                <p v-else class="">Nenhuma imagem disponível</p>
              </div>
              <div class=" p-2 text_sm_start">
                <div class="mb-3 d-flex text-break-sm">
                  <strong class="me-2">Nome:</strong>
                  <p>{{ contact.name }}</p>
                </div>
                <div class="mb-3 d-flex text-break-sm">
                  <strong class="me-2">Email:</strong>
                  <p>{{ contact.email }}</p>
                </div>
                <div class="mb-3 d-flex text-break-sm">
                  <strong class="me-2">Telefone:</strong>
                  <p>{{ contact.phone }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-else class="text-center mt-4">
          <p>Carregando...</p>
        </div>
      </div>
    </div>

  </div>
</template>





<script setup>
import { useRoute } from 'vue-router';
import contactApi from '../../Plugins/Sdk/contact';
import { onMounted, ref } from 'vue';

const route = useRoute()
const contact = ref()

async function showContact(id) {
  const { data } = await contactApi.show(id)
  console.log(data)
  contact.value = data
}

onMounted(async () => {
  showContact(route.params.id)
})
</script>
<style scoped>
.contact-image {
  max-width: 100%;
  height: auto;
  max-height: 300px;

}

.text-break-sm {
  word-wrap: break-word;
  overflow-wrap: break-word;
}



@media (max-width: 767.98px) {
  .text-break-sm {
    word-wrap: break-word;
    overflow-wrap: break-word;
  }

  .flex_mobile {
    display: flex;
    flex-direction: column;
  }

  .text_sm_start {
    width: 100%;
  }



}

.fixed-size-image {
  width: 400px;
  height: 400px;
  border-radius: 50%;
}
</style>