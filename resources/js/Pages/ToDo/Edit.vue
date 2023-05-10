<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, onMounted, computed } from 'vue';

// Props
const props = defineProps({ todo: Object })

// Variables
const form = useForm({
    id: '',
    title: '',
    description: '',
    status: 0
})

// Functions
function submitForm() {
    form.patch(route('todos.update', { todo: form.id }));
}

// Functions
function backToPreviousPage() {
    history.back();
}

// Computed Properties
const isChecked = computed(() => form.status === 1 ? true : false)

// Lifecycle Hooks
onMounted(() => {
    if (props.todo) {
        form.id = props.todo.id;
        form.title = props.todo.title;
        form.description = props.todo.description;
        form.status = props.todo.status === 1 ? true : false;
    }
})
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
                    <form @submit.prevent="submitForm">
                        <div class="form-group col-6 p-0">
                            <label for="title">Title <b class="text-danger">*</b></label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Title" v-model="form.title">
                            <p v-if="form.errors.title" style="color: red;">{{ form.errors.title }}</p>
                        </div>
                        <div class="form-group col-6 p-0">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" id="description" placeholder="Description" v-model="form.description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <div class="button btn-toggle r">
                                <input type="checkbox" class="checkbox" id="status" name="status" v-model="form.status" :checked="isChecked"/>
                                <div class="knobs"></div>
                                <div class="layer"></div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mr-3" :disabled="form.processing">Save</button>
                        <button type="button" class="btn btn-danger" @click="backToPreviousPage">Back</button>
                    </form>
                </div>
            </div>
        </ContainerLayout>
    </AuthenticatedLayout>
</template>

<style scoped>
.button {
  position: relative;
  /* top: 50%; */
  width: 70px;
  height: 30px;
  /* overflow: hidden; */
}
.checkbox {
  position: relative;
  width: 100%;
  height: 100%;
  padding: 0;
  margin: 0;
  opacity: 0;
  cursor: pointer;
  z-index: 3;
}

.button.r,
.button.r .layer {
  border-radius: 100px;
}

.knobs,
.layer {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
}

.knobs {
  z-index: 2;
}

.layer {
    background-color: #fcebeb;
    transition: 0.3s ease all;
    width: 100%;
    z-index: 1;
}

.btn-toggle .knobs:before {
  /* content: "OFF"; */
  content: "";
  color: #fff;
  background-color: #f44336;
  border-radius: 50%;
  font-size: 10px;
  font-weight: bold;
  text-align: center;
  line-height: 1;
  padding: 9px 4px;
  position: absolute;
  transition: 0.3s ease all, left 0.3s cubic-bezier(0.18, 0.89, 0.35, 1.15);
  width: 30px;
  height: 30px;
}

.btn-toggle .checkbox:active + .knobs:before {
  width: 46px;
  border-radius: 100px;
}

.btn-toggle .checkbox:checked:active + .knobs:before {
  margin-left: -26px;
}

.btn-toggle .checkbox:checked + .knobs:before {
  /* content: "ON"; */
  content: "";
  left: 42px;
  background-color: #03a9f4;
}

.btn-toggle .checkbox:checked ~ .layer {
  background-color: #ebf7fc;
}
</style>
