<script setup>
import { ref } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

const page = usePage();
const user = page.props.auth.user;
const isSidebarOpen = ref(true);

const navigation = [
    { name: "Dashboard PMB", href: route("pmb.dashboard"), icon: "dashboard" },
    {
        name: "Isi Biodata",
        href: route("pmb.biodata.index"),
        icon: "person_add",
    },
    {
        name: "Upload Berkas",
        href: route("pmb.berkas.index"),
        icon: "cloud_upload",
    }, // Update ini
    {
        name: "Pembayaran Pendaftaran",
        href: route("pmb.pembayaran.index"),
        icon: "payments",
    },
    {
        name: "Pengumuman Seleksi",
        href: route("pmb.pengumuman.index"),
        icon: "campaign",
    },
];
</script>

<template>
    <div class="min-h-screen bg-gray-50 flex">
        <aside
            :class="isSidebarOpen ? 'w-64' : 'w-20'"
            class="bg-indigo-900 text-white transition-all duration-300 flex flex-col fixed inset-y-0 z-50"
        >
            <div class="p-6 flex items-center gap-3 border-b border-indigo-800">
                <div class="bg-white p-1 rounded">
                    <span class="material-icons text-indigo-900">school</span>
                </div>
                <h1
                    v-if="isSidebarOpen"
                    class="font-black tracking-tighter text-xl"
                >
                    PMB PORTAL
                </h1>
            </div>

            <nav class="flex-1 mt-6 px-3 space-y-2">
                <Link
                    v-for="item in navigation"
                    :key="item.name"
                    :href="item.href"
                    :class="
                        route().current(item.href)
                            ? 'bg-indigo-700'
                            : 'hover:bg-indigo-800'
                    "
                    class="flex items-center p-3 rounded-xl transition group"
                >
                    <span
                        class="material-icons text-indigo-300 group-hover:text-white"
                        >{{ item.icon }}</span
                    >
                    <span
                        v-if="isSidebarOpen"
                        class="ml-3 font-medium text-sm"
                        >{{ item.name }}</span
                    >
                </Link>
            </nav>

            <div class="p-4 border-t border-indigo-800">
                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="flex items-center text-indigo-300 hover:text-white w-full"
                >
                    <span class="material-icons">logout</span>
                    <span v-if="isSidebarOpen" class="ml-3 text-sm"
                        >Keluar</span
                    >
                </Link>
            </div>
        </aside>

        <main
            :class="isSidebarOpen ? 'ml-64' : 'ml-20'"
            class="flex-1 transition-all duration-300 min-h-screen"
        >
            <header
                class="bg-white border-b h-16 flex items-center justify-between px-8 sticky top-0 z-40"
            >
                <button
                    @click="isSidebarOpen = !isSidebarOpen"
                    class="text-gray-500 hover:bg-gray-100 p-2 rounded-lg"
                >
                    <span class="material-icons">menu</span>
                </button>

                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-800">
                            {{ user.name }}
                        </p>
                        <p class="text-xs text-gray-400">Calon Mahasiswa</p>
                    </div>
                    <div
                        class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center font-bold"
                    >
                        {{ user.name.charAt(0) }}
                    </div>
                </div>
            </header>

            <div class="p-8">
                <slot />
            </div>
        </main>
    </div>
</template>

<style>
/* Optional: Menambahkan transisi halus untuk margin main content */
main {
    transition: margin-left 0.3s ease;
}
</style>
