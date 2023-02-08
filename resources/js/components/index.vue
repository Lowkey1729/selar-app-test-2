<template>
    <div>
        <div class="player-container">
            <video-player class="vjs-custom-skin" ref="videoPlayer" :options="playerOptions">
            </video-player>
        </div>

    </div>
</template>
<script>

import Vue from "vue";
import videoPlayer from "vue-vjs-hls";

import VideoPlayer from 'vue-video-player';

Vue.use(VideoPlayer)



export default {
    data () {
        return {
            url: '',
            playerOptions: {
                autoplay: false,
                controls: true,
                sources: [{
                    type: "video/hls",
                    src: "http://127.0.0.1:8000"
                }]
            }
        }
    },
    methods: {
        handleApply () {
            this.playerOptions.sources[0].src = this.url
        }
    }
}

</script>
