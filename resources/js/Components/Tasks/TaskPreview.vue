<script setup>
import Deadline from "@/Components/Tasks/Deadline.vue";
import Priority from "@/Components/Tasks/Priority.vue";
import Estimate from "@/Components/Tasks/Estimate.vue";

defineProps({
    title: {
        type: String,
        required: true
    },
    priority: {
        type: Number,
        required: true
    },
    deadline: {
        type: String,
        required: true
    },
    estimate: {
        type: Number,
        required: true
    }
})
</script>

<template>
    <li>
        <a href="#" class="flex justify-between items-center gap-2 border-2 rounded-sm p-5 hover:border-gray-200">
            <div class="flex items-center gap-2">
                <Priority :level="priority" />

                <div class="text-xl">
                    {{ title }}
                </div>
            </div>

            <div class="flex items-center gap-2">
                <Deadline :deadline="deadline" />

                <Estimate>
                    {{ estimate }}
                </Estimate>
            </div>
        </a>
    </li>
</template>
