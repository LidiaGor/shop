<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import Sliders from "@/Components/Homepage/Sliders.vue";
import SpecialOffers from "@/Components/Homepage/SpecialOffers.vue";
import ProductCard from "@/Components/Common/ProductCards/ProductCard.vue";
import {ref} from "vue";
import {router, usePage} from "@inertiajs/vue3";

const props = defineProps({
    products: Object,
    groups: Object,
    this_group: Object,
    type: Number
})

const filter = ref(props.type ?? 0)

const selectGroup = ref(props.this_group.slug)
const changeParams = () => {
    return router.visit(route('products-groups.show', selectGroup.value), {
        data: {
            type: filter.value
        }
    })
}

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
                {{ props.this_group.name }}
            </li>
        </template>

        <div class="wrapper">
            <section class="title">
                <h2>
                    {{ props.this_group.name }}
                </h2>
            </section>
        </div>

        <div class="wrapper">
            <div class="filter">
                <div class="filter__item">
                    <select
                        class="form-select"
                        aria-label="Default select"
                        v-model="selectGroup"
                        @change="router.visit(route('products-groups.show', selectGroup), {
                            data: {
                                type: filter
                            }
                        })"
                    >
                        <option
                            v-for="group in props.groups"
                            :label="group.name"
                            :value="group.slug"
                            :style="'font-weight: bold;'"
                        ></option>
                    </select>
                </div>

                <div class="filter__item">
                    <select
                        class="form-select form-select_sorting"
                        aria-label="Default select"
                        v-model="filter"
                        @change="changeParams"
                    >
                        <option value="0">Самые популярные</option>
                        <option value="1">Новинки</option>
                        <option value="2">Сначала дешевые</option>
                        <option value="3">Сначала дорогие</option>
                        <option value="4" v-if="usePage()?.props?.auth?.user?.products_price_type_id">Со скидкой</option>
                    </select>
                </div>
            </div>
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

