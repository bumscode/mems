<template>
    <div class="fixed inset-0 overflow-hidden" role="dialog" aria-modal="true" v-if="showingUploadForm">
        <div class="absolute inset-0 overflow-hidden">
            <!--
              Background overlay, show/hide based on slide-over state.

              Entering: "ease-in-out duration-500"
                From: "opacity-0"
                To: "opacity-100"
              Leaving: "ease-in-out duration-500"
                From: "opacity-100"
                To: "opacity-0"
            -->
            <transition name="fade" appear>
                <div class="absolute inset-0 bg-gray-800 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            </transition>
            <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
                <transition name="slide" appear>
                    <!--
                      Slide-over panel, show/hide based on slide-over state.

                      Entering: "transform transition ease-in-out duration-500 sm:duration-700"
                        From: "translate-x-full"
                        To: "translate-x-0"
                      Leaving: "transform transition ease-in-out duration-500 sm:duration-700"
                        From: "translate-x-0"
                        To: "translate-x-full"
                    -->
                    <div class="relative w-96" v-if="showingUploadForm">
                        <!--
                          Close button, show/hide based on slide-over state.

                          Entering: "ease-in-out duration-500"
                            From: "opacity-0"
                            To: "opacity-100"
                          Leaving: "ease-in-out duration-500"
                            From: "opacity-100"
                            To: "opacity-0"
                        -->
                        <div class="absolute top-0 left-0 -ml-8 pt-4 pr-2 flex sm:-ml-10 sm:pr-4">
                            <button type="button"
                                    class="rounded-md text-gray-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                                    @click="$emit('close')">
                                <span class="sr-only">Close panel</span>
                                <!-- Heroicon name: outline/x -->
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Slide-over panel, show/hide based on slide-over state. -->
                        <div class="h-full bg-gray-900 p-8 overflow-y-auto">
                            <div class="pb-16 space-y-6">
                                <div>
                                    <h3 class="font-black text-2xl text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-yellow-600">Titel</h3>
                                    <div class="mt-2 relative">
                                            <div class="absolute -inset-0.5 bg-gradient-to-r from-pink-600 to-purple-600 rounded-lg blur-sm opacity-75 group-hover:opacity-100 transition duration-100 group-hover:duration-200 animate-tilt"></div>
                                            <input
                                                type="text"
                                                name="memetitle"
                                                id="memetitle"
                                                v-model="meme.title"
                                                class="relative bg-gray-900 shadow-sm focus:ring-pink-500 focus:border-pink-500 block w-full sm:text-sm border-gray-800 rounded-md text-white border border-pink-500"
                                                placeholder="Gib deinem Kunstwerk einen Namen.">
                                    </div>
                                </div>
                                <div>
                                    <h3 class="font-black text-2xl text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-yellow-600">Beschreibung</h3>
                                    <div class="mt-2 flex items-center justify-between relative">
                                        <div class="absolute -inset-0.5 bg-gradient-to-r from-pink-600 to-purple-600 rounded-lg blur-sm opacity-75 group-hover:opacity-100 transition duration-1000 group-hover:duration-200 animate-tilt"></div>
                                        <textarea
                                            name="memedescription"
                                            id="memedescription"
                                            v-model="meme.description"
                                            rows="6"
                                            class="py-3 px-4 relative block w-full shadow-sm bg-gray-900 focus:ring-pink-500 focus:border-pink-500 sm:text-sm border border-gray-800 rounded-md text-white border border-pink-500"
                                            placeholder="Erzaehl uns etwas ueber dein Kunstwerk. Und hoert mir nur auf damit staendig den Titel hier reinzukopieren 🤬!!!1"></textarea>
                                    </div>
                                </div>
                                <div>
                                    <div class="block w-full rounded-lg relative">
                                        <div class="absolute -inset-0.5 bg-gradient-to-r from-pink-600 to-purple-600 rounded-lg blur-sm opacity-75 group-hover:opacity-100 transition duration-1000 group-hover:duration-200 animate-tilt"></div>
                                        <file-pond
                                            name="meme"
                                            ref="pond"
                                            label-idle="Lege hier das Meme behutsam ab..."
                                            max-files="1"
                                            accepted-file-types="image/jpeg, image/png, image/gif, video/mp4"
                                            :server="server"
                                            @processfile="_handleFilePondProcessfile"
                                        />
                                    </div>
                                    <div class="mt-4 flex items-start justify-between" v-if="meme.id !== null">
                                        <div>
                                            <h2 class="font-black text-2xl text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-yellow-600"><span class="sr-only">Details for </span>
                                                {{meme.name }}
                                            </h2>
                                            <p class="text-sm font-medium text-gray-500">{{ meme.size }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex">
                                    <button
                                        type="button"
                                        class="flex-1 bg-pink-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                        @click="submitMeme"
                                    >
                                        Speichern
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>

            </div>
        </div>
    </div>

</template>

<script>
import {defineComponent} from 'vue'
// Import Vue FilePond
import vueFilePond from "vue-filepond";

// Import FilePond styles
import "filepond/dist/filepond.min.css";

// Import FilePond plugins
// Please note that you need to install these plugins separately

// Import image preview plugin styles
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

// Import image preview and file type validation plugins
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";

// Create component
const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview
);

export default defineComponent({
    components: {
        FilePond
    },
    props: ['showingUploadForm'],
    data() {
        return {
            meme: {
                id: null,
                name: null,
                size: null
            },
            server: {
                process: {
                    url: '/temp-meme',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': this.$page.props.csrf_token
                    },
                },
                revert: {
                    url: '/temp-meme/delete',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': this.$page.props.csrf_token,
                    }
                }
            }
        }
    },
    methods: {
        submitMeme() {
            this.$inertia.post('/memes', {
                meme: {
                    title: this.meme.title,
                    description: this.meme.description,
                    id: this.meme.id,
                    name: this.meme.name
                }
            })
        },
        _handleFilePondProcessfile(error, file) {
            this.meme.id = file.serverId
            this.meme.name = file.filename
            this.meme.size = this.humanFileSize(file.fileSize)

            this.$nextTick()
        },
        humanFileSize(bytes, si = false, dp = 1) {
            const thresh = si ? 1000 : 1024;

            if (Math.abs(bytes) < thresh) {
                return bytes + ' B';
            }

            const units = si
                ? ['kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']
                : ['KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB'];
            let u = -1;
            const r = 10 ** dp;

            do {
                bytes /= thresh;
                ++u;
            } while (Math.round(Math.abs(bytes) * r) / r >= thresh && u < units.length - 1);


            return bytes.toFixed(dp) + ' ' + units[u];
        },
    }
})
</script>

<style lang="css" scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s ease-in-out;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.slide-enter-active,
.slide-leave-active {
    transform: translateX(0px);
    transition: 0.5s ease-in-out;
}

.slide-enter-from,
.slide-leave-to {
    transform: translateX(100%);
}
</style>
