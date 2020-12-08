<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Vos abonnements
            </h2>
        </template>

       <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div v-for="tweet in followings" v-bind:key="tweet.id" class="flex items-center space-x-4 bg-white overflow-hidden rounded rounded-b-none border-b-2 border-gray-200 py-6 px-4">
                    <img class="h-16 w-16 object-cover rounded-full" :src="tweet.user.profile_photo_url">
                    <div class="flex flex-col w-2/3">
                    <span class="text-sm text-gray-900 font-bold">{{ tweet.user.name }} <span class="font-thin text-gray-400">· le {{ tweet.created_at }}</span></span>
                    <div class="text-sm text-gray-400 font-thin">{{ tweet.content }}</div>
                    </div>
                   <div class="w-40">
                    <inertia-link as="button" :href="`/unfollows/${tweet.user.id}`" method="POST" class="bg-white text-blue-500 cursor-pointer px-5 py-2 flex-shrink-0 hover:text-white border border-blue-500 leading-tight hover:bg-blue-500 rounded-full font-extrabold transition-all duration-300" preserve-scroll>Ne Plus Suivre</inertia-link>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import NavLink from '@/Jetstream/NavLink'

    export default {
        components: {
            AppLayout,
            NavLink,
        },

        props: {
            followings: Array,
        }
    }
</script>
