<template>
    <div>
        <div class="bg-gray-200 w-full rounded">
            <div class="bg-green-500 rounded-l text-white text-center transition-width duration-500" :style="'width:' + percentage + '%'">{{ percentage }}%</div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['episodes', 'watched_episode'],

        data() {
            return {
                watchedEpisode: this.watched_episode
            }
        },

        computed: {
            percentage() {
                let filterEp = this.episodes.filter(elem => {
                    return this.watchedEpisode.find(ep => {
                        return ep.id == elem.id
                    })
                });

                return Math.ceil(filterEp.length / this.episodes.length * 100);
            }
        },

        mounted() {
            eventBus.$on('toggleBarProgress', data => this.watchedEpisode = data);
        }
    }
</script>