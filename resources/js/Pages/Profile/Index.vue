<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import Search from "@/Pages/component_profile/Search.vue";
import Item from "@/Pages/component_profile/Item.vue";
import PostsSection from "@/Pages/component_profile/PostsSection.vue";
import ProfileInfo from "@/Pages/component_profile/ProfileInfo.vue";
import MainContainer from "@/Pages/component_profile/MainContainer.vue";
import {usePage} from '@inertiajs/vue3'
import {onMounted, reactive, ref} from "vue";

const props = defineProps({
    user: Object,
    posts: Object,
    status: Boolean,
    followersCount: Number,
    followingCount: Number,
    postsCount: Number,
    lastPage: Number,
});

let posts__ = ref([...props.posts.data])
const methods = {
    addPost(post) {
        posts__.value = [...posts__.value, ...post]
    },
    deletePost(post_id) {
        posts__.value = posts__.value.filter(item => {
            return item.id !== post_id
        })
    }
}
console.log(posts__)
</script>
<template>
    <Head title="Home"/>
    <AuthenticatedLayout>
        <main-container
            @addPost="methods.addPost"
            :post="posts__.length"
            :user_id="props.user.id"
            :lastPage="props.lastPage">
            <search></search>
            <profile-info
                :username="user.username"
                :user_id="props.user.id"
                :profile="props.user.profile"
                :post="props.postsCount"
                :status="props.status"
                :followers="props.followersCount"
                :following="props.followingCount"
            ></profile-info>
            <posts-section>
                <item
                    @deletePost="methods.deletePost"
                    :src_img="i.image_scale"
                    :username="user.username"
                    :user_id="user.id"
                    :avatar="user.profile.image"
                    :post_id="i.id"
                    :key="i.id"
                    v-for="i in posts__">
                </item>
            </posts-section>
        </main-container>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
