<script setup>
import {Head} from '@inertiajs/inertia-vue3';
import GroupLayout from '@/Pages/Groups/Partials/GroupLayout.vue';
defineProps({
    group: Object,
});
</script>

<template>
    <Head :title="group.name"/>
    <GroupLayout :group="group">

    </GroupLayout>
</template>
