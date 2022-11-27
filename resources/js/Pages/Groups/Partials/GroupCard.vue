<script setup>
import {InertiaLink} from "@inertiajs/inertia-vue3";
import { transChoice } from 'laravel-vue-i18n';

const props = defineProps({group: Object});
</script>

<template>
    <div class="px-4 py-2 bg-white border border-gray-100 mb-3 rounded-md">
        <div class="flex items-stretch py-2 justify-center items-center">
            <div class="flex-none pr-3">
                <img :src="group.image_url" :alt="group.name" class="w-16 h-16 rounded-full border border-gray-100">
            </div>
            <div class="flex-1 text-left">
                <InertiaLink class="text-gray-900 text-xl mb-1 hover:underline ease-in-out duration-200"
                             :href="route('groups.show', props.group.slug)" :title="group.name">{{ group.name }}
                </InertiaLink>
                <p class="text-gray-500 text-sm">{{ group.description ?? $t('No description provided.') }}</p>
                <div class="text-gray-500 text-sm">
                    <span>{{ transChoice('{0} No members|{1} :count member|[2,*] :count members', props.group.members_count) }}</span>
                    •
                </div>
            </div>
        </div>
    </div>
</template>
