<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    dataWizard: Object,
});

const step = ref(1);

const form = useForm({
    nik: "",
    nomor_telepon: "",
    jenis_kelamin: "",
    agama: "",
    tempat_lahir: "",
    tanggal_lahir: "",
    alamat_lengkap: "",
    rt: "",
    rw: "",
    desa_kelurahan: "",
    kecamatan: "",
    kota_kabupaten: "",
    provinsi: "",
    kode_pos: "",
    jalur_pendaftaran_id: "",
    gelombang_id: "",
    jenis_kelas_id: "",
    prodi_pilihan_1: "",
    prodi_pilihan_2: "",
});

const submit = () => {
    form.post(route("pmb.store"), {
        onSuccess: () => alert("Data berhasil disimpan!"),
    });
};
</script>

<template>
    <div class="bg-white p-8 rounded-lg shadow">
        <div class="flex mb-8 justify-between">
            <div
                v-for="i in 3"
                :key="i"
                :class="step >= i ? 'text-indigo-600' : 'text-gray-400'"
            >
                Step {{ i }}
            </div>
        </div>

        <form @submit.prevent="submit">
            <div v-if="step === 1" class="space-y-4">
                <h3 class="text-lg font-bold">Biodata Pribadi</h3>
                <input
                    v-model="form.nik"
                    placeholder="NIK"
                    class="w-full border rounded p-2"
                />
                <select
                    v-model="form.jenis_kelamin"
                    class="w-full border rounded p-2"
                >
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
                <button
                    type="button"
                    @click="step = 2"
                    class="bg-indigo-600 text-white px-4 py-2 rounded"
                >
                    Lanjut
                </button>
            </div>

            <div v-if="step === 2">
                <h3 class="text-lg font-bold">Alamat Lengkap</h3>
                <textarea
                    v-model="form.alamat_lengkap"
                    class="w-full border rounded p-2"
                ></textarea>
                <div class="flex space-x-2">
                    <button type="button" @click="step = 1">Kembali</button>
                    <button
                        type="button"
                        @click="step = 3"
                        class="bg-indigo-600 text-white px-4 py-2 rounded"
                    >
                        Lanjut
                    </button>
                </div>
            </div>

            <div v-if="step === 3" class="space-y-4">
                <h3 class="text-lg font-bold">Pilihan Program Studi</h3>
                <select
                    v-model="form.jalur_pendaftaran_id"
                    class="w-full border rounded p-2"
                >
                    <option v-for="j in dataWizard.jalurs" :value="j.id">
                        {{ j.nama_jalur }}
                    </option>
                </select>
                <select
                    v-model="form.prodi_pilihan_1"
                    class="w-full border rounded p-2"
                >
                    <option v-for="p in dataWizard.prodis" :value="p.id">
                        {{ p.nama_program_studi }}
                    </option>
                </select>
                <div class="flex space-x-2">
                    <button type="button" @click="step = 2">Kembali</button>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="bg-green-600 text-white px-4 py-2 rounded"
                    >
                        Submit Pendaftaran
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>
