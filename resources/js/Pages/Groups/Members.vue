<script setup>
import GroupLayout from '@/Pages/Groups/Partials/GroupLayout.vue';
import {Head} from '@inertiajs/inertia-vue3';

defineProps({
    group: Object,
    members: Object,
});
</script>

<template>
    <Head :title="group.name"/>

    <GroupLayout :group="group">

        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-xl font-semibold text-gray-900">{{ $t('Members') }}</h1>
                    <p class="mt-2 text-sm text-gray-700">{{ $t('A list of all the members of this group.') }}</p>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <button type="button" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Add user</button>
                </div>
            </div>
            <div class="mt-8 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 md:pl-0">{{ $t('Name')}}</th>
                                <th scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">Role</th>
                                <th scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">Joined</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 md:pr-0">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                            <tr v-for="member in members" :key="member.id">
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <img class="h-10 w-10 rounded-full" :src="member.avatar" alt="" />
                                        </div>
                                        <div class="ml-4">
                                            <div class="font-medium text-gray-900">{{ member.name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">{{ member.role }}</td>
                                <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">{{ member.created_at }}</td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 md:pr-0">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900"
                                    >Edit<span class="sr-only">, {{ member.name }}</span></a
                                    >
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </GroupLayout>
</template>
