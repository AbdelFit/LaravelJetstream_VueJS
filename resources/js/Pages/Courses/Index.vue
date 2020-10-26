<template>
    <app-layout>
        <!-- <template slot="header"> --> <!-- les 2 lignes sont pareils -->
        <template #header> 
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Listes des formations
            </h2>
        </template>

        <div class="bg-green-200 text-green-500 mb-4 mx-8 my-3 p-3" v-if="$page.flash.success">
            {{ $page.flash.success }}
        </div>

        <div class="py-3" v-for="course in this.courseList" v-bind:key="course.id">
            <div class="mx-8 bg-white rounded shadow p-2">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-700">
                        Par : {{ course.user.name }} 
                    </div>
                    <div class=" text-sm text-gray-400">
                        {{ course.participants }} 
                        participant<span v-if="parseInt(course.participants) > 1">s</span>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <div class="text-4xl">{{ course.title }}</div>
                    <div class="text-sm text-gray-400">{{ course.episodes_count }} épisodes</div>
                </div>
                <div class="text-sm text-gray-600">{{ course.description }}</div>
                <a :href="'course/' + course.id" class="bg-indigo-500 text-white px-2 py-1 text-sm mt-3 inline-block rounded hover:bg-indigo-700">Accéder à la formation</a>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from './../../Layouts/AppLayout';
    
    export default {
        components: {
            AppLayout,
        },
        
        props: ['courses'],

        data() {
            return {
                courseList: this.courses
            }
        },

        mounted() {
            
        }
    }
</script>