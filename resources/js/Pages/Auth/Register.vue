<template>
    <div class="container vh-100 d-flex">
        <div
            class="register-bg container d-flex justify-content-center align-items-center m-auto p-3 col-lg-6"
        >
            <div class="col-lg-6">
                <div class="col-lg-12 d-flex mt-4">
                    <img
                        src="/storage/app/public/Default-Image-2.jpg"
                        class="img-fluid mx-auto rounded"
                        style="height: 200px"
                    />
                </div>
                <h1 class="text-center mt-3">Cadastre-se</h1>

                <div class="mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input
                        v-model="payload.name"
                        id="name"
                        class="form-control"
                        :class="{
                            'is-invalid': !payload.name && formSubmited,
                        }"
                        type="name"
                    />
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input
                        v-model="payload.email"
                        id="email"
                        class="form-control"
                        :class="{
                            'is-invalid': !payload.email && formSubmited,
                        }"
                        type="email"
                    />
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Senha </label>
                    <input
                        type="password"
                        class="form-control"
                        :class="{
                            'is-invalid': !payload.password && formSubmited,
                        }"
                        id="password"
                        v-model="payload.password"
                        required
                    />
                </div>
                <div class="text-center">
                    <button
                        class="btn btn-primary btn rounded mt-3 mb-4 w-100"
                        @click="() => submitForm()"
                    >
                        Cadastrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref } from "vue";
import userApi from "../../Plugins/Sdk/user";
import { toast } from "vue3-toastify";
import router from "../../Plugins/Router";


const payload = ref({
    name: "",
    email: "",
    password: "",
});

const formSubmited = ref(false);

async function submitForm() {
    formSubmited.value = true;

    if (
        !payload.value.name ||
        !payload.value.email ||
        !payload.value.password
    ) {
        toast.error("Você não preencheu alguns campos obrigatórios.");
        return;
    }

    try {
        await userApi.store(payload.value);
        toast.success("Cadastro realizado com sucesso!");
		setTimeout(() => router.push({ name: "Login" }), 1500);

    } catch (error) {
        toast.error("Erro ao enviar o formulário. Por favor, tente novamente.");
    }
}
</script>

<style scoped>
.title-shadow {
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    font-weight: 700;
}

.is-invalid {
    border-color: red !important;
    background-color: #f8d7da !important;
}

.is-invalid .form-label {
    color: red !important;
}

.register-bg {
    background-color: rgba(255, 255, 255, 0.869);
    box-shadow: 8px 4px 9px rgba(228, 217, 217, 0.1);
}

label,
h1 {
    color: #000000;
}
</style>
