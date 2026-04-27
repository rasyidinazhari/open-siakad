<script setup>
import { ref } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

const isSidebarOpen = ref(true);
const user = usePage().props.auth.user;

const navigation = [
    { name: "Dashboard", href: route("dosen.dashboard"), icon: "dashboard" },
    {
        name: "Jadwal Mengajar",
        href: route("dosen.jadwal.index"),
        icon: "event_note",
    },
    {
        name: "Perwalian KRS",
        href: route("dosen.perwalian.index"),
        icon: "how_to_reg",
    },
    {
        name: "Input Nilai",
        href: route("dosen.penilaian.index"),
        icon: "edit_document",
    },
    {
        name: "Bimbingan Skripsi",
        href: route("dosen.bimbingan.index"),
        icon: "school",
    },
];
</script>

<template>
    <div class="min-h-screen bg-gray-50 flex">
        <aside
            :class="isSidebarOpen ? 'w-64' : 'w-20'"
            class="bg-emerald-900 text-white transition-all duration-300 flex flex-col fixed inset-y-0 z-50"
        >
            <div
                class="p-6 flex items-center justify-between border-b border-emerald-800"
            >
                <span
                    v-if="isSidebarOpen"
                    class="text-xl font-bold tracking-wider"
                    >PORTAL DOSEN</span
                >
                <button
                    @click="isSidebarOpen = !isSidebarOpen"
                    class="hover:bg-emerald-800 p-1 rounded"
                >
                    <span class="material-icons">{{
                        isSidebarOpen ? "menu_open" : "menu"
                    }}</span>
                </button>
            </div>

            <nav class="flex-1 px-4 space-y-2 mt-6">
                <Link
                    v-for="item in navigation"
                    :key="item.name"
                    :href="item.href"
                    class="flex items-center p-3 rounded-lg hover:bg-emerald-800 transition group"
                    :class="{
                        'bg-emerald-700': $page.url.startsWith(item.href),
                    }"
                >
                    <span
                        class="material-icons text-emerald-300 group-hover:text-white"
                        >{{ item.icon }}</span
                    >
                    <span v-if="isSidebarOpen" class="ml-4 font-medium">{{
                        item.name
                    }}</span>
                </Link>
            </nav>

            <div class="p-4 border-t border-emerald-800">
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
                class="bg-white border-b sticky top-0 z-40 px-8 py-4 flex justify-between items-center shadow-sm"
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
                        <p class="text-xs text-gray-500 font-medium">
                            NIDN: {{ user.dosen?.nidn || "-" }}
                        </p>
                    </div>
                    <div
                        class="h-10 w-10 rounded-full bg-emerald-100 flex items-center justify-center border-2 border-emerald-200"
                    >
                        <span class="text-emerald-700 font-bold">{{
                            user.name.charAt(0)
                        }}</span>
                    </div>
                </div>
            </header>

            <main class="p-8">
                <slot />
            </main>
        </div>
    </div>
</template>

<style scoped>
@import url("https://fonts.googleapis.com/icon?family=Material+Icons");
</style>
