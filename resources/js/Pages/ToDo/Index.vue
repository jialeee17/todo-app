<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({ todos: Object })

// Variables
const totalPendingTodos = ref(0)

// Watchers
watch(
        () => props.todos,
        (newTodos, oldTodos) => {
            totalPendingTodos.value = newTodos.filter((todo) => todo.status === 0 ).length;
        },
        { immediate: true }
    );

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
            <div class="row bg-white rounded p-3">
                <div class="col">
                    <template v-if="todos.length > 0">
                        <h3>Todo List</h3>
                        <!-- Pending Tasks Reminder -->
                        <p class="text-secondary text-sm">
                            <i class="fa-solid fa-bell"></i>
                            <template v-if="totalPendingTodos > 0">
                                You have {{ totalPendingTodos }} <b class="text-warning">pending</b> task left.
                            </template>
                            <template v-else>
                                You're all done!.
                            </template>
                        </p>
                        <ul class="todos-list p-0 mt-2">
                            <li v-for="(todo, index) in todos" class="list-unstyled mb-2" :class="completedClass(todo)">
                                {{ todo.title }}

                                <Link :href="route('todos.show', { todo: todo.id })" as="button" type="button" class="btn btn btn-primary btn-sm ml-2">
                                    <i class="fa-solid fa-eye"></i>
                                </Link>
                                <Link :href="route('todos.destroy', { todo: todo.id })" method="delete" as="button" type="button" class="btn btn-danger btn-sm ml-2" preserve-scroll>
                                    <i class="fa-sharp fa-solid fa-trash"></i>
                                </Link>
                            </li>
                        </ul>
                    </template>

                    <!-- Flash Message -->
                    <!-- <div v-if="$page.props.flash.message" class="alert">
                        {{ $page.props.flash.message }}
                    </div> -->
                    <Link :href="route('todos.create')" as="button" type="button" class="btn btn-outline-dark">Create</Link>
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
