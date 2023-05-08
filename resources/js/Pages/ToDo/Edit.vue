<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, onMounted, computed } from 'vue';

// Props
const props = defineProps({ todo: Object })

// Variables
const form = useForm({
    id: '',
    title: '',
    description: '',
    status: 0
})

// Functions
function submitForm() {
    form.patch(route('todos.update', { todo: form.id }));
}

// Computed Properties
const isChecked = computed(() => form.status === 1 ? true : false)

// Lifecycle Hooks
onMounted(() => {
    if (props.todo) {
        form.id = props.todo.id;
        form.title = props.todo.title;
        form.description = props.todo.description;
        form.status = props.todo.status === 1 ? true : false;
    }
})
</script>

<template>
    <Head title="ToDos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">ToDos - Edit</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    Edit Todo
                    <form @submit.prevent="submitForm">
                        <!-- Title -->
                        <div class="form-group">
                            <label for="title">Title *</label>
                            <input type="text" id="title" name="title" v-model="form.title">
                            <p v-if="form.errors.title" style="color: red;">{{ form.errors.title }}</p>
                        </div>
                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" cols="50" rows="1" v-model="form.description"></textarea>
                        </div>
                        <!-- Status -->
                        <label for="status">Status</label>
                        <input type="checkbox" id="status" name="status" v-model="form.status" :checked="isChecked">

                        <!-- Submit Button -->
                        <button type="submit" :disabled="form.processing" style="color: blue;">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
label {
    display: block;
}
</style>
