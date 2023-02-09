<template>
    <div class="liveView">
        <h3>Vue HLS Video Demo (480p)</h3>

        <hls-player :width="900" :height="500" :autoplay="false" :muted="true" :controls="true" ref="myPlayer" :source="src"/>

        <h3>Vue HLS Video Demo (720p)</h3>

        <hls-player :width="900" :height="500" :autoplay="false" :muted="true" :controls="true" ref="myPlayer" :source="src1"/>

    </div>
</template>

<script>
import 'hls-player/dist/hls-player.css'
import hlsPlayer from 'hls-player'

export default {
    components: {
        hlsPlayer,
    },
    data() {
        return {
            src:"http://127.0.0.1:8000/selar-converts/hls-converted_480p.m3u8",
            src1:"http://127.0.0.1:8000/selar-converts/hls-converted_720p.m3u8",
        };
    }
}
</script>

<style scoped>
.liveView {
    position: relative;
}
.selectWrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 20px;
    line-height: 30px;
    margin: 20px;
    vertical-align: baseline;
}
.inputWrapper {
    width: 500px;
    margin: 0 auto;
}
.buttonWrapper {
    text-align: center;
}
</style>
