<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editer la formation {{ form.title }}
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
                        <div class="flex justify-between items-center">
                            <label class="block text-gray-700 text-sm font-bold mb-2" :for="'title-'+index">
                                Titre de l'épisode {{ index+1 }}
                            </label>
                            <button v-if="form.episodes.length > 1" class="bg-red-600 p-1 rounded text-white block mb-4" @click.prevent="removeEp(form.episodes[index].id)">Retirer cette épisode</button>
                        </div>
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

                <button class="py-2 px-4 bg-green-600 rounded text-white block mb-4" @click.prevent="addEp">Ajouter une épisode</button>
                
                <div class="flex justify-between items-center">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Enregistrer la formation
                    </button>
                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" @click.prevent="removeCourse">
                        Supprimer la formation
                    </button>
                </div>
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

        props: ['course'],

        data() {
            return {
                form: this.course
            }
        },

        methods: {
            submit() {
                this.$inertia.put('/course/edit/' + this.form.id, this.form);
            },

            addEp() {
                this.form.episodes.push({title: null, description: null, video_url: null});
            },

            removeEp(id) {
                this.form.episodes = this.form.episodes.filter(elem => elem.id != id);
            },

            removeCourse() {
                this.$inertia.delete('/course/edit/' + this.form.id, this.form);
            }
        }
        
    }
</script>