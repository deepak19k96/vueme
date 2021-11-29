<template>
  <div class="homepage">
    <div class="pa-0">
      <v-img
        alt="Home Banner Image"
        style="z-index: 1"
        :src="
          guest
            ? '/images/Banner-imgs/home.png'
            : '/images/Banner-imgs/home_in.png'
        "
        aspect-ratio="1"
        :max-height="mobile ? 275 : 359"
        class="align-sm-center justify-sm-center home_hero"
      >
        <div
          class="justify-center text-center"
          style="
            position: absolute;
            width: 100%;
            margin-top: -50px;
            padding: 0 47px;
          "
          :style="{ top: mobile ? '45%' : '45%' }"
        >
          <h2>Answers are a Reading Away</h2>
          <h3>
            discover your personal psychic today,<br v-if="mobile" />
            get your free $5 credit
          </h3>
          <v-btn
            v-if="guest"
            rounded
            color="#8EbEF8"
            class="m-0 elevation-0 white--text"
            href="/signup"
            >Chat Now</v-btn
          >
        </div>
        <div
          v-if="user"
          class="d-flex justify-center w-100"
          style="height: 40px"
        >
          <SearchInput />
        </div>
      </v-img>
    </div>

    <SearchFilter />

    <v-container class="front pb-0 pt-0" v-if="online">
      <div>
        <v-row
          justify="space-around"
          :class="!mobile ? 'mt-12 px-4' : 'px-4'"
          class="mb-2"
          style="margin-top: 12px"
        >
          <v-col cols="9" class="mb-0">
            <h1>Top-Rated Online Psychics</h1>
          </v-col>
          <v-col class="mb-0 text-lg-right cursor-pointer px-0 px-lg-3" style="line-height: 18px;">
            <a  href="/search?sortBy=rating&online=1">
              <span class="grey--text" style="font-size: 14px;font-weight:600;color: #43425D !important;opacity: 0.5;">Show All</span>
            </a>
  


          </v-col>
        </v-row>

        <ListItems
          :guest="guest"
          :cols="!mobile ? 12 : 6"
          :filters="{ rating: true }"
          :perPageProp="!mobile ? 12 : 6"
        />
      </div>
    </v-container>

    <v-layout row class="m-0">
      <v-flex
        :style="
          ({ height: $vuetify.breakpoint.xsOnly ? '189px' : '130px' },
          { background: '#F4F4F4' })
        "
      >
        <v-container class="p-0" id="abilities">
          <div class="align-sm-center justify-sm-center home_banner">
            <p
              class="text-center-md"
              style="
                font-size: 14px !important;
                color: #656b72;
                font-weight: 500;
              "
            >
              Find answers and support for life’s most difficult questions when
              you engage with one of Psychics1on1’s™ top-rated online psychics.
              With more than 2,000 spiritual advisors ready to provide you with
              psychic readings in an online chat with you today, now is the
              perfect time to get your questions answered.
            </p>
          </div>
        </v-container>
      </v-flex>
    </v-layout>

    <v-container class="my-3 front">

      <v-row
        justify="space-around"
        :class="!mobile ? 'mt-5 px-4' : 'mt-0 px-4'"
        class="mb-2"
      >
        <v-col cols="9" class="h3 mb-0 d-flex align-center">
          <h4 class="mb-0">Popular Psychic Abilities</h4>
        </v-col>
        <v-col class="h3 mb-0 text-lg-right cursor-pointer">
          <div
            class="d-flex justify-end align-center"
            style="font-size: 30px; color: #43425d"
            @click="nextAbilities"
          >
            <span>&#8226;</span>
            <span>&#8226;</span>
            <span>&#8226;</span>
          </div>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <swiper v-if="!$vuetify.breakpoint.xsOnly" ref="mySwiper" :options="swiperOptions">
            <swiper-slide v-for="(item, index) in items" :key="index">
              <div class="my-2 ability_card" :key="index" style="height: 100%">
                <v-hover v-if="!item.loading" v-slot:default="{ hover }">
                  <a
                    :href="'/search?ability=' + item.slug"
                    style="text-decoration: none"
                  >
                    <v-row class="ma-0 text-center">
                      <v-col
                        cols="12"
                        class="align-sm-center justify-sm-center sm4 p-0"
                      >
                        <img
                          :alt="item.image.name + ' File'"
                          v-bind:src="'/files/' + item.image.path"
                          style=""
                        />
                      </v-col>
                      <v-col
                        cols="12"
                        class="align-center text-center p-0 mt-1"
                      >
                        <div class="description" style="">
                          {{ item.description }}
                        </div>
                      </v-col>
                    </v-row>
                  </a>
                </v-hover>
                <v-skeleton-loader
                  v-else
                  height="100"
                  type="image"
                  class="mx-auto"
                ></v-skeleton-loader>
              </div>
            </swiper-slide>
          </swiper>

          <swiper v-else ref="mySwiper" :options="swiperOptions">
            <swiper-slide v-for="(item2, index) in items" :key="index">
              <div class="my-2 ability_card" style="height: 100px" v-for="(item, index2) in item2" :key="index2">
                <v-hover v-if="!item.loading" v-slot:default="{ hover }">
                  <a
                    :href="'/search?ability=' + item.slug"
                    style="text-decoration: none"
                  >
                    <v-row class="ma-0 text-center">
                      <v-col
                        cols="12"
                        class="align-sm-center justify-sm-center sm4 p-0"
                      >
                        <img
                          :alt="item.image.name + ' File'"
                          v-bind:src="'/files/' + item.image.path"
                          style=""
                        />
                      </v-col>
                      <v-col
                        cols="12"
                        class="align-center text-center p-0 mt-1"
                      >
                        <div class="description" style="">
                          {{ item.description }}
                        </div>
                      </v-col>
                    </v-row>
                  </a>
                </v-hover>
                <v-skeleton-loader
                  v-else
                  height="100"
                  type="image"
                  class="mx-auto"
                ></v-skeleton-loader>
              </div>
            </swiper-slide>
          </swiper>
        </v-col>
      </v-row>
      <!-- </v-window-item>
      </v-window> -->
    </v-container>

    <v-container class="py-0 pt-3 front">
      <v-row
        justify="space-around"
        :class="!mobile ? 'mt-5 px-4' : 'px-4'"
        :style="!mobile ? 'margin-top': '50px'"
        class="mb-3"
      >
        <v-col cols="9" class="h3 mb-0">
          <h4>Featured Psychic Advisors</h4>
        </v-col>
        <v-col class="mb-0 text-lg-right cursor-pointer px-0 px-lg-3" style="line-height: 18px;">
          <a v-if="!mobile" href="/search?sortBy=featured">
            <span class="grey--text" style="font-size: 14px;font-weight:600;color: #43425D !important;opacity: 0.5;" >Show All</span>
          </a>
          <a
            v-else
            class="h3 d-flex justify-end align-center"
            style="font-size: 30px; color: #43425d; text-decoration: none; padding-right: 15px;"
            href="/search?sortBy=featured"
          >
            <span style="line-height: 15px;">&#8226;</span>
            <span style="line-height: 15px;">&#8226;</span>
            <span style="line-height: 15px;">&#8226;</span>
          </a>
          

        </v-col>
      </v-row>

      <ListItems
        :guest="guest"
        :cols="3"
        :rows="!mobile ? 2 : null"
        :bottomOff="1"
        :filters="{ featured: true }"
        :set-featured="setFeatured"
        :perPageProp ="2"
      />
    </v-container>

    <v-layout row class="mt-12 front m-0">
      <v-flex class="engage">
        <v-container class="p-0">
          <div
            class="align-sm-center text-center-md justify-sm-center home_banner" 
          >
            <h2 class="mb-5">Engage Easily</h2>
            <p class="text-center-md" style="">
              Connecting with our top-rated online psychics on issues that
              matter most to you is simple and transparent. Our spiritual
              advisors all have their own specialties and hail from all around
              the world, making it easy to find someone you can communicate with
              easily.
            </p>
          </div>
        </v-container>
      </v-flex>
    </v-layout>

    <v-container class="py-0 front">
      <v-row
        justify="space-around"
        :class="!mobile ? 'mt-12 px-4' : 'mt-8 px-4'"
        class="mb-2"
      >
        <v-col cols="9" class="h3 mb-0">
          <h4>Popular Psychic Advisors</h4>
        </v-col>
        <v-col class="mb-0 text-lg-right cursor-pointer px-0 px-lg-3" style="line-height: 18px;">
          <a v-if="!mobile" href="/search?sortBy=popular">
            <span class="grey--text" style="font-size: 14px;font-weight:600;color: #43425D !important;opacity: 0.5;">Show All</span>
          </a>
  <a
            v-else
            class="h3 d-flex justify-end align-center"
            style="font-size: 30px; color: #43425d; text-decoration: none; padding-right: 15px;"
           href="/search?sortBy=popular"
          >
            <span style="line-height: 15px;">&#8226;</span>
            <span style="line-height: 15px;">&#8226;</span>
            <span style="line-height: 15px;">&#8226;</span>
          </a>

        </v-col>
      </v-row>
      <ListItems :guest="guest" :cols="3" :perPageProp ="2"  :rows="!mobile ? 2 : null"  bottomOff="true" :filters="{ popular: true }" />
    </v-container>

    <v-layout row class="mt-12 front m-0">
      <v-flex
        :style="
          ({ height: $vuetify.breakpoint.xsOnly ? '274px' : '178px' },
          { background: '#F4F4F4' })
        "
      >
        <v-container class="p-0">
          <div
            class="align-sm-center text-center-md justify-sm-center home_banner"
          >
            <h3 class="mb-5">Find Your True Answers</h3>
            <p
              class="text-center-md"
              style="
                font-size: 14px !important;
                color: #656b72;
                font-weight: 500;
              "
            >
              Navigate through some of life’s most difficult scenarios and get
              the peace of mind that you deserve. Connect with Psychics1on1’s™
              top-rated online psychics who are always available to connect and
              offer the powerful truth and guidance you need. Whether you are
              coping with a difficult loss or struggling with a big decision,
              our spiritual advisors offer personal readings on topics.
            </p>
          </div>
        </v-container>
      </v-flex>
    </v-layout>

    <v-container class="mb-6 front">
      <v-row
        id="specialties"
        justify="space-around"
        :class="!mobile ? 'mt-7 px-4' : 'px-4'"
        class="mb-2"
      >
        <v-col cols="9" class="h3 mb-0 d-flex align-center">
          <h4 class="mb-0">Popular Psychic Specialties</h4>
        </v-col>
        <v-col class="h3 mb-0 text-lg-right cursor-pointer">
          <div
            class="d-flex justify-end align-center"
            style="font-size: 30px; color: #43425d"
            @click="nextSpecialties"
          >
            <span>&#8226;</span>
            <span>&#8226;</span>
            <span>&#8226;</span>
          </div>
        </v-col>
      </v-row>

      <v-row>
        <v-col>
          <swiper v-if="!$vuetify.breakpoint.xsOnly" ref="mySwiper2" :options="swiperOptions2" class="row">
            <swiper-slide v-for="(item, index) in specialties" :key="index">
              <div
                class="my-2 specialty_card"
                :key="index"
                style="height: 100%"
              >
                <v-hover v-if="!item.loading" v-slot:default="{ hover }">
                  <a
                    :href="'/search?category=' + item.slug"
                    style="text-decoration: none"
                  >
                    <v-row class="ma-0 text-center">
                      <v-col
                        cols="12"
                        class="align-sm-center justify-sm-center sm4 p-0"
                      >
                        <img :alt="item.name" v-bind:src="item.path" style="" />
                      </v-col>
                      <v-col
                        cols="12"
                        class="align-center text-center p-0 mt-1"
                      >
                        <div class="description" style="">{{ item.name }}</div>
                      </v-col>
                    </v-row>
                  </a>
                </v-hover>
                <v-skeleton-loader
                  v-else
                  height="100"
                  type="image"
                  class="mx-auto"
                ></v-skeleton-loader>
              </div>
            </swiper-slide>
          </swiper>

          <swiper v-else ref="mySwiper2" :options="swiperOptions2" class="row">
            <swiper-slide v-for="(item2, index) in specialties" :key="index">

              <div v-for="(item, index2) in item2" :key="index2"
                class="my-2 specialty_card"
                style="height: 140px" 
              >
                <v-hover v-if="!item.loading" v-slot:default="{ hover }" >
                  <a
                    :href="'/search?category=' + item.slug"
                    style="text-decoration: none"
                  >
                    <v-row class="ma-0 text-center">
                      <v-col
                        cols="12"
                        class="align-sm-center justify-sm-center sm4 p-0"
                      >
                        <img :alt="item.name" v-bind:src="item.path" style="" />
                      </v-col>
                      <v-col
                        cols="12"
                        class="align-center text-center p-0 mt-1"
                      >
                        <div class="description" style="">{{ item.name }}</div>
                      </v-col>
                    </v-row>
                  </a>
                </v-hover>
                <v-skeleton-loader
                  v-else
                  height="100"
                  type="image"
                  class="mx-auto"
                ></v-skeleton-loader>
              </div>
            </swiper-slide>
          </swiper>
        </v-col>
      </v-row>
      <!-- </v-window-item>
      </v-window> -->
    </v-container>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import ListItems from "./specialtie_user_list.vue";

