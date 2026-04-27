<script setup>
import { Head } from "@inertiajs/vue3";
import PmbLayout from "@/Layouts/PmbLayout.vue";

const props = defineProps({
    pendaftaran: Object,
});
</script>

<template>
    <Head title="Pengumuman Seleksi" />
    <PmbLayout>
        <div class="max-w-3xl mx-auto mt-10">
            <div
                v-if="
                    !pendaftaran ||
                    pendaftaran.status_pembayaran === 'Belum Lunas'
                "
                class="bg-white p-10 rounded-2xl shadow-sm border text-center"
            >
                <span class="material-icons text-6xl text-gray-300 mb-4"
                    >lock</span
                >
                <h2 class="text-2xl font-bold text-gray-800">
                    Pengumuman Belum Tersedia
                </h2>
                <p class="text-gray-500 mt-2">
                    Selesaikan tahapan kelengkapan biodata, berkas, dan
                    pembayaran pendaftaran untuk melihat hasil seleksi.
                </p>
            </div>

            <div
                v-else-if="pendaftaran.status_lulus === 'Pending'"
                class="bg-white p-10 rounded-2xl shadow-sm border border-amber-200 text-center"
            >
                <span class="material-icons text-6xl text-amber-500 mb-4"
                    >hourglass_top</span
                >
                <h2 class="text-2xl font-bold text-gray-800">
                    Berkas Sedang Diproses
                </h2>
                <p class="text-gray-600 mt-2">
                    Terima kasih telah mendaftar. Panitia PMB saat ini sedang
                    memverifikasi berkas Anda. Silakan cek halaman ini secara
                    berkala.
                </p>
            </div>

            <div
                v-else-if="pendaftaran.status_lulus === 'Lulus'"
                class="bg-gradient-to-br from-green-500 to-emerald-700 p-10 rounded-2xl shadow-lg text-center text-white"
            >
                <span class="material-icons text-6xl mb-4">emoji_events</span>
                <h2 class="text-3xl font-black mb-2">SELAMAT! ANDA LULUS.</h2>
                <p class="text-green-100 font-medium mb-6">
                    Anda resmi diterima menjadi calon mahasiswa baru. Persiapkan
                    diri Anda untuk tahap selanjutnya.
                </p>
                <div class="bg-white/20 p-4 rounded-xl inline-block text-left">
                    <p
                        class="text-sm font-bold uppercase tracking-wider text-green-50"
                    >
                        Langkah Berikutnya:
                    </p>
                    <ul
                        class="list-disc list-inside mt-2 text-sm text-green-50"
                    >
                        <li>Melakukan pembayaran Daftar Ulang.</li>
                        <li>Mengambil Jaket Almamater.</li>
                        <li>Mengikuti kegiatan Pengenalan Kehidupan Kampus.</li>
                    </ul>
                </div>
            </div>

            <div
                v-else
                class="bg-red-50 p-10 rounded-2xl shadow-sm border border-red-200 text-center"
            >
                <span class="material-icons text-6xl text-red-400 mb-4"
                    >cancel</span
                >
                <h2 class="text-2xl font-bold text-red-800">
                    Mohon Maaf, Anda Tidak Lulus
                </h2>
                <p class="text-red-600 mt-2">
                    Jangan patah semangat. Anda masih dapat mencoba mendaftar
                    melalui jalur seleksi lainnya atau di periode tahun depan.
                </p>
            </div>
        </div>
    </PmbLayout>
</template>
