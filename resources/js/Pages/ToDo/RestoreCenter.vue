<script setup>
import { Head, usePage, router } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';

const page = usePage()

// Computed Properties (For display in template)
// const user = computed(() => page.props.auth.user)

// Functions
function ajaxRequest(params) {
    $.ajax({
        url: route('restoreCenter.data'),
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

function queryParams(params) {
    return {
        ...params,
        userId: page.props.auth.user.id
    }
}

function columns() {
    return [
        {
            title: 'ID',
            field: 'id',
        },
        {
            title: 'Title',
            field: 'title',
        },
        {
            title: 'Description',
            field: 'description',
        },
        {
            title: 'Deleted Time (UTC)',
            field: 'deleted_at',
        },
        {
            title: 'Action',
            align: 'center',
            formatter: actionFormatter,
            events: actionEvents()
        }
    ]
}

function actionFormatter(value, row, index, field) {
    const btnRestore = '<a href="javascript: void(0)" class="btn-restore"><i class="fa-solid fa-trash-can-arrow-up text-success""></i></a>';

    return btnRestore;
}

function actionEvents() {
    return {
        'click .btn-restore': function (event, value, row, index) {
            restoreTodo(row.id);
        }
    }
}

function restoreTodo(id) {
    $.ajax({
        url: route('restoreCenter.restore', { 'id': id }),
        method: "POST",
        success: function(response) {
            router.visit(route('restoreCenter.index'), { preserveScroll: true });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Handle error
        },
        complete: function(jqXHR, textStatus) {
            // Handle completion of the request (regardless of success or error)
        }
    });
}

// Lifecycle Hooks
onMounted(() => {
    $('#trashed-activity-log-table').bootstrapTable({
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
    <Head title="Restore Center" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Restore Center</h2>
        </template>

        <ContainerLayout #content>
            <div class="row bg-white rounded p-3">
                <div class="col">
                    <table id="trashed-activity-log-table"></table>
                </div>
            </div>
        </ContainerLayout>
    </AuthenticatedLayout>
</template>