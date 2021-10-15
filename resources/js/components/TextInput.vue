<template>
    <div class="relative">
        <div class="absolute -inset-0.5 bg-gradient-to-r from-pink-600 to-purple-600 rounded-lg blur-sm opacity-75 group-hover:opacity-100 transition duration-100 group-hover:duration-200 animate-tilt"></div>
        <input
            :placeholder="placeholder"
            class="relative bg-gray-900 shadow-sm focus:ring-pink-500 focus:border-pink-500 block w-full sm:text-sm border-gray-800 rounded-md text-white border border-pink-500"
            :type="type"
            :name="name"
            :id="id"
            :value="email"
            @input="$emit('update:email', $event.target.value)"
        >
    </div>
</template>

<script>
import {defineComponent} from 'vue'

export default defineComponent({
    props: {
        email: String,
        id: {
            type: String,
            required: true
        },
        name: {
            type: String,
            required: true
        },
        type: {
            type: String,
            required: true
        },
        placeholder: {
            type: String,
            required: true
        }
    },

    emits: ['update:email'],
})
</script>
