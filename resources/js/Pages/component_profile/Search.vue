<template>
    <div class="fixed inset-0 bg-black bg-opacity-50 z-[500]" v-if="this.show" @click="click_arrow">
    </div>
    <div class="search_profile" id="search__" style="box-shadow: #282829 0px 5px 15px;">
        <div class="search_container p-[10px] h-full" v-if="this.show" id="search_container">
            <div class="search__ max-h-[30px]">
                <input type="text" class="w-[98%] text-black" placeholder="Введиди имя профиля" v-model="search">
            </div>
            <div class="found_profiles overflow-y-auto mt-[20px] mb-[10px]" style="height: calc(100% - 50px);">
                <div class="found_profile relative flex items-center max-w-[150px] mt-[10px] cursor-pointer"
                     v-for="i in profiles" @click="this.goToProfile(i.id)">
                    <img :src="i.image" alt="" class="__profile w-[40px] h-[40px] rounded-full mr-[5px]">
                    <p class="name_found_profile">{{ i.name }}</p>
                </div>
            </div>
        </div>
        <div class="w-[20px] h-[20px] rounded-full bg-[#48484E] absolute top-1/2 right-[-12px]"
             @click="click_arrow" id="arrow">
            <img src="/svg/arrov.svg" alt="">
        </div>
    </div>
</template>

<script>
import {ref} from "vue";

export default {
    name: "Search",
    data() {
        return {
            show: ref(false),
            search_profile: "",
            search: "",
            profiles: [],
            arrow: "",
        }
    },
    mounted() {
        this.fetchProfiles();
        this.search_profile = document.getElementById("search__");
        this.arrow = document.getElementById("arrow");
    },
    methods: {
        click_arrow(event) {
            this.show = !this.show;
            document.body.classList.toggle("no-scroll");
            this.search_profile.classList.toggle("search_open");
            this.arrow.classList.toggle("arrow_rotate");
            this.search = "";
        },
        async fetchProfiles() {
            const response = await axios.get(route("ajax_profiles"), {
                params: {
                    search: this.search,
                }
            }).then(result => {
                    // console.log(result.data)
                    this.profiles = result.data;
                    console.log(this.profiles)
                },
                error => {
                    console.log(error)
                });
        },
        goToProfile(id) {
            window.location.assign(route("profile.show", {user: id}));
            console.log(id);
        }
    },
    watch: {
        search(newSearch) {
            this.fetchProfiles();
        },
    }
}
</script>

<style scoped>
* {

}
</style>
