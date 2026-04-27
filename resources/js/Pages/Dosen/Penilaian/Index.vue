<script setup>
import { Head, Link } from "@inertiajs/vue3";
import DosenLayout from "@/Layouts/DosenLayout.vue";

const props = defineProps({
    jadwals: Array,
});
</script>

<template>
    <Head title="Daftar Kelas Penilaian" />

    <DosenLayout>
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Input Nilai Mahasiswa
            </h2>
            <p class="text-gray-500 mt-1">
                Pilih kelas yang Anda ampu untuk mengelola nilai akhir
                mahasiswa.
            </p>
        </div>

        <div
            class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden"
        >
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="p-4 font-semibold text-sm">Mata Kuliah</th>
                        <th class="p-4 font-semibold text-sm">
                            Jadwal & Ruang
                        </th>
                        <th class="p-4 font-semibold text-sm text-center">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="jadwal in jadwals"
                        :key="jadwal.id"
                        class="border-b hover:bg-emerald-50 transition"
                    >
                        <td class="p-4">
                            <div class="font-bold text-gray-800">
                                {{ jadwal.mata_kuliah?.nama_mata_kuliah }}
                            </div>
                            <div class="text-xs text-gray-500">
                                SKS: {{ jadwal.beban_sks }} | Kelas:
                                {{ jadwal.kelas }}
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="text-sm font-medium text-gray-800">
                                {{ jadwal.hari }},
                                {{ jadwal.waktu_kuliah?.waktu_mulai }}
                            </div>
                            <div class="text-xs text-gray-500">
                                Ruang: {{ jadwal.ruang?.nama_ruang }}
                            </div>
                        </td>
                        <td class="p-4 text-center">
                            <Link
                                :href="route('dosen.penilaian.show', jadwal.id)"
                                class="bg-emerald-100 text-emerald-800 hover:bg-emerald-200 px-4 py-2 rounded-lg font-bold transition text-sm inline-block"
                            >
                                Kelola Nilai
                            </Link>
                        </td>
                    </tr>
                    <tr v-if="jadwals.length === 0">
                        <td colspan="3" class="p-8 text-center text-gray-500">
                            Anda belum memiliki jadwal mengajar untuk semester
                            ini.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </DosenLayout>
</template>
