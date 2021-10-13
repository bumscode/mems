<template>
    <img class="max-w-xs rounded-lg shadow-md" :srcset="responsiveString" loading="lazy" />
</template>

<script>
import { defineComponent, toRefs } from 'vue'

export default defineComponent({
    props: {
        images: Object,
        memeId: Number
    },

    setup(props) {
        const urls = props.images.urls.map(url => {
            const result = url.match(/__media_library_original_(\d*?)_(\d.*?)\./)

            return `/media/${props.memeId}/responsive-images/${url} ${result[1]}w`
        })

        const responsiveString = urls.join(', ')

        return {
            responsiveString
        }
    }
})
</script>

