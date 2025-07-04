<script setup>
import LogoHeader from '@/Components/LogoHeader.vue'
import { usePage, Link } from '@inertiajs/vue3'

const page = usePage()

const navClass = (pathFragment) => {
    return [
        page.url.startsWith(pathFragment)
            ? 'bg-gray-200 text-indigo-700 font-semibold'
            : 'text-gray-700 hover:bg-gray-100 transition-colors duration-200',
        'block px-4 py-2 rounded flex items-center gap-2'
    ]
}
</script>

<template>
    <aside class="w-64 bg-white shadow flex-shrink-0">
        <!-- Logo -->
        <LogoHeader />

        <!-- Menu -->
        <nav class="px-4 py-4 flex flex-col justify-between h-[calc(100vh-4rem)]">
            <ul class="space-y-2">
                <li>
                    <Link :href="route('dashboard')" :class="navClass('/dashboard')">
                        <i class="fa-solid fa-chart-line"></i>
                        <span>Dashboard</span>
                    </Link>
                </li>

                <li>
                    <Link :href="route('financeiro.index')" :class="navClass('/financeiro')">
                        <i class="fa-solid fa-money-bill-wave"></i>
                        <span>Financeiro</span>
                    </Link>
                </li>

                <li>
                    <Link :href="route('departamentos.index')" :class="navClass('/departamentos')">
                        <i class="fa-solid fa-building"></i>
                        <span>Departamentos</span>
                    </Link>
                </li>

                <li>
                    <Link :href="route('usuarios.index')" :class="navClass('/usuarios')">
                        <i class="fa-solid fa-users"></i>
                        <span>Usuários</span>
                    </Link>
                </li>

                <li>
                    <Link :href="route('profile.edit')" :class="navClass('/profile')">
                        <i class="fa-solid fa-user"></i>
                        <span>Perfil</span>
                    </Link>
                </li>
            </ul>

            <!-- Botão sair separado -->
            <div class="mt-8 border-t pt-4">
                <Link :href="route('logout')" method="post" as="button"
                    class="block px-4 py-2 rounded text-red-500 hover:bg-gray-100 flex items-center gap-2 transition-colors duration-200">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Sair</span>
                </Link>
            </div>
        </nav>
    </aside>
</template>
