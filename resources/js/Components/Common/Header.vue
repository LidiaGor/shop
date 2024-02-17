<script setup>
import HeaderMenu from "@/Components/Common/Menu/HeaderMenu.vue";
import Login from "@/Components/Popups/Login.vue";
import CartHeader from "@/Components/Common/CartHeader.vue";
import {router, usePage} from "@inertiajs/vue3";
import {ref, watch} from "vue";

const search = ref(route().params.search ?? null)

const searchUpdate = (e) => {
    search.value = e
}
const toSearch = () => {
    if (search.value) {
        return router.visit(
            route('search.product'),
            {
                data: {
                    search: search.value
                }
            }
        )
    }
}

watch(search, (newValue) => {
    if (!newValue && !route().current('home')) {
        return router.visit(route('home'))
    }
})
</script>

<template>
    <header class="header">
        <div class="wrapper">

            <section class="header__list">
                <div class="header__logo">
                    <a :href="route('home')" class="d-block">
                        <img src="/img/logo.svg" alt="">
                    </a>
                </div>

                <HeaderMenu
                    :search="search"
                    @searchupdate="searchUpdate"
                />

                <section class="search">
                    <div class="input-group">
                        <input
                            type="search"
                            v-model="search"
                            class="form-control"
                            placeholder="Поиск по сайту"
                            aria-label="Имя пользователя получателя"
                            @keyup.enter.prevent="toSearch()"
                        >

                        <button class="btn btn-search" type="button" @click.prevent="toSearch()"></button>
                    </div>
                </section>

                <section class="user-block">
                    <a
                        class="icon cursor-pointer"
                        @click.prevent="router.visit(route('home'))"
                    >
                        <svg width="20" height="17" viewBox="0 0 20 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 17V11H12V17H17V9H20L10 0L0 9H3V17H8Z" fill="#020203"/>
                        </svg>

                        <span class="icon__text">
                            Главная
                        </span>
                    </a>

                    <Login/>

                    <a
                        href="/orders.php" class="icon"
                        v-if="$page?.props?.auth?.user"
                    >
                        <svg width="21" height="19" viewBox="0 0 21 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10.005 0C11.5963 0 13.1224 0.632141 14.2476 1.75736C15.3729 2.88258 16.005 4.4087 16.005 6V7H20.005V9H18.838L18.081 18.083C18.0602 18.3329 17.9463 18.5658 17.7618 18.7357C17.5773 18.9055 17.3358 18.9999 17.085 19H2.925C2.67408 19.0001 2.43228 18.9059 2.24759 18.736C2.06291 18.5662 1.94883 18.3331 1.928 18.083L1.171 9H0.00500488V7H4.005V6C4.005 4.4087 4.63715 2.88258 5.76236 1.75736C6.88758 0.632141 8.41371 0 10.005 0ZM11.005 11H9.005V15H11.005V11ZM7.005 11H5.005V15H7.005V11ZM15.005 11H13.005V15H15.005V11ZM10.005 2C8.97876 2 7.99178 2.39444 7.24819 3.10172C6.50461 3.80901 6.06132 4.77504 6.01 5.8L6.005 6V7H14.005V6C14.005 4.97376 13.6106 3.98677 12.9033 3.24319C12.196 2.4996 11.23 2.05631 10.205 2.005L10.005 2Z"
                                fill="#020203"/>
                        </svg>

                        <span class="icon__text">
                            Заказы
                        </span>
                    </a>

                    <a
                        @click.prevent="$page?.props?.favorites?.length ? router.visit(route('favorites.index')) : ''"
                        class="icon cursor-pointer"
                        v-if="$page?.props?.auth?.user"
                    >
                        <sup>{{ $page?.props?.favorites.length }}</sup>

                        <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10 18.35L8.55 17.03C3.4 12.36 0 9.28 0 5.5C0 2.42 2.42 0 5.5 0C7.24 0 8.91 0.81 10 2.09C11.09 0.81 12.76 0 14.5 0C17.58 0 20 2.42 20 5.5C20 9.28 16.6 12.36 11.45 17.04L10 18.35Z"
                                fill="#020203"/>
                        </svg>

                        <span class="icon__text">
                            Избранное
                        </span>
                    </a>

                    <CartHeader/>
                </section>
            </section>
        </div>
    </header>
</template>
