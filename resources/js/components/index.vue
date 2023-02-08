<template>
    <div>
        <div class="player-container">
            <vplayer :playerOptions="vOption" @onplay="play"/>
        </div>

    </div>
</template>
<script>
import HLSCore from '@core-player/playcore-hls'
import player from 'vue-hls-player'
import Vue from "vue";

Vue.use(player)


export default {
    data() {
        return {
            HLSCore,
            vOption: {
                type: "application/x-mpegURL",
                src: 'http://127.0.0.1:8000/hls-stream_480p.ts',
                preload: true,
                autoplay: true,
                isLoop: false,
                playsinline: false,
                controls: 'progress,current,durration,volume',
                crossOrigin: false
            },

        }
    },

    methods: {
        play(e) {
            console.log(e)
        }
    }

}

</script>
