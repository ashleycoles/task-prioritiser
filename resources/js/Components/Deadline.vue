<script setup>

import {computed} from "vue"
import {differenceInDays, isBefore, parseISO, format} from "date-fns"

const props = defineProps({
    deadline: String
})

const backgroundClass = computed(() => {
    const today = new Date()
    const deadlineDate = new Date(props.deadline)
    const daysDifference = differenceInDays(deadlineDate, today)

    if (daysDifference === 0) {
        return "bg-orange-500"
    }

    if (isBefore(deadlineDate, today)) {
        return "bg-red-500"
    }

    return  "bg-green-500"
})

const formattedDeadline = computed(() => {
    const deadlineDate = parseISO(props.deadline)
    return format(deadlineDate, "dd/MM/yyyy")
})

</script>

<template>
    <div :class="[backgroundClass, 'p-2 rounded-sm']">
        {{ formattedDeadline }}
    </div>
</template>
