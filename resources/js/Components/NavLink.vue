<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps(['href', 'active']);

const classes = computed(() =>
    props.active
        ? 'bg-[#40474a] text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md'
        : 'text-white hover:bg-[#474e51] hover:bg-opacity-75 group flex items-center px-2 py-2 text-sm font-medium rounded-md'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
