<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
  mensagem: String,
  tipo: String
});

const mostrar = ref(false);

const tipoClasses = {
  green: 'bg-green-100 border-green-400 text-green-800',
  red: 'bg-red-100 border-red-400 text-red-800',
  yellow: 'bg-yellow-100 border-yellow-400 text-yellow-800',
  blue: 'bg-blue-100 border-blue-400 text-blue-800'
};

watch(() => props.mensagem, (val) => {
  if (val) {
    mostrar.value = true;
    setTimeout(() => {
      mostrar.value = false;
    }, 3000);
  }
});
</script>

<template>
  <div v-if="mostrar" :class="['mt-4 p-4 rounded-md border', tipoClasses[props.tipo] || tipoClasses.green]">
    {{ props.mensagem }}
  </div>
</template>
