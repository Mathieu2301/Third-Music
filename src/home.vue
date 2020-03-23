<template>
  <div class="home">
    <div class="header">
      <div class="title">Third Music</div>
      <img src="@/assets/logo.png" alt="logo">
    </div>
    <div :class="{
      content: true,
      hideable: true,
      hidden: musics == false
    }">
      <div class="musics_conatiner" v-if="musics != false">
        <div
          v-scroll-reveal.reset
          v-for="music in musics"
          :key="music.id"
          :class="{
            music: true,
            playing: selected === music.id
          }"
        >
          <div class="rows_container clickable" @click="play(music.id)">
            <div class="flex">
              <svg class="playpause"
                viewBox="0 0 100 100"
                v-if="selected === music.id && !paused"
              >
                <path d="M50,2.5C23.8,2.5,2.5,23.8,2.5,50c0,26.2,21.3,47.5,47.5,
                47.5S97.5,76.2,97.5,50C97.5,23.8,76.2,2.5,50,2.5z M50,90.1
                c-22.1,0-40.1-18-40.1-40.1c0-22.1,18-40.1,40.1-40.1s40.1,18,40.1,
                40.1C90.1,72.1,72.1,90.1,50,90.1z"/>
                <path d="M62.3,36.6v27.1c0,2-1.6,3.7-3.7,3.7c-2,0-3.7-1.6-3.7-3.7V36.6c0-2,
                1.6-3.7,3.7-3.7C60.7,33,62.3,34.6,62.3,36.6z"/>
                <path d="M44.7,36.6v27.1c0,2-1.6,3.7-3.7,3.7s-3.7-1.6-3.7-3.7V36.6c0-2,
                1.6-3.7,3.7-3.7S44.7,34.6,44.7,36.6z"/>
              </svg>
              <svg class="playpause" viewBox="0 0 100 100" v-else>
                <path d="M65.8,47.5L42.7,32.1c-2-1.3-4.6,0.1-4.6,2.5v30.8c0,2.4,2.7,3.8,4.6,
                2.5l23.1-15.4C67.6,51.3,67.6,48.7,65.8,47.5z"/>
                <path d="M50,2.5C23.8,2.5,2.5,23.8,2.5,50c0,26.2,21.3,47.5,47.5,47.5S97.5,76.2,
                97.5,50C97.5,23.8,76.2,2.5,50,2.5z M50,90.1
                c-22.1,0-40.1-18-40.1-40.1c0-22.1,18-40.1,40.1-40.1s40.1,18,40.1,40.1C90.1,72.1,
                72.1,90.1,50,90.1z"/>
              </svg>
              <div class="column">
                <div class="title">{{ music.title }}</div>
                <div class="date">{{ music.date | date_format }}</div>
              </div>
            </div>
            <div>
              <div class="tags">
                <div class="tag" v-for="tag in music.tags.split(',')" :key="tag">{{ tag }}</div>
              </div>
            </div>
          </div>
          <div class="column">
            <div class="row">
              <div class="icon_text">{{ music.likes | stat_format }}</div>
              <svg
                viewBox="0 0 100 100"
                :class="{
                  icon: true,
                  red: music.loved
                }"
                @click="love(music.id)"
              >
                <path d="M91.58,14.9A28.71,28.71,0,0,0,51,14.9l-1,1-1-1A28.68,28.68,0,0,0,8.39,
                55.46l1,1L35.24,82.32h0l6,6,0.1,0.11L43.9,91a8.63,8.63,0,0,0,12.17,
                0l2.37-2.37h0l6.28-6.28h0L90.55,56.5l1-1A28.64,28.64,0,0,0,91.58,14.9Z"/>
              </svg>
            </div>
            <div class="row">
              <div class="icon_text">{{ music.downloads | stat_format }}</div>
              <svg
                class="icon"
                viewBox="0 0 400 400"
                @click="download(music.id)"
              >
                <path d="M358.8,272.2v70.3c0,1.4-0.2,2.7-0.5,3.9v0c0,0,0,0,0,
                0c-1.4,6.9-7.5,12.1-14.7,12.1H56.3c-7.7,0-14.1-5.9-14.9-13.4
                c-0.2-0.9-0.2-1.7-0.2-2.7v-70.3c0-8.3,6.8-15,15-15c4.1,0,7.9,
                1.7,10.6,4.4c2.7,2.7,4.4,6.5,4.4,10.6v56.3h257.7v-56.3
                c0-8.3,6.8-15,15-15c4.1,0,7.9,1.7,10.6,
                4.4C357.1,264.3,358.8,268.1,358.8,272.2z"/>
                <path d="M286.5,201.8l-73.7,73.7c-0.1,0.2-0.3,0.3-0.4,
                0.4c-2.7,2.7-6.2,4.4-9.7,4.9c-0.3,0-0.6,0.1-0.9,0.1
                c-0.6,0.1-1.2,0.1-1.8,0.1h0l-1.7-0.1c-0.3,
                0-0.6-0.1-0.9-0.1c-3.6-0.5-7-2.2-9.7-4.9c-0.1-0.1-0.3-0.3-0.4-0.4l-73.7-73.7
                c-3.4-3.4-5.1-7.9-5.1-12.4c0-4.5,1.7-9,5.1-12.4c6.8-6.8,
                17.9-6.8,24.8,0l44.3,44.3V59c0-9.6,7.9-17.5,17.5-17.5
                c4.8,0,9.2,2,12.4,5.1c3.2,3.2,5.1,7.5,5.1,12.4v162.3l44.3-44.3c6.8-6.8,
                17.9-6.8,24.8,0C293.3,183.9,293.3,195,286.5,201.8z"/>
              </svg>
            </div>
          </div>
        </div>
      </div>
    </div>
    <svg viewBox="0 0 135 135" :class="{
      loading: true,
      hidden: musics != false
    }">
      <rect y="26.7548" width="15" height="86.4903" rx="6">
        <animate attributeName="height" begin="0.5s" dur="1s"
        values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
        repeatCount="indefinite"/>
        <animate attributeName="y" begin="0.5s" dur="1s"
        values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
        repeatCount="indefinite"/>
      </rect>
      <rect x="30" y="39.2548" width="15" height="61.4903" rx="6">
        <animate attributeName="height" begin="0.25s" dur="1s"
        values="120;110;100;90;80;70;60;50;40;140;120"
        calcMode="linear" repeatCount="indefinite"/>
        <animate attributeName="y" begin="0.25s" dur="1s"
        values="10;15;20;25;30;35;40;45;50;0;10"
        calcMode="linear" repeatCount="indefinite"/>
      </rect>
      <rect x="60" width="15" height="75.097" rx="6" y="32.4515">
        <animate attributeName="height" begin="0s" dur="1s"
        values="120;110;100;90;80;70;60;50;40;140;120"
        calcMode="linear" repeatCount="indefinite"/>
        <animate attributeName="y" begin="0s" dur="1s"
        values="10;15;20;25;30;35;40;45;50;0;10"
        calcMode="linear" repeatCount="indefinite"/>
      </rect>
      <rect x="90" y="39.2548" width="15" height="61.4903" rx="6">
        <animate attributeName="height" begin="0.25s" dur="1s"
        values="120;110;100;90;80;70;60;50;40;140;120"
        calcMode="linear" repeatCount="indefinite"/>
        <animate attributeName="y" begin="0.25s" dur="1s"
        values="10;15;20;25;30;35;40;45;50;0;10"
        calcMode="linear" repeatCount="indefinite"/>
      </rect>
      <rect x="120" y="26.7548" width="15" height="86.4903" rx="6">
        <animate attributeName="height" begin="0.5s" dur="1s"
        values="120;110;100;90;80;70;60;50;40;140;120"
        calcMode="linear" repeatCount="indefinite"/>
        <animate attributeName="y" begin="0.5s" dur="1s"
        values="10;15;20;25;30;35;40;45;50;0;10"
        calcMode="linear" repeatCount="indefinite"/>
      </rect>
    </svg>

    <aplayer
      :autoplay="true"
      :music="playing_music"
      @play="onPlay"
      @pause="onPause"
    />
  </div>
