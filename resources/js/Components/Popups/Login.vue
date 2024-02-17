<script setup>
import {ref} from "vue";
import {router, useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";

const showLogin = ref(false)
const showRegistration = ref(false)

const form = useForm({
    email: '',
    password: '',
    remember: false
});
const formRegistration = useForm({
    name: '',
    company: '',
    company_info: '',
    phone: '',
    email: '',
    password: '',
    password_confirmation: '',
    agree: false
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
        onSuccess: () => router.visit(route('home'))
    });
};

const submitRegister = () => {
    formRegistration.post(route('register'), {
        onFinish: () => formRegistration.reset('password', 'password_confirmation'),
        onSuccess: () => router.visit(route('home'))
    });
};
</script>

<template>

    <div
        v-if="$page?.props?.auth?.user"
        class="icon cursor-pointer"
        @click.prevent="router.visit(route('profile.edit'))"
    >
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M8 8C10.21 8 12 6.21 12 4C12 1.79 10.21 0 8 0C5.79 0 4 1.79 4 4C4 6.21 5.79 8 8 8ZM8 10C5.33 10 0 11.34 0 14V16H16V14C16 11.34 10.67 10 8 10Z"
                fill="#020203"/>
        </svg>
        <span class="icon__text">{{ $page?.props?.auth?.user?.name }}</span>
    </div>

    <a href="#" class="icon" @click="showLogin=!showLogin" v-else>
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M8 8C10.21 8 12 6.21 12 4C12 1.79 10.21 0 8 0C5.79 0 4 1.79 4 4C4 6.21 5.79 8 8 8ZM8 10C5.33 10 0 11.34 0 14V16H16V14C16 11.34 10.67 10 8 10Z"
                fill="#020203"/>
        </svg>
        <span class="icon__text">Войти</span>
        <!--  для авторизованного пользователя выводится Имя    -->
    </a>

    <section
        class="modal fade show block"
        v-if="showLogin"
        @click="showLogin=!showLogin"
    >
        <div class="modal-dialog modal-dialog-centered" @click.stop="">
            <div class="modal-content">
                <form @submit.prevent="submit">
                    <div
                        class="modal-header"
                        v-if="!showRegistration"
                    >
                        <h5 class="modal-title">
                            Войти
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            @click="showLogin=!showLogin; form.reset()"
                        ></button>
                    </div>

                    <div
                        class="modal-body"
                        v-if="!showRegistration"
                    >
                        <div class="row mb-4">
                            <div class="col">
                                <input
                                    type="text"
                                    v-model="form.email"
                                    class="form-control"
                                    autocomplete="email"
                                    placeholder="Логин"
                                />
                                <div
                                    class="text-red-500"
                                    v-if="form.errors.email"
                                >
                                    {{ form.errors.email }}
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col">
                                <input
                                    type="password"
                                    class="form-control"
                                    placeholder="Пароль"
                                    autocomplete="current-password"
                                    v-model="form.password"
                                />

                                <div
                                    class="text-red-500"
                                    v-if="form.errors.password"
                                >
                                    {{ form.errors.password }}
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col">
                                <div>
                                    <input
                                        type="checkbox"
                                        id="remember"
                                        v-model="form.remember"
                                    />

                                    <label for="remember" class="text-nowrap">
                                        Запомнить меня
                                    </label>
                                </div>
                            </div>

                            <div class="col text-end">
                                <a href="#">
                                    Забыли пароль?
                                </a>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <button
                                    class="btn-basket mx-auto"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    войти
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 text-center">
                                <a
                                    @click.prevent="showRegistration = !showRegistration"
                                    class="fw-bold"
                                    data-bs-toggle="modal"
                                >
                                    ЗАРЕГИСТРИРОВАТЬСЯ
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <form @submit.prevent="submitRegister">
                    <div
                        v-if="showRegistration"
                    >
                        <div class="modal-header">
                            <h5 class="modal-title">
                                Зарегистрироваться
                            </h5>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                                @click.prevent="showLogin=!showLogin; form.reset()"
                            ></button>
                        </div>

                        <div class="modal-body">
                            <div class="row mb-4">
                                <div class="col">
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="formRegistration.name"
                                        placeholder="Фамилия, Имя, Отчество*"
                                        required
                                    >

                                    <InputError class="mt-2" :message="formRegistration.errors.name" />
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col">
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="formRegistration.company"
                                        placeholder="Компания"
                                    >

                                    <InputError class="mt-2" :message="formRegistration.errors.company" />
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col">
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="formRegistration.company_info"
                                        placeholder="Реквизиты компании"
                                    >

                                    <InputError class="mt-2" :message="formRegistration.errors.company_info" />
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col">
                                    <input
                                        type="tel"
                                        class="form-control"
                                        v-model="formRegistration.phone"
                                        placeholder="Телефон*"
                                        required
                                    >

                                    <InputError class="mt-2" :message="formRegistration.errors.phone" />
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col">
                                    <input
                                        type="email"
                                        class="form-control"
                                        v-model="formRegistration.email"
                                        placeholder="E-mail*"
                                        required
                                        autocomplete="new-email"
                                    >

                                    <InputError class="mt-2" :message="formRegistration.errors.email" />
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col">
                                    <input
                                        type="password"
                                        class="form-control"
                                        v-model="formRegistration.password"
                                        placeholder="Пароль*"
                                        autocomplete="new-password"
                                        required
                                    >

                                    <InputError class="mt-2" :message="formRegistration.errors.password" />
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col">
                                    <input
                                        type="password"
                                        class="form-control"
                                        v-model="formRegistration.password_confirmation"
                                        placeholder="Подтверждение пароля*"
                                        autocomplete="new-password"
                                        required
                                    >

                                    <InputError class="mt-2" :message="formRegistration.errors.password_confirmation" />
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="d-flex align-items-center">
                                        <input
                                            type="checkbox"
                                            id="agree"
                                            v-model="formRegistration.agree"
                                        />

                                        <label for="agree">
                                            Я согласен с Условиями использования сайта и даю согласие на обработку моих
                                            <a
                                                href="/pdf/privacy-policy.pdf" target="_blank" class="private">персональных
                                                данных</a>
                                        </label>

                                        <InputError class="mt-2" :message="formRegistration.errors.agree" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-12">
                                    <button
                                        class="btn-basket mx-auto"
                                        type="submit"
                                    >
                                        ЗАРЕГИСТРИРОВАТЬСЯ
                                    </button>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 text-center">
                                    <a
                                        class="fw-bold"
                                        data-bs-toggle="modal"
                                        @click.prevent="showRegistration = !showRegistration"
                                    >
                                        ВОЙТИ
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <div class="modal-backdrop fade show" v-if="showLogin"></div>
</template>
