<script setup>
import { Head, Link } from "@inertiajs/vue3";
import PmbLayout from "@/Layouts/PmbLayout.vue";

const props = defineProps({
    user: Object,
    pendaftaran: Object, // Data relasi pendaftaran calon mahasiswa
    tagihan_pmb: Object, // Data tagihan pendaftaran
});
</script>

<template>
    <Head title="Dashboard PMB" />
    <PmbLayout>
        <div class="mb-8">
            <h2 class="text-3xl font-black text-gray-800">
                Selamat Datang, {{ user?.name || "Calon Mahasiswa" }}! 👋
            </h2>
            <p
                v-if="tagihan_pmb?.nominal"
                class="text-2xl font-black text-amber-600 mb-4"
            >
                Rp {{ tagihan_pmb.nominal.toLocaleString("id-ID") }}
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border mb-8">
            <h3 class="text-lg font-bold text-gray-800 mb-6">
                Status Pendaftaran Anda
            </h3>

            <div
                class="flex flex-col md:flex-row justify-between items-center gap-4 text-center relative"
            >
                <div
                    class="hidden md:block absolute top-1/2 left-[10%] right-[10%] h-1 bg-gray-200 -z-10 -translate-y-1/2"
                ></div>

                <div class="flex flex-col items-center bg-white px-4">
                    <div
                        class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-white mb-2 shadow-md"
                        :class="pendaftaran ? 'bg-green-500' : 'bg-indigo-600'"
                    >
                        <span class="material-icons">{{
                            pendaftaran ? "check" : "person"
                        }}</span>
                    </div>
                    <span class="font-bold text-gray-800">1. Biodata</span>
                    <span
                        class="text-xs"
                        :class="
                            pendaftaran ? 'text-green-600' : 'text-indigo-600'
                        "
                        >{{ pendaftaran ? "Selesai" : "Pending" }}</span
                    >
                </div>

                <div class="flex flex-col items-center bg-white px-4">
                    <div
                        class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-white mb-2 shadow-md"
                        :class="
                            pendaftaran?.berkas_lengkap
                                ? 'bg-green-500'
                                : pendaftaran
                                  ? 'bg-indigo-600'
                                  : 'bg-gray-300'
                        "
                    >
                        <span class="material-icons">{{
                            pendaftaran?.berkas_lengkap
                                ? "check"
                                : "folder_open"
                        }}</span>
                    </div>
                    <span class="font-bold text-gray-800">2. Berkas</span>
                    <span class="text-xs text-gray-500">Ijazah, KK, dll</span>
                </div>

                <div class="flex flex-col items-center bg-white px-4">
                    <div
                        class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-white mb-2 shadow-md"
                        :class="
                            tagihan_pmb?.status === 'Lunas'
                                ? 'bg-green-500'
                                : pendaftaran?.berkas_lengkap
                                  ? 'bg-amber-500'
                                  : 'bg-gray-300'
                        "
                    >
                        <span class="material-icons">{{
                            tagihan_pmb?.status === "Lunas"
                                ? "check"
                                : "payments"
                        }}</span>
                    </div>
                    <span class="font-bold text-gray-800">3. Pembayaran</span>
                    <span class="text-xs text-gray-500">Biaya Pendaftaran</span>
                </div>

                <div class="flex flex-col items-center bg-white px-4">
                    <div
                        class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-white mb-2 shadow-md"
                        :class="
                            pendaftaran?.status_lulus === 'Lulus'
                                ? 'bg-green-500'
                                : 'bg-gray-300'
                        "
                    >
                        <span class="material-icons">school</span>
                    </div>
                    <span class="font-bold text-gray-800">4. Pengumuman</span>
                    <span class="text-xs text-gray-500">Hasil Seleksi</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div
                class="bg-white rounded-xl shadow-sm border p-6 hover:shadow-md transition border-l-4"
                :class="
                    pendaftaran ? 'border-l-green-500' : 'border-l-indigo-500'
                "
            >
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-800">
                        Lengkapi Biodata
                    </h3>
                    <span class="material-icons text-gray-400">badge</span>
                </div>
                <p class="text-gray-600 text-sm mb-6">
                    Isi data diri Anda dengan lengkap dan benar sesuai dokumen
                    resmi (KTP/KK).
                </p>
                <Link
                    v-if="!pendaftaran"
                    href="#"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow hover:bg-indigo-700"
                    >Isi Form Sekarang</Link
                >
                <Link
                    v-else
                    href="#"
                    class="bg-gray-100 text-gray-800 px-4 py-2 rounded-lg text-sm font-bold hover:bg-gray-200"
                    >Lihat / Edit Data</Link
                >
            </div>

            <div
                class="bg-white rounded-xl shadow-sm border p-6 hover:shadow-md transition border-l-4"
                :class="
                    tagihan_pmb?.status === 'Lunas'
                        ? 'border-l-green-500'
                        : 'border-l-amber-500'
                "
            >
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-800">
                        Biaya Pendaftaran
                    </h3>
                    <span class="material-icons text-gray-400"
                        >account_balance_wallet</span
                    >
                </div>
                <p class="text-gray-600 text-sm mb-6">
                    Lakukan pembayaran agar berkas pendaftaran Anda dapat
                    diproses oleh panitia.
                </p>

                <div v-if="tagihan_pmb?.status === 'Belum Lunas'">
                    <p class="text-2xl font-black text-amber-600 mb-4">
                        Rp {{ tagihan_pmb.nominal.toLocaleString("id-ID") }}
                    </p>
                    <button
                        class="bg-amber-500 text-white px-4 py-2 rounded-lg text-sm font-bold shadow hover:bg-amber-600 flex items-center"
                    >
                        <span class="material-icons text-sm mr-2">payment</span>
                        Bayar Sekarang (Midtrans)
                    </button>
                </div>
                <div
                    v-else-if="tagihan_pmb?.status === 'Lunas'"
                    class="bg-green-50 p-3 rounded-lg flex items-center text-green-800"
                >
                    <span class="material-icons mr-2">verified</span> Pembayaran
                    Lunas
                </div>
                <div v-else class="text-sm text-gray-400 italic">
                    Selesaikan biodata & berkas terlebih dahulu.
                </div>
            </div>
        </div>
    </PmbLayout>
</template>
