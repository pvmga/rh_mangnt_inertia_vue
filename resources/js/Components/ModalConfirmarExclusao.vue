<template>
  <Modal :show="show" @close="emit('close')">
    <div class="p-6">
      <h2 class="text-lg font-semibold text-gray-800 mb-4 text-danger">Confirmar Exclusão</h2>

      <div class="mb-6">
        <p class="text-gray-700">
          Tem certeza que deseja excluir <strong>{{ nome }}</strong>?
        </p>
      </div>

      <div class="flex justify-end">
        <button
          type="button"
          @click="emit('close')"
          class="mr-2 text-sm text-gray-600 hover:underline"
        >
          Cancelar
        </button>
        <button
          type="button"
          @click="emit('confirmar')"
          class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm"
        >
          Excluir
        </button>
      </div>
    </div>
  </Modal>
</template>

<script setup>
import Modal from '@/Components/Modal.vue'

const props = defineProps({
  show: Boolean,
  nome: String,
})

const emit = defineEmits(['close', 'confirmar'])
</script>
