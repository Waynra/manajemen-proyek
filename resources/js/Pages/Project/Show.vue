<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Button from "@/Components/Button.vue";
import Card from "@/Components/Card.vue";
import Dialog from "@/Components/Dialog.vue";
import Input from "@/Components/Input.vue";
import Textarea from "@/Components/Textarea.vue";
import Badge from "@/Components/Badge.vue";
import DatePicker from "@/Components/DatePicker.vue";
import Select from "@/Components/Select.vue";

defineProps({
    project: Object,
    tasks: Array,
    users: Array,
});

const showCreateDialog = ref(false);
const showEditDialog = ref(false);
const editingTask = ref(null);

const form = useForm({
    title: "",
    description: "",
    due_date: "",
    assignees: [],
});

const editForm = useForm({
    title: "",
    description: "",
    due_date: "",
    assignees: [],
    status: "",
});

const openCreateDialog = () => {
    form.reset();
    showCreateDialog.value = true;
};

const closeCreateDialog = () => {
    showCreateDialog.value = false;
};

const submitCreateTask = () => {
    form.post(route("projects.tasks.store", project.id), {
        onSuccess: () => {
            closeCreateDialog();
            form.reset();
        },
    });
};

const openEditDialog = (task) => {
    editingTask.value = task;
    editForm.title = task.title;
    editForm.description = task.description;
    editForm.due_date = task.due_date;
    editForm.status = task.status;
    editForm.assignees = task.assignees.map((u) => u.id);
    showEditDialog.value = true;
};

const closeEditDialog = () => {
    showEditDialog.value = false;
    editingTask.value = null;
};

const submitEditTask = () => {
    editForm.put(
        route("projects.tasks.update", [project.id, editingTask.value.id]),
        {
            onSuccess: () => {
                closeEditDialog();
                editForm.reset();
            },
        },
    );
};

const deleteTask = (task) => {
    if (confirm("Are you sure you want to delete this task?")) {
        useForm({}).delete(
            route("projects.tasks.destroy", [project.id, task.id]),
        );
    }
};

const getStatusBadgeVariant = (status) => {
    const variants = {
        todo: "default",
        in_progress: "warning",
        done: "success",
    };
    return variants[status] || "default";
};

const getStatusLabel = (status) => {
    const labels = {
        todo: "To Do",
        in_progress: "In Progress",
        done: "Done",
    };
    return labels[status] || status;
};

const updateTaskStatus = (task, newStatus) => {
    useForm({ status: newStatus }).put(
        route("projects.tasks.update", [project.id, task.id]),
    );
};

