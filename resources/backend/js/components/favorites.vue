<template>
  <div>
    <v-row class="mb-0 mt-5"  no-gutters>
      <v-col class="subtitleDiv" style="padding-left: 20px !important;">Favorites</v-col>
    </v-row>

    <v-row v-if="!loadingFavorite" no-gutters class="favorites">
      <v-col 
        :class="$vuetify.breakpoint.smAndDown ? 'col col-12 pa-3 pa-md-4 pt-0' : 'p-0 m-0 col col-12'"
      
       >
         <v-hover v-slot:default="{ hover }" 
         
         :style="[ $vuetify.breakpoint.smAndDown ? {'width': '100% !important','margin' : '20px auto  !important'}:{'width': '355px !important','margin' : '20px  !important'}]"
         style="float: left;" v-for="item,index in favorites" :key="index" >
               <v-card
                v-if="!item.loading"
                style="min-height: 228px; border-radius: 20px!important;background: #EBF4FD;"
                :elevation="hover ? 12 : 2"
                class="mx-auto list_card"
              >
                <div>
                  <v-row class="m-0" style="height:118px;background: #EBF4FD;border-radius: 20px 20px 0 0;">
                    <a v-bind:href="'/'+ item.profile.profile_link">
                    <v-badge v-if="item.online" color="green" bottom>
                      <template v-slot:badge>{{''}}</template>

                      <div
                        :aria-label="item.profile.display_name"
                        class="user_avatar_lg"
                        :class="[item.online ?  'online' : 'offline']"
                        :style="{ 'background-image': 'url(' + item.profile.profile_headshot_url  + ')', 'margin-top': '18px', 'margin-left': '15px'}"
                      ></div>
                    </v-badge>
                    <v-badge v-else color="grey" bottom>
                      <template v-slot:badge>{{''}}</template>

                      <div
                        :aria-label="item.profile.display_name"
                        class="user_avatar_lg"
                        :class="[item.online ?  'online' : 'offline']"
                        :style="{ 'background-image': 'url(' + item.profile.profile_headshot_url  + ')', 'margin-top': '18px', 'margin-left': '15px'}"
                      ></div>
                    </v-badge>
                    <div
                      :aria-label="item.profile.display_name"
                      class="user_avatar_lg"
                      :class="[item.online ?  'online' : 'offline']"
                      v-else
                      :style="{ 'background-image': 'url(' + item.profile.profile_headshot_url  + ')', 'margin-top': '18px', 'margin-left': '15px' }"
                    ></div>

                 
                  </a>
                     <v-card-title class="justify-center  d-flex p-0" style="align-items: baseline !important;     margin-top: 39px;">
                  <div class="flex-row">
                    <div class="col-12 pr-0 pl-2 pl-lg-3" 
                        style=" margin-bottom: 10px;"
                          :style="{
                            'font-size': !$vuetify.breakpoint.xsOnly ? '15px' : '14px', 
                            'color':'#43425D', 
                            'width': $vuetify.breakpoint.xsOnly ? '202px': '238px',
                            'line-height': '1.5',
                             'word-break': 'break-word',
                            'overflow': 'hidden !important'}">
                      <a
                        v-bind:href="'/'+ item.profile.profile_link"
                        style="color: #43425D;font-weight: 600;"
                      >
                       <span>{{ item.profile.display_name }}</span>
                      </a>
                    </div>
                    <a
                      v-bind:href="'/'+ item.profile.profile_link + '#reviews'"
                      style="color: #A2A2A2; text-decoration: none; "
                      
                    >
                      
                             <v-rating
                            v-if="item.reviews_rating"
                            :value="parseFloat(item.reviews_rating)"
                            color="amber"
                            dense
                            half-increments
                            background-color="#C7C7C7"
                            empty-icon="mdi-star"
                            readonly
                            size="16"
                            class="starBtn"
                            style="line-height: 0.5"
                            :style="
                              !$vuetify.breakpoint.xsOnly
                                ? ' padding-left:10px'
                                : ' padding-left:5px'
                            "
                          ></v-rating>
                          <div
                            v-else
                            class="review-me"
                            style="line-height: 1.5"
                            :style="
                              !$vuetify.breakpoint.xsOnly
                                ? ' padding-left:12px'
                                : ' padding-left:9px'
                            "
                          >
                            Be the first to
                            <font style="text-decoration: underline"
                              >review me</font
                            >
                          </div>
                          
                        
                    </a>
                  </div>

                    
                    </v-card-title>
                  </v-row>
                </div>
                <v-tooltip top>
                  <template v-slot:activator="{ on }">
                    <v-icon v-if="item.favorite"
                      @click="saveFavorite(item)"
                      v-on="on"
                      size="35"
                      color="#43425D"
                      style="position: absolute; top: 5px; right: 13px;font-size:19px!important"
                      class="ma-1 cursor-pointer"
                    >mdi-heart</v-icon>
                    <v-icon v-else
                      @click="saveFavorite(item)"
                      v-on="on"
                      size="35"
                      
                      style="position: absolute; top: 5px; right: 13px;font-size:19px!important"
                      class="ma-1 cursor-pointer"
                    >mdi-heart-outline</v-icon>
                  </template>
                  <span>{{item.favorite?'Remove from favorites':'Add to favorites'}}</span>
                </v-tooltip>
                <v-row justify="space-around">
                
                </v-row>

                

                <v-card-text style="background:#ffffff;border-radius:20px;font-size:10px;padding:10px!important; position:absolute; bottom:0;">
                  <div class="row">
                    <div class="col-12 text-center tagline--text" style="min-height: 22px">
                      {{item.profile.tagline}}
                    </div>
                  </div>

                   <div class="row mt-2" style="font-size: 10px; padding:0px 20px"
                  
                  >
                    <div class="col p-0 grey--text"  v-if="item.reviews"
                    
                    :style="[!item.profile.years_experience ? {textAlign:'center'} : {textAlign:'left'}]"
                    
                    >
                      <b  style="color: #656B72; font-weight: 600;">{{ item.reviews }}</b>
                      <span v-if="item.reviews == 1"> Review</span>
                      <span v-else> Reviews</span>
                    </div>




                    <div
                      v-if="
                        item.profile.years_experience != null &&
                        item.profile.years_experience > 0
                      "
                      class="col p-0 grey--text" 
                      :style="[item.reviews ? {textAlign:'center',display:'inline-flex'} : {textAlign:'center'}]"
                    >
                      <b 
                       style="color: #656B72; font-weight: 600;"
                      :style="[item.reviews ? {display:'inline-flex'} : {textAlign:''}]"
                        >{{ item.profile.years_experience }}
                        <span v-if="item.profile.years_experience > 1"
                          :style="[item.reviews ? {padding:'0px 2px'} : {padding:'0px'}]"
                          >years</span
                        >
                        <span v-else>year</span></b
                      >
                      Experience
                    </div>
                  
                    <div class="col p-0 grey--text" 
                    :style="[!item.profile.years_experience || !item.reviews ? {textAlign:'center'} : {textAlign:'right'}]"
                    >
                      <span v-if="item.profile.t_clients == 0"
                        ><b  style="color: #656B72; font-weight: 600;">New</b> Psychic</span
                      >
                      <span v-else-if="item.profile.t_clients == 1"
                        ><b  style="color: #656B72; font-weight: 600;">{{ item.profile.t_clients }}</b> Client</span
                      >
                      <span v-else
                        ><b  style="color: #656B72; font-weight: 600;">{{ item.profile.t_clients }}</b> Clients</span
                      >
                    </div>
                  </div>

                  <div class="row mt-2">
                    <div class="col-6" style="padding: 0px 3px!important;">
                      <span v-for="(cat, index) in item.categories">
                       <img v-if="index < 4" :src="cat.path"/>
                      </span>
                    </div>
                    <div class="col-6 text-right">
                     <v-btn style="font-size:12px"
                      rounded
                      small
                      color="#8EbEF8"
                      height="30"
                      class="m-0 elevation-0 white--text pr-0 pl-3"
                      :href="'/'+ item.profile.profile_link"
                    > Profile <img src="/images/icons/chevron-right.svg"/>
                    </v-btn>
                    </div>
                    
                  </div>
                  
                </v-card-text>
              </v-card>
              <v-sheet v-else color="grey lighten-4" style="min-height: 240px; background-color: #EBF4FD !important;">
                <v-row>
                  <v-col class="d-flex justify-start big-avatar align-center">
                    <v-skeleton-loader type="avatar"></v-skeleton-loader>
                    <v-skeleton-loader width="50%" type="text" class="ml-3"></v-skeleton-loader>
                  </v-col>
                </v-row>
                <div style="background-color: white !important;" class="pb-3 pt-2">
                  <v-row class="mt-10">
                  <v-col class="d-flex justify-start">
                    <v-skeleton-loader width="50%" type="text" class="ml-2"></v-skeleton-loader>
                  </v-col>
                </v-row>
                <v-row class="mt-4">
                  <v-col class="d-flex justify-end">
                    <v-skeleton-loader class="ml-3" type="button" style="border-radius: 10%; width: 90px" width="90"></v-skeleton-loader>
                  </v-col>
                </v-row>
                </div>
              </v-sheet>
            </v-hover>
      </v-col>
      <v-col cols="12" v-if="!favorites.length">
        <v-alert type="success">There are no favorites</v-alert>
      </v-col>
    </v-row>
    <v-row v-else>
      <v-col cols="12" md="4" class="mb-5" v-for="index in 4" :key="index">
        <v-sheet color="grey lighten-4">
          <v-row>
            <v-col>
              <v-skeleton-loader width="100%" height="130" type="image"></v-skeleton-loader>
            </v-col>
          </v-row>
          <v-row>
            <v-col class="d-flex justify-center big-avatar">
              <v-skeleton-loader style="margin-top: -60px" type="avatar"></v-skeleton-loader>
            </v-col>
          </v-row>
          <v-row class="mt-10">
            <v-col class="d-flex justify-center">
              <v-skeleton-loader width="50%" type="text"></v-skeleton-loader>
            </v-col>
          </v-row>
          <v-row class="mt-4">
            <v-col class="d-flex justify-center">
              <v-skeleton-loader width="80%" type="text"></v-skeleton-loader>
            </v-col>
          </v-row>
          <v-row class="mt-4">
            <v-col class="d-flex justify-center">
              <v-skeleton-loader width="90%" type="text"></v-skeleton-loader>
            </v-col>
          </v-row>
          <v-row class="mt-4">
            <v-col class="d-flex justify-center">
              <v-skeleton-loader type="button"></v-skeleton-loader>
            </v-col>
          </v-row>
        </v-sheet>
      </v-col>
    </v-row>
    <v-dialog
      content-class="videoAudioDialog"
      elevation="0"
      class="video-audio"
      v-model="videoAudioDialog"
    >
      <v-card
        style="max-width: 700px; max-height: 500px; background-color: transparent"
        @mouseover="hover = true"
        @mouseleave="hover = false"
      >
        <v-card-text class="pa-0">
          <v-icon v-show="!audio && (hover || mobile)" @click="videoAudioDialog = false">mdi-close</v-icon>
          <div class="w-100 d-flex align-center justify-center">
            <video
              controls
              controlslist="nodownload"
              v-if="video"
              style="max-width: 700px; max-height: 500px"
            >
              <source v-bind:src="item.profile.intro_video_path" type="video/mp4" />
              <source v-bind:src="item.profile.intro_video_path" type="video/ogg" />Your browser does not support HTML5 video.
            </video>

            <audio controls controlslist="nodownload" v-if="audio" style="max-width: 700px">
              <source v-bind:src="item.profile.intro_audio_path" />Your browser does not support the audio element.
            </audio>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      favorites: [],
      hover: false,
      videoAudioDialog: false,
      video: false,
      audio: false,
      item: {},
    };
  },
  computed: {
    ...mapGetters({
      mobile: "util/mobile",
      items: "favorite/items",
      loadingFavorite: "favorite/loading",
    }),
  },
  watch: {
    videoAudioDialog(val) {
      if (!val) {
        this.audio = this.video = this.videoAudioDialog = false;
        this.item = {};
      }
    },
  },
  methods: {
    openVideoAudioDialog(item, video) {
      if (item.profile.intro_video_path || item.profile.intro_audio_path) {
        if (video) this.video = true;
        else this.audio = true;
        this.item = item;
        this.videoAudioDialog = true;
      }
    },
    getCategories(item) {
      let html = "";
      let categories = item.categories;
      for (let i = 0; i < categories.length; i++) {
        html =
          html +
          `<a class="cursor-pointer" href="${categories[i].url}" style="text-decoration: none; color:#8EBEF8!important"> ${categories[i].name} </a>`;
        break;
      }

      if (categories.length >= 1)
        html =
          html +
          `<a class="cursor-pointer" href="/${item.profile.profile_link}"
                            style="text-decoration: none; color: #8EBEF8!important"
                          ><span> • </span> +${categories.length - 1} more</a>`;
      //`<span> • </span> +${categories.length - 2} more`;

      return html;
    },
    saveFavorite(item) {
      if (!this.loadingFavorite)
        this.$store
          .dispatch("favorite/saveFavorite", { id: item.id, type: "remove" })
          .then(() => {
            this.favorites.splice(this.favorites.indexOf(item), 1);
          });
    },
  },
  created() {
    this.$store.dispatch("favorite/getItems").then(() => {
      this.favorites = this.items;
    });
  },
};
</script>

