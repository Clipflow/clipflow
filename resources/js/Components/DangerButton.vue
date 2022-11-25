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
        class="inline-flex items-center px-6 py-2 bg-red-500 border border-transparent rounded-full font-semibold text-sm text-white hover:bg-opacity-90 focus:bg-opacity-90 transition ease-in-out duration-150"
    >
        <slot />
    </button>
</template>
