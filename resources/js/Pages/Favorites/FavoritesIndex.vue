<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import Sliders from "@/Components/Homepage/Sliders.vue";
import SpecialOffers from "@/Components/Homepage/SpecialOffers.vue";
import ProductCard from "@/Components/Common/ProductCards/ProductCard.vue";
import {watch} from "vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    products: Object
})

</script>

<template>
    <GuestLayout>
        <template
            v-slot:breadcrumbs
        >
            <li class="breadcrumb-item">
                <a :href="route('home')">
                    Главная
                </a>
            </li>

            <li class="breadcrumb-item active" aria-current="page">
                Избранное
            </li>
        </template>

        <div class="wrapper">
            <section class="title">
                <h2>
                    Избранное
                </h2>
            </section>
        </div>

        <div class="wrapper">
            <section class="catalog__list">
                <template v-for="product in products">
                    <ProductCard
                        :product="product"
                    />
                </template>
            </section>
        </div>
    </GuestLayout>
</template>

