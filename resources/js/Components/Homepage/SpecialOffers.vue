<script setup>
import ProductCard from "@/Components/Common/ProductCards/ProductCard.vue";
import {onMounted, ref} from "vue";

const products = ref([]);
let page = 1;

onMounted(() => {
    loadMore()
})

const loadMore = () => {
    axios
        .post(route('home.special-offers'), {page: page})
        .then((response)=>{
            products.value = products.value.concat(response.data.data)
            page++;
        })
}
</script>

<template>
    <div class="wrapper">
        <section class="title">
            <h2>
                Лучшие предложения!
            </h2>
        </section>

        <section class="catalog__list">
            <template v-for="product in products">
                <ProductCard
                    :product="product"
                />
            </template>
        </section>
    </div>
    <section class="wrapper">
        <button class="show-more mt-40 mx-auto" @click="loadMore()">
            показать еще
        </button>
    </section>
</template>
