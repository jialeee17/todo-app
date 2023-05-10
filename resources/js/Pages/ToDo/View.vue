<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

// Props
const props = defineProps({ todo: Object })

// Computed Properties
const todoStatus = computed(() => props.todo.status === 0 ? 'In-progress' : 'Completed')

// Functions
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
                    <div class="details mb-3">
                        <div class="mb-1">
                            <h4 class="title d-inline-block mr-2">Title: </h4>
                            <span>{{ todo.title }}</span>
                        </div>
                        <div class="mb-1">
                            <h4 class="description d-inline-block mr-2">Description: </h4>
                            <span v-if="todo.description">{{ todo.description }}</span>
                            <span v-else>NULL</span>
                        </div>
                        <div class="mb-1">
                            <h4 class="status d-inline-block mr-2">Status: </h4>
                            <span>{{ todoStatus }}</span>
                        </div>
                        <div class="mb-1">
                            <h4 class="created-at d-inline-block mr-2">Created At: </h4>
                            <span>{{ todo.created_at }}</span>
                        </div>
                    </div>

                    <Link :href="route('todos.edit', { todo: todo.id })" class="btn btn-light mr-3">Edit</Link>
                    <button type="button" class="btn btn-danger" @click="backToPreviousPage">Back</button>
                </div>
            </div>
        </ContainerLayout>
    </AuthenticatedLayout>
</template>

<style scoped>
    .title,
    .description,
    .status,
    .created-at {
        font-size: 1.125rem !important;
    }
</style>
