<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'
import { onMounted } from 'vue'
import Chart from 'chart.js/auto'

defineOptions({
  layout: AppLayout
})

const transacoes = [
  { data: '02/07/2025', descricao: 'Venda produto X', valor: '1.200,00', tipo: 'receita' },
  { data: '01/07/2025', descricao: 'Pagamento fornecedor', valor: '850,00', tipo: 'despesa' },
  { data: '30/06/2025', descricao: 'Mensalidade cliente Y', valor: '3.500,00', tipo: 'receita' },
  { data: '29/06/2025', descricao: 'Internet escritório', valor: '200,00', tipo: 'despesa' },
]

onMounted(() => {
  const ctx = document.getElementById('graficoFinanceiro')
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
      datasets: [
        {
          label: 'Receita',
          data: [4000, 4200, 4800, 5000, 5300, 5500],
          backgroundColor: '#22c55e',
        },
        {
          label: 'Despesas',
          data: [2500, 2600, 2800, 3000, 3200, 3400],
          backgroundColor: '#ef4444',
        },
      ],
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
        },
      },
    },
  })
})
</script>

<template>
  <Head title="Dashboard" />

  <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 space-y-8">
    <!-- Título -->
    <header>
      <h2 class="text-lg font-medium text-gray-900">Dashboard</h2>
      <p class="text-sm text-gray-500">Resumo financeiro da sua aplicação</p>
    </header>

    <!-- Cards resumo -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div class="bg-gray-50 rounded-2xl shadow p-5 border">
        <p class="text-sm text-gray-500">Receita Total</p>
        <p class="text-2xl font-semibold text-green-600">R$ 15.200,00</p>
      </div>

      <div class="bg-gray-50 rounded-2xl shadow p-5 border">
        <p class="text-sm text-gray-500">Despesas</p>
        <p class="text-2xl font-semibold text-red-500">R$ 8.740,00</p>
      </div>

      <div class="bg-gray-50 rounded-2xl shadow p-5 border">
        <p class="text-sm text-gray-500">Saldo Atual</p>
        <p class="text-2xl font-semibold text-blue-600">R$ 6.460,00</p>
      </div>
    </div>

    <!-- Gráfico -->
    <div class="bg-gray-50 rounded-2xl shadow p-6 border">
      <h2 class="text-lg font-semibold mb-4 text-gray-700">Visão Geral Mensal</h2>
      <canvas id="graficoFinanceiro" height="100"></canvas>
    </div>

    <!-- Tabela de transações -->
    <div class="bg-gray-50 rounded-2xl shadow p-6 border">
      <h2 class="text-lg font-semibold mb-4 text-gray-700">Últimas Transações</h2>
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="text-sm text-gray-600 border-b">
            <th class="py-2">Data</th>
            <th class="py-2">Descrição</th>
            <th class="py-2">Valor</th>
            <th class="py-2">Tipo</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(transacao, index) in transacoes"
            :key="index"
            class="border-b text-sm hover:bg-gray-100 transition"
          >
            <td class="py-2">{{ transacao.data }}</td>
            <td class="py-2">{{ transacao.descricao }}</td>
            <td
              class="py-2 font-medium"
              :class="{
                'text-green-600': transacao.tipo === 'receita',
                'text-red-500': transacao.tipo === 'despesa'
              }"
            >
              R$ {{ transacao.valor }}
            </td>
            <td class="py-2 capitalize">{{ transacao.tipo }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
