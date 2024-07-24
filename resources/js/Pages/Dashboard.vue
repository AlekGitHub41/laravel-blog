<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import Search from "@/Pages/component_profile/Search.vue";
import Item from "@/Pages/component_profile/Item.vue";
import PostsSection from "@/Pages/component_profile/PostsSection.vue";
import ProfileInfo from "@/Pages/component_profile/ProfileInfo.vue";
import MainContainer from "@/Pages/component_profile/MainContainer.vue";

defineProps({
    user: Object,
});

// import Test from "@/Pages/Test.vue"
// export default {
//     name: "MainPage",
//     components: {
//         Search, Item, PostsSection, ProfileInfo, MainContainer,
//     },
//     data() {
//         return {
//             filename: "/src/img/img1.jpg",
//         }
//     }
// }
const filename = "/img/img1.jpg"
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <!--        <template #header>-->
        <!--            <h2 class="font-semibold text-xl text-white leading-tight bg-red">Dashboard</h2>-->
        <!--        </template>-->
<!--        <main-container>-->
<!--            <search></search>-->
<!--            <profile-info :username="user.username"></profile-info>-->
<!--            <Posts-section>-->
<!--                <item v-model:src_img="filename" v-for="i in 6"></item>-->
<!--            </Posts-section>-->
<!--        </main-container>-->
    </AuthenticatedLayout>
</template>
<style>

</style>
