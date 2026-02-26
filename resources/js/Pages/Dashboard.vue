<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import Button from '@/Components/Button.vue'
</script>

<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800">Dashboard</h2>
    </template>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
      <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">Welcome to Project Management!</h1>
        
        <p class="text-gray-600 mb-6">
          You are logged in. Start by creating your first project or managing existing ones.
        </p>

        <Link :href="route('projects.index')">
          <Button>Go to Projects</Button>
        </Link>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
