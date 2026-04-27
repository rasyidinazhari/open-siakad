<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";

defineProps({
    canResetPassword: { type: Boolean },
    status: { type: String },
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <Head title="Masuk - SIAKAD" />

    <div class="min-h-screen flex">
        <div
            class="hidden lg:flex lg:w-1/2 bg-indigo-900 text-white flex-col justify-center items-center p-12 relative overflow-hidden"
        >
            <div
                class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=2070&auto=format&fit=crop')] bg-cover bg-center opacity-20 mix-blend-overlay"
            ></div>
            <div class="relative z-10 max-w-lg text-center">
                <span class="material-icons text-6xl mb-4">school</span>
                <h1 class="text-4xl font-black mb-4">
                    Portal Akademik Terpadu
                </h1>
                <p class="text-indigo-200 text-lg">
                    Kelola kegiatan akademik, jadwal perkuliahan, dan
                    administrasi kampus dalam satu platform cerdas.
                </p>
            </div>
        </div>

        <div
            class="w-full lg:w-1/2 flex items-center justify-center bg-gray-50 p-8"
        >
            <div
                class="w-full max-w-md bg-white p-10 rounded-2xl shadow-xl border border-gray-100"
            >
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-black text-gray-800">
                        Selamat Datang 👋
                    </h2>
                    <p class="text-gray-500 mt-2">
                        Silakan masuk ke akun Anda.
                    </p>
                </div>

                <div
                    v-if="status"
                    class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded-lg"
                >
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <label
                            class="block text-sm font-bold text-gray-700 mb-2"
                            >Email Publik / Kampus</label
                        >
                        <input
                            v-model="form.email"
                            type="email"
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-3"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="nama@kampus.ac.id"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div>
                        <label
                            class="block text-sm font-bold text-gray-700 mb-2"
                            >Kata Sandi</label
                        >
                        <input
                            v-model="form.password"
                            type="password"
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-3"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.password"
                        />
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input
                                v-model="form.remember"
                                type="checkbox"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            />
                            <span class="ml-2 text-sm text-gray-600 font-medium"
                                >Ingat Saya</span
                            >
                        </label>

                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition"
                        >
                            Lupa sandi?
                        </Link>
                    </div>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-xl shadow-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200 transition disabled:opacity-50"
                    >
                        {{ form.processing ? "Memproses..." : "Masuk Sistem" }}
                    </button>

                    <p class="text-center text-sm text-gray-600 mt-6">
                        Calon Mahasiswa Baru?
                        <Link
                            :href="route('register')"
                            class="font-bold text-indigo-600 hover:text-indigo-800 transition"
                            >Daftar di sini</Link
                        >
                    </p>
                </form>
            </div>
        </div>
    </div>
</template>
