<script setup>
import { Head } from "@inertiajs/vue3";
import DosenLayout from "@/Layouts/DosenLayout.vue";

const props = defineProps({
    dosen: Object,
    statistik: Object,
});
</script>

<template>
    <Head title="Dashboard Dosen - SIAKAD" />

    <DosenLayout>
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800">
                Selamat Datang, Bapak/Ibu {{ $page.props.auth.user.name }}
            </h2>
            <p class="text-gray-500 mt-1">
                Sistem Informasi Akademik Tahun Ajaran 2024/2025 Genap
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center"
            >
                <div
                    class="bg-emerald-100 p-4 rounded-lg text-emerald-600 mr-4"
                >
                    <span class="material-icons text-3xl">groups</span>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">
                        Mahasiswa Perwalian
                    </p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ statistik.mahasiswa_perwalian }}
                    </p>
                </div>
            </div>

            <div
                class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center"
            >
                <div class="bg-blue-100 p-4 rounded-lg text-blue-600 mr-4">
                    <span class="material-icons text-3xl">menu_book</span>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">
                        Kelas Diampu
                    </p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ statistik.kelas_diampu }}
                    </p>
                </div>
            </div>

            <div
                class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center"
            >
                <div class="bg-amber-100 p-4 rounded-lg text-amber-600 mr-4">
                    <span class="material-icons text-3xl">fact_check</span>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">
                        KRS Pending (Butuh Approval)
                    </p>
                    <p class="text-2xl font-bold text-gray-900">0</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">
                Jadwal Mengajar Hari Ini
            </h3>

            <div class="text-center py-8 text-gray-500">
                <span class="material-icons text-5xl mb-2 text-gray-300"
                    >event_busy</span
                >
                <p>Tidak ada jadwal mengajar untuk hari ini.</p>
            </div>
        </div>
    </DosenLayout>
</template>
