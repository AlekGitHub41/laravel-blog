<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {Head} from '@inertiajs/vue3';
import {router} from '@inertiajs/vue3'
import {reactive} from 'vue'

const props = defineProps({
    posts: Object,
    errors: Object,
})
const form = reactive({
    caption: props.posts.caption,
    image: null,
})

function submit() {
    router.visit(route("posts.post.update"), {
        method: 'post',
        form,
        data: {
            id: props.posts.id,
            ...form,
        },
    })
}
</script>
<template>
    <Head title="Обновление поста"/>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-black shadow sm:rounded-lg" style="box-shadow: 0 4px 8px rgba(255, 255, 255, 0.08), 0 0px 4px rgba(255, 255, 255, 0.08);">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-white">Обновить пост</h2>
                        </header>
                        <main>
                            <form @submit.prevent="submit" class="mt-6 space-y-6">
                                <div>
                                    <InputLabel for="name" value="Заголовок поста"/>
                                    <TextInput
                                        id="name"
                                        type="text"
                                        class="mt-1 block w-[80%]"
                                        v-model="form.caption"
                                        required
                                        autofocus
                                        autocomplete="name"
                                    />
                                    <InputError class="mt-2" :message="errors.caption"/>
                                </div>
                                <div>
                                    <InputLabel for="image" value="Изображение"/>
                                    <input name="image" type="file" class="mt-1"
                                           @input="form.image = $event.target.files[0]">

                                    <InputError class="mt-2" :message="errors.image"/>
                                </div>
                                <PrimaryButton type="submit">Сохранить</PrimaryButton>
                            </form>
                        </main>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
