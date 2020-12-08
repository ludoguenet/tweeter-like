<template>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form @submit.prevent="postTweet">
                <textarea ref="tweetTextarea" @input="resizeTweetTextarea" placeholder="Que se passe-t-il ?" class="rounded-lg border border-gray-200 w-full p-2 font-semibold resize-none focus:outline-none" v-model="content"></textarea>
                <span class="my-5 text-red-500" v-if="$page.errors.content">
                    {{ $page.errors.content }}
                </span>
                <div class="flex items-center space-x-4 justify-end mt-3">
                    <p class="text-sm text-gray-400 font-thin" :class="{ 'text-red-500' : calculateRemainingChar < 0 }">{{ calculateRemainingChar }} caractères restants</p>
                    <button-vue :disabled="!canSubmit" class="bg-blue-500 hover:bg-blue-800 rounded-full font-extrabold">Tweet</button-vue>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import Button from '../../Jetstream/Button.vue'

    export default {
    components: { ButtonVue: Button },

    data() {
        return {
            'content': '',
            'maxChar': 280
        }
    },

    methods: {
        postTweet() {
            this.$inertia.post('/tweets',
                { 'content' : this.content },
                { preserveState: false }
            )
        },

        resizeTweetTextarea() {
            let textarea = this.$refs['tweetTextarea']
            textarea.style.height = 'initial'
            textarea.style.height = `${textarea.scrollHeight}px`
        }
    },

    computed: {
        calculateRemainingChar() {
            return this.maxChar - this.content.length
        },

        canSubmit() {
            return this.content.length && this.calculateRemainingChar >= 0
        }
    }

    }
</script>

<style scoped>
    button:disabled {
        opacity: 50%;
        cursor: not-allowed;
    }
</style>
