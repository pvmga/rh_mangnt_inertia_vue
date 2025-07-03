<template>
    <header class="h-16 border-b shadow flex items-center justify-between px-6"
        style="background-color: #F43180; color: white;">
        <h1 class="text-lg font-semibold text-white"></h1>

        <div class="flex items-center gap-4">
            <Dropdown align="right" width="48">
                <template #trigger>
                    <button
                        class="flex items-center text-sm font-medium text-white hover:text-gray-100 focus:outline-none gap-2">

                        <i class="fa-solid fa-user"></i> <!-- Ícone de perfil -->

                        <span class="truncate max-w-[150px]">{{ $page.props.auth.user.name }}</span>

                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                </template>

                <template #content>
                    <DropdownLink href="/profile">Perfil</DropdownLink>
                    <DropdownLink as="button" method="post" href="/logout" class="text-red-500">Sair</DropdownLink>
                </template>
            </Dropdown>
        </div>
    </header>

</template>

<script setup>
import Dropdown from '@/Components/Dropdown.vue'
import DropdownLink from '@/Components/DropdownLink.vue'
</script>
