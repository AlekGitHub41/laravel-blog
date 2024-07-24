<template>
    <div class="item relative w-auto h-[311px] max-[567px]:h-[130px] cursor-pointer"
         @click="this.clickImg()">
        <img :src="src_img" alt="" class="absolute w-full h-full object-cover">
    </div>
    <div
        class="fixed text-white top-0 left-0 right-0 bottom-0 bg-black bg-opacity-50 z-[1000] overflow-y-auto flex justify-center py-[30px]"
        v-if="this.modal__show" @click="close()">
        <div
            class="modal max-w-[60%] max-[1110px]:max-w-[90%] w-full min-h-[630px] h-[90%] bg-black rounded-[1%]" style="box-shadow: #282829 0px 5px 15px;"
            @click.stop>
            <div class="modal_header w-full h-[6%] flex justify-end align-center">
                <div class="relative burger w-[30px] h-[30px] mt-[8px] mr-[10px]" v-if="user.id===user_id">
                    <img :src="burger" alt=""
                         @click="this.modal_burger=!this.modal_burger"
                         class="cursor-pointer">
                    <div class="absolute bg-gray-800 text-white py-[15px] rounded-[5px]" v-if="this.modal_burger">
                        <ul>
                            <li class="mb-[10px] w-[120px] hover:bg-[#374151] py-[4px]">
                                <a
                                   click.prevent
                                   @click="this.fetchDeletePost()"
                                   class="position_href">Удалить</a>
                            </li>
                            <li class="hover:bg-[#374151] w-[120px] py-[4px]">
                                <a
                                    :href="route('posts.update',{posts:this.post_id})"
                                    class="position_href">Обновить</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="text-white text-[26px] mr-[7px] box-border cursor-pointer h-[25px] mt-[10px]"
                     @click="close()">&times;
                </div>
            </div>
            <div class="modal_main flex w-full h-[94%] pb-[4%]">
                <div class="main_img w-[65%] h-full relative">
                    <img :src="get_img" alt="" class="absolut top-0 left-0 w-full h-full object-cover">
                </div>
                <div class="main_desc w-[35%] box-border p-[5px]">
                    <div class="main_desc_content w-full h-full">
                        <div class="modal__avatar h-full box-border pr-[8px] pl-[8px]"
                             style="overflow-y: auto">
                            <div class="modal_avatar w-[45px] h-[45px] mr-[6px] float-left">
                                <img :src="avatar" alt="" class="rounded-full w-full h-full">
                            </div>
                            <span class="mr-[6px]"><strong>{{ this.username }}:</strong></span>
                            <span style="word-break:break-all;">{{ this.caption }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {usePage} from '@inertiajs/vue3'

export default {
    name: "Item",
    props: {
        src_img: {
            type: String,
        },
        user_id: {
            type: Number,
        },
        avatar: {
            type: String,
        },
        username: {
            type: String,
        },
        post_id: {
            type: Number,
        }
    },
    emits: ['deletePost'],
    methods: {
        async fetchDeletePost() {
            const response = await axios.get(route("posts.destroy"), {
                params: {
                    post_id: this.post_id,
                }
            }).then(result => {
                    this.modal__show = !this.modal__show;
                    this.$emit("deletePost", this.post_id)
                },
                error => {
                    console.log(error)
                });
        },
        async fetchPost() {
            const response = await axios.get(route("post.get"), {
                params: {
                    post_id: this.post_id,
                }
            }).then(result => {
                    this.get_img = result.data.image
                    this.caption = result.data.caption
                },
                error => {
                    console.log(error);
                })
        },
        clickImg() {
            this.modal__show = !this.modal__show;
            this.fetchPost();
            document.body.classList.toggle("no-scroll");
        },
        close(){
            this.modal__show=!this.modal__show;
            this.modal_burger=false
            document.body.classList.toggle("no-scroll");
        }
    },
    data() {
        return {
            burger: "/img/burger-menu.svg",
            modal_burger: false,
            modal__show: false,
            user: usePage().props.auth.user,
            get_img: "/storage/loading.gif",
            caption: "",
        }
    },
}
</script>

<style scoped>
.position_href{
    display: block;width: min-content; margin: 0 auto;
}
</style>
