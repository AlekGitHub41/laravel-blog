<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-black">

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-black shadow-md overflow-hidden sm:rounded-lg" style="box-shadow: 0 4px 8px rgba(255, 255, 255, 0.08), 0 0px 4px rgba(255, 255, 255, 0.08);"
        >
            <slot />
        </div>
    </div>
</template>
