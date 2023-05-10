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

function backToPreviousPage() {
    history.back();
}
</script>

<template>
    <Head title="ToDos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">ToDos</h2>
        </template>

        <ContainerLayout #content>
            <div class="row">
                <div class="col">
                    <form v-if="form.todos.length > 0" class="mb-3" @submit.prevent="submitForm">
                        <div v-for="(todo, index) in form.todos" :key="index">
                            <div class="form-group col-6 p-0">
                                <label for="title">Title <b class="text-danger">*</b></label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Title" v-model="todo.title" required>
                                <p v-if="form.errors['todos.0.title']" style="color: red;">{{ form.errors['todos.0.title'] }}</p>
                            </div>
                            <div class="form-group col-6 p-0">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" id="description" placeholder="Description" v-model="todo.description"></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" :disabled="form.processing">Save</button>
                    </form>
                    <p v-else>Click the 'Add Todo' button to add your todo now!</p>

                    <button type="button" class="btn btn-light mr-3" @click="addTodo">Add Todo</button>
                    <!-- <button type="button" class="btn btn-danger" @click="backToPreviousPage">Back</button> -->
                </div>
            </div>
        </ContainerLayout>
    </AuthenticatedLayout>
</template>
