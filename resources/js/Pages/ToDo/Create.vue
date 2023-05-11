<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import VButton from '../../Components/VButton.vue';

// Props
const props = defineProps({ todos: Object })

// Variables
const form = useForm({
    todos: [
        {
            title: '',
            description: ''
        }
    ]
})

// Functions
function addTodo() {
    form.todos.push({
        title: '',
        description: ''
    });
}

function removeTodo(index) {
    form.todos.splice(index, 1);
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
            <div class="row bg-white rounded p-3">
                <div class="col">
                    <form v-if="form.todos.length > 0" class="mb-3" @submit.prevent="submitForm">
                        <div v-for="(todo, index) in form.todos" :key="index" class="mb-4">
                            <div class="form-group col-6 p-0">
                                <label for="title">Title <b class="text-danger">*</b></label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Title" v-model="todo.title" required>
                                <p v-if="form.errors['todos.0.title']" style="color: red;">{{ form.errors['todos.0.title'] }}</p>
                            </div>
                            <div class="form-group col-6 p-0">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" id="description" placeholder="Description" v-model="todo.description"></textarea>
                            </div>

                            <div class="btn-action mb-3">
                                <!-- 'ADD' button will only show on last item.  -->
                                <VButton v-if="index === form.todos.length - 1" type="button" class="btn btn btn-outline-primary btn-add mr-2" @click="addTodo">
                                    <i class="fa-solid fa-plus"></i>
                                </VButton>
                                <!-- 'Remove' button will show on every items AS LONG AS the list contains MORE THAN 1 item.  -->
                                <VButton v-if="form.todos.length > 1" type="button" class="btn btn-outline-danger btn-remove mr-2" @click="removeTodo(index)">
                                    <i class="fa-sharp fa-solid fa-trash"></i>
                                </VButton>
                            </div>
                        </div>

                        <VButton type="submit" class="btn btn-outline-dark" :disabled="form.processing">
                            Save
                        </VButton>
                    </form>
                    <p v-else>Click the 'Add Todo' button to add your todo now!</p>

                    <!-- <button type="button" class="btn btn-danger" @click="backToPreviousPage">Back</button> -->
                </div>
            </div>
        </ContainerLayout>
    </AuthenticatedLayout>
</template>
