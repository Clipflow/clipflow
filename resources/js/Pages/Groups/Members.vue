<script setup>
import GroupLayout from '@/Pages/Groups/Partials/GroupLayout.vue';
import {Head} from '@inertiajs/inertia-vue3';
import { transChoice } from 'laravel-vue-i18n';
import PrimaryButton from "@/Components/PrimaryButton";
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import { nextTick, ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    group: Object,
    members: Object,
});

const confirmingMemberAdd = ref(false);
const emailInput = ref(null);

const form = useForm({
    email: '',
    role: 'member',
});

const confirmUserAdd = () => {
    confirmingMemberAdd.value = true;

    nextTick(() => emailInput.value.focus());
};

const addUser = () => {
    form.post(route('groups.members.store', props.group.slug), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => emailInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingMemberAdd.value = false;
    form.reset();
};
</script>

<template>
    <Head :title="group.name"/>

    <GroupLayout :group="group">

        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-xl font-semibold text-gray-900">{{ $t('Members') }} ({{ transChoice('{0} 0|{1} :count member|[2,*] :count members', members.length) }})</h1>
                    <p class="mt-2 text-sm text-gray-700">{{ $t('A list of all the members of this group.') }}</p>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <PrimaryButton @click="confirmUserAdd">
                        {{ $t('Add member') }}
                    </PrimaryButton>
                </div>
            </div>
            <div class="mt-8 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 md:pl-0">{{ $t('Name')}}</th>
                                <th scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">{{ $t('Role')}}</th>
                                <th scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">{{ $t('Joined at')}}</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 md:pr-0">
                                    <span class="sr-only">{{ $t('Edit')}}</span>
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
                                <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">
                                    <span v-if="member.pivot.role === 'admin'">
                                        {{ $t('Group Admin') }}
                                    </span>
                                    <span v-else>
                                        {{ $t('Group Member') }}
                                        </span>
                                </td>
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
        <!-- Handle the add user modal-->
        <Modal :show="confirmingMemberAdd" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ $t('Add a new member') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ $t("Enter the email address of the person you'd like to add to this group. They must have an account in order to be added.") }}
                </p>

                <div class="mt-6">
                    <InputLabel for="email" value="Email" class="sr-only" />
                    <TextInput
                        id="email"
                        ref="emailInput"
                        v-model="form.email"
                        type="email"
                        class="mt-1 block w-3/4"
                        placeholder="Email Address"
                        @keyup.enter="addUser"
                    />

                    <InputError :message="form.errors.email" class="mt-2" />
                </div>

                <div class="mt-6">
                    <InputLabel for="role" value="Role" class="sr-only" />
                    <select id="role" class="border-gray-300 focus:border-brand-light focus:ring-0 rounded-lg shadow-none ease-in-out duration-200 transition mt-1 block w-3/4">
                        <option value="member">Member</option>
                        <option value="admin">Admin</option>
                        </select>

                    <InputError :message="form.errors.role" class="mt-2" />
                </div>
                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> {{ $t('Cancel') }} </SecondaryButton>

                    <PrimaryButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="addUser"
                    >
                        {{ $t('Add member') }}
                    </PrimaryButton>
                </div>
            </div>
        </Modal>
        <!-- End the add user modal-->
    </GroupLayout>
</template>
