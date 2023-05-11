<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';

// Props
const props = defineProps({ todo: Object })

// Computed Properties
const todoStatus = computed(() => props.todo.status === 0 ? 'In-progress' : 'Completed')

// Functions
function ajaxRequest(params) {
    $.ajax({
        url: route('activityLog.data'),
        method: "GET",
        data: params.data,
        success: function(response) {
            params.success(response.data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Handle error
            // console.log("Error: " + errorThrown);
        },
        complete: function(jqXHR, textStatus) {
            // Handle completion of the request (regardless of success or error)
            // console.log("Request completed with status: " + textStatus);
        }
    });
}

function columns() {
    return [
        {
            title: 'Time (UTC)',
            field: 'created_at',
        },
        {
            title: 'User',
            field: 'user.name',
        },
        {
            title: 'Type',
            field: 'type',
        },
        {
            title: 'Description',
            field: 'description',
        }
    ]
}

function queryParams(params) {
    return {
        ...params,
        todoId: props.todo.id,
        userId: props.todo.user_id,
    }
}

function backToPreviousPage() {
    history.back();
}

// Lifecycle Hooks
onMounted(() => {
    $('#activity-log-table').bootstrapTable({
        ajax: ajaxRequest,
        columns: columns(),
        pagination: true,
        sidePagination: 'server',
        paginationVAlign: 'both',
        pageSize: 25,
        pageList:"[25, 50, 75, 100]",
        queryParams: queryParams
    })
})
</script>

<template>
    <Head title="ToDos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">ToDos</h2>
        </template>

        <ContainerLayout #content>
            <div class="row bg-white rounded p-3 mb-3">
                <div class="col">
                    <div class="details mb-3">
                        <div class="mb-1">
                            <h4 class="title d-inline-block mr-2">ID: </h4>
                            <span>{{ todo.id }}</span>
                        </div>
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

                    <Link :href="route('todos.edit', { todo: todo.id })" class="btn btn-outline-dark mr-3">Edit</Link>
                    <!-- <button type="button" class="btn btn-danger" @click="backToPreviousPage">Back</button> -->
                </div>
                <!-- <div class="col-4">
                    <div class="card bg-dark shadow" style="height: 220px;">
                        <div class="card-body" style="overflow: auto;">
                            <div class="todo bg-light rounded px-2">
                                <h4>Item (ID: 2): I want to lean XXX</h4>
                            </div>
                            <div class="todo bg-light rounded px-2">
                                <h4>Item (ID: 2): I want to lean XXX</h4>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>

            <div class="row bg-white rounded p-3">
                <div class="col">
                    <table id="activity-log-table"></table>
                </div>
            </div>
        </ContainerLayout>
    </AuthenticatedLayout>
</template>

<style lang="scss" scoped>
    .details {
        .title,
        .description,
        .status,
        .created-at {
            font-size: 1.125rem !important;
        }
    }
</style>
