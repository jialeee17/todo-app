<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';

const page = usePage()

// Computed Properties (For display in template)
// const user = computed(() => page.props.auth.user)

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
        userId: page.props.auth.user.id
    }
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
    <Head title="Activity Log" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Activity Log</h2>
        </template>

        <ContainerLayout #content>
            <div class="row bg-white rounded p-3">
                <div class="col">
                    <table id="activity-log-table"></table>
                </div>
            </div>
        </ContainerLayout>
    </AuthenticatedLayout>
</template>

<style>
.btn-secondary {
    background-color: #6c757d !important;
}
</style>