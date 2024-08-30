<template>
    <div
        class="container vh-100 d-flex justify-content-center align-items-center"
    >
        <div
            class="register-bg container d-flex justify-content-center align-items-center m-auto p-3 col-lg-6 col-md-8"
        >
            <div class="col-lg-6 col-md-8">
                <div class="col-lg-12 d-flex mt-4">
                    <img
                        src="/public/Default-Image-2.jpg"
                        class="img-fluid mx-auto rounded shadow register-img"
                    />
                </div>
                <h1 class="text-center mt-3">Cadastre-se</h1>
                <form>
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
                            v$.email.$error
                                ? v$.email.$errors[0].$message
                                : errors['email']
                                ? errors['email'][0]
                                : ''
                        "
                    />
                    <AppInput
                        v-model="payload.password"
                        label="Senha"
                        placeholder="********"
                        id="password"
                        type="password"
                        :error="
                            v$.password.$error
                                ? v$.password.$errors[0].$message
                                : ''
                        "
                    />
                    <AppInput
                        v-model="payload.password_confirmation"
                        label="Confirmar senha"
                        placeholder="********"
                        id="password_confirmation"
                        type="password"
                        :error="
                            v$.password_confirmation.$error
                                ? v$.password_confirmation.$errors[0].$message
                                : ''
                        "
                    />

                    <div class="text-center">
                        <button
                            class="register-btn btn btn-primary btn rounded mt-3 mb-4 w-100 shadow"
                            @click.prevent="() => submitForm()"
                        >
                            Cadastrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, computed } from "vue";
import userApi from "../../Plugins/Sdk/user";
import { toast } from "vue3-toastify";
import router from "../../Plugins/Router";
import AppInput from "../../Components/Form/AppInput.vue";
import validator from "./../../Utils/validator";
import { useVuelidate } from "@vuelidate/core";
import { AxiosError } from "axios";

const errors = ref([]);

const rules = computed(() => ({
    name: {
        required: validator.required,
    },
    email: {
        required: validator.required,
        maxLength: validator.maxLength(100),
        email: validator.email,
    },
    password: {
        required: validator.required,
        minLength: validator.minLength(6),
    },
    password_confirmation: {
        required: validator.required,
        sameAs: validator.sameAs(payload.value.password),
    },
}));
const payload = ref({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const v$ = useVuelidate(rules, payload);

async function submitForm() {
    try {
        await v$.value.$validate();
        if (v$.value.$invalid) {
            return;
        }
        await userApi.store(payload.value);
        toast.success("Cadastro realizado com sucesso!");
        setTimeout(() => router.push({ name: "Login" }), 1500);
    } catch (error) {
        if (error instanceof AxiosError) {
            if (error.response.status === 422) {
                errors.value = error.response.data.errors;
                return;
            }

            toast.error(
                "Erro ao enviar o formulário. Por favor, tente novamente."
            );
        }
    }
}
</script>

<style scoped>
.is-invalid {
    border-color: #e57373 !important;
    background-color: #f8d7da !important;
}

.is-invalid .form-label {
    color: #e57373 !important;
}

.register-bg {
    background-color: rgba(255, 255, 255, 0.869);
    box-shadow: 8px 4px 9px rgba(228, 217, 217, 0.1);
}

.register-img {
    height: 200px;
    border: 2px solid #ddd;
}

.register-btn {
    font-size: 1.2rem;
    transition: background-color 0.3s;
}

label,
h1 {
    color: #333333;
}

h1.text-center::before,
h1.text-center::after {
    content: "";
    flex: 1;
    border-bottom: 1px solid #333333;
    margin: auto 16px;
}

h1.text-center {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #333333;
}
</style>
