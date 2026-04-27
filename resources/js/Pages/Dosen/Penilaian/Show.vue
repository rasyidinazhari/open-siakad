<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import DosenLayout from "@/Layouts/DosenLayout.vue";
import { onMounted } from "vue";

const props = defineProps({
    jadwal: Object,
    peserta: Array,
});

// Menyiapkan form data yang berisi array peserta
const form = useForm({
    nilai: [],
});

// Mengisi data awal form saat komponen dimuat
onMounted(() => {
    form.nilai = props.peserta.map((p) => ({
        krs_detail_id: p.krs_detail_id,
        angka: p.nilai_angka || "", // Gunakan nilai string kosong jika null agar input text bersih
    }));
});

const submitNilai = () => {
    form.post(route("dosen.penilaian.store", props.jadwal.id), {
        preserveScroll: true,
        onSuccess: () => alert("Nilai berhasil disimpan!"),
    });
};
</script>

<template>
    <Head title="Input Nilai Kelas" />

    <DosenLayout>
        <div class="mb-6 flex justify-between items-center">
            <div>
                <Link
                    :href="route('dosen.penilaian.index')"
                    class="text-emerald-600 hover:underline flex items-center text-sm font-bold mb-2"
                >
                    <span class="material-icons text-sm mr-1">arrow_back</span>
                    Kembali ke Daftar Kelas
                </Link>
                <h2 class="text-2xl font-bold text-gray-800">
                    Input Nilai: {{ jadwal.mata_kuliah?.nama_mata_kuliah }}
                </h2>
                <p class="text-gray-500 mt-1">
                    Kelas: {{ jadwal.kelas }} | Hari: {{ jadwal.hari }}
                </p>
            </div>

            <button
                @click="submitNilai"
                :disabled="form.processing"
                class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-lg font-bold shadow transition disabled:bg-gray-400"
            >
                {{ form.processing ? "Menyimpan..." : "Simpan Nilai" }}
            </button>
        </div>

        <form @submit.prevent="submitNilai">
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden"
            >
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="p-4 w-12 text-center">No</th>
                            <th class="p-4 font-semibold text-sm">
                                Nama Mahasiswa
                            </th>
                            <th class="p-4 font-semibold text-sm">NIM</th>
                            <th class="p-4 font-semibold text-sm text-center">
                                Nilai Angka (0-100)
                            </th>
                            <th class="p-4 font-semibold text-sm text-center">
                                Nilai Huruf
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(p, index) in peserta"
                            :key="p.krs_detail_id"
                            class="border-b hover:bg-gray-50"
                        >
                            <td class="p-4 text-center text-gray-500">
                                {{ index + 1 }}
                            </td>
                            <td class="p-4 font-bold text-gray-800">
                                {{ p.nama_mahasiswa }}
                            </td>
                            <td class="p-4 text-gray-600">{{ p.nim }}</td>
                            <td class="p-4 text-center">
                                <input
                                    type="number"
                                    min="0"
                                    max="100"
                                    step="0.01"
                                    v-model="form.nilai[index].angka"
                                    class="w-24 text-center border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                                    placeholder="0"
                                />
                            </td>
                            <td class="p-4 text-center">
                                <span
                                    v-if="p.nilai_huruf"
                                    class="px-3 py-1 bg-gray-100 text-gray-800 font-bold rounded"
                                >
                                    {{ p.nilai_huruf }}
                                </span>
                                <span
                                    v-else
                                    class="text-gray-400 italic text-sm"
                                    >Belum dinilai</span
                                >
                            </td>
                        </tr>
                        <tr v-if="peserta.length === 0">
                            <td
                                colspan="5"
                                class="p-8 text-center text-gray-500"
                            >
                                Belum ada mahasiswa yang KRS-nya disetujui untuk
                                kelas ini.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </DosenLayout>
</template>
