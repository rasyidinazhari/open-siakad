<script setup>
import { Head } from "@inertiajs/vue3";
import MahasiswaLayout from "@/Layouts/MahasiswaLayout.vue";

const props = defineProps({
    tagihan: Array,
});
</script>

<template>
    <Head title="Tagihan Kuliah" />

    <MahasiswaLayout>
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Tagihan Kuliah</h2>
            <p class="text-gray-500 mt-1">
                Rincian kewajiban keuangan akademik Anda.
            </p>
        </div>

        <div
            class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded mb-6 flex items-start"
        >
            <span class="material-icons text-blue-500 mr-3">info</span>
            <div>
                <strong class="block text-blue-800">Informasi Penting</strong>
                <span class="text-sm text-blue-700"
                    >Pelunasan tagihan semester berjalan adalah syarat wajib
                    untuk dapat melakukan pengisian Kartu Rencana Studi
                    (KRS).</span
                >
            </div>
        </div>

        <div
            class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden"
        >
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="p-4 font-semibold text-sm">Nama Tagihan</th>
                        <th class="p-4 font-semibold text-sm">
                            Tahun Akademik
                        </th>
                        <th class="p-4 font-semibold text-sm">Jatuh Tempo</th>
                        <th class="p-4 font-semibold text-sm text-right">
                            Nominal
                        </th>
                        <th class="p-4 font-semibold text-sm text-center">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="item in tagihan"
                        :key="item.id"
                        class="border-b hover:bg-gray-50 transition"
                    >
                        <td class="p-4 font-bold text-gray-800">
                            {{ item.nama_tagihan }}
                        </td>
                        <td class="p-4 text-sm text-gray-600">
                            {{ item.tahun_akademik?.nama_tahun }}
                        </td>
                        <td class="p-4 text-sm text-red-600 font-medium">
                            {{ item.tenggat_waktu }}
                        </td>
                        <td class="p-4 text-right font-bold font-mono">
                            Rp {{ item.nominal.toLocaleString("id-ID") }}
                        </td>
                        <td class="p-4 text-center">
                            <span
                                :class="{
                                    'bg-green-100 text-green-800':
                                        item.status === 'Lunas',
                                    'bg-red-100 text-red-800':
                                        item.status === 'Belum Lunas',
                                }"
                                class="px-3 py-1 rounded-full text-xs font-bold uppercase"
                            >
                                {{ item.status }}
                            </span>
                        </td>
                    </tr>
                    <tr v-if="tagihan.length === 0">
                        <td colspan="5" class="p-8 text-center text-gray-500">
                            <span
                                class="material-icons text-4xl mb-2 text-gray-300"
                                >receipt_long</span
                            >
                            <p>Tidak ada tagihan aktif saat ini.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </MahasiswaLayout>
</template>
