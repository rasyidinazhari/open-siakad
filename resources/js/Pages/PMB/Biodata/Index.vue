<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import PmbLayout from "@/Layouts/PmbLayout.vue";

// Jika data pendaftaran sudah ada, isi sebagai default value
const props = defineProps({
    pendaftaran: Object,
});

const form = useForm({
    // Jika props.pendaftaran ada, ambil nilainya. Jika tidak, baru kosongkan.
    nik: props.pendaftaran?.nik || "",
    tempat_lahir: props.pendaftaran?.tempat_lahir || "",
    tanggal_lahir: props.pendaftaran?.tanggal_lahir || "",
    jenis_kelamin: props.pendaftaran?.jenis_kelamin || "",
    alamat_lengkap: props.pendaftaran?.alamat_lengkap || "",
    asal_sekolah: props.pendaftaran?.asal_sekolah || "",
});

const submit = () => {
    form.post(route("pmb.biodata.store"));
};
</script>

<template>
    <Head title="Isi Biodata" />
    <PmbLayout>
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Lengkapi Biodata Diri
            </h2>
            <p class="text-gray-500">
                Pastikan data yang diisi sesuai dengan dokumen resmi (KTP/KK).
            </p>
        </div>

        <div class="bg-white p-8 rounded-xl shadow-sm border max-w-3xl">
            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1"
                        >Nomor Induk Kependudukan (NIK)</label
                    >
                    <input
                        v-model="form.nik"
                        type="text"
                        class="w-full border-gray-300 rounded-lg shadow-sm"
                        placeholder="Masukkan 16 digit NIK"
                        required
                    />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label
                            class="block text-sm font-bold text-gray-700 mb-1"
                            >Tempat Lahir</label
                        >
                        <input
                            v-model="form.tempat_lahir"
                            type="text"
                            class="w-full border-gray-300 rounded-lg shadow-sm"
                            required
                        />
                    </div>
                    <div>
                        <label
                            class="block text-sm font-bold text-gray-700 mb-1"
                            >Tanggal Lahir</label
                        >
                        <input
                            v-model="form.tanggal_lahir"
                            type="date"
                            class="w-full border-gray-300 rounded-lg shadow-sm"
                            required
                        />
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1"
                        >Jenis Kelamin</label
                    >
                    <select
                        v-model="form.jenis_kelamin"
                        class="w-full border-gray-300 rounded-lg shadow-sm"
                        required
                    >
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1"
                        >Alamat Lengkap</label
                    >
                    <textarea
                        v-model="form.alamat_lengkap"
                        rows="3"
                        class="w-full border-gray-300 rounded-lg shadow-sm"
                        placeholder="Sesuai KTP"
                        required
                    ></textarea>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1"
                        >Asal Sekolah (SMA/SMK/Sederajat)</label
                    >
                    <input
                        v-model="form.asal_sekolah"
                        type="text"
                        class="w-full border-gray-300 rounded-lg shadow-sm"
                        required
                    />
                </div>

                <div class="pt-4 border-t flex justify-end">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-bold shadow hover:bg-indigo-700 transition disabled:bg-indigo-400"
                    >
                        {{
                            form.processing
                                ? "Menyimpan..."
                                : "Simpan & Lanjut ke Berkas"
                        }}
                    </button>
                </div>
            </form>
        </div>
    </PmbLayout>
</template>
