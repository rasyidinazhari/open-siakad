<script setup>
import { Head, Link } from "@inertiajs/vue3";
import MahasiswaLayout from "@/Layouts/MahasiswaLayout.vue";

const props = defineProps({
    message: String,
});
</script>

<template>
    <Head title="Akses KRS Terkunci" />

    <MahasiswaLayout>
        <div class="max-w-3xl mx-auto mt-10">
            <div
                class="bg-red-50 border-l-4 border-red-500 p-6 rounded-lg shadow-sm flex items-start"
            >
                <span class="material-icons text-red-500 text-4xl mr-4"
                    >block</span
                >
                <div>
                    <h2 class="text-xl font-bold text-red-800 mb-2">
                        Akses KRS Terkunci
                    </h2>
                    <p class="text-red-700">{{ message }}</p>
                    <div class="mt-4">
                        <Link
                            :href="route('mahasiswa.dashboard')"
                            class="bg-red-100 text-red-800 hover:bg-red-200 px-4 py-2 rounded font-medium transition"
                        >
                            Kembali ke Dashboard
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </MahasiswaLayout>
</template>
