<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

// Props
const props = defineProps({ todos: Object })

// Variables
const form = useForm({
    todos: []
})

// Functions
function addTodo() {
    form.todos.push({
        title: '',
        description: ''
    });
}

function submitForm() {
    form.post(route('todos.store'));
}
</script>

<template>
    <Head title="ToDos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">ToDos - Create</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <button type="button" style="color: blue;" @click="addTodo">Add Todo</button>

                    <div>
                        <template v-if="form.todos.length > 0">
                            <h2 style="font-weight: bold;">--- FORM ---</h2>
                            <form @submit.prevent="submitForm">
                                <div v-for="(todo, index) in form.todos" :key="index" style="background: yellowgreen">
                                    <!-- Title -->
                                    <div class="form-group">
                                        <label for="title">Title *</label>
                                        <input type="text" id="title" name="title" v-model="todo.title">
                                        <p v-if="form.errors['todos.0.title']" style="color: red;">{{ form.errors['todos.0.title'] }}</p>
                                    </div>
                                    <!-- Description -->
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" cols="50" rows="1" v-model="todo.description"></textarea>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" :disabled="form.processing" style="color: blue;">Save</button>
                            </form>
                        </template>
                        <p v-else>Click the 'Add Todo' button to add your todo now!</p>
                    </div>
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
