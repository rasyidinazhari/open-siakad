<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import DosenLayout from '@/Layouts/DosenLayout.vue';
import { ref } from 'vue';

const props = defineProps({ krs: Object });
const showRejectModal = ref(false);

const rejectForm = useForm({ catatan: '' });

const approveKrs = () => {
    if (confirm('Setujui KRS mahasiswa ini?')) {
        useForm({}).post(route('dosen.perwalian.approve', props.krs.id));
    }
};

const submitReject = () => {
    rejectForm.post(route('dosen.perwalian.reject', props.krs.id), {
        onSuccess: () => showRejectModal.value = false
    });
};
</script>

<template>
    <Head title="Verifikasi KRS" />
    <DosenLayout>
        <div class="max-w-5xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <Link :href="route('dosen.perwalian.index')" class="flex items-center text-gray-600 hover:text-emerald-600">
                    <span class="material-icons mr-2">arrow_back</span> Kembali
                </Link>
                <div v-if="krs.status === 'Pending'" class="space-x-3">
                    <button @click="showRejectModal = true" class="bg-red-100 text-red-700 px-4 py-2 rounded-lg font-bold hover:bg-red-200">Tolak KRS</button>
                    <button @click="approveKrs" class="bg-emerald-600 text-white px-6 py-2 rounded-lg font-bold shadow-md hover:bg-emerald-700">Setujui KRS</button>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border p-8">
                <div class="grid grid-cols-2 gap-8 mb-8 border-b pb-8">
                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Mahasiswa</h4>
                        <p class="text-xl font-black text-gray-900">{{ krs.mahasiswa.user.name }}</p>
                        <p class="text-gray-500">{{ krs.mahasiswa.nim }} • {{ krs.mahasiswa.program_studi.nama_program_studi }}</p>
                    </div>
                    <div class="text-right">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Status Pengajuan</h4>
                        <span class="text-lg font-bold uppercase" :class="krs.status === 'Approved' ? 'text-green-600' : 'text-amber-600'">{{ krs.status }}</span>
                    </div>
                </div>

                <table class="w-full text-left">
                    <thead>
                        <tr class="text-gray-400 text-sm border-b">
                            <th class="py-4 font-medium">Mata Kuliah</th>
                            <th class="py-4 font-medium">Jadwal</th>
                            <th class="py-4 font-medium text-center">SKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="jadwal in krs.jadwal_kuliahs" :key="jadwal.id" class="border-b">
                            <td class="py-4 font-bold text-gray-800">{{ jadwal.mata_kuliah.nama_mata_kuliah }}</td>
                            <td class="py-4 text-sm text-gray-600">{{ jadwal.hari }}, {{ jadwal.waktu_kuliah.waktu_mulai }}</td>
                            <td class="py-4 text-center font-bold">{{ jadwal.beban_sks }}</td>
                        </tr>
                        <tr class="bg-gray-50 font-black">
                            <td colspan="2" class="py-4 px-4 text-right uppercase text-xs tracking-widest">Total SKS Diambil</td>
                            <td class="py-4 text-center text-xl">{{ krs.total_sks }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div v-if="showRejectModal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl p-6 max-w-md w-full shadow-2xl">
                <h3 class="text-lg font-bold mb-4">Alasan Penolakan KRS</h3>
                <textarea v-model="rejectForm.catatan" class="w-full border rounded-lg p-3 h-32 mb-4" placeholder="Contoh: SKS melebihi batas atau mata kuliah prasyarat belum diambil..."></textarea>
                <div class="flex justify-end space-x-3">
                    <button @click="showRejectModal = false" class="text-gray-500 font-bold">Batal</button>
                    <button @click="submitReject" class="bg-red-600 text-white px-4 py-2 rounded-lg font-bold">Kirim Penolakan</button>
                </div>
            </div>
        </div>
    </DosenLayout>
</template>