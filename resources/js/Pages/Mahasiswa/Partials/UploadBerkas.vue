<script setup>
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    syaratPendaftaran: Array,
    berkasDiunggah: Array, // Data berkas yang sudah pernah diupload
});

const uploadForm = useForm({
    syarat_id: null,
    file: null,
});

const handleUpload = (syaratId, event) => {
    uploadForm.syarat_id = syaratId;
    uploadForm.file = event.target.files[0];
    uploadForm.post(route("pmb.upload_berkas"), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => uploadForm.reset(),
    });
};

// Fungsi untuk mengecek apakah berkas sudah diupload
const getStatus = (syaratId) => {
    const berkas = props.berkasDiunggah.find(
        (b) => b.syarat_pendaftaran_id === syaratId,
    );
    return berkas ? berkas.status : "Belum Diunggah";
};
</script>

<template>
    <div class="bg-white p-6 rounded-lg shadow-sm border mt-6">
        <h3 class="text-xl font-bold mb-4">Upload Berkas Persyaratan</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b bg-gray-50">
                        <th class="p-3 text-sm font-semibold">Nama Syarat</th>
                        <th class="p-3 text-sm font-semibold">Status</th>
                        <th class="p-3 text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="syarat in syaratPendaftaran"
                        :key="syarat.id"
                        class="border-b hover:bg-gray-50"
                    >
                        <td class="p-3">
                            <div class="font-medium">
                                {{ syarat.nama_syarat }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ syarat.deskripsi }}
                            </div>
                        </td>
                        <td class="p-3">
                            <span
                                :class="{
                                    'bg-yellow-100 text-yellow-800':
                                        getStatus(syarat.id) === 'Pending',
                                    'bg-green-100 text-green-800':
                                        getStatus(syarat.id) === 'Disetujui',
                                    'bg-red-100 text-red-800':
                                        getStatus(syarat.id) === 'Ditolak',
                                    'bg-gray-100 text-gray-800':
                                        getStatus(syarat.id) ===
                                        'Belum Diunggah',
                                }"
                                class="px-2 py-1 rounded text-xs font-bold uppercase"
                            >
                                {{ getStatus(syarat.id) }}
                            </span>
                        </td>
                        <td class="p-3">
                            <input
                                type="file"
                                @change="handleUpload(syarat.id, $event)"
                                class="text-xs block w-full text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                            />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
