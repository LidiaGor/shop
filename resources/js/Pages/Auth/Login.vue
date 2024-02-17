<script setup xmlns="http://www.w3.org/1999/html">
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, Link, router, useForm} from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
        onSuccess: () => router.visit(route('home'))
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />
        <div class="w-[90%] md:w-[50%] lg:w-[30%] mx-auto">
            <form @submit.prevent="submit">
            <div class="modal-header">
                <h5 class="modal-title">
                    Войти
                </h5>
            </div>

            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col">
                        <input
                            type="text"
                            v-model="form.email"
                            class="form-control"
                            placeholder="Логин"
                            autocomplete="username"
                        />
                        <div class="text-red-500" v-if="form.errors.email">{{form.errors.email}}</div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col">
                        <input
                            type="password"
                            class="form-control"
                            placeholder="Пароль"
                            v-model="form.password"
                            autocomplete="current-password"
                        />
                        <div class="text-red-500" v-if="form.errors.password">{{form.errors.password}}</div>
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
                            <label for="remember" class="text-nowrap">Запомнить меня</label>
                        </div>
                    </div>
                    <div class="col text-end">
                        <a href="#">Забыли пароль?</a>
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
                        <a href="#register" class="fw-bold" data-bs-toggle="modal">ЗАРЕГИСТРИРОВАТЬСЯ</a>
                    </div>
                </div>

            </div>
        </form>
        </div>
    </GuestLayout>
</template>
