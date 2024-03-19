<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {getProductImagePath} from "@/Composables/GetPaths.js";
import {onMounted, ref} from "vue";
import {can} from "@/Composables/can.js";
import {PlusIcon, MinusIcon} from "@heroicons/vue/24/outline/index.js";
import {router, usePage} from "@inertiajs/vue3";

const props = defineProps({
    product: Object,
    cart: Object
})

const emit = defineEmits(['cartupdate'])

const getBgImage = (img) => 'background-image: url("'
    + ((img) ? getProductImagePath(img) : '/img/musor/slider/1.jpg')
    + '")'

onMounted(() => {
    $('.slider-product-nav').slick({
        asNavFor: '.slider-product-for',
        centerMode: false,
        focusOnSelect: true,
        adaptiveWidth: true,
        vertical: true,
        verticalSwiping: true,
        infinite: true,
        slidesToShow: 6,
        slidesToScroll: 1
    });

    $('.slider-product-for').slick({
        asNavFor: '.slider-product-nav',
        arrows: false,
        dots: false,
        infinite: true,
        fade: true,
        cssEase: 'linear',
        lazyLoad: 'ondemand',
        slidesToShow: 1,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 667,
                settings: {
                    dots: true
                }
            }
        ]
    });
})

const getDiscount = (product) => {
    return (100 - (props.product.price / props.product.oldprice) * 100).toFixed(2)
}

const amount = ref(1)
amount.value = usePage().props.cart.find(x => x.product_id === props.product.id)?.quantity || 1

const getTotalPrice = () => {
    let price = (props.product?.lowprice) ? props.product?.lowprice : props.product?.price
    return ((price * amount.value).toFixed(2))/100
}

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
            router.reload({
                only: ['product'],
                preserveScroll: true
            })
        })
}

const addToCart = () => {
    //TODO логика корзины для незареганного юзера - другая
    if (amount.value) {
        axios
            .post(
                route('cart.update'), {
                    product: props.product.id,
                    quantity: amount.value
                })
            .then((response) => {
                usePage().props.cart = response.data
            })
    } else if (usePage().props.cart.find(x => x.product_id === props.product.id).id) {
        let id = usePage().props.cart.find(x => x.product_id === props.product.id).id
        axios
            .delete(
                route('cart.destroy', id)
            )
            .then((response) => {
                usePage().props.cart = response.data
            })
    }
    return false
}

</script>

