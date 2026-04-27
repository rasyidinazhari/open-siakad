<script setup>
import { Head, Link } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Tentang Kami" />

    <div class="min-h-screen bg-gray-50">
        <nav
            class="bg-white border-b px-6 py-4 flex justify-between items-center"
        >
            <Link
                href="/"
                class="flex items-center gap-2 text-indigo-600 hover:text-indigo-800"
            >
                <span class="material-icons">arrow_back</span>
                <span class="font-bold">Kembali ke Beranda</span>
            </Link>
        </nav>

        <div class="max-w-5xl mx-auto py-16 px-6">
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-4">
                    Tentang Kampus Kami
                </h1>
                <p class="text-xl text-gray-500">
                    Berdedikasi untuk mencetak generasi unggul berbasis
                    teknologi.
                </p>
            </div>

            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-20"
            >
                <div>
                    <img
                        src="about.jpg"
                        alt="Kampus"
                        class="rounded-2xl shadow-xl border-4 border-white"
                    />
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">
                        Visi Kami
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Menjadi perguruan tinggi terkemuka yang menyelenggarakan
                        pendidikan berkualitas, penelitian inovatif, dan
                        pengabdian masyarakat yang berdampak nyata pada kemajuan
                        peradaban.
                    </p>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">
                        Misi Kami
                    </h2>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-start">
                            <span class="material-icons text-indigo-500 mr-2"
                                >check_circle</span
                            >
                            Menyelenggarakan proses pembelajaran interaktif dan
                            modern.
                        </li>
                        <li class="flex items-start">
                            <span class="material-icons text-indigo-500 mr-2"
                                >check_circle</span
                            >
                            Mengembangkan kurikulum yang adaptif terhadap
                            kebutuhan industri.
                        </li>
                        <li class="flex items-start">
                            <span class="material-icons text-indigo-500 mr-2"
                                >check_circle</span
                            >
                            Membangun ekosistem penelitian dan wirausaha di
                            kalangan mahasiswa.
                        </li>
                    </ul>
                </div>
            </div>

            <div
                class="bg-indigo-900 text-white rounded-3xl p-12 grid grid-cols-1 md:grid-cols-3 gap-8 text-center shadow-2xl"
            >
                <div>
                    <span class="block text-5xl font-black mb-2">15+</span>
                    <span
                        class="text-indigo-200 font-medium uppercase tracking-wider"
                        >Program Studi</span
                    >
                </div>
                <div>
                    <span class="block text-5xl font-black mb-2">10k+</span>
                    <span
                        class="text-indigo-200 font-medium uppercase tracking-wider"
                        >Mahasiswa Aktif</span
                    >
                </div>
                <div>
                    <span class="block text-5xl font-black mb-2">95%</span>
                    <span
                        class="text-indigo-200 font-medium uppercase tracking-wider"
                        >Lulusan Terserap Kerja</span
                    >
                </div>
            </div>
        </div>
    </div>
</template>
