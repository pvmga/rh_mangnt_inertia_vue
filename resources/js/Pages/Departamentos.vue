<script setup>
import { ref } from 'vue'
import { Head, router } from '@inertiajs/vue3'

// Components
import AppLayout from '@/Layouts/AppLayout.vue'
import DepartamentosTable from '@/Components/DepartamentosTable.vue'
import ModalConfirmarExclusao from '@/Components/ModalConfirmarExclusao.vue'
import ModalEditarDepartamentos from '@/Components/ModalEditarDepartamentos.vue'

defineOptions({ layout: AppLayout })

defineProps({ departamentos: Object })

const showModalExcluir = ref(false)
const showModalEditar = ref(false)

const usuarioSelecionado = ref(null)
const nome = ref('')
const modoEdicao = ref(false)

// Abrir modal de criação
const abrirModalNovo = () => {
  usuarioSelecionado.value = null
  nome.value = ''
  modoEdicao.value = false
  showModalEditar.value = true
}

// Abrir modal de edição
const abrirModalEditar = (departamento) => {
  console.log(departamento)
  modoEdicao.value = true
  showModalEditar.value = true
}

// Confimar criação ou edição
const confirmarEdicao = () => {

  const payload = { name: nome.value }

  router.post(`/departamentos`, payload, {
    onSuccess: () => {
        showModalEditar.value = false
      },
      onError: (errors) => {
        console.log(errors)
    }
  })
  
}

const abrirModalExcluir = (departamento) => {
  usuarioSelecionado.value = departamento
  showModalExcluir.value = true
}

const confirmarExclusao = () => {
  console.log('excluir')
}

const goToPage = (url) => {
  if (url) router.visit(url)
}
</script>

<template>

  <Head title="Departamentos" />

  <div v-if="$page.props.flash.success" class="mb-4 text-green-600 font-medium">
    {{ $page.props.flash.success }}
  </div>

  <div v-if="$page.props.flash.error" class="mb-4 text-red-600 font-medium">
    {{ $page.props.flash.error }}
  </div>

  <ModalConfirmarExclusao 
  :show="showModalExcluir"
  @close="showModalExcluir = false"
  @confirmar="confirmarExclusao"
  :nome="usuarioSelecionado?.name"
  />

  <ModalEditarDepartamentos 
    :show="showModalEditar"
    @close="showModalEditar = false"
    :modo-edicao="modoEdicao"
    @confirmar="confirmarEdicao"
    v-model:nome="nome"
  />

  <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
    <header class="flex items-center justify-between mb-6">
      <div>
        <h2 class="text-lg font-medium text-gray-900">Departamentos</h2>
        <p class="text-sm text-gray-600">Gerencie os Departamentos</p>
      </div>

      <button @click="abrirModalNovo" class="px-4 py-2 bg-indigo-600 text-white rounded text-sm hover:bg-indigo-700">
        Cadastrar Novo Departamento
      </button>
    </header>

    <DepartamentosTable 
      v-if="departamentos?.data"
      :departamentos="departamentos.data"
      @editar="abrirModalEditar"
      @confirmarExclusao="abrirModalExcluir"
    />
  </div>

  <nav class="flex justify-center mt-6">
    <ul class="inline-flex items-center space-x-1">
      <li v-for="link in departamentos.links" :key="link.label">
        <button v-html="link.label" @click.prevent="goToPage(link.url)" :disabled="!link.url" :class="[
          'px-3 py-2 border text-sm rounded',
          link.active
            ? 'bg-blue-600 text-white border-blue-600'
            : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100',
          !link.url && 'cursor-not-allowed text-gray-400'
        ]"></button>
      </li>
    </ul>
  </nav>

</template>
