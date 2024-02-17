<script setup>

import GuestLayout from "@/Layouts/GuestLayout.vue";
import CartFullPrice from "@/Components/Common/CartFullPrice.vue";
import {getProductImagePath} from "@/Composables/GetPaths.js";
import {watch} from "vue";
import {router, usePage} from "@inertiajs/vue3";

const props = defineProps({
    carts: Object
})

const
    checkPrice = (cart) => {
        return cart?.product?.price
                ?? cart?.product?.oldprice
                ?? 0
    }
const getBgImage = (img) => {
    return 'background-image: url("'
    + ((img.length && img[0]) ? getProductImagePath(img[0]) : '/img/musor/slider/1.jpg')
    + '")';
}

const quantityUpdate = (cart) => {
    if (cart.quantity) {
        axios
            .post(
                route('cart.update'), {
                    product: cart.product_id,
                    quantity: cart.quantity,
                    is_cart: 1
                })
            .then((response) => {
                usePage().props.cart = response.data
                router.reload({
                    only: ['carts'],
                    preserveScroll: true
                })
            })

    } else (
        deleteCart(cart.id)
    )
}
const deleteCart = (id) => {
    axios
        .delete(
            route('cart.destroy', id)
        )
        .then((response) => {
            usePage().props.cart = response.data
            router.reload({
                only: ['carts'],
                preserveScroll: true
            })
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
                Корзина
            </li>
        </template>

        <section class="wrapper">
            <div class="page-title">
                <h1>
                    Корзина
                </h1>
            </div>
        </section>

        <section class="wrapper basket">
            <div class="basket__list">
                <div class="basket__item basket__item_left">
                    <form action="">
                        <section class="cart__list">
                            <article
                                class="cart__item"
                                v-for="cart in props.carts"
                            >
                                <div
                                    class="cart__img"
                                    :style="getBgImage(cart?.product?.gallery)"
                                ></div>

                                <div class="cart__title">
                                    {{cart?.product?.name ?? ''}}
                                </div>

                                <div class="cart__technical">
                                    <section class="cart__options">
                                        <div class="quantity">
                                            {{ cart?.quantity }}&nbsp;{{ cart?.product.unit }}
                                        </div>

                                        <div class="unit-price whitespace-nowrap">
                                            {{
                                                Intl.NumberFormat('ru-RU', {minimumFractionDigits: 2}).format(checkPrice(cart))
                                            }} ₽
                                        </div>

                                        <div class="step">
                                            <div class="stepper js-spinner">
                                                <div class="stepper__text">
                                                    <input
                                                        type="number"
                                                        min="0"
                                                        step="1"
                                                        class="stepper__input"
                                                        :placeholder="!cart.quantity  ? 0 : ''"
                                                        v-model="cart.quantity"
                                                        @input="quantityUpdate(cart)"
                                                    >
                                                </div>

                                                <div class="stepper__controls">
                                                    <button
                                                        type="button"
                                                        spinner-button="up"
                                                        @click.prevent="cart.quantity++; quantityUpdate(cart)"
                                                    > +</button>

                                                    <button
                                                        type="button"
                                                        spinner-button="down"
                                                        @click.prevent="(cart.quantity > 0) ? cart.quantity--: false; quantityUpdate(cart)"
                                                    > —</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            class="del cursor-pointer"
                                            @click.prevent="deleteCart(cart.id)"
                                        >
                                            <svg
                                                width="12"
                                                height="16"
                                                viewBox="0 0 12 16"
                                                fill="none"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    d="M1.00008 13.8333C1.00008 14.75 1.75008 15.5 2.66675 15.5H9.33342C10.2501 15.5 11.0001 14.75 11.0001 13.8333V3.83333H1.00008V13.8333ZM3.05008 7.9L4.22508 6.725L6.00008 8.49167L7.76675 6.725L8.94175 7.9L7.17508 9.66667L8.94175 11.4333L7.76675 12.6083L6.00008 10.8417L4.23342 12.6083L3.05842 11.4333L4.82508 9.66667L3.05008 7.9ZM8.91675 1.33333L8.08342 0.5H3.91675L3.08341 1.33333H0.166748V3H11.8334V1.33333H8.91675Z"
                                                    fill="#020203"/>
                                            </svg>

                                            <span>Удалить</span>
                                        </div>

                                    </section>
                                </div>
                            </article>
                        </section>
                    </form>
                </div>

                <div class="basket__item basket__item_right">
                    <CartFullPrice
                        :full="props.carts"
                    />
                    <!--                    <?php-->
                    <!--                include('views/blocks/price-block-basket.php');-->
                    <!--                ?>-->
                </div>

            </div>
        </section>
    </GuestLayout>
</template>
