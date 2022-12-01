<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import TabWrapper from "@/Components/TabWrapper";
import TabLink from "@/Components/TabLink";
import {HomeIcon, UsersIcon, InformationCircleIcon, CogIcon} from '@heroicons/vue/20/solid';

defineProps({
    group: Object,
});
</script>

<template>
    <AuthenticatedLayout full>
        <div>
            <div class="bg-white w-full text-base">
                <div>
                    <div class="flex items-stretch py-4 px-4 justify-center items-center">
                        <div class="flex-none pr-3">
                            <img :src="group.image_url" :alt="group.name"
                                 class="w-20 h-20 rounded-full border border-gray-100">
                        </div>
                        <div class="flex-1 text-left mt-2">
                            <h1 class="text-gray-900 text-xl mb-0.5">
                                {{ group.name }}
                            </h1>
                            <p class="text-gray-500 text-sm">{{ group.description ?? $t('No description provided.') }}</p>
                        </div>
                    </div>
                </div>
                <TabWrapper>
                    <TabLink :href="route('groups.show', group.slug)" :active="route().current('groups.show')">
                        <HomeIcon class="mr-1.5 flex-shrink-0 h-4 w-4 inline -mt-1"/>
                        <span>{{ $t('Home') }}</span>
                    </TabLink>
                    <TabLink :href="route('groups.edit', group.slug)" :active="route().current('groups.edit')">
                        <CogIcon class="mr-1.5 flex-shrink-0 h-4 w-4 inline -mt-1"/>
                        <span>{{ $t('Settings') }}</span>
                    </TabLink>
                    <TabLink :href="route('groups.members', group.slug)" :active="route().current('groups.members')">
                        <UsersIcon class="mr-1.5 flex-shrink-0 h-4 w-4 inline -mt-1"/>
                        <span>{{ $t('Members') }}</span>
                    </TabLink>
                    <TabLink :href="route('groups.edit', group.slug)" :active="route().current('groups.about')">
                        <InformationCircleIcon class="mr-1.5 flex-shrink-0 h-4 w-4 inline -mt-1"/>
                        <span>{{ $t('About') }}</span>
                    </TabLink>
                </TabWrapper>
            </div>
        </div>
        <main class="px-6 py-3">
            <slot/>
        </main>
    </AuthenticatedLayout>
</template>
