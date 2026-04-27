<script setup>
import { Head } from "@inertiajs/vue3";
import MahasiswaLayout from "@/Layouts/MahasiswaLayout.vue";

const props = defineProps({ transkrip: Array, ipk: Number, totalSks: Number });
</script>

<template>
    <Head title="Transkrip Nilai" />
    <MahasiswaLayout>
        <div class="mb-6 flex justify-between items-end">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Transkrip Nilai Akademik
                </h2>
                <p class="text-gray-500">
                    Rekapitulasi seluruh nilai mata kuliah yang telah ditempuh.
                </p>
            </div>
            <div class="flex gap-4">
                <div
                    class="bg-white border p-4 rounded-xl shadow-sm text-center"
                >
                    <p class="text-xs font-bold text-gray-400 uppercase">
                        Total SKS
                    </p>
                    <p class="text-2xl font-black text-gray-800">
                        {{ totalSks }}
                    </p>
                </div>
                <div
                    class="bg-indigo-600 p-4 rounded-xl shadow-lg text-center text-white min-w-[100px]"
                >
                    <p class="text-xs font-bold opacity-80 uppercase">
                        IPK Akhir
                    </p>
                    <p class="text-2xl font-black">{{ ipk }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="p-4 font-bold text-sm text-gray-600">
                            SMST
                        </th>
                        <th class="p-4 font-bold text-sm text-gray-600">
                            Kode
                        </th>
                        <th class="p-4 font-bold text-sm text-gray-600">
                            Mata Kuliah
                        </th>
                        <th
                            class="p-4 font-bold text-sm text-gray-600 text-center"
                        >
                            SKS
                        </th>
                        <th
                            class="p-4 font-bold text-sm text-gray-600 text-center"
                        >
                            Nilai
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(item, index) in transkrip"
                        :key="index"
                        class="border-b hover:bg-gray-50"
                    >
                        <td class="p-4 text-sm text-gray-500 text-center">
                            {{ item.semester }}
                        </td>
                        <td class="p-4 text-sm text-gray-500">
                            {{ item.kode_mata_kuliah }}
                        </td>
                        <td class="p-4 font-medium text-gray-800">
                            {{ item.nama_mata_kuliah }}
                        </td>
                        <td class="p-4 text-center">{{ item.beban_sks }}</td>
                        <td class="p-4 text-center font-bold text-indigo-700">
                            {{ item.nilai_huruf || "-" }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </MahasiswaLayout>
</template>
