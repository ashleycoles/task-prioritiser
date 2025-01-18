<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
    href: {
        type: String,
        required: true
    }
})
</script>

<template>
    <Link class="border-2 rounded-sm py-8 text-center text-xl hover:bg-gray-200" :href="href" >
        <slot />
    </Link>
</template>
