<template>
    <app-layout title="Memes">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <template v-for="meme in memes">
                    <div class="text-white">({{ meme.id }}){{ meme.title }}</div>
                    <div class="mb-8" v-html="meme.image"></div>
                </template>
            </div>
        </div>
    </app-layout>
</template>

<script>
import {defineComponent} from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import ResponsiveImage from "@/components/ResponsiveImage"

export default defineComponent({
    props: {
        memes: Array
    },
    components: {
        AppLayout,
        ResponsiveImage
    },
})
</script>
