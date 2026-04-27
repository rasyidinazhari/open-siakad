<script setup>
import { Head, Link } from "@inertiajs/vue3";
import DosenLayout from "@/Layouts/DosenLayout.vue";

const props = defineProps({
    bimbingan: Array,
});
</script>

<template>
    <Head title="Bimbingan Skripsi" />

    <DosenLayout>
        <div class="mb-6 flex justify-between items-end">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Bimbingan Skripsi / Tugas Akhir
                </h2>
                <p class="text-gray-500 mt-1">
                    Daftar mahasiswa yang berada di bawah bimbingan Anda.
                </p>
            </div>
            <div
                class="bg-emerald-100 text-emerald-800 px-4 py-2 rounded-lg font-bold shadow-sm"
            >
                Total Bimbingan: {{ bimbingan.length }} Mahasiswa
            </div>
        </div>

        <div
            class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden"
        >
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="p-4 font-semibold text-sm">Mahasiswa</th>
                        <th class="p-4 font-semibold text-sm">Program Studi</th>
                        <th class="p-4 font-semibold text-sm w-1/3">
                            Judul Skripsi
                        </th>
                        <th class="p-4 font-semibold text-sm text-center">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="item in bimbingan"
                        :key="item.id"
                        class="border-b hover:bg-emerald-50 transition"
                    >
                        <td class="p-4">
                            <div class="font-bold text-gray-800">
                                {{ item.mahasiswa?.user?.name }}
                            </div>
                            <div class="text-xs text-gray-500 font-medium">
                                NIM: {{ item.mahasiswa?.nim }}
                            </div>
                        </td>
                        <td class="p-4 text-sm text-gray-700">
                            {{
                                item.mahasiswa?.program_studi
                                    ?.nama_program_studi
                            }}
                        </td>
                        <td class="p-4">
                            <div
                                class="text-sm font-medium text-gray-900 line-clamp-2"
                            >
                                {{ item.judul }}
                            </div>
                        </td>
                        <td class="p-4 text-center">
                            <span
                                :class="{
                                    'bg-gray-100 text-gray-800':
                                        item.status === 'Diajukan',
                                    'bg-blue-100 text-blue-800':
                                        item.status === 'Disetujui',
                                    'bg-green-100 text-green-800':
                                        item.status === 'Selesai',
                                    'bg-red-100 text-red-800':
                                        item.status === 'Ditolak',
                                }"
                                class="px-3 py-1 rounded-full text-xs font-bold uppercase"
                            >
                                {{ item.status }}
                            </span>
                        </td>
                    </tr>
                    <tr v-if="bimbingan.length === 0">
                        <td colspan="4" class="p-8 text-center text-gray-500">
                            <span
                                class="material-icons text-4xl mb-2 text-gray-300"
                                >school</span
                            >
                            <p>
                                Anda belum memiliki mahasiswa bimbingan
                                Skripsi/TA saat ini.
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </DosenLayout>
</template>
