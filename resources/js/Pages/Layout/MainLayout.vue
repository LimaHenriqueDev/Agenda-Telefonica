<template>
    <Navbar />
    <router-view />
    <Footer />
</template>

<script setup>
import Navbar from "../../Pages/Layout/Navbar.vue";
import Footer from "./Footer.vue";
</script>

<style>
html,
body {
    background-color: #f8f7fa !important;
}
</style>
