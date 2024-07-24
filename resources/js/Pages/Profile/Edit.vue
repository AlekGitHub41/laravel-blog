<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import UpdateUserInformationForm from './Partials/UpdateUserInformationForm.vue';
import {Head} from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    profile: {
        type: Object,
    },
});
</script>

<template>
    <Head title="Profile"/>

    <AuthenticatedLayout>
        <!--        <template #header>-->
        <!--            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profile</h2>-->
        <!--        </template>-->
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-black shadow sm:rounded-lg" style="box-shadow: 0 4px 8px rgba(255, 255, 255, 0.08), 0 0px 4px rgba(255, 255, 255, 0.08);">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>
                <div class="p-4 sm:p-8 bg-black shadow sm:rounded-lg" style="box-shadow: 0 4px 8px rgba(255, 255, 255, 0.08), 0 0px 4px rgba(255, 255, 255, 0.08);">
                    <UpdateUserInformationForm
                        :profile="profile"
                        class="max-w-xl"
                    />
                </div>

                <div class="p-4 sm:p-8 bg-black shadow sm:rounded-lg" style="box-shadow: 0 4px 8px rgba(255, 255, 255, 0.08), 0 0px 4px rgba(255, 255, 255, 0.08);">
                    <UpdatePasswordForm class="max-w-xl"/>
                </div>

                <div class="p-4 sm:p-8 bg-black shadow sm:rounded-lg" style="box-shadow: 0 4px 8px rgba(255, 255, 255, 0.08), 0 0px 4px rgba(255, 255, 255, 0.08);">
                    <DeleteUserForm class="max-w-xl"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
