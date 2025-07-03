<template>
    <div class="flex h-screen bg-gray-100">
        <Sidebar/>

        <div class="flex-1 flex flex-col overflow-hidden">
            <TopBar/>

            <main class="flex-1 overflow-y-auto p-6 bg-gray-100">
                <slot/>
            </main>
        </div>
    </div>
</template>

<script setup>
import TopBar from '@/Layouts/TopBar.vue'
import Sidebar from '@/Layouts/SideBar.vue'
</script>
