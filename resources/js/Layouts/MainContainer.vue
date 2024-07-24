<template>
    <main-container>
        <search></search>
        <profile-info :username="'TestUsername'"></profile-info>
        <posts-section>
            <item v-model:src_img="this.filename" v-for="i in 6"></item>
        </posts-section>
    </main-container>
</template>

<script>
import Search from "@/components/Search.vue";
import Item from "@/components/Item.vue";
import PostsSection from "@/components/PostsSection.vue";
import ProfileInfo from "@/components/ProfileInfo.vue";
import MainContainer from "@/components/MainContainer.vue";
export default {
    components: {
        Search, Item, PostsSection, ProfileInfo, MainContainer,
    },
    name: "MainContainer"
}
</script>

<style scoped>

</style>
