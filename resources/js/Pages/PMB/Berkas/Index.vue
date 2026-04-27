<script setup>
// PERBAIKAN 1: Tambahkan Link di sini
import { Head, useForm, Link } from "@inertiajs/vue3";
import PmbLayout from "@/Layouts/PmbLayout.vue";

const props = defineProps({
    pendaftaran: Object,
});

const form = useForm({
    berkas: null,
    jenis_berkas: "",
});

const uploadBerkas = (jenis) => {
    form.jenis_berkas = jenis;
    form.post(route("pmb.berkas.store"), {
        forceFormData: true,
        onSuccess: () => {
            form.reset("berkas");
            // PERBAIKAN 2: Menggunakan ID dinamis sesuai jenis berkas
            document.getElementById("fileInput-" + jenis).value = "";
        },
    });
};

const listSyarat = [
    { id: "foto", nama: "Pas Foto Terbaru (3x4)", key: "path_foto" },
    { id: "ijazah", nama: "Scan Ijazah / SKL", key: "path_ijazah" },
    { id: "kk", nama: "Scan Kartu Keluarga", key: "path_kk" },
    { id: "ktp", nama: "Scan KTP / Kartu Pelajar", key: "path_ktp" },
];
</script>

<template>
    <Head title="Upload Berkas" />
    <PmbLayout>
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Upload Berkas Persyaratan
            </h2>
            <p class="text-gray-500">
                Unggah dokumen dalam format PDF atau Gambar (Maks. 2MB).
            </p>
        </div>

        <div class="grid grid-cols-1 gap-4 max-w-4xl">
            <div
                v-for="syarat in listSyarat"
                :key="syarat.id"
                class="bg-white p-5 rounded-xl border flex flex-col md:flex-row md:items-center justify-between gap-4 shadow-sm"
            >
                <div class="flex items-center gap-4">
                    <div
                        class="p-3 rounded-lg"
                        :class="
                            pendaftaran?.[syarat.key]
                                ? 'bg-green-100 text-green-600'
                                : 'bg-gray-100 text-gray-400'
                        "
                    >
                        <span class="material-icons">{{
                            pendaftaran?.[syarat.key]
                                ? "check_circle"
                                : "description"
                        }}</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800">
                            {{ syarat.nama }}
                        </h4>
                        <p
                            class="text-xs"
                            :class="
                                pendaftaran?.[syarat.key]
                                    ? 'text-green-600'
                                    : 'text-red-500'
                            "
                        >
                            {{
                                pendaftaran?.[syarat.key]
                                    ? "Berkas sudah terunggah"
                                    : "Wajib diunggah"
                            }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a
                        v-if="pendaftaran?.[syarat.key]"
                        :href="'/storage/' + pendaftaran[syarat.key]"
                        target="_blank"
                        class="text-indigo-600 hover:bg-indigo-50 px-3 py-2 rounded-lg text-sm font-medium border border-indigo-200 transition"
                    >
                        Lihat Berkas
                    </a>

                    <div class="flex items-center gap-2">
                        <input
                            :id="'fileInput-' + syarat.id"
                            type="file"
                            @input="form.berkas = $event.target.files[0]"
                            class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                        />
                        <button
                            @click="uploadBerkas(syarat.id)"
                            :disabled="
                                form.processing ||
                                !form.berkas ||
                                (form.jenis_berkas !== syarat.id &&
                                    form.processing)
                            "
                            class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-xs font-bold shadow hover:bg-indigo-700 disabled:bg-gray-300 transition"
                        >
                            {{
                                form.processing &&
                                form.jenis_berkas === syarat.id
                                    ? "Loading..."
                                    : "Upload"
                            }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10 flex justify-end max-w-4xl">
            <Link
                :href="route('pmb.dashboard')"
                class="bg-gray-800 text-white px-10 py-3 rounded-xl font-bold shadow-lg hover:bg-gray-900 transition"
            >
                Selesai & Ke Dashboard
            </Link>
        </div>
    </PmbLayout>
</template>
