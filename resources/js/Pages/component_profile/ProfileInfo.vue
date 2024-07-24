<template>
    <div
        class="profile_info flex flex-wrap justify-between pb-20 border-b border-gray-300 h-full max-[598px]:justify-center">
        <div class="cart">
            <div
                class="img relative w-full h-screen max-w-[150px] max-h-[150px] mr-[20px] max-[567px]:max-w-[120px] max-[567px]:max-h-[120px]">
                <img :src="profile.image" class="absolute w-full h-full rounded-full object-cover"/>
            </div>
            <div class="info flex flex-col max-[567px]:mt-[30px]">
                <div class="name text-[20px] mb-[20px]">
                    {{ this.username }}
                    <template v-if="this.show_follow">
                        <PrimaryButton type="submit" class="ml-[20px]" @click="followUser" v-if="user.id!==user_id">
                            {{ this.status ? "Отписаться" : "Подписаться" }}
                        </PrimaryButton>
                    </template>
                </div>
                <div class="general_info flex justify-start mb-[20px]">
                    <p class="mr-[20px]">{{ this.post }} post</p>
                    <p class="mr-[20px]">{{ this.followers }} followers</p>
                    <p class="mr-[20px]">{{ this.following }} following</p>
                </div>
                <div class="nick_name mb-[20px]">{{ this.profile.title }}</div>
                <div class="desc mb-[20px]">{{ this.profile.description }}</div>
            </div>
        </div>
        <div class="url_create" v-show="show_create">
            <PrimaryButton @click="assign()" type="submit" class="url_create ml-[20px] max-[650px]:mt-[30px] h-[auto]">
                Создать пост
            </PrimaryButton>
        </div>
    </div>
</template>

<script>
import {usePage} from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {router} from '@inertiajs/vue3'

export default {
    name: "ProfileInfo",
    components: {
        PrimaryButton,
    },

    props: {
        username: {
            type: String,
        },
        user_id: {
            type: Number,
            default: -1,
        },
        status: {
            type: Boolean,
        },
        profile: {
            type: Object
        },
        post: {
            type: Number,
            default: 0,
        },
        followers: {
            type: Number,
            default: 0,
        },
        following: {
            type: Number,
            default: 0,
        },
    },
    data() {
        return {
            show_create: false,
            show_follow: true,
            user: usePage().props.auth.user,
        }
    },
    mounted() {
        if (this.user) {
            if (this.user.id === this.user_id) {
                this.show_create = true;
            }
        }
    },
    beforeMount() {
        if (!(this.user)) {
            this.show_follow = false;
        }
    },

    methods: {
        followUser() {
            router.visit(route("follow.create", {user: this.user_id}), {
                method: 'post',
            })
        },
        assign(){
            window.location.assign(route('posts.create'));
        }
    }

}
</script>

<style scoped>

</style>
