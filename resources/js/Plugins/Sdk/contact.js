import api from "./index.js";

async function list(query = '') {
    return (await api.get(`/api/contacts${query}`)).data;
}

async function store(payload) {
    return await api.post(`/api/contacts`, payload);
}

async function update(payload,id) {
    return await api.post(`/api/contacts/${id}`, {...payload, '_method':"PUT"});
}

async function show(id) {
    return await api.get(`/api/contacts/${id}`);
}

async function destroy(id) {
    return await api.delete(`/api/contacts/${id}`);
}

export default {list, store,update,show,destroy };