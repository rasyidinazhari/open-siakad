<script setup>
import { computed } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import MahasiswaLayout from "@/Layouts/MahasiswaLayout.vue";

const props = defineProps({
    mahasiswa: Object,
    jadwals: Array,
});

const form = useForm({
    jadwal_ids: [],
});

// Computed property untuk menghitung total SKS otomatis
const totalSks = computed(() => {
    return props.jadwals
        .filter((jadwal) => form.jadwal_ids.includes(jadwal.id))
        .reduce((sum, jadwal) => sum + Number(jadwal.beban_sks), 0);
});

const submitKrs = () => {
    // Validasi sederhana di frontend
    if (totalSks.value > 24) {
        alert("Total SKS tidak boleh melebihi 24 SKS.");
        return;
    }

    form.post(route("mahasiswa.krs.store"), {
        preserveScroll: true,
        onSuccess: () => alert("KRS Berhasil diajukan!"),
    });
};
</script>

<template>
    <Head title="Pengajuan KRS" />

    <MahasiswaLayout>
        <div class="mb-6 flex justify-between items-end">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Kartu Rencana Studi (KRS)
                </h2>
                <p class="text-gray-500 mt-1">
                    Pilih jadwal mata kuliah untuk semester berjalan.
                </p>
            </div>

            <div
                class="bg-indigo-900 text-white px-6 py-3 rounded-lg shadow-md flex items-center"
            >
                <span class="mr-4">Total SKS Terpilih:</span>
                <span
                    class="text-2xl font-black"
                    :class="{ 'text-red-400': totalSks > 24 }"
                    >{{ totalSks }}</span
                >
                <span class="ml-2 text-sm text-indigo-300">/ 24</span>
            </div>
        </div>

        <form @submit.prevent="submitKrs">
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden"
            >
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="p-4 w-12 text-center">Pilih</th>
                                <th class="p-4 font-semibold text-sm">
                                    Mata Kuliah
                                </th>
                                <th class="p-4 font-semibold text-sm">Dosen</th>
                                <th class="p-4 font-semibold text-sm">
                                    Jadwal & Ruang
                                </th>
                                <th
                                    class="p-4 font-semibold text-sm text-center"
                                >
                                    SKS
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="jadwal in jadwals"
                                :key="jadwal.id"
                                class="border-b hover:bg-indigo-50 transition"
                            >
                                <td class="p-4 text-center">
                                    <input
                                        type="checkbox"
                                        :value="jadwal.id"
                                        v-model="form.jadwal_ids"
                                        class="w-5 h-5 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500"
                                    />
                                </td>
                                <td class="p-4">
                                    <div class="font-bold text-gray-800">
                                        {{
                                            jadwal.mata_kuliah?.nama_mata_kuliah
                                        }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        Kelas: {{ jadwal.kelas }}
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="text-sm text-gray-700">
                                        {{ jadwal.dosen?.user?.name }}
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div
                                        class="text-sm font-medium text-gray-800"
                                    >
                                        {{ jadwal.hari }},
                                        {{ jadwal.waktu_kuliah?.waktu_mulai }} -
                                        {{ jadwal.waktu_kuliah?.waktu_selesai }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ jadwal.metode }} • R.
                                        {{ jadwal.ruang?.nama_ruang }}
                                    </div>
                                </td>
                                <td class="p-4 text-center">
                                    <span
                                        class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full font-bold"
                                    >
                                        {{ jadwal.beban_sks }}
                                    </span>
                                </td>
                            </tr>
                            <tr v-if="jadwals.length === 0">
                                <td
                                    colspan="5"
                                    class="p-8 text-center text-gray-500"
                                >
                                    Belum ada jadwal kuliah yang dibuka untuk
                                    saat ini.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="p-6 bg-gray-50 border-t flex justify-end">
                    <button
                        type="submit"
                        :disabled="
                            form.processing ||
                            form.jadwal_ids.length === 0 ||
                            totalSks > 24
                        "
                        class="bg-indigo-600 hover:bg-indigo-700 disabled:bg-gray-400 text-white px-8 py-3 rounded-lg font-bold shadow-md transition"
                    >
                        Ajukan KRS Sekarang
                    </button>
                </div>
            </div>
        </form>
    </MahasiswaLayout>
</template>
