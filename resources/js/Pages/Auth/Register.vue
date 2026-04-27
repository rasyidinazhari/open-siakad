<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <Head title="Pendaftaran PMB" />

    <div
        class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8"
    >
        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
            <span class="material-icons text-6xl text-indigo-600"
                >how_to_reg</span
            >
            <h2 class="mt-4 text-3xl font-black text-gray-900">
                Pendaftaran Akun Baru
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Sudah punya akun?
                <Link
                    :href="route('login')"
                    class="font-bold text-indigo-600 hover:text-indigo-500"
                >
                    Masuk di sini
                </Link>
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div
                class="bg-white py-8 px-4 shadow-xl sm:rounded-2xl sm:px-10 border border-gray-100"
            >
                <form class="space-y-6" @submit.prevent="submit">
                    <div>
                        <label class="block text-sm font-bold text-gray-700"
                            >Nama Lengkap</label
                        >
                        <input
                            v-model="form.name"
                            type="text"
                            class="mt-1 w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2"
                            required
                            autofocus
                            autocomplete="name"
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700"
                            >Email Aktif</label
                        >
                        <input
                            v-model="form.email"
                            type="email"
                            class="mt-1 w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2"
                            required
                            autocomplete="username"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700"
                            >Kata Sandi</label
                        >
                        <input
                            v-model="form.password"
                            type="password"
                            class="mt-1 w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2"
                            required
                            autocomplete="new-password"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.password"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700"
                            >Konfirmasi Kata Sandi</label
                        >
                        <input
                            v-model="form.password_confirmation"
                            type="password"
                            class="mt-1 w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2"
                            required
                            autocomplete="new-password"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.password_confirmation"
                        />
                    </div>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-xl shadow hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200 transition"
                    >
                        Buat Akun PMB
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
