<template>
    <div
        class="main-container container d-flex justify-content-center align-items-center"
    >
        <div class="card border-0">
            <div class="card-body">
                <form @submit.prevent="submitForm">
                    <h1 class="text-center">{{ title }}</h1>

                    <AppInput
                        v-model="payload.name"
                        label="Nome"
                        placeholder="Nome de usuário"
                        id="name"
                        type="name"
                        :error="
                            v$.name.$error ? v$.name.$errors[0].$message : ''
                        "
                    />

                    <AppInput
                        v-model="payload.email"
                        label="Email"
                        placeholder="seuemail@gmail.com"
                        id="email"
                        type="email"
                        :error="
                            v$.email.$error ? v$.email.$errors[0].$message : ''
                        "
                    />

                    <AppInput
                        v-model="payload.phone"
                        label="Telefone"
                        placeholder="(00) 00000-0000"
                        id="phone"
                        type="tel"
                        v-mask="'(##) #####-####'"
                        :error="
                            v$.phone.$error ? v$.phone.$errors[0].$message : ''
                        "
                    />

                    <label
                        v-if="contact.image"
                        for=""
                        class="form-label"
                    ></label>
                    <div class="p-3 text-center">
                        <img
                            v-if="contact.image"
                            :src="`/storage/${contact.image?.path}`"
                            alt="Imagem do Contato"
                            class="img-fluid fixed-size-image"
                        />

                        <div v-else>
                            <img
                                src="/public/Default-Image.jpg"
                                class="img-fluid fixed-size-image"
                                alt=""
                            />
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label"
                            >Escolha uma imagem:</label
                        >
                        <input
                            class="form-control"
                            accept="image/png, image/jpg, image/jpeg"
                            type="file"
                            id="image"
                            @change="handleFileUpload"
                        />
                    </div>

                    <div class="text-center">
                        <button
                            type="submit"
                            class="btn btn-primary"
                            :disabled="buttonDisable"
                        >
                            {{ title }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, onMounted, computed } from "vue";
import contactApi from "../../Plugins/Sdk/contact";
import { useRoute } from "vue-router";
import router from "../../Plugins/Router";
import { toast } from "vue3-toastify";
import { useVuelidate } from "@vuelidate/core";
import AppInput from "../../Components/Form/AppInput.vue";
import validator from "./../../Utils/validator";
import { AxiosError } from "axios";

const rules = computed(() => ({
    name: {
        required: validator.required,
    },
    email: {
        required: validator.required,
        email: validator.email,
    },
    phone: {
        required: validator.required,
    },
}));

const payload = ref({
    name: "",
    email: "",
    phone: "",

    image: null,
});

const v$ = useVuelidate(rules, payload);

const title = computed(() =>
    payload.value.id ? "Editar Contato" : "Cadastrar Contato"
);

const route = useRoute();
const contact = ref([]);
const formSubmitted = ref(false);

async function submitForm() {
    formSubmitted.value = true;

    try {
        await v$.value.$validate();
        if (v$.value.$invalid) {
            return;
        }
        if (payload.value.id) {
            await contactApi.update(payload.value, payload.value.id);
            toast.success("Contato atualizado com sucesso!");
            setTimeout(() => router.push({ name: "ContactIndex" }), 1500);
        } else {
            await contactApi.store(payload.value);
            toast.success("Contato criado com sucesso!");
            setTimeout(() => router.push({ name: "ContactIndex" }), 1500);
        }
    } catch (error) {
        if (
            (error.response &&
                error.response.status === 409 &&
                error.response.data.message.includes("email")) ||
            error.response.data.message.includes("e-mail")
        ) {
            toast.error("Email de contato já está cadastrado.");
            return;
        }
        toast.error("Erro ao enviar o formulário. Por favor, tente novamente.");
    }
}

async function loadContact(id) {
    const { data } = await contactApi.show(id);
    contact.value = data;
    payload.value = {
        id: contact.value.id,
        name: contact.value.name,
        email: contact.value.email,
        phone: contact.value.phone,
        image: contact.value.image?.path,
    };
}

onMounted(async () => {
    if (route.params.id) {
        loadContact(route.params.id);
    }
});

const buttonDisable = ref(false);

function handleFileUpload(event) {
    payload.value.image = event.target.files[0];
}
</script>
<style scoped>
h1 {
    font-weight: 700;
}

.is-invalid {
    border-color: #e57373 !important;
    background-color: #f8d7da !important;
}

.is-invalid .form-label {
    color: #e57373 !important;
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

.main-container {
    min-height: calc(100vh - 144px);
}
</style>
