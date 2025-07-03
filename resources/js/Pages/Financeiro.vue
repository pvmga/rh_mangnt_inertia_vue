<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3';

defineOptions({
    layout: AppLayout
})
</script>

<template>

    <Head title="Financeiro" />

    <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
        <header>
            <section>
                <h2 class="text-lg font-medium text-gray-900">
                    Financeiro
                </h2>
                <p>Conteúdo da página inicial aqui...</p>
            </section>
        </header>
    </div>


</template>