<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Link
        :href="href"
        class="block w-full bg-gray-800 px-4 py-2 text-start text-sm leading-5 text-white hover:bg-[#374151] focus:outline-none transition duration-150 ease-in-out"
    >
        <slot />
    </Link>
</template>