import { Swiper, SwiperSlide } from "vue-awesome-swiper";
import 'swiper/swiper-bundle.css'

export default {
  data() {
    return {
      window: 0,
      window1: 0,
      online: true,
      featured: true,
      categories: [],
      items: [],
      specialties: [],
      specialtiesList: [],
      links: [
        "/specialty/psychic",
        "/specialty/medium",
        "/specialty/astrology",
        "/specialty/palm-reading",
        "/specialty/tarot-card-reader",
        "/specialty/clairvoyant",
        "/specialty/spiritual-healer",
      ],
      filter: false,
      swiperOptions: {
        loop: true,
        breakpoints: {
          // when window width is >= 320px
          320: {
            slidesPerView: 5,
          },
          // when window width is >= 960
          960: {
            slidesPerView: 6,
          },
          // when window width is >= 1264
          1264: {
            slidesPerView: 9,
          },
        },
      },
      swiperOptions2: {
        loop: true,
        breakpoints: {
          // when window width is >= 320
          320: {
            slidesPerView: 3,
          },
               768: {
            slidesPerView: 6,
          },
          // when window width is >= 960
          960: {
            slidesPerView: 6,
          },
          // when window width is >= 1264
          1264: {
            slidesPerView: 9,
          },
        },
      },
    };
  },
  props: ["guest", "user"],
  components: {
    ListItems,
    Swiper,
    SwiperSlide,
  },
  computed: {
    swiper() {
      return this.$refs.mySwiper.$swiper;
    },
    swiper2() {
      return this.$refs.mySwiper2.$swiper;
    },
    ...mapGetters({
      mobile: "util/mobile",
      paginate: "category/items",
      paginate1: "specialty/items",
    }),
  },

  watch: {
  },
  methods: {
    nextAbilities() {
      this.swiper.slideNext();
    },
    nextSpecialties() {
      this.swiper2.slideNext();
    },
    getLoadingArray() {
      let array = [];
      for (let i = 0; i < 6; i++) array.push({ loading: true });
      return array;
    },
    setFeatured(val) {
      this.featured = val;
    },
    f_open_login() {
      EventBus.$emit("open_sign_up_user", {});
    },
  },
  created() {
    const chunk = (arr, size) =>
      Array.from({ length: Math.ceil(arr.length / size) }, (v, i) =>
        arr.slice(i * size, i * size + size)
      );

    this.$store.dispatch("category/getItems").then(() => {
      if(this.$vuetify.breakpoint.xsOnly){
       this.items = chunk(this.paginate.data, 2);
       }
      else this.items = this.paginate.data;
    });

    this.$store.dispatch("specialty/getItems").then(() => {
      if (this.$vuetify.breakpoint.xsOnly) {
        this.specialties = chunk(this.paginate1.data, 3);
      } 
      else this.specialties = this.paginate1.data;
    });
    this.$store.dispatch("util/setUser", this.user);
  },
};
</script>
<style>
.v-expansion-panel:before {
  box-shadow: none;
}

.theme--light.v-expansion-panels .v-expansion-panel {
  background-color: transparent;
}

.v-expansion-panel-header__icon i {
  color: #a163c1 !important;
  font-size: 45px !important;
}
</style>