<style >
/* width */
::-webkit-scrollbar {
  width: 5px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: #888;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555;
}
.icon-close {
  position: absolute;
  top: 0;
  right: 0;
  margin-right: 5px;
  margin-top: 5px;
}
.videoAudioDialog {
  width: auto;
  height: auto;
  max-width: 700px;
  max-height: 500px;
}

.videoAudioDialog .v-card__title {
  height: 30px;
  background-color: black;
  padding: 0px !important;
}

.videoAudioDialog .mdi-close {
  position: absolute !important;
  font-size: 30px;
  cursor: pointer !important;
  color: white;
  z-index: 100;
  position: absolute;
  margin-right: 5px;
  margin-top: 5px;
  right: 0px;
}

/* width */
::-webkit-scrollbar {
  width: 5px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: #888;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555;
}

/* .v-window__next,
.v-window__prev {
  background: transparent !important;
  border: 2px solid #a163c1;
  margin: 0 -4px !important;
}

.v-window__next,
.v-window__prev {
  margin: 0 -4px !important;
} */

.big-avatar .v-skeleton-loader__avatar {
  width: 120px;
  height: 120px;
}
.tagline--text {
    color: #656b72;
    font-weight: 600;
}
.review-me {
  letter-spacing: 0.2px;
  color: #8ebef8;
  opacity: 1;
  font-weight: 600;
  font-size: 10px;
}
</style>

