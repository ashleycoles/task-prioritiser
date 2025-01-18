<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Priority from "@/Components/Tasks/Priority.vue";
import Deadline from "@/Components/Tasks/Deadline.vue";
import H2 from "@/Components/H2.vue";
import TaskPreview from "@/Components/Tasks/TaskPreview.vue";
import TaskList from "@/Components/Tasks/TaskList.vue";

defineProps({
    today: {
        type: Array
    },
    future: {
        type: Array
    }
})
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <H2>View Your Tasks</H2>
        </template>

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div
                class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
            >
                <div class="flex flex-col gap-2 p-6 text-gray-900">
                    <H2>Today's Tasks</H2>
                    <TaskList :tasks="today" />

                    <H2>Future Tasks</H2>
                    <TaskList :tasks="future" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
