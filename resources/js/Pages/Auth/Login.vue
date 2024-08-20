<template>
    <div class="container vh-100 d-flex ">
        <div class="login_bg  container d-flex justify-content-center  align-items-center  m-auto p-3 col-lg-6">
            <div class="col-lg-6">
                <div class="col-lg-12 d-flex mt-4">
                    <img src="/storage/app/public/pexels-ono-kosuki-5999834.jpg"
                        class="img-fluid mx-auto rounded" style=" height: 200px;" />

                </div>
                <h1 class="text-center mt-3 "> Entrar </h1>
                <div class="text-center mb-4"><p> Acesse sua Agenda telefônica</p></div>
            

                <div class="  mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input v-model="payload.email" id="email" class="form-control"
                        :class="{ 'is-invalid': !payload.email && formSubmitted }" type="email" />
                </div>
                <div class=" mb-3">
                    <label for="password" class="form-label">Senha </label>
                    <input type="password" class="form-control"
                        :class="{ 'is-invalid': !payload.password && formSubmitted }" id="password"
                        v-model="payload.password" required>
                </div>
                <div class=" text-center  "><button class="btn btn-primary btn rounded mt-3 mb-4 w-100"
                        @click="() => login()">Entrar</button>
                </div>

            </div>


        </div>
    </div>



</template>
<script setup>
import { ref } from 'vue';
import auth from '../../Plugins/Sdk/auth';
import router from '../../Plugins/Router';
import { toast } from 'vue3-toastify';

const payload = ref({
    email: '',
    password: ''
})
const formSubmitted = ref(false)

async function login() {
    formSubmitted.value = true;
    try {

        if (!payload.value.email || !payload.value.password) {
            toast.error('O campo e-mail e senha são obrigatórios!');
            return;
        }

        await axios.get('/sanctum/csrf-cookie')
        await auth.login(payload.value)
        setTimeout(() => {
            router.push({ name: 'ContactIndex' })
        }, 1000)
    } catch (error) {
        toast.error('Email ou senha incorreto.');
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
    /* X, Y, Blur, Spread, Color */

}

label,
h1 {
    color: #000000;
}
</style>