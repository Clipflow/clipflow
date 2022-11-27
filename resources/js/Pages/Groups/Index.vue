<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/inertia-vue3';
import PrimaryButton from "@/Components/PrimaryButton";
import {InertiaLink} from "@inertiajs/inertia-vue3";
import Dropdown from "@/Components/Dropdown";
import DropdownItem from "@/Components/DropdownLink";
import SecondaryButton from "@/Components/SecondaryButton";
import {FunnelIcon} from '@heroicons/vue/24/outline';
import GroupCard from "@/Pages/Groups/Partials/GroupCard";

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
        <div class="flex justify-between">
            <div>
                <div class="flex">
                    <FunnelIcon class="h-6 w-6 text-gray-400 mr-2 mt-2"/>
                    <Dropdown>
                        <template #trigger>
                            <SecondaryButton class="mr-2">
                                {{ $t('Filter') }} <span class="text-gray-500 ml-1">({{ groups.data.length }} {{ $t('results')}})</span>
                            </SecondaryButton>
                        </template>
                        <template #content>
                            <DropdownItem :href="route('groups.index', {'filter': 'joined'})">
                                {{ $t('Group member') }}
                            </DropdownItem>
                            <DropdownItem :href="route('groups.index', {'filter': 'not-joined'})">
                                {{ $t('Not a group member') }}
                            </DropdownItem>
                        </template>
                    </Dropdown>
                </div>
            </div>
            <div>
                <InertiaLink :href="route('groups.create')" class="mr-2">
                    <PrimaryButton>
                        {{ $t('Create group') }}
                    </PrimaryButton>
                </InertiaLink>
            </div>
        </div>
        <div class="my-4">
            <div v-if="groups.data.length > 0">
                <TransitionGroup>
                    <GroupCard v-for="group in groups.data" :key="group.id" :group="group"/>
                </TransitionGroup>
            </div>
            <div v-else class="text-center">
                <h1 class="text-gray-900 text-2xl mb-2">{{ $t('No groups can be found.') }}</h1>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
