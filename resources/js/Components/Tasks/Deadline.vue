<script setup>

import {computed} from "vue"
import {differenceInDays, isBefore, parseISO, format, subDays, isSameDay, startOfDay} from "date-fns"

const {deadline} = defineProps({
    deadline: String
})

const backgroundClass = computed(() => {
    const today = startOfDay(new Date())
    const deadlineDate = startOfDay(parseISO(deadline))

    if (isSameDay(deadlineDate, today)) {
        return "bg-yellow-500"
    }

    if (isBefore(deadlineDate, subDays(today, 5))) {
        return "bg-red-500"
    }

    if (isBefore(deadlineDate, today)) {
        return "bg-orange-500"
    }

    return  "bg-green-500"
})

const formattedDeadline = computed(() => {
    const deadlineDate = parseISO(deadline)
    return format(deadlineDate, "dd/MM/yyyy")
})

</script>

<template>
    <div :class="[backgroundClass, 'p-2 rounded-sm']">
        {{ formattedDeadline }}
    </div>
</template>
