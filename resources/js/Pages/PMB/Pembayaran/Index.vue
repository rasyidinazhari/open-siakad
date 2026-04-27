<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import PmbLayout from "@/Layouts/PmbLayout.vue";

const props = defineProps({
    pendaftaran: Object,
    nominal: Number,
    snapToken: String,
});

const bayarSekarang = () => {
    // Memanggil popup Midtrans menggunakan token dari controller
    window.snap.pay(props.snapToken, {
        onSuccess: function (result) {
            // Jika sukses, arahkan ke controller success
            router.post(route("pmb.pembayaran.success"), { result });
        },
        onPending: function (result) {
            alert("Menunggu pembayaran Anda!");
            console.log(result);
        },
        onError: function (result) {
            alert("Pembayaran gagal!");
            console.log(result);
        },
        onClose: function () {
            alert("Anda menutup jendela pembayaran tanpa menyelesaikannya.");
        },
    });
};
</script>

<template>
    <Head title="Pembayaran PMB" />
    <PmbLayout>
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Biaya Pendaftaran</h2>
            <p class="text-gray-500">
                Selesaikan pembayaran agar panitia dapat memverifikasi berkas
                Anda.
            </p>
        </div>

        <div
            class="bg-white rounded-xl shadow-sm border max-w-2xl overflow-hidden"
        >
            <div class="p-8">
                <div
                    class="flex items-center justify-between mb-8 border-b pb-6"
                >
                    <div>
                        <h3 class="text-sm font-bold text-gray-500 uppercase">
                            Total Tagihan
                        </h3>
                        <p class="text-4xl font-black text-gray-800 mt-1">
                            Rp {{ nominal.toLocaleString("id-ID") }}
                        </p>
                    </div>
                    <div
                        class="p-3 rounded-full"
                        :class="
                            pendaftaran.status_pembayaran === 'Lunas'
                                ? 'bg-green-100 text-green-600'
                                : 'bg-amber-100 text-amber-600'
                        "
                    >
                        <span class="material-icons text-3xl">{{
                            pendaftaran.status_pembayaran === "Lunas"
                                ? "verified"
                                : "hourglass_empty"
                        }}</span>
                    </div>
                </div>

                <div class="space-y-4 mb-8">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Nama Pendaftar</span>
                        <span class="font-bold text-gray-800">{{
                            $page.props.auth.user.name
                        }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Status Pembayaran</span>
                        <span
                            class="font-bold uppercase text-sm px-3 py-1 rounded"
                            :class="
                                pendaftaran.status_pembayaran === 'Lunas'
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-red-100 text-red-700'
                            "
                        >
                            {{ pendaftaran.status_pembayaran }}
                        </span>
                    </div>
                </div>

                <div
                    v-if="pendaftaran.status_pembayaran === 'Belum Lunas'"
                    class="bg-amber-50 border border-amber-200 p-4 rounded-lg mb-6"
                >
                    <p class="text-sm text-amber-800 font-medium">
                        Klik tombol di bawah ini untuk memilih metode pembayaran
                        (Transfer Bank, QRIS, GoPay, dll).
                    </p>
                </div>

                <div class="flex gap-4">
                    <button
                        v-if="pendaftaran.status_pembayaran === 'Belum Lunas'"
                        @click="bayarSekarang"
                        class="flex-1 bg-indigo-600 text-white py-3 rounded-lg font-bold shadow-lg hover:bg-indigo-700 transition"
                    >
                        Bayar Sekarang
                    </button>

                    <Link
                        v-if="pendaftaran.status_pembayaran === 'Lunas'"
                        :href="route('pmb.dashboard')"
                        class="flex-1 text-center bg-gray-800 text-white py-3 rounded-lg font-bold shadow hover:bg-gray-900 transition"
                    >
                        Kembali ke Dashboard
                    </Link>
                </div>
            </div>

            <div
                class="bg-gray-50 p-4 border-t text-center text-xs text-gray-500"
            >
                Pembayaran diproses secara aman oleh
                <strong>Midtrans Payment Gateway</strong>.
            </div>
        </div>
    </PmbLayout>
</template>
