<template>
  <Modal :show="show" @close="emit('close')">
    <div class="p-6">
      <h2 class="text-lg font-semibold text-gray-800 mb-4">
        {{ modoEdicao ? 'Editar Usuário' : 'Cadastrar Novo Usuário' }}
      </h2>

      <form @submit.prevent="emit('confirmar')" class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Nome</label>
          <input
            :value="nome"
            type="text"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
            @input="emit('update:nome', $event.target.value)"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Email</label>
          <input
            :value="email"
            type="email"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
            @input="emit('update:email', $event.target.value)"
          />
        </div>

        <div class="flex justify-end">
          <button type="button" @click="emit('close')" class="mr-2 text-sm text-gray-600 hover:underline">
            Cancelar
          </button>
          <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm">
            Salvar
          </button>
        </div>
      </form>
    </div>
  </Modal>
</template>

<script setup>
import Modal from '@/Components/Modal.vue'

const props = defineProps({
  show: Boolean,
  nome: String,
  email: String,
  modoEdicao: Boolean
})

const emit = defineEmits(['close', 'confirmar', 'update:nome', 'update:email'])
</script>
