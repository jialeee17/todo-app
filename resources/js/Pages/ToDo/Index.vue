<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({ todos: Object })

// Functions
function completedClass(todo) {
    return {
        'text-muted': todo.status === 1 ? true : false,
        'text-line-through': todo.status === 1 ? true : false
    }
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
                    <template v-if="todos.length > 0">
                        <h3>Todo List</h3>
                        <ul class="todos-list p-0">
                            <li v-for="(todo, index) in todos" class="list-unstyled mb-2" :class="completedClass(todo)">
                                {{ todo.title }}

                                <Link :href="route('todos.show', { todo: todo.id })" as="button" type="button" class="btn btn btn-dark btn-sm ml-2">
                                    <i class="fa-solid fa-eye"></i>
                                </Link>
                                <Link :href="route('todos.destroy', { todo: todo.id })" method="delete" as="button" type="button" class="btn btn-danger btn-sm ml-2">
                                    <i class="fa-sharp fa-solid fa-trash"></i>
                                </Link>
                            </li>
                        </ul>
                    </template>

                    <Link :href="route('todos.create')" as="button" type="button" class="btn btn-light">Create</Link>
                </div>
            </div>
        </ContainerLayout>
    </AuthenticatedLayout>
</template>

<scope lang="scss" scoped>
    .text-line-through {
        text-decoration: line-through;
    }
</scope>
