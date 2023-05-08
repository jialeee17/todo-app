<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({ todos: Object })
</script>

<template>
    <Head title="ToDos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">ToDos</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <Link :href="route('todos.create')" style="color: blue;">Create</Link>

                    <hr>

                    <template v-if="todos">
                        <ul class="todos-list">
                            <h2 style="font-weight: bold;">Todo List</h2>
                            <li v-for="(todo, index) in todos">
                                {{ todo.title }}

                                <!-- View & Delete buttons -->
                                <Link :href="route('todos.show', { todo: todo.id })" class="btn btn-view" style="color: green; font-weight: bold; text-decoration: underline; margin-right: 5px;">VIEW</Link>

                                <Link :href="route('todos.destroy', { todo: todo.id })" method="delete" as="button" type="button" class="btn btn-delete" style="color: red; font-weight: bold; text-decoration: underline;">DEL</Link>
                            </li>
                        </ul>
                    </template>

                    <hr>

                    <!-- Activity Logs -->
                    <!-- <template v-if="true">
                        <h2 style="font-weight: bold;">Activity Logs</h2>
                        <div class="activity-logs">
                            <p>You deleted 'I want to learn Vue.js' on 10 May 2023, 10:41am.</p>
                            <p>You updated 'I want to learn HTML' to 'I want to learn Vue.js' on 9 May 2023, 2:41pm.</p>
                            <p>You created 'I want to learn HTML' on 8 May 2023, 3:01pm.</p>
                        </div>
                    </template> -->
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
