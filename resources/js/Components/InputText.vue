<script setup>
defineProps({
    value: {
        type: Object,
    },
});
</script>

<template>
    <div class="flex flex-column gap-2">
        <label for="username">Username</label>
        <InputText
            id="username"
            v-model="value"
            aria-describedby="username-help"
        />
        <small id="username-help"
            >Enter your username to reset your password.</small
        >
    </div>
</template>
