<script setup>
import GroupLayout from '@/Pages/Groups/Partials/GroupLayout.vue';
import {Head} from '@inertiajs/inertia-vue3';
import UpdateGroupForm from "@/Pages/Groups/Partials/UpdateGroupForm";
import DeleteGroupForm from "@/Pages/Groups/Partials/DeleteGroupForm";

defineProps({
    group: Object,
});
</script>

<template>
    <Head :title="group.name"/>

    <GroupLayout :group="group">
        <div>
            <UpdateGroupForm :group="group"/>
        </div>
        <div>
            <DeleteGroupForm :group="group"/>
        </div>
    </GroupLayout>
</template>
