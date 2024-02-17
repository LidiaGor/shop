<script setup>
import Header from "@/Components/Common/Header.vue";
import Footer from "@/Components/Common/Footer.vue";
import {usePage} from "@inertiajs/vue3";
import {ref} from "vue";

const cart = ref(null)
cart.value = usePage().props.cart

const cartUpdate = (e) => {
    cart.value = e
}
</script>

<template>
    <Header/>
    <main class="main">
        <section class="wrapper" v-if="$slots.breadcrumbs">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <slot name="breadcrumbs"/>
                </ol>
            </nav>
        </section>

        <slot
            :cart="cart"
            @cartupdate="cartUpdate"
        />
    </main>
    <Footer/>
</template>
