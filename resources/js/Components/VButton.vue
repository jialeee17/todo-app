<template>
    <button :type="type">
        <slot></slot>
    </button>
</template>

<script setup>
const props = defineProps({
    type: String
})
</script>