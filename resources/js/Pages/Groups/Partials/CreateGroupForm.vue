<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import {useForm, usePage} from '@inertiajs/inertia-vue3';
import PrimaryButtonLarge from "@/Components/PrimaryButtonLarge";
import InputDescription from "@/Components/InputDescription";
import {ref} from "vue";
import SecondaryButton from "@/Components/SecondaryButton";
import DangerButton from "@/Components/DangerButton";
import {TransitionRoot} from '@headlessui/vue'

const form = useForm({
    name: '',
    description: '',
    image_url: null,
});

const imagePreview = ref(null);
const imageInput = ref(null);

const createGroup = () => {
    if (imageInput.value) {
        form.image_url = imageInput.value.files[0];
    }

    form.post(route('groups.store'), {
        errorBag: 'createGroup',
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });

};

const selectImage = () => {
    imageInput.value.click();
};

const removeImageSelection = () => {
    imagePreview.value = null;
    imageInput.value = null;
};

const updateImagePreview = () => {
    const photo = imageInput.value.files[0];
    if (!photo) return;
    const reader = new FileReader();
    reader.onload = (e) => {
        imagePreview.value = e.target.result;
    };
    reader.readAsDataURL(photo);
};
</script>

<template>
    <form @submit.prevent="createGroup" class="mt-6 space-y-6 max-w-lg mx-auto">
        <div>
            <InputLabel for="name" :value="$t('Groups name')"/>
            <TextInput
                id="name"
                type="text"
                class="mt-1 block w-full"
                v-model="form.name"
                autofocus
                autocomplete="group-name"
            />
            <InputDescription>{{ $t('The name your group will go by.') }}</InputDescription>
            <InputError class="mt-2" :message="form.errors.name"/>
        </div>

        <div class="mt-4">
            <InputLabel for="description" :value="$t('Groups description')"/>

            <TextInput
                id="description"
                type="text"
                class="mt-1 block w-full"
                v-model="form.description"
                autocomplete="group-description"
            />
            <InputError class="mt-2" :message="form.errors.description"/>
            <InputDescription>{{ $t('A short description about your group.') }}</InputDescription>
        </div>

        <div class="mt-4">
            <InputLabel for="image" :value="$t('Groups image')" class="mb-2"/>

            <input
                ref="imageInput"
                type="file"
                class="hidden"
                @change="updateImagePreview"
                accept="image/png, image/jpeg">

            <!-- Preview -->
            <div class="flex space-x-2 items-center">
                <TransitionRoot :show="imagePreview !== false"
                                class="mt-2"
                                enter="transition-opacity duration-75"
                                enter-from="opacity-0"
                                enter-to="opacity-100"
                                leave="transition-opacity duration-150"
                                leave-from="opacity-100"
                                leave-to="opacity-0">
                    <span v-show="imagePreview"
                        class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                        :style="'background-image: url(\'' + imagePreview + '\');'"
                    />
                </TransitionRoot>
                <DangerButton type="button" @click.prevent="removeImageSelection" class="mr-2"
                              v-show="imagePreview">
                    {{ $t('Clear image choice') }}
                </DangerButton>
                <SecondaryButton type="button" @click.prevent="selectImage">
                    {{ $t('Pick an image') }}
                </SecondaryButton>
            </div>
            <InputDescription>{{ $t('Limited to png and jpg files only. 300px recommended.') }}</InputDescription>
            <InputError class="mt-2" :message="form.errors.image_url"/>
        </div>
        <PrimaryButtonLarge :disabled="form.processing || !form.name">{{ $t('Create group') }}</PrimaryButtonLarge>
    </form>
</template>
