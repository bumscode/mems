<template>
    <Head title="Welcome" />

    <div class="relative flex items-top justify-center min-h-screen bg-gray-900 sm:items-center sm:pt-0">

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-6xl block font-black text-pink-500 mb-6">Hi this is mems.wtf</h1>
            <div class="flex">
                <text-input
                    placeholder="enter your email"
                    id="login-input"
                    name="login-input"
                    type="text"
                    v-model:email="email"
                />
                <button
                    type="button"
                    class="flex-1 bg-pink-600 py-1 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    @click="login"
                >
                    Login
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import TextInput from '@/components/TextInput';

    export default defineComponent({
        components: {
            TextInput,
            Head,
            Link,
        },
        data () {
          return {
              email: null
          }
        },
        methods: {
            login() {
                this.$inertia.post('/login', {
                    email: this.email
                })
            }
        }
    })
</script>
