<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/inertia-vue3';
import CreateGroupForm from "@/Pages/Groups/Partials/CreateGroupForm";
</script>

<template>
    <Head :title="$t('Begin creating your new group')"/>

    <AuthenticatedLayout>
        <div>
            <div class="mb-4 text-center">
                <h1 class="text-gray-900 text-2xl my-2 font-semibold">{{ $t('Begin creating your new group') }}</h1>
                <p class="text-base text-gray-800 inline">{{ $t('We need some details first..') }}</p>
            </div>
            <div>
                <CreateGroupForm/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
