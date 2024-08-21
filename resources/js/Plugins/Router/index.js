import { createWebHistory, createRouter } from "vue-router";

import Home from "../../home.vue";
import Login from "../../Pages/Auth/Login.vue";
import Register from "../../Pages/Auth/Register.vue";
import ContactForm from "../../Pages/Contacts/ContactForm.vue";
import ContactShow from "../../Pages/Contacts/ContactShow.vue";
import ContactList from "../../Pages/Contacts/ContactList.vue";
import auth from "../Sdk/auth";
import MainLayout from "../../Pages/Layout/MainLayout.vue";
const routes = [
    {
        path: "/",
        meta: { requiresAuth: true },
        component: MainLayout,
        children: [
            { path: "", component: ContactList, name: "ContactIndex" },

            {
                path: "contacts/create",
                component: ContactForm,
                name: "ContactForm",
            },
            {
                path: "contacts/edit/:id",
                component: ContactForm,
                name: "ContactEdit",
            },
            {
                path: "contacts/show/:id",
                component: ContactShow,
                name: "ContactDetails",
                props: true,
            },
        ],
    },
    { path: "/login",
         component: Login,
         name:'Login', },
    { path: "/register", component: Register, name: "Register" },

];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresAuth)) {
        try {
            await auth.isLoged();

            next();
        } catch (error) {
            next("/login");
        }
    } else {
        next();
    }
});

export default router;
