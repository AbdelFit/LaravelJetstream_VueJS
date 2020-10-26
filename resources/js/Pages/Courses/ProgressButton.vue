<template>
    <div>
        <button class="bg-green-500 px-2 py-2 rounded text-white" @click="toggleProgress()">
            {{ this.isWatched ? 'Terminée' : 'Terminée ?' }}
        </button>
    </div>
</template>

<script>
    export default {
        props: ['episode_id', 'watched_episodes'],

        data() {
            return {
                watchedEp: this.watched_episodes,
                isWatched: null
            }
        },

        methods: {
            toggleProgress() {
                axios.post('/toggleProgress', {
                    episodeId: this.episode_id,
                })
                .then(res => {
                    if (res.status == 200) {
                        this.isWatched = !this.isWatched;
                        eventBus.$emit('toggleBarProgress', res.data);
                    }
                })
                .catch(err => console.log(err))
            },

            isWatchedEp() {
                return this.watchedEp.find(elem => elem.id == this.episode_id) ? true : false;
            }
        },

        mounted() {
            this.isWatched = this.isWatchedEp();
        }
    }
</script>