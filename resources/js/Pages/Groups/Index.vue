<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/inertia-vue3';
import PrimaryButton from "@/Components/PrimaryButton";
import {InertiaLink} from "@inertiajs/inertia-vue3";

defineProps({
    groups: Object,
});

</script>

<template>
    <Head :title="$t('Groups')"/>

    <AuthenticatedLayout>
        <template #header>
            {{ $t('Groups') }}
        </template>
        <div class="flex justify-end mb-5">
            <InertiaLink :href="route('groups.create')">
                <PrimaryButton :title="$t('Create group')">
                    {{ $t('Create group') }}
                </PrimaryButton>
            </InertiaLink>
        </div>
        <div>
            <ul>
                <li v-for="group in groups" :key="group.id">
                    <InertiaLink :href="route('groups.show', group.slug)">
                        {{ group.name }}
                    </InertiaLink>
                    <InertiaLink :href="route('groups.edit', group.slug)">
                        {{ $t('Edit') }}
                    </InertiaLink>
                </li>
            </ul>
        </div>
    </AuthenticatedLayout>
</template>
