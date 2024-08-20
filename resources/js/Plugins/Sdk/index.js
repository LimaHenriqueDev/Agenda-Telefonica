import axios from "axios";

const api = axios.create({
    baseURL: import.meta.env.VITE_URL,
    withCredentials: true,
    headers: {
        "Content-type": "multipart/form-data'",
        Accept: "application/json",
    },
});

export default api;