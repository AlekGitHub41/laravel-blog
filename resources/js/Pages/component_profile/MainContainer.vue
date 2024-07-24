<template>
    <div class="container__ w-full flex text-base font-normal text-white bg-black min-h-[100vh]">
        <div
            class="main_content px-[10px] pb[10px] w-full bg-black min-h-[100vh]">
            <div class="profile_content w-full max-w-[964px] border-black mx-auto">
                <slot></slot>
                <div id="observe" class="w-full h-[1px]" v-if="post>0"></div>
            </div>
        </div>
    </div>
</template>

<script>

export default {

    name: "MainContainer",
    props: {
        user_id: {
            type: Number,
        },
        post: {
            type: Number,
        },
        lastPage: {
            type: Number,
        }
    },
    data() {
        return {
            page: 2,
            posts: [],
        }
    },
    methods: {
        async fetchData() {
            try {
                const response = await axios.get(route("ajax"), {
                    params: {
                        page: this.page,
                        user: this.user_id,
                    }
                })
                const data = response.data;
                console.log(data)
                this.posts = data.data;
                this.addDataPosts();
                this.page += 1;
            } catch (error) {
                console.error('Ошибка при получении данных:', error);
            }
        },
        addDataPosts() {
            this.$emit("addPost", this.posts)
        }
    },
    mounted() {
        console.log(this.post);
        let options = {
            rootMargin: "0px",
            threshold: 1.0,
        };
        let callback = (entries, observer) => {
            if (entries[0].isIntersecting && this.lastPage + 1 > this.page) {
                this.fetchData();
            }
        };

        let observer = new IntersectionObserver(callback, options);
        if (this.post > 0) {
            observer.observe(document.getElementById("observe"))
        }
    }
}
</script>

<style scoped>
</style>
