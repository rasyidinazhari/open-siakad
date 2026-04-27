<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import MahasiswaLayout from "@/Layouts/MahasiswaLayout.vue";

const props = defineProps({ skripsi: Object, dosens: Array });

const form = useForm({
    judul: "",
    dosen_pembimbing_id: "",
    abstrak: "",
});

const submit = () => form.post(route("mahasiswa.skripsi.store"));
</script>

<template>
    <Head title="Skripsi / Tugas Akhir" />
    <MahasiswaLayout>
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Manajemen Skripsi / TA
            </h2>
            <p class="text-gray-500">
                Ajukan judul dan pantau perkembangan bimbingan akhir Anda.
            </p>
        </div>

        <div v-if="skripsi" class="bg-white p-8 rounded-xl shadow-sm border">
            <div class="flex justify-between items-start mb-6">
                <span
                    class="px-4 py-1 rounded-full text-xs font-bold uppercase"
                    :class="
                        skripsi.status === 'Disetujui'
                            ? 'bg-blue-100 text-blue-700'
                            : 'bg-amber-100 text-amber-700'
                    "
                >
                    Status: {{ skripsi.status }}
                </span>
            </div>
            <h3 class="text-xl font-black text-gray-900 mb-2">
                {{ skripsi.judul }}
            </h3>
            <p class="text-gray-600 text-sm mb-6">{{ skripsi.abstrak }}</p>
            <div class="border-t pt-4">
                <p class="text-xs font-bold text-gray-400 uppercase">
                    Dosen Pembimbing
                </p>
                <p class="font-bold text-gray-800">
                    {{ skripsi.pembimbing?.user?.name }}
                </p>
            </div>
        </div>

        <div v-else class="bg-white p-8 rounded-xl shadow-sm border max-w-2xl">
            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1"
                        >Judul Skripsi</label
                    >
                    <input
                        v-model="form.judul"
                        type="text"
                        class="w-full border-gray-300 rounded-lg shadow-sm"
                        placeholder="Masukkan judul penelitian..."
                    />
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1"
                        >Pilih Calon Pembimbing</label
                    >
                    <select
                        v-model="form.dosen_pembimbing_id"
                        class="w-full border-gray-300 rounded-lg shadow-sm"
                    >
                        <option value="">-- Pilih Dosen --</option>
                        <option
                            v-for="dosen in dosens"
                            :key="dosen.id"
                            :value="dosen.id"
                        >
                            {{ dosen.user.name }}
                        </option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1"
                        >Abstrak / Gambaran Umum</label
                    >
                    <textarea
                        v-model="form.abstrak"
                        class="w-full border-gray-300 rounded-lg shadow-sm h-32"
                    ></textarea>
                </div>
                <button
                    type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-bold shadow-md hover:bg-indigo-700 transition"
                >
                    Ajukan Judul Skripsi
                </button>
            </form>
        </div>
    </MahasiswaLayout>
</template>
