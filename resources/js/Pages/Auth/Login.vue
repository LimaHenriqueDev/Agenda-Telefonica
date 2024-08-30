<template>
    <div class="container vh-100 d-flex">
        <div
            class="login_bg container d-flex justify-content-center align-items-center m-auto p-3 col-lg-6"
        >
            <div class="col-lg-6">
                <div class="col-lg-12 d-flex mt-4">
                    <img
                        src="/public/Default-Image-2.jpg"
                        class="register-img img-fluid mx-auto rounded"
                        style="height: 200px"
                    />
                </div>
                <h1 class="text-center mt-3">Entrar</h1>
                <div class="text-center mb-4">
                    <p>Acesse sua Agenda telefônica</p>
                </div>
                <form>
                    <AppInput
                        v-model="payload.email"
                        label="Email *"
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
                        @blur="v$.email.$touch"
                    />
                    <AppInput
                        v-model="payload.password"
                        label="Senha *"
                        placeholder="********"
                        id="password"
                        type="password"
                        :error="
                            v$.password.$error
                                ? v$.password.$errors[0].$message
                                : errors['password']
                                ? errors['password'][0]
                                : ''
                        "
                        @blur="v$.password.$touch"
                    />
                    <div class="text-center">
                        <button
                            :disabled="v$.$invalid || submitForm"
                            class="login-btn btn btn-primary btn rounded mt-3 mb-4 w-100"
                            @click.prevent="() => login()"
                        >
                            Entrar
                        </button>
                        <div>
                            <router-link
                                :to="{ name: 'Register' }"
                                class="register-btn btn btn-success mt-1 mb-4 w-100"
                            >
                                Criar uma conta!
                            </router-link>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref } from "vue";
import auth from "../../Plugins/Sdk/auth";
import router from "../../Plugins/Router";
import { toast } from "vue3-toastify";
import { useVuelidate } from "@vuelidate/core";
import { computed } from "vue";
import AppInput from "../../Components/Form/AppInput.vue";
import validator from "./../../Utils/validator";
import { AxiosError } from "axios";

const submitForm = ref(false);
const errors = ref([]);

const rules = computed(() => ({
    email: {
        required: validator.required,
        maxLength: validator.maxLength(100),
        email: validator.email,
    },
    password: {
        required: validator.required,
        minLength: validator.minLength(6),
    },
}));

const payload = ref({
    email: "",
    password: "",
});

const v$ = useVuelidate(rules, payload);

async function login() {
    try {
        submitForm.value = true;
        await v$.value.$validate();
        if (v$.value.$invalid) {
            return;
        }

        await axios.get("/sanctum/csrf-cookie");
        await auth.login(payload.value);
        router.push({ name: "ContactIndex" });

        setTimeout(() => toast.success("Login realizado com sucesso!"), 500);
    } catch (error) {
        submitForm.value = false;
        if (error instanceof AxiosError) {
            if (error.response.status === 401) {
                return toast.error("Email ou senha incorreto.");
            }

            if (error.response.status === 422) {
                errors.value = error.response.data.errors;
                return toast.error("Valide os campos do formulário.");
            }
        }

        toast.error(
            "Não foi possível realizar a operação tente novamente mais tarde"
        );
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

.login_bg {
    background-color: rgba(255, 255, 255, 0.869);
    box-shadow: 8px 4px 9px rgba(228, 217, 217, 0.1);
}

label,
h1 {
    color: #000000;
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
    color: #333333;
}

.register-img {
    height: 200px;
    border: 2px solid #ddd;
}

.login-btn {
    font-size: 1.2rem;
    transition: background-color 0.3s;
}

.register-btn {
    font-size: 1rem;
    transition: background-color 0.3s;
}
</style>
