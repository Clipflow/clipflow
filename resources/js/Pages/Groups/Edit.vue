<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/inertia-vue3';
import UpdateGroupForm from "@/Pages/Groups/Partials/UpdateGroupForm";
import DeleteGroupForm from "@/Pages/Groups/Partials/DeleteGroupForm";

defineProps({
    group: Object,
});
</script>

<template>
    <Head :title="group.name"/>

    <AuthenticatedLayout>
        <div>
            <UpdateGroupForm :group="group"/>
        </div>
        <div>
            <DeleteGroupForm :group="group"/>
        </div>
    </AuthenticatedLayout>
</template>
