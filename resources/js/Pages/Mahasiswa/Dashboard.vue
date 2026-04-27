<script setup>
import MahasiswaLayout from "@/Layouts/MahasiswaLayout.vue";
import PmbWizard from "./Partials/PmbWizard.vue";

const props = defineProps({
    mahasiswa: Object,
    dataWizard: Object,
});
</script>

<template>
    <MahasiswaLayout>
        <div v-if="$page.props.auth.user.roles.includes('Calon Mahasiswa')">
            <h2 class="text-2xl font-bold mb-4">Lengkapi Pendaftaran Anda</h2>
            <PmbWizard :dataWizard="dataWizard" />
        </div>
        <div v-else>
            <p>Selamat Datang di Portal Akademik.</p>
        </div>
    </MahasiswaLayout>
</template>
