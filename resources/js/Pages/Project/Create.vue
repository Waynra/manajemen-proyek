<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, Link } from "@inertiajs/vue3";
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Textarea from "@/Components/Textarea.vue";
import Card from "@/Components/Card.vue";

const form = useForm({
    name: "",
    description: "",
});

const submit = () => {
    form.post(route("projects.store"));
};
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800">Create Project</h2>
        </template>

        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 py-12">
            <Card>
                <form @submit.prevent="submit" class="space-y-6">
                    <Input
                        v-model="form.name"
                        label="Project Name"
                        placeholder="Enter project name"
                        required
                        :errors="form.errors.name"
                    />

                    <Textarea
                        v-model="form.description"
                        label="Description"
                        placeholder="Enter project description (optional)"
                        :errors="form.errors.description"
                    />

                    <div class="flex gap-3 justify-end">
                        <Link :href="route('projects.index')">
                            <Button variant="outline">Cancel</Button>
                        </Link>
                        <Button :disabled="form.processing" type="submit">
                            {{
                                form.processing
                                    ? "Creating..."
                                    : "Create Project"
                            }}
                        </Button>
                    </div>
                </form>
            </Card>
        </div>
    </AuthenticatedLayout>
</template>
