<script setup>
import { Head, Link } from "@inertiajs/vue3";
import DosenLayout from "@/Layouts/DosenLayout.vue";

const props = defineProps({ perwalian: Array });
</script>

<template>
    <Head title="Perwalian KRS" />
    <DosenLayout>
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Daftar Perwalian KRS
            </h2>
            <p class="text-gray-500">
                Pantau dan verifikasi pengajuan KRS mahasiswa bimbingan Anda.
            </p>
        </div>

        <div
            class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden"
        >
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="p-4 font-semibold text-sm">Mahasiswa</th>
                        <th class="p-4 font-semibold text-sm">
                            Tahun Akademik
                        </th>
                        <th class="p-4 font-semibold text-sm text-center">
                            Total SKS
                        </th>
                        <th class="p-4 font-semibold text-sm">Status</th>
                        <th class="p-4 font-semibold text-sm text-center">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="item in perwalian"
                        :key="item.id"
                        class="border-b hover:bg-gray-50"
                    >
                        <td class="p-4">
                            <div class="font-bold text-gray-800">
                                {{ item.mahasiswa.user.name }}
                            </div>
                            <div class="text-xs text-gray-500">
                                NIM: {{ item.mahasiswa.nim }}
                            </div>
                        </td>
                        <td class="p-4 text-sm">
                            {{ item.tahun_akademik.nama_tahun }}
                        </td>
                        <td class="p-4 text-center font-bold">
                            {{ item.total_sks }}
                        </td>
                        <td class="p-4">
                            <span
                                :class="{
                                    'bg-yellow-100 text-yellow-800':
                                        item.status === 'Pending',
                                    'bg-green-100 text-green-800':
                                        item.status === 'Approved',
                                    'bg-red-100 text-red-800':
                                        item.status === 'Rejected',
                                }"
                                class="px-3 py-1 rounded-full text-xs font-bold uppercase"
                            >
                                {{ item.status }}
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <Link
                                :href="route('dosen.perwalian.show', item.id)"
                                class="text-emerald-600 hover:underline font-medium"
                            >
                                Detail & Verifikasi
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </DosenLayout>
</template>
