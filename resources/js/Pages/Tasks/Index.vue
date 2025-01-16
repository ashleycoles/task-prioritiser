<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Priority from "@/Components/Priority.vue";
import Deadline from "@/Components/Deadline.vue";

defineProps({
    tasks: {
        type: Array
    }
})
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                View your tasks for today
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <ul class="flex flex-col gap-2">
                            <li v-for="task in tasks">
                                <a href="#" class="flex justify-between items-center gap-2 border-2 rounded-sm p-5 hover:border-gray-200">
                                    <div class="flex items-center gap-2">
                                        <Priority :level="task.priority" />

                                        <div class="text-xl">
                                            {{ task.title }}
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <Deadline :deadline="task.deadline" />

                                        <div class="bg-green-300 p-2 rounded-sm">
                                            {{ task.estimate }}
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
