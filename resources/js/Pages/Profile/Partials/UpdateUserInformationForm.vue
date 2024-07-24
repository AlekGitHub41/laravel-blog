<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Link, router, useForm, usePage} from '@inertiajs/vue3';

let props = defineProps({
    profile: {
        type: Object,
    },
    errors: {
        type: Object,
    },
})
const profile = props.profile;
console.log(profile)
const form = useForm({
    title: profile.title,
    description: profile.description,
    image: null,
});

function submit() {
    form.post(route('custom_profile.update'));
}
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-white">Информация профиля</h2>

            <p class="mt-1 text-sm text-white">
                Обновите информацию вашего профиля.
            </p>
        </header>
        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <div>
                <InputLabel for="title" value="Title"/>
                <TextInput
                    id="title"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.title"
                    required
                    autofocus
                    autocomplete="title"
                />
                <InputError class="mt-2" :message="form.errors.title"/>
            </div>

            <div>
                <InputLabel for="description" value="description"/>
                <TextInput
                    id="description"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.description"
                    required
                    autocomplete="description"
                />
                <InputError class="mt-2" :message="form.errors.description"/>
            </div>
            <div>
                <InputLabel for="image" value="image"/>
                <input id="image" name="image" type="file" class="mt-1"
                       @input="form.image = $event.target.files[0]">
                <InputError class="mt-2" :message="form.errors.image"/>
            </div>
            <PrimaryButton type="submit">Сохранить</PrimaryButton>
        </form>
    </section>
</template>
