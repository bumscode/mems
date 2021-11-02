<template>
    <app-layout title="Memes">
        <div v-html="media"></div>
        <pre class="text-white">{{meme}}</pre>
    </app-layout>
</template>

<script>
import {defineComponent} from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

export default defineComponent({
    props: {
        meme: Object,
        media: String,
    },
    components: {
        AppLayout
    }
})
</script>
