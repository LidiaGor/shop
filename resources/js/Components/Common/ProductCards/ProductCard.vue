<script setup>
import {getProductImagePath} from "@/Composables/GetPaths.js";
import {can} from "@/Composables/can.js";
import {router, usePage} from "@inertiajs/vue3";

const props = defineProps({
    product: Object
})

const getBgImage = (img) => 'background-image: url('
    + ((img[0]) ? getProductImagePath(img[0]) : '/img/musor/slider/1.jpg')
    + ')'

const checkFavorites = () => {
    return usePage().props.favorites.find(x => x.product_id === props?.product?.id && x.user_id === usePage()?.props?.auth?.user?.id)
}

const toFavorites = () => {
    axios
        .post(
            route('favorites.update'), {
                product: props.product.id
            })
        .then((response) => {
            usePage().props.favorites = response.data

            if (route().current('favorites.index')) {
                router.visit(route('favorites.index'))
            } else {
                router.reload({
                    only: ['product'],
                    preserveScroll: true
                })
            }
        })
}

</script>

<template>
    <article class="catalog__item">
        <a :href="route('product.show', product.slug)" class="card-product">
            <div class="card-product__img"
                 :style="getBgImage(product.gallery)">

                <div
                    v-if="$page?.props?.auth?.user"
                    class="favorites"
                    :class="{'active': checkFavorites()}"
                    @click.prevent="toFavorites()"
                >
                    <svg
                        width="20"
                        height="19"
                        viewBox="0 0 20 19"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path class="border"
                              d="M10 18.35L8.55 17.03C3.4 12.36 0 9.28 0 5.5C0 2.42 2.42 0 5.5 0C7.24 0 8.91 0.81 10 2.09C11.09 0.81 12.76 0 14.5 0C17.58 0 20 2.42 20 5.5C20 9.28 16.6 12.36 11.45 17.04L10 18.35Z"/>
                        <path class="inside"
                              d="M14.5 0C12.76 0 11.09 0.81 10 2.09C8.91 0.81 7.24 0 5.5 0C2.42 0 0 2.42 0 5.5C0 9.28 3.4 12.36 8.55 17.04L10 18.35L11.45 17.03C16.6 12.36 20 9.28 20 5.5C20 2.42 17.58 0 14.5 0ZM10.1 15.55L10 15.65L9.9 15.55C5.14 11.24 2 8.39 2 5.5C2 3.5 3.5 2 5.5 2C7.04 2 8.54 2.99 9.07 4.36H10.94C11.46 2.99 12.96 2 14.5 2C16.5 2 18 3.5 18 5.5C18 8.39 14.86 11.24 10.1 15.55Z"/>
                    </svg>
                </div>
            </div>

            <div class="card-product__price" v-if="product.price">
                <template v-if="product.oldprice">
                    <span class="basic" v-if="product.price">
                        {{ Intl.NumberFormat('ru-RU').format(product.price) }} ₽
                    </span>

                    <span class="price" v-if="product.oldprice">
                        {{ Intl.NumberFormat('ru-RU').format(product.oldprice) }} ₽
                    </span>

                    <span class="discount" v-if="product.oldprice">
                        {{ (100 - (product.price / product.oldprice) * 100).toFixed(2) }} %
                    </span>
                </template>

                <template v-else>
                    <span class="basic">
                        {{ Intl.NumberFormat('ru-RU').format(product.price/100) }} ₽
                    </span>
                </template>
            </div>

            <div class="card-product__price text-gray-600/40" v-else>
                Нет на складе
            </div>

            <div class="card-product__title">
                {{ product.name }}
            </div>
        </a>
    </article>
</template>

<style scoped>

</style>
