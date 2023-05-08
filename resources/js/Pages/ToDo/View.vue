<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

// Props
const props = defineProps({ todo: Object })

// Computed Properties
const todoStatus = computed(() => props.todo.status === 0 ? 'In-progress' : 'Completed')

</script>

<template>
    <Head title="ToDos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">ToDos - View</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <Link :href="route('todos.edit', { todo: todo.id })" style="color: blue;">Edit</Link>
                    <!-- Title -->
                    <div class="title">
                        <h3 style="font-weight: bold;">Title: </h3>
                        <p>{{ todo.title }}</p>
                    </div>
                    <!-- Description -->
                    <div class="description">
                        <h3 style="font-weight: bold;">Description: </h3>
                        <p v-if="todo.description">{{ todo.description }}</p>
                        <p v-else>NULL</p>
                    </div>
                    <!-- Status -->
                    <div class="status">
                        <h3 style="font-weight: bold;">Status: </h3>
                        <p>{{ todoStatus }}</p>
                    </div>
                    <!-- Created At -->
                    <div class="created-at">
                        <h3 style="font-weight: bold;">Created At: </h3>
                        <p>{{ todo.created_at }}</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