<template>
    <GuestLayout>
        <template v-slot:breadcrumbs>
            <li class="breadcrumb-item">
                <a :href="route('home')">Каталог</a>
            </li>

            <li class="breadcrumb-item">
                <a :href="route('products-groups.show', props.product?.products_groups[0]?.slug)">
                    {{ props.product?.products_groups[0]?.name }}
                </a>
            </li>

            <li class="breadcrumb-item active" aria-current="page">
                {{ props.product?.name }}
            </li>
        </template>

        <section class="wrapper">
            <div class="page-title">
                <h1>
                    {{ props.product.name }}
                </h1>

                <div
                    class="favorites"
                    :class="{'active': checkFavorites()}"
                    v-if="$page?.props?.auth?.user"
                >
                    <span>
                        В избранное:
                    </span>

                    <svg
                        width="20"
                        height="19"
                        viewBox="0 0 20 19"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        @click.prevent="toFavorites()"
                    >
                        <path class="border"
                              d="M10 18.35L8.55 17.03C3.4 12.36 0 9.28 0 5.5C0 2.42 2.42 0 5.5 0C7.24 0 8.91 0.81 10 2.09C11.09 0.81 12.76 0 14.5 0C17.58 0 20 2.42 20 5.5C20 9.28 16.6 12.36 11.45 17.04L10 18.35Z"/>
                        <path class="inside"
                              d="M14.5 0C12.76 0 11.09 0.81 10 2.09C8.91 0.81 7.24 0 5.5 0C2.42 0 0 2.42 0 5.5C0 9.28 3.4 12.36 8.55 17.04L10 18.35L11.45 17.03C16.6 12.36 20 9.28 20 5.5C20 2.42 17.58 0 14.5 0ZM10.1 15.55L10 15.65L9.9 15.55C5.14 11.24 2 8.39 2 5.5C2 3.5 3.5 2 5.5 2C7.04 2 8.54 2.99 9.07 4.36H10.94C11.46 2.99 12.96 2 14.5 2C16.5 2 18 3.5 18 5.5C18 8.39 14.86 11.24 10.1 15.55Z"/>
                    </svg>
                </div>
            </div>
        </section>

        <section class="wrapper page-product">
            <div class="page-product__list">
                <div class="page-product__item page-product__item_img">
                    <div class="slider-main">
                        <div class="slider-main__item slider-main__item_nav">
                            <div class="slider-product-nav">

                                <template v-for="image in props.product.gallery">
                                    <div class="slider-product-nav__item">
                                        <div
                                            class="slider-product-nav__inner"
                                            :style="getBgImage(image)"
                                        >
                                            <img src="/img/empty.png">
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <div class="slider-product-main__item">
                            <div class="slider-product-for">
                                <template v-for="image in props.product.gallery">
                                    <a
                                        data-fancybox="gallery-product"
                                        :href="getProductImagePath(image)"
                                        class="slider-product-for__item"
                                        :style="getBgImage(image)"
                                    >
                                        <img src="/img/empty.png"/>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-product__item page-product__item_description">
                    <div class="description-block">
                        <div
                            class="description-block__list"
                            v-if="props.product.article"
                        >
                            <div>Артикул:</div>
                            <div>{{ props.product.article }}</div>

                            <!--TODO нет такого -->
                            <!--div>Производство:</div>
                            <div>Мебельная фабрика “Рыбка”. Россия</div>

                            <div>Габариты Ш/В/Г, мм:</div>
                            <div>100 л. 100х100х50</div>

                            <div>Материалы:</div>
                            <div>Стекло, сталь</div>

                            <div>Количество в наличии:</div>
                            <div>1 шт.</div-->
                        </div>
                        <!--TODO нет такого -->
                        <div
                            class="description-block__text"
                            v-if="props.product.description"
                        >
                            <div>Описание:</div>
                            {{ props.product.description }}
                        </div>
                    </div>
                </div>

                <div class="page-product__item page-product__item_price">
                    <form>
                        <section class="price-block">
                            <div>Цена:</div>
                            <template v-if="props.product.oldprice">
                                <div
                                    class="price d-flex flex-column align-items-start"
                                >
                                    {{
                                        Intl.NumberFormat('ru-RU', {minimumFractionDigits: 2}).format(props.product.oldprice)
                                    }} ₽
                                    <a href="#myprice" data-bs-toggle="modal">Предложите свою цену</a>
                                </div>

                                <div>Скидка:</div>
                                <div class="discount">
                                    {{ getDiscount(props.product) }} %
                                </div>
                                <div>Новая цена:</div>
                                <div class="basic">
                                    {{
                                        Intl.NumberFormat('ru-RU', {minimumFractionDigits: 2}).format(props.product.price)
                                    }} ₽
                                </div>
                            </template>
                            <template v-else>
                                <div
                                    class="price d-flex flex-column align-items-start"
                                >
                                    {{
                                        Intl.NumberFormat('ru-RU', {minimumFractionDigits: 2}).format((props.product.price)/100)
                                    }} ₽
                                    <a href="#myprice" data-bs-toggle="modal">Предложите свою цену</a>
                                </div>
                            </template>

                            <div>Количество:</div>
                            <div>
                                <div class="stepper js-spinner">
                                    <div class="stepper__text">
                                        <input
                                            type="number"
                                            min="0"
                                            step="1"
                                            class="stepper__input"
                                            v-model="amount"
                                            placeholder="0"
                                        >
                                    </div>

                                    <div class="stepper__controls">
                                        <button
                                            type="button"
                                            spinner-button="up"
                                            @click="amount++"
                                        >
                                            +
                                        </button>

                                        <button
                                            type="button"
                                            spinner-button="down"
                                            @click="(amount > 0) ? amount--: false"
                                        >
                                            —
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- при добавлении в корзину появляется блок по сумме к оплате -->
                            <div>
                                Сумма к оплате:
                            </div>

                            <div class="basic">
                                {{
                                    Intl.NumberFormat('ru-RU', {minimumFractionDigits: 2}).format(getTotalPrice())
                                }} ₽
                            </div>

                            <div class="button">
                                <button
                                    type="button"
                                    class="btn-basket mx-auto bg-[#ec670d]"
                                    v-if="props.product.oldprice ?? props.product.price"
                                    @click="addToCart()"
                                >
                                    В корзину
                                </button>
                            </div>
                        </section>
                    </form>
                </div>
            </div>
        </section>
    </GuestLayout>
</template>
