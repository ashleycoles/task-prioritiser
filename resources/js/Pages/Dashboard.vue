<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import H1 from "@/Components/Text/H1.vue";
import DashboardLink from "@/Components/Navigation/DashboardLink.vue";
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <H1>Dashboard</H1>
        </template>

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-4 gap-2 p-6 text-gray-900">
                    <DashboardLink :href="route('tasks.index')">
                        View Tasks
                    </DashboardLink>

                    <DashboardLink :href="route('tasks.create')">
                        Add Task
                    </DashboardLink>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
