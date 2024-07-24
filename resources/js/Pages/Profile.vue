<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import Search from "@/Pages/component_profile/Search.vue";
import Item from "@/Pages/component_profile/Item.vue";
import PostsSection from "@/Pages/component_profile/PostsSection.vue";
import ProfileInfo from "@/Pages/component_profile/ProfileInfo.vue";
import MainContainer from "@/Pages/component_profile/MainContainer.vue";

defineProps({
    user: {
        type: Object,
    },
});
const filename = "/img/img1.jpg"
</script>
<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <main-container>
            <search></search>
            <profile-info :username="user.username"></profile-info>
            <posts-section>
                <item v-model:src_img="filename" v-for="i in 6"></item>
            </posts-section>
        </main-container>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
