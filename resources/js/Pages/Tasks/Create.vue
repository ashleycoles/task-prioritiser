<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3';
import {reactive} from "vue";
import H2 from "@/Components/H2.vue";

defineProps({
    errors: Object
})

const form = reactive({
    title: null,
    description: null,
    deadline: null,
    priority: null,
    estimate: null
})

function submit() {
    router.post(route('tasks.store'), form)
}
</script>

<template>
    <Head title="Create Task" />

    <AuthenticatedLayout>
        <template #header>
            <H2>Create a New Task</H2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <div>
                                <label for="title">Title</label>
                                <input type="text" id="title" v-model="form.title" required />
                                <div v-if="errors.title">{{ errors.title }}</div>
                            </div>


                            <div>
                                <label for="description">Description</label>
                                <textarea id="description" v-model="form.description" required></textarea>
                                <div v-if="errors.description">{{ errors.description }}</div>

                            </div>

                            <div>
                                <label for="deadline">Deadline</label>
                                <input type="date" id="deadline" v-model="form.deadline" required />
                                <div v-if="errors.deadline">{{ errors.deadline }}</div>

                            </div>

                            <div>
                                <label for="priority">Priority</label>
                                <input type="number" id="priority" v-model="form.priority" min="1" max="5" required />
                                <div v-if="errors.priority">{{ errors.priority }}</div>

                            </div>

                            <div>
                                <label for="estimate">Estimate</label>
                                <input type="number" id="estimate" v-model="form.estimate" min="0.0" max="8.0" step="0.25" required />
                                <div v-if="errors.estimate">{{ errors.estimate }}</div>
                            </div>

                            <div>
                                <input type="submit" value="Save" />
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
