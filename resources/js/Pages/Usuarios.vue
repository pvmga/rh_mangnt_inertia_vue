<script setup>
import { ref } from 'vue'
import { Head, router } from '@inertiajs/vue3'

// Components
import AppLayout from '@/Layouts/AppLayout.vue'
import UsuariosTable from '@/Components/UsuariosTable.vue'
import ModalConfirmarExclusao from '@/Components/ModalConfirmarExclusao.vue'
import ModalEditar from '@/Components/ModalEditar.vue'

defineOptions({ layout: AppLayout })

defineProps({ usuarios: Object })

const showModalExcluir = ref(false)
const showModalEditar = ref(false)

const usuarioSelecionado = ref(null)
const nome = ref('')
const email = ref('')
const modoEdicao = ref(false)

// Abrir modal de criação
const abrirModalNovo = () => {
  usuarioSelecionado.value = null
  nome.value = ''
  email.value = ''
  modoEdicao.value = false
  showModalEditar.value = true
}

// Abrir modal de edição
const abrirModalEditar = (usuario) => {
  usuarioSelecionado.value = usuario
  nome.value = usuario.name
  email.value = usuario.email
  modoEdicao.value = true
  showModalEditar.value = true
}

// Confirmar criação ou edição
const confirmarEdicao = () => {
  const payload = { name: nome.value, email: email.value }

  if (modoEdicao.value) {
    router.put(`/usuarios/${usuarioSelecionado.value.id}`, payload, {
      onSuccess: () => {
        showModalEditar.value = false
      },
      onError: (errors) => {
        console.log(errors)
      }
    })
  } else {
    payload.password = '12345678'

    router.post(`/usuarios`, payload, {
      onSuccess: () => {
        showModalEditar.value = false
      },
      onError: (errors) => {
        console.log(errors)
      }
    })
  }
}

// Confirmar exclusão
const abrirModalExcluir = (usuario) => {
  usuarioSelecionado.value = usuario
  showModalExcluir.value = true
}

const confirmarExclusao = () => {
  router.delete(`/usuarios/${usuarioSelecionado.value.id}`, {
    onSuccess: () => {
      showModalExcluir.value = false
      usuarioSelecionado.value = null
    }
  })
}

const goToPage = (url) => {
  if (url) router.visit(url)
}
</script>

<template>

  <Head title="Usuários" />

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

  <ModalEditar 
    :show="showModalEditar"
    @close="showModalEditar = false"
    :modo-edicao="modoEdicao"
    :nome="nome"
    :email="email"
    v-model:nome="nome"
    v-model:email="email"
    @confirmar="confirmarEdicao"
  />

  <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
    <header class="flex items-center justify-between mb-6">
      <div>
        <h2 class="text-lg font-medium text-gray-900">Usuários</h2>
        <p class="text-sm text-gray-600">Gerencie os Usuários</p>
      </div>

      <button @click="abrirModalNovo" class="px-4 py-2 bg-indigo-600 text-white rounded text-sm hover:bg-indigo-700">
        Cadastrar Novo Usuário
      </button>
    </header>

    <UsuariosTable 
      v-if="usuarios?.data"
      :usuarios="usuarios.data"
      @editar="abrirModalEditar"
      @confirmarExclusao="abrirModalExcluir" />
  </div>

  <nav class="flex justify-center mt-6">
    <ul class="inline-flex items-center space-x-1">
      <li v-for="link in usuarios.links" :key="link.label">
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
