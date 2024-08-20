import api from "./index.js";

async function getToken() {
    return await api.get("/sanctum/csrf-cookie");
}

async function login(payload) {
    return await api.post("/api/login", payload);
}

async  function logout() {
    return await api.post('/api/logout')
  }

  async  function isLoged() {
    return await api.get('/api/is-loged')
  }


export default { getToken, login, logout, isLoged };
