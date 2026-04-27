<script setup>
import { Head, Link } from "@inertiajs/vue3";
import MahasiswaLayout from "@/Layouts/MahasiswaLayout.vue";

const props = defineProps({
    daftarKrs: Array,
});
</script>

<template>
    <Head title="Daftar KHS" />

    <MahasiswaLayout>
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800">
                Kartu Hasil Studi (KHS)
            </h2>
            <p class="text-gray-500 mt-1">
                Pilih periode semester untuk melihat detail perolehan nilai
                Anda.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div
                v-for="item in daftarKrs"
                :key="item.id"
                class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition group"
            >
                <div class="flex justify-between items-start mb-4">
                    <div
                        class="bg-indigo-100 text-indigo-700 p-3 rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition"
                    >
                        <span class="material-icons">history_edu</span>
                    </div>
                    <span
                        class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded uppercase"
                        >Terbit</span
                    >
                </div>

                <h3 class="text-lg font-bold text-gray-800">
                    Semester {{ item.semester }}
                </h3>
                <p class="text-sm text-gray-500 mb-6">
                    {{ item.tahun_akademik.nama_tahun }}
                </p>

                <div class="flex items-center justify-between border-t pt-4">
                    <div class="text-xs text-gray-400">
                        Total: <strong>{{ item.total_sks }} SKS</strong>
                    </div>
                    <Link
                        :href="route('mahasiswa.khs.show', item.id)"
                        class="text-indigo-600 font-bold text-sm flex items-center hover:underline"
                    >
                        Lihat Nilai
                        <span class="material-icons text-sm ml-1"
                            >arrow_forward</span
                        >
                    </Link>
                </div>
            </div>

            <div
                v-if="daftarKrs.length === 0"
                class="col-span-full bg-gray-50 border-2 border-dashed border-gray-200 rounded-xl p-12 text-center"
            >
                <span class="material-icons text-5xl text-gray-300 mb-4"
                    >description</span
                >
                <p class="text-gray-500 font-medium">
                    Belum ada data KHS yang tersedia.
                </p>
                <p class="text-sm text-gray-400">
                    Data KHS akan muncul setelah pengajuan KRS Anda disetujui
                    oleh Dosen Wali.
                </p>
            </div>
        </div>
    </MahasiswaLayout>
</template>
