<script setup>
import { useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Button from "@/Components/Button.vue";
import Card from "@/Components/Card.vue";
import Input from "@/Components/Input.vue";
import Textarea from "@/Components/Textarea.vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    name: props.project.name,
    description: props.project.description,
});

const submitForm = () => {
    form.put(route("projects.update", props.project.id), {
        onSuccess: () => {
            window.location.href = route("projects.show", props.project.id);
        },
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800">Edit Project</h2>
        </template>

        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 py-12">
            <Card>
                <form @submit.prevent="submitForm" class="space-y-6">
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
                        placeholder="Enter project description"
                        :errors="form.errors.description"
                    />

                    <div class="flex gap-3 justify-end">
                        <Link :href="route('projects.show', project.id)">
                            <Button variant="outline">Cancel</Button>
                        </Link>
                        <Button :disabled="form.processing" type="submit">
                            {{ form.processing ? "Saving..." : "Save Changes" }}
                        </Button>
                    </div>
                </form>
            </Card>
        </div>
    </AuthenticatedLayout>
</template>
