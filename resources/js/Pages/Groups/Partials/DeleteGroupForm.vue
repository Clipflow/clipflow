<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {useForm, usePage} from '@inertiajs/inertia-vue3';
import {nextTick, ref} from 'vue';
import InputDescription from "@/Components/InputDescription";

const confirmingGroupDeletion = ref(false);
const nameInput = ref(null);

const props = defineProps({
    group: Object,
});

const form = useForm({
    name: '',
});

const confirmGroupDeletion = () => {
    confirmingGroupDeletion.value = true;
    nextTick(() => nameInput.value.focus());
};

const deleteGroup = () => {
    form.delete(route('groups.destroy', props.group.slug), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => nameInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingGroupDeletion.value = false;
    form.reset();
};
</script>

<template>
    <div>
        <DangerButton @click="confirmGroupDeletion">Delete group</DangerButton>

        <Modal :show="confirmingGroupDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ $t('Are you sure your want to delete this group?') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ $t("Once your group is deleted, all of its resources and data will be permanently deleted and this cannot be restored. Please type in the name of the group to confirm.") }}
                </p>

                <div class="mt-6">
                    <InputLabel for="name" value="Groups name" class="sr-only"/>

                    <TextInput
                        id="name"
                        ref="nameInput"
                        v-model="form.name"
                        type="text"
                        class="mt-1 block w-3/4"
                        @keyup.enter="deleteGroup"
                    />
                    <InputDescription>
                        {{ $t('Please type in the group name to confirm.') }}
                    </InputDescription>
                    <InputError :message="form.errors.name" class="mt-2"/>
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> {{ $t('Cancel') }}</SecondaryButton>

                    <DangerButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteGroup">
                        {{ $t('Delete group') }}
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </div>
</template>
