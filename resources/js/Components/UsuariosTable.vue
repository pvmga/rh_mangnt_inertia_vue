<script setup>
const emit = defineEmits(['editar', 'confirmarExclusao'])

const props = defineProps({
    usuarios: Array
})

</script>

<template>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Criado em
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="usu in usuarios" :key="usu.id">
                    <td class="px-6 py-4">{{ usu.id }}</td>
                    <td class="px-6 py-4">{{ usu.name }}</td>
                    <td class="px-6 py-4">{{ usu.email }}</td>
                    <td class="px-6 py-4">{{ usu.created_at }}</td>
                    <td class="px-6 py-4 text-right">
                        <template v-if="usu.id !== 1">
                            <button @click="$emit('editar', usu)"
                                class="text-indigo-600 hover:underline mr-3">Editar</button>
                            <button @click="$emit('confirmarExclusao', usu)"
                                class="text-red-600 hover:underline">Excluir</button>
                        </template>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
