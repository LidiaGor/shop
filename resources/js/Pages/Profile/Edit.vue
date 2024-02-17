<script setup>
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import {Head, router, useForm, usePage} from '@inertiajs/vue3';
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {ref} from "vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";

defineProps({});
const
    formEdit = ref(false);

const
    user = usePage().props.auth.user;

const
    form = useForm({
        name: user.name,
        email: user.email,
        company: user.company,
        company_info: user.company_info,
        phone: user.phone,
        address: user.address,
    });
</script>

<template>
    <Head title="Личный кабинет"/>

    <GuestLayout>
        <template v-slot:breadcrumbs>
            <li class="breadcrumb-item">
                <a :href="route('home')">Каталог</a>
            </li>

            <li class="breadcrumb-item active" aria-current="page">
                Личный кабинет
            </li>
        </template>

        <section class="wrapper">
            <div class="page-title">
                <h1>
                    Личный кабинет
                </h1>
            </div>
        </section>

        <section class="wrapper">
            <form
                @submit.prevent="form.patch(route('profile.update'), {onSuccess: formEdit = false})"
            >
                <div class="block-lk">
                    <article class="block-lk__list">
                        <div class="block-lk__item">
                            Фамилия, Имя, Отчество:
                        </div>

                        <div class="block-lk__item">
                            <label
                                for="name"
                                class="form-label"
                                v-if="!formEdit"
                            >
                                {{ form.name }}
                            </label>

                            <input
                                class="form-control"
                                v-if="formEdit"
                                v-model="form.name"
                                id="name"
                            >
                        </div>
                    </article>

                    <article class="block-lk__list">
                        <div class="block-lk__item">
                            Компания:
                        </div>

                        <div class="block-lk__item">
                            <label
                                for="company"
                                v-if="!formEdit"
                                class="form-label"
                            >
                                {{ form.company }}
                            </label>

                            <input
                                class="form-control"
                                v-if="formEdit"
                                v-model="form.company"
                                id="company"
                            >
                        </div>
                    </article>

                    <article class="block-lk__list">
                        <div class="block-lk__item">
                            Реквизиты компании:
                        </div>

                        <div class="block-lk__item">
                            <label
                                for="info"
                                v-if="!formEdit"
                                class="form-label"
                            >
                                {{ form.company_info }}
                            </label>

                            <input
                                class="form-control"
                                v-if="formEdit"
                                v-model="form.company_info"
                                id="info"
                            >
                        </div>
                    </article>

                    <article class="block-lk__list">
                        <div class="block-lk__item">
                            Телефон:
                        </div>

                        <div class="block-lk__item">
                            <label
                                for="phone"
                                v-if="!formEdit"
                                class="form-label"
                            >
                                {{ form.phone }}
                            </label>

                            <input
                                class="form-control"
                                v-if="formEdit"
                                v-model="form.phone"
                                id="phone"
                            >
                        </div>
                    </article>

                    <article class="block-lk__list">
                        <div class="block-lk__item">
                            E-mail:
                        </div>

                        <div class="block-lk__item">
                            <label
                                for="email"
                                v-if="!formEdit"
                                class="form-label"
                            >
                                {{ form.email }}
                            </label>

                            <input
                                class="form-control"
                                v-if="formEdit"
                                v-model="form.email"
                                id="email"
                            >
                        </div>
                    </article>

                    <article class="block-lk__list">
                        <div class="block-lk__item">
                            Адрес:
                        </div>

                        <div class="block-lk__item">
                            <label
                                for="address"
                                v-if="!formEdit"
                                class="form-label"
                            >
                                {{ form.address }}
                            </label>

                            <input
                                class="form-control"
                                v-if="formEdit"
                                v-model="form.address"
                                id="address"
                            >
                        </div>
                    </article>

                    <div class="block-lk__btn">
                        <button
                            class="btn-edit mr-auto"
                            @click.prevent="formEdit = !formEdit; form.reset()"
                        >
                            <template v-if="!formEdit">
                                <svg width="19" height="18" viewBox="0 0 19 18" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11.06 6.02L11.98 6.94L2.92 16H2V15.08L11.06 6.02ZM14.66 0C14.41 0 14.15 0.1 13.96 0.29L12.13 2.12L15.88 5.87L17.71 4.04C17.8027 3.94749 17.8762 3.8376 17.9264 3.71662C17.9766 3.59565 18.0024 3.46597 18.0024 3.335C18.0024 3.20403 17.9766 3.07435 17.9264 2.95338C17.8762 2.8324 17.8027 2.72251 17.71 2.63L15.37 0.29C15.17 0.09 14.92 0 14.66 0ZM11.06 3.19L0 14.25V18H3.75L14.81 6.94L11.06 3.19Z"
                                        fill="white"/>
                                </svg>
                                редактировать
                            </template>

                            <template
                                v-else-if="formEdit"
                            >
                                отменить
                            </template>
                        </button>

                        <button
                            class="btn-edit mx-auto"
                            :class="{'hidden' : form.processing}"
                            type="submit"
                            v-if="form.isDirty"
                        >
                            сохранить
                        </button>

                        <button
                            class="btn-edit ml-auto"
                            type="button"
                            @click.prevent="router.visit(route('logout'), {method: 'post'})"
                        >
                            Выйти из аккаунта
                        </button>
                    </div>
                </div>

<!--                <div class="block-lk my-8">
                    <UpdatePasswordForm class="max-w-xl"/>
                </div>

                <div class="block-lk my-8 relative">
                    <DeleteUserForm class="max-w-xl"/>
                </div>-->
            </form>
        </section>
    </GuestLayout>
</template>
