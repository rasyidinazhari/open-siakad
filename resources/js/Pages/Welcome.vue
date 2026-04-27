<script setup>
import { Head, Link } from "@inertiajs/vue3";

defineProps({
    canLogin: { type: Boolean },
    canRegister: { type: Boolean },
});
</script>

<template>
    <Head title="Beranda - SIAKAD" />

    <div class="min-h-screen bg-gray-50 flex flex-col font-sans">
        <nav
            class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center sticky top-0 z-50"
        >
            <div class="flex items-center gap-2">
                <span class="material-icons text-3xl text-indigo-600"
                    >account_balance</span
                >
                <span class="font-black text-xl tracking-tight text-gray-800"
                    >SIAKAD<span class="text-indigo-600">PRO</span></span
                >
            </div>
            <div class="flex items-center gap-6 font-bold text-sm">
                <Link href="/" class="text-gray-900 hover:text-indigo-600"
                    >Beranda</Link
                >
                <Link href="/about" class="text-gray-500 hover:text-indigo-600"
                    >Tentang Kami</Link
                >

                <div v-if="canLogin" class="flex gap-4 ml-4">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="bg-gray-900 text-white px-5 py-2 rounded-lg hover:bg-gray-800"
                        >Masuk Dashboard</Link
                    >
                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="text-indigo-600 px-5 py-2 rounded-lg hover:bg-indigo-50"
                            >Login</Link
                        >
                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700 shadow-sm"
                            >Daftar PMB</Link
                        >
                    </template>
                </div>
            </div>
        </nav>

        <main
            class="flex-1 flex flex-col items-center justify-center text-center px-6 py-20 bg-gradient-to-b from-white to-gray-50"
        >
            <div
                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-50 text-indigo-700 font-bold text-xs uppercase tracking-widest mb-8 border border-indigo-100"
            >
                <span class="relative flex h-2 w-2">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"
                    ></span>
                    <span
                        class="relative inline-flex rounded-full h-2 w-2 bg-indigo-600"
                    ></span>
                </span>
                Penerimaan Mahasiswa Baru Telah Dibuka
            </div>

            <h1
                class="text-5xl md:text-7xl font-black text-gray-900 mb-6 tracking-tight max-w-4xl"
            >
                Masa Depan Cerah Dimulai dari
                <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600"
                    >Sini.</span
                >
            </h1>

            <p
                class="text-lg md:text-xl text-gray-500 max-w-2xl mb-10 leading-relaxed"
            >
                Sistem Informasi Akademik terintegrasi untuk memberikan
                pengalaman pendaftaran, perkuliahan, dan administrasi terbaik
                bagi seluruh civitas akademika.
            </p>

            <div class="flex flex-col sm:flex-row gap-4">
                <Link
                    :href="route('register')"
                    class="bg-indigo-600 text-white text-lg font-bold px-8 py-4 rounded-xl shadow-lg hover:bg-indigo-700 hover:-translate-y-1 transition duration-300"
                >
                    Mulai Pendaftaran
                </Link>
                <Link
                    href="/about"
                    class="bg-white text-gray-800 border-2 border-gray-200 text-lg font-bold px-8 py-4 rounded-xl hover:bg-gray-50 transition duration-300"
                >
                    Pelajari Kampus Kami
                </Link>
            </div>
        </main>
    </div>
</template>
