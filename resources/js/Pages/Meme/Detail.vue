<template>
    <app-layout title="Memes">
        <div v-html="media"></div>
        <pre class="text-white">{{meme}}</pre>
        <pre class="text-blue-500">{{owner}}</pre>
    </app-layout>
</template>

<script>
import {defineComponent} from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

export default defineComponent({
    props: {
        meme: Object,
        media: String,
        owner: Object
    },
    components: {
        AppLayout
    }
})
</script>
