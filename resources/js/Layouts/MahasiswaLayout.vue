<script setup>
import { ref } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

const isSidebarOpen = ref(true);
const user = usePage().props.auth.user;

const navigation = [
    {
        name: "Dashboard",
        href: route("mahasiswa.dashboard"),
        icon: "dashboard",
    },
    {
        name: "Tagihan Keuangan",
        href: route("mahasiswa.tagihan.index"),
        icon: "account_balance_wallet",
    }, // Tambahkan ini
    {
        name: "Kartu Rencana Studi (KRS)",
        href: route("mahasiswa.krs.index"),
        icon: "list_alt",
    },
    {
        name: "Kartu Hasil Studi (KHS)",
        href: route("mahasiswa.khs.index"),
        icon: "assignment",
    },
    {
        name: "Transkrip Nilai",
        href: route("mahasiswa.transkrip.index"),
        icon: "history_edu",
    },
    {
        name: "Skripsi / TA",
        href: route("mahasiswa.skripsi.index"),
        icon: "school",
    },
];
</script>

<template>
    <div class="min-h-screen bg-gray-50 flex">
        <aside
            :class="isSidebarOpen ? 'w-64' : 'w-20'"
            class="bg-indigo-900 text-white transition-all duration-300 flex flex-col fixed inset-y-0 z-50"
        >
            <div class="p-6 flex items-center justify-between">
                <span
                    v-if="isSidebarOpen"
                    class="text-xl font-bold tracking-wider"
                    >SIAKAD</span
                >
                <button
                    @click="isSidebarOpen = !isSidebarOpen"
                    class="hover:bg-indigo-800 p-1 rounded"
                >
                    <span class="material-icons">{{
                        isSidebarOpen ? "menu_open" : "menu"
                    }}</span>
                </button>
            </div>

            <nav class="flex-1 px-4 space-y-2 mt-4">
                <Link
                    v-for="item in navigation"
                    :key="item.name"
                    :href="item.href"
                    class="flex items-center p-3 rounded-lg hover:bg-indigo-800 transition group"
                    :class="{
                        'bg-indigo-700': $page.url.startsWith(item.href),
                    }"
                >
                    <span
                        class="material-icons text-indigo-300 group-hover:text-white"
                        >{{ item.icon }}</span
                    >
                    <span v-if="isSidebarOpen" class="ml-4 font-medium">{{
                        item.name
                    }}</span>
                </Link>
            </nav>

            <div class="p-4 border-t border-indigo-800">
                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="w-full flex items-center p-3 rounded-lg hover:bg-red-600 transition"
                >
                    <span class="material-icons">logout</span>
                    <span v-if="isSidebarOpen" class="ml-4 font-medium"
                        >Keluar</span
                    >
                </Link>
            </div>
        </aside>

        <div
            :class="isSidebarOpen ? 'ml-64' : 'ml-20'"
            class="flex-1 flex flex-col transition-all duration-300"
        >
            <header
                class="bg-white border-b sticky top-0 z-40 px-8 py-4 flex justify-between items-center"
            >
                <h1
                    class="text-lg font-semibold text-gray-700 uppercase tracking-tight"
                >
                    {{ $page.component.split("/").pop() }}
                </h1>

                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-900">
                            {{ user.name }}
                        </p>
                        <p class="text-xs text-gray-500 italic uppercase">
                            {{ user.mahasiswa?.nim || "NIM Belum Terbit" }}
                        </p>
                    </div>
                    <div
                        class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center border-2 border-indigo-200"
                    >
                        <span class="text-indigo-700 font-bold">{{
                            user.name.charAt(0)
                        }}</span>
                    </div>
                </div>
            </header>

            <main class="p-8">
                <slot />
            </main>

            <footer
                class="mt-auto p-8 text-center text-sm text-gray-400 border-t bg-white"
            >
                &copy; 2026 STMIK Amikom Surakarta - Sistem Informasi Akademik
            </footer>
        </div>
    </div>
</template>

<style>
/* Pastikan Anda menambahkan link Material Icons di app.blade.php jika ingin menggunakan icon ini */
@import url("https://fonts.googleapis.com/icon?family=Material+Icons");
</style>
