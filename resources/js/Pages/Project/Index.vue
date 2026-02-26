<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import Button from '@/Components/Button.vue'
import Card from '@/Components/Card.vue'
import { useForm } from '@inertiajs/vue3'

const { projects } = usePage().props

const deleteProject = (project) => {
  if (confirm('Are you sure you want to delete this project?')) {
    useForm({}).delete(route('projects.destroy', project.id))
  }
}
</script>

<template>
  <AuthenticatedLayout>
    <template #header>
      <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800">Projects</h2>
        <Link :href="route('projects.create')">
          <Button>+ Create Project</Button>
        </Link>
      </div>
    </template>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
      <div v-if="projects.length > 0" class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        <Link v-for="project in projects" :key="project.id" :href="route('projects.show', project.id)" class="block group">
          <Card class="cursor-pointer hover:shadow-lg transition h-full">
            <div class="space-y-3">
              <h3 class="font-semibold text-lg text-gray-900 group-hover:text-blue-600">
                {{ project.name }}
              </h3>
              <p v-if="project.description" class="text-sm text-gray-600 line-clamp-2">
                {{ project.description }}
              </p>
              <div class="flex gap-2 pt-4">
                <Link :href="route('projects.edit', project.id)">
                  <Button size="sm" variant="outline">Edit</Button>
                </Link>
                <Button size="sm" variant="destructive" @click.prevent="deleteProject(project)">
                  Delete
                </Button>
              </div>
            </div>
          </Card>
        </Link>
      </div>

      <div v-else class="text-center py-12">
        <p class="text-gray-500 mb-4">No projects yet</p>
        <Link :href="route('projects.create')">
          <Button>Create your first project</Button>
        </Link>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
