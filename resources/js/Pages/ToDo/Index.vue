<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch, onMounted } from 'vue';

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
                        <div class="todos-list p-0 mt-2 mb-4">
                            <div v-for="(todo, index) in todos" class="todo-list-item bg-dark d-flex justify-content-between align-items-center rounded shadow p-2 mb-3" data-aos="fade-in">
                                <h4 class="title text-white mb-0" :class="completedClass(todo)">{{ todo.title }}</h4>

                                <div class="btn-actions d-flex gap-2">
                                    <Link :href="route('todos.show', { todo: todo.id })" as="button" type="button" class="btn btn btn-primary btn-sm">
                                        <i class="fa-solid fa-eye"></i>
                                    </Link>
                                    <Link :href="route('todos.destroy', { todo: todo.id })" method="delete" as="button" type="button" class="btn btn-danger btn-sm" preserve-scroll>
                                        <i class="fa-sharp fa-solid fa-trash"></i>
                                    </Link>
                                </div>
                            </div>
                        </div>
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
    .todos-list {
        .title {
            font-size: 1.125rem;
        }
    }

    // Custom Utilities Class
    .text-line-through {
        text-decoration: line-through;
    }
</scope>
