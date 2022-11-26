<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button
        :type="type"
        class="w-full text-center px-6 py-3 bg-brand-light border border-transparent rounded-full font-semibold text-sm text-white hover:bg-opacity-90 focus:bg-opacity-90 transition ease-in-out duration-150 disabled:cursor-not-allowed disabled:opacity-50"
    >
        <slot />
    </button>
</template>
