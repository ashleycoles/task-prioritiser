<script setup>
import TaskPreview from "@/Components/Tasks/TaskPreview.vue";

defineProps({
    tasks: {
        type: Array,
        required: true
    }
})
</script>

<template>
    <ul class="flex flex-col gap-2">
        <TaskPreview v-for="task in tasks" :title="task.title" :estimate="task.estimate" :deadline="task.deadline" :priority="task.priority" />
    </ul>
</template>
