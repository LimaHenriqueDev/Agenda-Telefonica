<template>
    <div class="container m-auto" style="min-height: calc(100vh - 144px)">
        <div class="card mt-5 bg-white border-0">
            <div class="card-body m-3">
                <div
                    class="d-flex col-lg-12 flex-column align-items-center justify-content-center text-center mt-4"
                >
                    <h1 class="mb-4">Bem-vindo à Agenda telefônica!</h1>
                </div>
                <div
                    class="mobile_column d-flex justify-content-between align-items-center"
                >
                    <div class="title text-center">
                        <h1>Contatos</h1>
                    </div>
                    <div>
                        <router-link
                            :to="{ name: 'ContactForm' }"
                            class="btn btn-success d-flex align-items-center w-100 w-sm-auto btn-icon-text"
                        >
                            <i class="fa-solid fa-circle-plus fs-6"></i>
                            <h3 class="font_h3 p-1">Cadastre um Contato!</h3>
                        </router-link>
                    </div>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Imagem</th>
                                <th>Nome</th>
                                <th>Telefone</th>
                                <th>Email</th>
                                <th class="col-lg-2">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="contact in contacts.data"
                                :key="contact.id"
                            >
                                <td class="text-center align-middle">
                                    <img
                                        v-if="contact.image"
                                        :src="`/storage/${contact.image.path}`"
                                        alt="Imagem do Contato"
                                        class="align-middle my-auto rounded-circle"
                                        style="
                                            max-width: 38px;
                                            min-height: 38px;
                                        "
                                    />
                                    <div v-else>
                                        <img
                                            src="/public/Default-Image.jpg"
                                            class="rounded-circle"
                                            style="
                                                max-width: 38px;
                                                min-height: 38px;
                                            "
                                            alt="Imagem padrão"
                                        />
                                    </div>
                                </td>
                                <td class="align-middle">{{ contact.name }}</td>
                                <td class="align-middle">
                                    {{ contact.phone }}
                                </td>
                                <td class="align-middle">
                                    {{ contact.email }}
                                </td>
                                <td>
                                    <router-link
                                        :to="{
                                            name: 'ContactEdit',
                                            params: { id: contact.id },
                                        }"
                                        class="btn me-2"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </router-link>
                                    <router-link
                                        :to="{
                                            name: 'ContactDetails',
                                            params: { id: contact.id },
                                        }"
                                        class="btn me-2"
                                    >
                                        <i class="fas fa-eye"></i>
                                    </router-link>
                                    <button
                                        @click="confirmDelete(contact.id)"
                                        class="btn"
                                    >
                                        <i
                                            class="fas fa-trash-alt text-danger"
                                        ></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <nav aria-label="Page navigation example">
                    {{ contacts.las_page }}
                    <ul class="pagination d-flex justify-content-end">
                        <li class="page-item">
                            <a
                                class="page-link"
                                :class="{
                                    disabled: contacts.current_page === 1,
                                }"
                                @click="
                                    () =>
                                        listContacts(contacts.current_page - 1)
                                "
                                >Voltar</a
                            >
                        </li>
                        <li
                            v-for="page in contacts.last_page"
                            @click="() => listContacts(page)"
                            :class="{ active: page === contacts.current_page }"
                            class="page-item"
                        >
                            <a class="page-link" href="#">{{ page }}</a>
                        </li>
                        <li class="page-item">
                            <a
                                class="page-link"
                                @click="
                                    () =>
                                        listContacts(contacts.current_page + 1)
                                "
                                :class="{
                                    disabled:
                                        contacts.last_page ===
                                        contacts.current_page,
                                }"
                                >Próximo</a
                            >
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <button
        type="button"
        ref="modalButtonDelete"
        style="display: none !important"
        data-bs-toggle="modal"
        data-bs-target="#confirmDeleteModal"
        data-bs-dismiss="modal"
    ></button>

    <div
        class="modal fade"
        ref="modalDelete"
        id="confirmDeleteModal"
        tabindex="-1"
        aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">
                        Confirmar Deleção
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    Você tem certeza de que deseja deletar este contato?
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                        ref="closeButton"
                    >
                        Cancelar
                    </button>
                    <button
                        type="button"
                        class="btn btn-danger"
                        @click="deleteContact"
                    >
                        Deletar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import "bootstrap/dist/js/bootstrap.bundle.min.js";
import { onMounted, ref } from "vue";
import contactApi from "../../Plugins/Sdk/contact";
import { toast } from "vue3-toastify";

const contacts = ref({
    last_page: 1,
    current_page: 1,
    data: [],
});
const contactIdToDelete = ref(null);
const modalDelete = ref();
const modalButtonDelete = ref();
const closeButton = ref();

function confirmDelete(id) {
    contactIdToDelete.value = id;
    modalButtonDelete.value.click();
}

async function listContacts(page = 1) {
    const data = await contactApi.list(`?page=${page}`);
    contacts.value = data;
}

async function deleteContact() {
    try {
        await contactApi.destroy(contactIdToDelete.value);
        closeButton.value.click();
        listContacts();
        toast(" Contato deletado com sucesso!.");
    } catch (error) {
        toast("Erro ao deletar contato:");
    }
}

onMounted(() => {
    listContacts();
});
</script>
<style scoped>
td {
    align-items: center !important;
}

.title h1 {
    font-size: 2.5rem;
}

.font_h3 {
    font-size: 1.2rem;
    margin: 0;
}

@media (max-width: 767.98px) {
    .text_break_sm {
        word-wrap: break-word !important;
        overflow-wrap: break-word !important;
    }

    .mobile_column {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-bottom: 10px;
    }
}

.btn-icon-text {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.fixed-size-image {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 50%;
}
</style>
