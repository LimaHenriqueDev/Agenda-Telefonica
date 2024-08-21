import api from "./index.js";

async function store(payload) {
    return await api.post(`/api/register`, payload);
}

export default { store };