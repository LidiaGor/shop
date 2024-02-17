<script setup>
import {onMounted, ref} from "vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    search: String
});

const emit = defineEmits(['searchupdate']);

const search = ref(props.search);
const showMenu = ref(false);
const menu = ref([]);

const searchCheck = () => {
    emit('searchupdate', search.value)
};

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
};

onMounted(() => {
    axios
        .post(route('products-groups.groups-menu-header'))
        .then((response) => {
            menu.value = menu.value.concat(response.data)
        })
});

</script>

<template>

    <a class="header__btn cursor-pointer" @click.prevent="showMenu = !showMenu" :class="{'active' : showMenu}">
        <span></span> Каталог
    </a>

    <Teleport to="body">
        <section class="header-catalog-menu" :class="{'active' : showMenu}">
            <div class="header-catalog-menu_close" @click.prevent="showMenu = false"></div>

            <section class="search">
                <form action="">
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Поиск по сайту"
                            v-model="search"
                            aria-label="Имя пользователя получателя"
                            @input="searchCheck"
                        >

                        <button class="btn btn-search" type="button" @click.prevent="toSearch()"></button>
                    </div>
                </form>
            </section>

            <div class="header-catalog-menu__list">
                <ul class="menu-accordion">
                    <li class="menu-accordion-item" v-for="item in menu">
                        <div
                            class="menu-accordion-header cursor-pointer"
                            @click.prevent="router.visit(route('products-groups.show', item.slug))"
                        >
                            {{ item.name }}
                        </div>
                    </li>
                </ul>
            </div>
        </section>
    </Teleport>
</template>

