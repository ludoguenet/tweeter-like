<template>
    <app-layout>
        <template #header>
            <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Profile de {{ profileUser.name }}
            </h2>
                <div v-if="profileUser.id !== $page.user.id">
                    <inertia-link v-if="!profileUser.isFollowing" as="button" :href="`/follows/${profileUser.id}`" method="POST" class="bg-white text-blue-500 cursor-pointer px-5 py-2 hover:text-white border border-blue-500 leading-tight hover:bg-blue-500 rounded-full font-extrabold transition-all duration-300" preserve-scroll>Suivre</inertia-link>
                </div>
            </div>
        </template>

       <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div v-for="tweet in tweets" v-bind:key="tweet.id" class="flex items-center space-x-4 bg-white overflow-hidden rounded rounded-b-none border-b-2 border-gray-200 py-6 px-4">
                    <img class="h-16 w-16 object-cover rounded-full" :src="profileUser.profile_photo_url">
                    <div class="flex flex-col w-2/3">
                    <span class="text-sm text-gray-900 font-bold">{{ profileUser.name }} <span class="font-thin text-gray-400">· le {{ tweet.created_at }}</span></span>
                    <div class="text-sm text-gray-400 font-thin">{{ tweet.content }}</div>
                    <p v-if="profileUser.is_following_you" class="text-blue-400 text-xs">Cet utilisateur vous suit</p>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'

    export default {
        components: {
            AppLayout,
        },

        props: {
            profileUser: Object,
            tweets: Array,
        }
    }
</script>