</template>

<style scoped>
@keyframes bg-slide {
  0% { background-position: 0% 60% }
  100% { background-position: 100% 60% }
}

.content {
  padding: 1px 0;
  background: linear-gradient(15deg,#000000,#0f9b0f);
  z-index: 1;
}

.flex {
  display: flex;
  min-width: 165px;
}

.musics_conatiner {
  max-width: 700px;
  margin: 0 auto;
}

.music {
  margin: 15px 15px;
  box-shadow: 0 3px 8px #0000002e;

  border-radius: 7px;
  background: linear-gradient(
    -15deg,
    #0f9b0f,
    #000000,
    #0f9b0f
  );
  background-size: 1800% 1800%;

  display: flex;
  justify-content: space-between;
  padding-right: 13px;
}

.music.playing {
  animation: bg-slide 60s ease infinite;
}

.music:hover { opacity: 1 }

.music .row {
  display: flex;
  justify-content: flex-end;
}

.music .column {
  display: flex;
  flex-direction: column;
  height: 70px;
  justify-content: space-evenly;
}

.music .playpause {
  fill: #FFF;
  height: 45px;
  margin: 12px 15px;
  opacity: 0.7;
}

.music .title { opacity: 0.9 }
.music .date  { opacity: 0.6 }

.rows_container {
  width: 100%;
}

.tags {
  display: flex;
  flex-flow: wrap;
  align-items: flex-end;
  padding: 0 8px 8px;
}

.tags > .tag {
  opacity: 0.7;
  font-size: 13px;
  background-color: #0f970f;
  background: linear-gradient(75deg,#0f970f,#0d8e0d);
  border: solid 1px;
  padding: 4px 12px;
  height: 25px;
  border-radius: 25px;
  margin: 2px;
  cursor: default;
  display: inline-block;
}

.music .icon_text {
  padding-top: 2px;
  margin-right: 5px;
  font-size: 15px;
  opacity: 0.7;
}

.music .icon {
  cursor: pointer;
  fill: #FFF;
  opacity: 0.6;
  height: 20px;
}

.music .icon.red { fill: #ff6c6c }
</style>

<script>
import filters from '@/filters';
import aplayer from 'vue-aplayer';

aplayer.disableVersionBadge = true;

export default {
  name: 'Home',
  filters,
  components: {
    aplayer,
  },

  data() {
    return {
      musics: false,
      selected: this.$route.params.music,
      paused: false,
    };
  },

  methods: {
    async play(music) {
      if (`${this.$route.params.music}` === `${music}`) {
        this.$children[0].toggle();
      } else {
        await this.$children[0].pause();
        this.selected = music;
        await this.$router.push({ path: `/${music}` });
        this.$children[0].thenPlay();
      }
    },

    love(music) {
      this.musics.forEach((m, i) => {
        if (m.id === music && !this.musics[i].loved) {
          this.api.LOVE_MUSIC({ music });
          this.musics[i].likes += 1;
          this.musics[i].loved = true;
        }
      });
    },

    download(music) {
      window.location.replace(`https://third-music.usp-3.fr/api/?download=${music}&HD`);
      this.musics.forEach((m, i) => {
        if (m.id === music) this.musics[i].downloads += 1;
      });
    },

    onPlay() {
      this.paused = false;
    },

    onPause() {
      this.paused = true;
    },
  },

  mounted() {
    this.api.GET_MUSICS((fetchedMusics) => {
      if (!fetchedMusics.error) {
        this.musics = fetchedMusics;
        if (this.selected) this.$children[0].thenPlay();
      }
    });
  },

  computed: {
    music() {
      if (this.musics && this.selected) {
        return this.musics.filter((m) => m.id === this.selected)[0];
      }
      return false;
    },

    playing_music() {
      return this.music ? {
        title: this.music.title,
        artist: 'Third',
        src: `https://third-music.usp-3.fr/files/${this.music.id}.mp3`,
        pic: 'false',
        theme: '#0b720b',
      } : {
        artist: 'Third',
        theme: '#0b720b',
      };
    },
  },
};
</script>