const userOptions = users?.map((u) => ({ value: u.id, label: u.name })) || [];
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800">
                    {{ project.name }}
                </h2>
                <div class="flex gap-2">
                    <Button
                        size="sm"
                        @click="
                            () =>
                                $inertia.visit(
                                    route('projects.edit', project.id),
                                )
                        "
                    >
                        Edit
                    </Button>
                    <Button
                        size="sm"
                        variant="destructive"
                        @click="
                            () =>
                                $inertia.patch(
                                    route('projects.destroy', project.id),
                                    {},
                                    { method: 'delete' },
                                )
                        "
                    >
                        Delete
                    </Button>
                </div>
            </div>
            <p v-if="project.description" class="mt-2 text-gray-600">
                {{ project.description }}
            </p>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
            <!-- Tasks Header -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Tasks</h3>
                <Button @click="openCreateDialog">+ Add Task</Button>
            </div>

            <!-- Tasks List -->
            <div v-if="tasks.length > 0" class="grid gap-4">
                <Card
                    v-for="task in tasks"
                    :key="task.id"
                    class="cursor-pointer hover:shadow-lg transition"
                >
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h4 class="font-medium text-gray-900">
                                    {{ task.title }}
                                </h4>
                                <Badge
                                    :variant="
                                        getStatusBadgeVariant(task.status)
                                    "
                                >
                                    {{ getStatusLabel(task.status) }}
                                </Badge>
                            </div>
                            <p
                                v-if="task.description"
                                class="text-gray-600 text-sm mb-2"
                            >
                                {{ task.description }}
                            </p>
                            <div
                                class="flex items-center gap-4 text-sm text-gray-500"
                            >
                                <span v-if="task.due_date"
                                    >Due:
                                    {{
                                        new Date(
                                            task.due_date,
                                        ).toLocaleDateString()
                                    }}</span
                                >
                                <span v-if="task.assignees.length"
                                    >Assigned to:
                                    {{
                                        task.assignees
                                            .map((u) => u.name)
                                            .join(", ")
                                    }}</span
                                >
                            </div>
                        </div>
                        <div class="flex gap-2 ml-4">
                            <Button
                                size="sm"
                                variant="outline"
                                @click.stop="openEditDialog(task)"
                            >
                                Edit
                            </Button>
                            <Button
                                size="sm"
                                variant="outline"
                                @click.stop="deleteTask(task)"
                            >
                                Delete
                            </Button>
                        </div>
                    </div>
                </Card>
            </div>

            <div v-else class="text-center py-12">
                <p class="text-gray-500 mb-4">No tasks yet</p>
                <Button @click="openCreateDialog"
                    >Create your first task</Button
                >
            </div>
        </div>

        <!-- Create Task Dialog -->
        <Dialog
            :open="showCreateDialog"
            title="Add New Task"
            @close="closeCreateDialog"
        >
            <div class="space-y-4">
                <Input
                    v-model="form.title"
                    label="Task Title"
                    placeholder="Enter task title"
                    required
                    :errors="form.errors.title"
                />
                <Textarea
                    v-model="form.description"
                    label="Description"
                    placeholder="Enter task description (optional)"
                    :errors="form.errors.description"
                />
                <DatePicker
                    v-model="form.due_date"
                    label="Due Date"
                    :errors="form.errors.due_date"
                />
                <Select
                    v-model="form.assignees"
                    :options="userOptions"
                    label="Assign To"
                    multiple
                    placeholder="Select users"
                    :errors="form.errors.assignees"
                />
            </div>
            <template #footer>
                <div class="flex gap-2 justify-end">
                    <Button variant="outline" @click="closeCreateDialog"
                        >Cancel</Button
                    >
                    <Button
                        :disabled="form.processing"
                        @click="submitCreateTask"
                    >
                        {{ form.processing ? "Creating..." : "Create Task" }}
                    </Button>
                </div>
            </template>
        </Dialog>

        <!-- Edit Task Dialog -->
        <Dialog
            :open="showEditDialog"
            title="Edit Task"
            @close="closeEditDialog"
        >
            <div class="space-y-4">
                <Input
                    v-model="editForm.title"
                    label="Task Title"
                    placeholder="Enter task title"
                    :errors="editForm.errors.title"
                />
                <Textarea
                    v-model="editForm.description"
                    label="Description"
                    placeholder="Enter task description (optional)"
                    :errors="editForm.errors.description"
                />
                <Select
                    v-model="editForm.status"
                    :options="[
                        { value: 'todo', label: 'To Do' },
                        { value: 'in_progress', label: 'In Progress' },
                        { value: 'done', label: 'Done' },
                    ]"
                    label="Status"
                    :errors="editForm.errors.status"
                />
                <DatePicker
                    v-model="editForm.due_date"
                    label="Due Date"
                    :errors="editForm.errors.due_date"
                />
                <Select
                    v-model="editForm.assignees"
                    :options="userOptions"
                    label="Assign To"
                    multiple
                    placeholder="Select users"
                    :errors="editForm.errors.assignees"
                />
            </div>
            <template #footer>
                <div class="flex gap-2 justify-end">
                    <Button variant="outline" @click="closeEditDialog"
                        >Cancel</Button
                    >
                    <Button
                        :disabled="editForm.processing"
                        @click="submitEditTask"
                    >
                        {{ editForm.processing ? "Saving..." : "Save Changes" }}
                    </Button>
                </div>
            </template>
        </Dialog>
    </AuthenticatedLayout>
</template>
