<script setup>
import { Head } from "@inertiajs/vue3";
import DosenLayout from "@/Layouts/DosenLayout.vue";

const props = defineProps({ jadwal: Array });

const hariOrder = [
    "Senin",
    "Selasa",
    "Rabu",
    "Kamis",
    "Jumat",
    "Sabtu",
    "Minggu",
];
</script>

<template>
    <Head title="Jadwal Mengajar" />
    <DosenLayout>
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Jadwal Mengajar Anda
            </h2>
            <p class="text-gray-500">
                Daftar seluruh kelas dan waktu perkuliahan yang Anda ampu.
            </p>
        </div>

        <div
            class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden"
        >
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="p-4 font-semibold text-sm">Hari & Waktu</th>
                        <th class="p-4 font-semibold text-sm">Mata Kuliah</th>
                        <th class="p-4 font-semibold text-sm">Ruang</th>
                        <th class="p-4 font-semibold text-sm">Kelas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="item in jadwal"
                        :key="item.id"
                        class="border-b hover:bg-emerald-50 transition"
                    >
                        <td class="p-4">
                            <div class="font-bold text-gray-800">
                                {{ item.hari }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ item.waktu_kuliah.waktu_mulai }} -
                                {{ item.waktu_kuliah.waktu_selesai }}
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="font-medium text-gray-900">
                                {{ item.mata_kuliah.nama_mata_kuliah }}
                            </div>
                            <div
                                class="text-xs text-emerald-600 font-bold uppercase"
                            >
                                {{ item.jenis_kelas.nama_jenis_kelas }}
                            </div>
                        </td>
                        <td class="p-4 text-sm text-gray-700">
                            R. {{ item.ruang.nama_ruang }} (Lantai
                            {{ item.ruang.lantai }})
                        </td>
                        <td class="p-4 text-center">
                            <span
                                class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs font-bold"
                                >{{ item.kelas }}</span
                            >
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </DosenLayout>
</template>
