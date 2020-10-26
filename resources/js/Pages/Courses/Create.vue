<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ajouter une formation
            </h2>
        </template>

        <div class="py-3">
            <form class="w-3/4 bg-white shadow-md rounded px-8 py-6 mx-auto mb-4" @submit.prevent="submit">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                        Titre de la formation
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" type="text" v-model="form.title">
                    <div class="bg-red-100 text-red-800 p-2 mt-2" v-if="$page.flash.errors.title">
                        {{ $page.flash.errors.title[0] }}
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                        Description de la formation
                    </label>
                    <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" type="text" v-model="form.description"></textarea>
                    <div class="bg-red-100 text-red-800 p-2" v-if="$page.flash.errors.description">
                        {{ $page.flash.errors.description[0] }}
                    </div>
                </div>

                <h2 class="text-2xl mb-4">Episodes de la formation</h2>

                <div class="mb-4">
                    <div class="mb-4" v-for="(episode, index) in form.episodes" v-bind:key="index">
                        <label class="block text-gray-700 text-sm font-bold mb-2" :for="'title-'+index">
                            Titre de l'épisode {{ index+1 }}
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" :id="'title-'+index" type="text" v-model="form.episodes[index].title">
                        <div class="bg-red-100 text-red-800 p-2 mt-2" v-if="$page.flash.errors['episodes.' + index + '.title']">
                            {{ $page.flash.errors['episodes.' + index + '.title'] }}
                        </div>

                        <label class="block text-gray-700 text-sm font-bold mb-2" :for="'description-'+index">
                            Description de l'épisode {{ index+1 }}
                        </label>
                        <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" :id="'description-'+index" type="text" v-model="form.episodes[index].description"></textarea>
                        <div class="bg-red-100 text-red-800 p-2 mt-2" v-if="$page.flash.errors['episodes.' + index + '.description']">
                            {{ $page.flash.errors['episodes.' + index + '.description'] }}
                        </div>

                        <label class="block text-gray-700 text-sm font-bold mb-2" :for="'video_url-'+index">
                            URL de l'épisode {{ index+1 }}
                        </label>
                        <input class="mb-2 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" :id="'video_url-'+index" type="text" v-model="form.episodes[index].video_url">
                        <div class="bg-red-100 text-red-800 p-2 mt-2" v-if="$page.flash.errors['episodes.' + index + '.video_url']">
                            {{ $page.flash.errors['episodes.' + index + '.video_url'] }}
                        </div>

                        <div v-if="index < form.episodes.length - 1" class="bg-indigo-700 w-full h-1 rounded"></div>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <button class="py-2 px-4 bg-green-600 rounded text-white block mb-4" @click.prevent="addEp">Ajouter une épisode</button>
                    <button v-if="form.episodes.length > 1" class="py-2 px-4 bg-red-600 rounded text-white block mb-4" @click.prevent="removeEp">Retirer une épisode</button>
                </div>

                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Enregistrer la formation
                </button>
            </form>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from './../../Layouts/AppLayout';
    
    export default {
        components: {
            AppLayout,
        },

        data() {
            return {
                form: {
                    title: null,
                    description: null,
                    episodes: [
                        {title: null, description: null, video_url: null},
                    ]
                }
            }
        },

        methods: {
            submit() {
                this.$inertia.post('/courses', this.form);
            },

            addEp() {
                this.form.episodes.push({title: null, description: null, video_url: null});
            },

            removeEp() {
                this.form.episodes.pop();
            },
        }
        
    }
</script>