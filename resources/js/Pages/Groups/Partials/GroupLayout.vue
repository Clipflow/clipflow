<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
const props = defineProps({
    group: Object,
});
</script>

<template>
    <AuthenticatedLayout>
        <div>

        </div>
        <main>
            <slot />
        </main>
    </AuthenticatedLayout>
</template>
