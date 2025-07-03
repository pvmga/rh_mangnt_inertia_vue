<script setup>
import { usePage, Link } from '@inertiajs/vue3'

const page = usePage()

const navClass = (pathFragment) => {
    return [
        page.url.startsWith(pathFragment)
            ? 'bg-gray-200 text-indigo-700 font-semibold'
            : 'text-gray-700 hover:bg-gray-100',
        'block px-4 py-2 rounded'
    ]
}
</script>

<template>
    <aside class="w-64 bg-white shadow flex-shrink-0">
        <div class="h-16 flex items-center justify-center px-6 border-b">
            <img src="./../../../images/logo.png" alt="Logo" class="h-15" />
        </div>

        <nav class="px-4 py-4">
            <ul class="space-y-2">

                <li>
                    <Link :href="route('dashboard')" :class="navClass('/dashboard')">
                        <i class="fa-solid fa-chart-line"></i>
                        Dashboard
                    </Link>
                </li>
                
                <li>
                    <Link :href="route('financeiro')" :class="navClass('/financeiro')">
                    <i class="fa-solid fa-money-bill-wave"></i>
                    Financeiro
                    </Link>
                </li>

                <li>
                    <Link :href="route('departamentos.index')" :class="navClass('/departamentos')">
                    <i class="fa-solid fa-building"></i>
                    Departamentos
                    </Link>
                </li>

                <li>
                    <Link :href="route('usuarios.index')" :class="navClass('/usuarios')">
                    <i class="fa-solid fa-users"></i>
                    Usuários
                    </Link>
                </li>

                <li>
                    <Link :href="route('profile.edit')" :class="navClass('/profile')">
                    <i class="fa-solid fa-user"></i>
                    Perfil
                    </Link>
                </li>

                <li>
                    <Link :href="route('logout')" method="post" as="button"
                        class="block px-4 py-2 rounded text-red-500 hover:bg-gray-100">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Sair
                    </Link>
                </li>

            </ul>
        </nav>
    </aside>
</template>
