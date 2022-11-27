<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps(['href', 'active']);

const classes = computed(() => props.active
    ? 'inline-block p-4 text-brand rounded-t-lg border-b-2 border-brand active dark:text-brand dark:border-brand ease-in-out transition duration-200'
    : 'inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 ease-in-out transition duration-200'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
