<script setup>
import {ref} from 'vue';
import BreezeNavLink from '@/Components/NavLink.vue';
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import {Link} from '@inertiajs/inertia-vue3';

// Icons
import {HomeIcon, XCircleIcon, Bars4Icon, UserGroupIcon} from '@heroicons/vue/24/solid';
import {Dialog, DialogOverlay, TransitionChild, TransitionRoot} from '@headlessui/vue'
import WhiteLogo from "@/Components/Assets/WhiteLogo";

const sidebarOpen = ref(false);

const props = defineProps({
    full: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <div>

        <TransitionRoot as="template" :show="sidebarOpen">
            <Dialog as="div" class="fixed inset-0 flex z-40 md:hidden" @close="sidebarOpen = false">
                <TransitionChild as="template" enter="transition-opacity ease-linear duration-300"
                                 enter-from="opacity-0" enter-to="opacity-100"
                                 leave="transition-opacity ease-linear duration-300" leave-from="opacity-100"
                                 leave-to="opacity-0">
                    <DialogOverlay class="fixed inset-0 bg-gray-600 bg-opacity-75"/>
                </TransitionChild>
                <TransitionChild as="template" enter="transition ease-in-out duration-300 transform"
                                 enter-from="-translate-x-full" enter-to="translate-x-0"
                                 leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0"
                                 leave-to="-translate-x-full">
                    <div class="relative flex-1 flex flex-col max-w-xs w-full bg-[#323a3e]">
                        <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0"
                                         enter-to="opacity-100" leave="ease-in-out duration-300"
                                         leave-from="opacity-100" leave-to="opacity-0">
                            <div class="absolute top-0 right-0 -mr-12 pt-2">
                                <button type="button"
                                        class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                                        @click="sidebarOpen = false">
                                    <span class="sr-only">Close sidebar</span>
                                    <XCircleIcon class="h-6 w-6 text-white" aria-hidden="true"/>
                                </button>
                            </div>
                        </TransitionChild>
                        <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                            <div class="flex-shrink-0 flex items-center px-4">
                                <Link :href="route('dashboard')">
                                <WhiteLogo class="h-8 w-auto"/>
                                </Link>
                            </div>
                            <nav class="mt-5 px-2 space-y-1">
                                <BreezeResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                    <HomeIcon class="mr-3 flex-shrink-0 h-6 w-6 text-gray-300"/>
                                    {{ $t('Dashboard') }}
                                </BreezeResponsiveNavLink>
                                <BreezeResponsiveNavLink :href="route('groups.index')" :active="route().current('groups.*')">
                                    <UserGroupIcon class="mr-3 flex-shrink-0 h-6 w-6 text-gray-300"/>
                                    {{ $t('Groups') }}
                                </BreezeResponsiveNavLink>
                            </nav>
                        </div>
                        <div class="flex-shrink-0 flex bg-[#2e3639] p-4">
                            <a href="#" class="flex-shrink-0 group block">
                                <div class="flex items-center">
                                    <div>
                                        <img class="inline-block h-10 w-10 rounded-full"
                                             :src="$page.props.auth.user.avatar" alt=""/>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-base font-medium text-white">{{ $page.props.auth.user.name }}</p>
                                        <Link :href="route('profile.edit')"
                                              class="text-sm font-medium text-indigo-200 group-hover:text-white">{{ $t('Edit account')}}
                                        </Link>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </TransitionChild>
                <div class="flex-shrink-0 w-14" aria-hidden="true">
                    <!-- Force sidebar to shrink to fit close icon -->
                </div>
            </Dialog>
        </TransitionRoot>


        <!-- Static sidebar for desktop -->
        <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div class="flex-1 flex flex-col min-h-0 bg-[#323a3e]">
                <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                    <div class="flex items-center flex-shrink-0 px-4 mx-auto">
                        <Link :href="route('dashboard')">
                        <WhiteLogo class="h-8 w-auto text-center inline"/>
                        </Link>
                    </div>
                    <nav class="mt-5 flex-1 px-2 space-y-1">
                        <BreezeNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            <HomeIcon class="mr-4 flex-shrink-0 h-6 w-6 text-gray-300"/>
                            {{ $t('Dashboard') }}
                        </BreezeNavLink>
                        <BreezeNavLink :href="route('groups.index')" :active="route().current('groups.*')">
                        <UserGroupIcon class="mr-4 flex-shrink-0 h-6 w-6 text-gray-300"/>
                        {{ $t('Groups') }}
                        </BreezeNavLink>
                    </nav>
                </div>
                <div class="flex-shrink-0 flex bg-[#2e3639] p-4">
                    <a href="#" class="flex-shrink-0 w-full group block">
                        <div class="flex items-center">
                            <div>
                                <img class="inline-block h-9 w-9 rounded-full"
                                     :src="$page.props.auth.user.avatar"
                                     alt="">
                            </div>
                            <div class="ml-3">
                                <p class="text-base font-medium text-white">{{ $page.props.auth.user.name }}</p>
                                <Link :href="route('profile.edit')"
                                      class="text-sm font-medium text-gray-200 group-hover:text-white">{{ $t('Edit account')}}
                                </Link>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="md:pl-64 flex flex-col flex-1">
            <div class="sticky top-0 z-10 md:hidden pl-1 pt-1 sm:pl-3 sm:pt-3 bg-gray-100">
                <button type="button"
                        class="-ml-0.5 -mt-0.5 h-12 w-12 inline-flex items-center justify-center rounded-md text-gray-500 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                        @click="sidebarOpen = true">
                    <span class="sr-only">{{ $t('Open sidebar')}}</span>
                    <Bars4Icon class="h-6 w-6"/>
                </button>
            </div>
            <main class="flex-1">
                <div class="py-6" v-if="!full">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 mb-8" v-if="$slots.header">
                        <h1 class="text-2xl font-semibold text-gray-900">
                            <slot name="header"/>
                        </h1>
                    </div>
                    <transition name="fade" mode="out-in" appear>
                        <div :key="$page.url">
                            <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8" v-if="!full">
                                <slot/>
                            </div>
                            <div v-else>
                                <slot/>
                            </div>
                        </div>
                    </transition>
                </div>
                <div v-else>
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 mb-8" v-if="$slots.header">
                        <h1 class="text-2xl font-semibold text-gray-900">
                            <slot name="header"/>
                        </h1>
                    </div>
                    <transition name="fade" mode="out-in" appear>
                        <div :key="$page.url">
                            <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8" v-if="!full">
                                <slot/>
                            </div>
                            <div v-else>
                                <slot/>
                            </div>
                        </div>
                    </transition>
                </div>
            </main>
        </div>
    </div>
</template>
