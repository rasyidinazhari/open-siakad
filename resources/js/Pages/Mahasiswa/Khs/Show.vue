<script setup>
import { Head, Link } from "@inertiajs/vue3";
import MahasiswaLayout from "@/Layouts/MahasiswaLayout.vue";

const props = defineProps({
    krs: Object,
    nilai: Array,
    ips: Number,
});

const getNilai = (jadwalId) => {
    return props.nilai.find((n) => n.jadwal_kuliah_id === jadwalId);
};
</script>

<template>
    <Head title="Kartu Hasil Studi" />

    <MahasiswaLayout>
        <div class="max-w-5xl mx-auto">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">
                        Kartu Hasil Studi (KHS)
                    </h2>
                    <p class="text-gray-500">
                        {{ krs.tahun_akademik.nama_tahun }} - Semester
                        {{ krs.semester }}
                    </p>
                </div>
                <div
                    class="bg-indigo-600 text-white p-4 rounded-xl shadow-lg text-center min-w-[120px]"
                >
                    <p class="text-xs uppercase font-bold opacity-80">
                        IPS Semester
                    </p>
                    <p class="text-3xl font-black">{{ ips }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b">
                        <tr>
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
                            <th
                                class="p-4 font-bold text-sm text-gray-600 text-center"
                            >
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="jadwal in krs.jadwal_kuliahs"
                            :key="jadwal.id"
                            class="border-b"
                        >
                            <td class="p-4 text-sm text-gray-500">
                                {{ jadwal.mata_kuliah.kode_mata_kuliah }}
                            </td>
                            <td class="p-4 font-medium text-gray-800">
                                {{ jadwal.mata_kuliah.nama_mata_kuliah }}
                            </td>
                            <td class="p-4 text-center">
                                {{ jadwal.beban_sks }}
                            </td>
                            <td class="p-4 text-center">
                                <span
                                    v-if="getNilai(jadwal.id)?.nilai_huruf"
                                    class="font-black text-lg text-indigo-700"
                                >
                                    {{ getNilai(jadwal.id).nilai_huruf }}
                                </span>
                                <span
                                    v-else
                                    class="text-gray-300 italic text-xs"
                                    >Belum ada nilai</span
                                >
                            </td>
                            <td class="p-4 text-center">
                                <span
                                    v-if="getNilai(jadwal.id)?.status_kelulusan"
                                    :class="
                                        getNilai(jadwal.id).status_kelulusan ===
                                        'Lulus'
                                            ? 'text-green-600 bg-green-50'
                                            : 'text-red-600 bg-red-50'
                                    "
                                    class="px-2 py-1 rounded text-xs font-bold uppercase"
                                >
                                    {{ getNilai(jadwal.id).status_kelulusan }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div
                    class="p-6 bg-gray-50 border-t flex justify-between items-center"
                >
                    <div class="text-sm text-gray-500">
                        * Nilai IPS dihitung berdasarkan bobot standar akademik.
                    </div>
                    <button
                        @click="window.print()"
                        class="bg-white border border-gray-300 px-4 py-2 rounded-lg text-sm font-bold flex items-center hover:bg-gray-100 transition"
                    >
                        <span class="material-icons text-sm mr-2">print</span>
                        Cetak KHS
                    </button>
                </div>
            </div>
        </div>
    </MahasiswaLayout>
</template>
