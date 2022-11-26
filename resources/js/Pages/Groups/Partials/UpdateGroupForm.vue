<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputDescription from "@/Components/InputDescription";
import {ref} from "vue";
import {useForm} from "@inertiajs/inertia-vue3";
import SecondaryButton from "@/Components/SecondaryButton";
import DangerButton from "@/Components/DangerButton";
import {TransitionRoot} from '@headlessui/vue'
import PrimaryButton from "@/Components/PrimaryButton";

const props = defineProps({
    group: Object,
});

const form = useForm({
    _method: 'PUT',
    name: props.group.name,
    description: props.group.description,
    image_url: null,
});

const imagePreview = ref(null);
const imageInput = ref(null);

const updateGroup = () => {
    if (imageInput.value) {
        form.image_url = imageInput.value.files[0];
    }

    form.post(route('groups.update', props.group.slug), {
        errorBag: 'updateGroup',
        preserveScroll: true,
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
    <form @submit.prevent="updateGroup">
        <!-- Name -->
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
            <InputError class="mt-2" :message="form.errors.name"/>
        </div>

        <!-- Description -->
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
        </div>

        <!-- Image -->
        <div class="mt-4">
            <InputLabel for="image" :value="$t('Groups image')" class="mb-2"/>

            <input
                ref="imageInput"
                type="file"
                class="hidden"
                @change="updateImagePreview"
                accept="image/png, image/jpeg">

            <div class="flex space-x-2 items-center">
                <TransitionRoot :show="! imagePreview"
                                class="mt-2"
                                enter="transition-opacity duration-75"
                                enter-from="opacity-0"
                                enter-to="opacity-100"
                                leave="transition-opacity duration-150"
                                leave-from="opacity-100"
                                leave-to="opacity-0">
                    <img :src="group.image_url" :alt="group.name" class="rounded-full h-20 w-20 object-cover"
                         v-show="group.image_url"/>
                </TransitionRoot>
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

        <div class="mt-4">
            <PrimaryButton :disabled="form.processing" type="submit">
                {{ $t('Save changes') }}
            </PrimaryButton>
        </div>
    </form>
</template>
