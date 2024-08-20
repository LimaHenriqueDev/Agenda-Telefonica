<template>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 144px);">
        <div class="card border-0 ">
            <div class="card-body">
                <form @submit.prevent="submitForm">
                    <h1 class="text-center">{{ title }}</h1>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome:</label>
                        <input v-model="payload.name" id="name" class="form-control "
                            :class="{ 'is-invalid': !payload.name && formSubmitted }" type="text" />
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input v-model="payload.email" id="email" class="form-control"
                            :class="{ 'is-invalid': !payload.email && formSubmitted }" type="email" />
                    </div>

                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone:</label>
                        <input v-model="payload.phone" id="telefone" class="form-control"
                            :class="{ 'is-invalid': !payload.phone && formSubmitted }" v-mask="'(###) ###-####'"
                            type="tel" @input="validatePhone" />

                    </div>
                    <label v-if="contact.image" for="" class="form-label">Imagem:</label>
                    <div class="p-3 text-center">
                        <img v-if="contact.image" :src="`/storage/${contact.image?.path}`" alt="Imagem do Contato"
                            class="img-fluid fixed-size-image" />

                        <div v-else>
                            <img src="/storage/app/public/pexels-pixabay-47319.jpg" class="img-fluid fixed-size-image"
                                alt="">
                        </div>
                    </div>


                    <div class="mb-3">
                        <label for="image" class="form-label">Imagem</label>
                        <input class="form-control" accept="image/png, image/jpg, image/jpeg" type="file" id="image"
                            @change="handleFileUpload">
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" :disabled="buttonDisable">{{ title }}</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</template>
<script setup>
import { ref, onMounted, computed } from 'vue';
import contactApi from '../../Plugins/Sdk/contact';
import { useRoute } from 'vue-router';
import router from '../../Plugins/Router';
import { toast } from 'vue3-toastify'

const title = computed(() => payload.value.id ? 'Editar Contato' : 'Cadastrar Contato');
const payload = ref({
    name: '',
    email: '',
    phone: '',

    image: null
});

const route = useRoute()
const contact = ref([])
const formSubmitted = ref(false);

async function submitForm() {
    formSubmitted.value = true;

    if (!payload.value.name || !payload.value.email || !payload.value.phone) {
        toast.error('Você não preencheu alguns campos obrigatórios.');
        return;
    }

    try {

        if (payload.value.id) {
            await contactApi.update(payload.value, payload.value.id);
            toast.success('Contato atualizado com sucesso!');
            setTimeout(() => router.push({ name: 'ContactIndex' }), 1500);
        } else {
            await contactApi.store(payload.value);
            toast.success('Contato criado com sucesso!');
            setTimeout(() => router.push({ name: 'ContactIndex' }), 1500);
        }

    } catch (error) {
        toast.error('Erro ao enviar o formulário. Por favor, tente novamente.');
    }
}


async function loadContact(id) {
    const { data } = await contactApi.show(id)
    contact.value = data
    payload.value = {
        id: contact.value.id,
        name: contact.value.name,
        email: contact.value.email,
        phone: contact.value.phone,
        image: contact.value.image?.path,
    }

}

onMounted(async () => {

    if (route.params.id) {
        loadContact(route.params.id)

    }
})

const buttonDisable = ref(false);


function handleFileUpload(event) {
    payload.value.image = event.target.files[0];
}

function validatePhone(event) {
    // Remove tudo que não for número
    payload.value.phone = event.target.value.replace(/\D/g, '');
}

</script>
<style scoped>
h1 {
    font-weight: 700;
}

.is-invalid {
    border-color: red !important;
    background-color: #f8d7da !important;
}

.is-invalid .form-label {
    color: red !important;
}

.contact-image {
    max-width: 100%;
    height: auto;
    max-height: 300px;
}


.fixed-size-image {
    width: 400px;
    height: 200px;
    /* Defina a altura desejada */
    object-fit: cover;
    border-radius: 5%;
}
</style>