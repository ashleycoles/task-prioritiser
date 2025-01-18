<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3';
import {reactive} from "vue";
import H2 from "@/Components/H2.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import FormGroup from "@/Components/Forms/FormGroup.vue";
import InputError from "@/Components/Forms/InputError.vue";

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
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit" class="flex flex-col gap-6">
                            <FormGroup>
                                <InputLabel>
                                    Title
                                    <input class="w-full" type="text" v-model="form.title" required />
                                </InputLabel>
                                <InputError :message="errors.title" />
                            </FormGroup>

                            <FormGroup>
                                <InputLabel>
                                    Description
                                    <textarea class="w-full" v-model="form.description" required></textarea>
                                </InputLabel>
                                <Error v-if="errors.description">{{ errors.description }}</Error>
                            </FormGroup>

                            <div class="flex justify-between gap-2">
                                <FormGroup>
                                    <InputLabel>
                                        Priority
                                        <input type="number" class="w-full" v-model="form.priority" min="1" max="5" required />
                                    </InputLabel>
                                    <InputError :message="errors.priority" />
                                </FormGroup>

                                <FormGroup>
                                    <InputLabel>
                                        Deadline
                                        <input type="date" class="w-full" v-model="form.deadline" required />
                                    </InputLabel>
                                    <InputError :message="errors.deadline" />
                                </FormGroup>

                                <FormGroup>
                                    <InputLabel>
                                        Estimate
                                        <input type="number" class="w-full" v-model="form.estimate" min="0.0" max="8.0" step="0.25" required />
                                    </InputLabel>
                                    <InputError :message="errors.estimate" />
                                </FormGroup>
                            </div>

                            <div class="text-center">
                                <PrimaryButton>Create Task</PrimaryButton>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
