<script setup>

import {computed} from "vue"

const props = defineProps({
    level: Number
})

const backgroundClass = computed(() => {
    const levelColors = {
        1: "bg-red-500",
        2: "bg-orange-500",
        3: "bg-yellow-500",
        4: "bg-green-500",
        5: "bg-blue-500",
    };
    return levelColors[props.level] || "bg-gray-500"
})

</script>

<template>
    <div :class="[backgroundClass, 'p-2 rounded-sm']">
        {{ props.level }}
    </div>
</template>
