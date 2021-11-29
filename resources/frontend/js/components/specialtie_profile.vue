<template>
  <div
    class="row p-0 m-0 sfProfile"
    :class="{ blur: schedule_appointment }"
    v-if="item.profile"
  >
    <div class="sfNavLeftb col p-0 m-0" v-if="!$vuetify.breakpoint.smAndDown">
      <div class="sfNavLeft d-flex" :style="[{'top': space_header+'px !important'}]" >
        <!-- :style="[{'height': 'calc(100vh  - '+space_header+'px !important'}]" -->
        <div class="sfNavBtn"  >
          <div
            :key="'service_' + index"
            v-for="(service, index) in services_ordered"
            :class="{ disabled: service.active == 0 }"
          >
            <v-btn
              :disabled="!service.active"
              @click="iniChat(service)"
              class="text-center"
              style="height: 100% !important;min-height:203px;"
              color="#ebf4fd"
            >
              <img
                v-if="service.active"
                :src="'/images/profile/menu-' + service.service.icon"
                :alt="service.service.name"
              />
              <img
                v-else
                :src="'/images/profile/menu-off-' + service.service.icon"
                :alt="service.service.name"
              />
              <span>{{ service.service.name }}</span>
            </v-btn>
          </div>
        </div>

        <div class="sfNavProfile">
          <v-card>
            <div class="text-center border-0" style="padding-top: 50px">
              <div style="position: absolute; right: 20px">
                <v-tooltip top v-if="!currentUser || currentUserRole != 1">
                  <template v-slot:activator="{ on }">
                    <v-icon
                      v-if="item.favorite"
                      @click="saveFavorite(item)"
                      v-on="on"
                      size="35"
                      color="#1D1C2F"
                      style="font-size: 25px !important"
                      class="ml-3"
                      >mdi-heart</v-icon
                    >
                    <v-icon
                      v-else
                      @click="saveFavorite(item)"
                      v-on="on"
                      size="35"
                      color="#1D1C2F"
                      style="font-size: 25px !important"
                      class="ml-3"
                      >mdi-heart-outline</v-icon
                    >
                  </template>
                  <span>{{
                    item.favorite ? "Remove from favorites" : "Add to favorites"
                  }}</span>
                </v-tooltip>
              </div>
              <v-badge
                overlap
                bottom
                :color="this.item.online ? '#2CC05F' : '#C7C7C7'"
              >
                <template v-slot:badge>{{ item.online.color }}</template>
                <v-avatar
                  class="user_avatar_lg"
                  style="
                    object-fit: cover;
                    min-width: 145px;
                    min-height: 145px;
                    margin-bottom: 20px;
                  "
                  size="145"
                >
                  <v-img
                    :alt="item.profile.display_name"
                    :src="item.profile.profile_headshot_url"
                  ></v-img>
                </v-avatar>
              </v-badge>
            </div>

            <v-card-title
              class="justify-center"
              style="text-align: center; margin: 0px 20px; line-height: 22px"
              >{{ item.profile.display_name }}</v-card-title
            >

            <v-card-text>
              <v-row  align="center" class="justify-center sfProfileStar">
                <v-rating
                  v-if="item.reviews_rating"
                  class="d-inline starBtn"
                  :value="parseFloat(item.reviews_rating)"
                  color="amber"
                  background-color="#C7C7C7"
                  empty-icon="mdi-star"
                  dense
                  half-increments
                  readonly
                  size="17"
                ></v-rating>
              </v-row>

              <div class="d-flex sfProfileInfo">
                <v-card class="mx-auto transparent" elevation="0">
                  <v-card-title class="justify-center">Reviews</v-card-title>
                  <v-card-text
                    v-if="item.reviews_count"
                    class="justify-center"
                    >{{ item.reviews_count }}</v-card-text
                  >

                  <v-card-text v-else class="justify-center"
                    >Review Me</v-card-text
                  >
                </v-card>
                <v-card
                  class="mx-auto transparent"
                  elevation="0"
                  v-if="item.profile.years_experience"
                >
                  <v-card-title class="justify-center">Experience</v-card-title>
                  <v-card-text
                    class="justify-center"
                    v-if="item.profile.years_experience === 1"
                    >{{ item.profile.years_experience }} year</v-card-text
                  >
                  <v-card-text class="justify-center" v-else
                    >{{ item.profile.years_experience }} years</v-card-text
                  >
                </v-card>
                <v-card
                  class="mx-auto transparent"
                  elevation="0"
                  v-if="item.profile.t_clients"
                >
                  <v-card-title class="justify-center">Clients</v-card-title>
                  <v-card-text class="justify-center">{{
                    item.profile.t_clients
                  }}</v-card-text>
                </v-card>
                <v-card class="mx-auto transparent" elevation="0" v-else>
                  <v-card-title class="justify-center">Clients</v-card-title>
                  <v-card-text class="justify-center">New Psychic</v-card-text>
                </v-card>
              </div>

              <h1 class="sfTagline">
                {{ item.profile.tagline }}
              </h1>

              <div class="sfElevator">
                {{ item.profile.elevator_pitch }}
              </div>
              <div class="row sfMedia">
                <div
                  v-if="item.profile.intro_video_path"
                  class="col-5 m-0 p-0 mt-3"
                  style="height: 90px; width: 90px"
                >
                  <v-btn
                    class="no-background-hover p-0 pr-2 m-0"
                    text
                    style="height: 90px !important"
                    v-if="item.profile.intro_video_path"
                    @click.stop="
                      video = true;
                      videoAudioDialog = true;
                    "
                  >
                    <video
                      class="p-0 m-0"
                      style="height: 90px; width: 90px; border-radius: 5px !important;"
                      :src="item.profile.intro_video_path"
                      preload="auto"
                      :poster="item.profile.intro_video_thumbnail"
                    ></video>
                    <v-icon light color="white" class="mt-n8 ml-n14">mdi-play-circle-outline</v-icon>
                  </v-btn>
                </div>
                <div
                  v-if="item.profile.intro_audio_path"
                  class="col-7 m-0 p-0 mt-3"
                  style="height: 90px"
                >
                  <vue-wave-surfer
                    class="m-0 p-0 spaceWave"
                    style="height: 90px; border-radius: 5px !important;"
                    :src="item.profile.intro_audio_path"
                    :options="options"
                  ></vue-wave-surfer>

                  <div style="position: absolute; bottom: 0px;left:0px; z-index: 100;">
                    <v-btn
                      height="20px !important"
                      v-if="displayPlay"
                      @click="play()"
                      class="no-background-hover p-0"
                      style="background: #f4f4f4"
                    >
                      <img class="ml-n7" src="/images/profile/sound.svg" />
                    </v-btn>
                    <v-btn
                      height="20px !imporatnt"
                      v-else
                      @click="pause()"
                      class="no-background-hover p-0"
                      style="background: #f4f4f4"
                    >
                      <img class="ml-n7" src="/images/profile/sound_gray.svg" />
                    </v-btn>
                  </div>
                </div>
              </div>
            </v-card-text>
          </v-card>
        </div>
      </div>
    </div>
    <div
      class="sfContainerProfile d-flex col"
      v-if="!$vuetify.breakpoint.smAndDown"
    >
      <div class="sfProfileDetail" style="d-inline-block">
        <div class="sfProfileRates d-flex white">
          <div class="sfRatesTitle">
            <p>Rates:</p>
          </div>

          <div class="sfProfileAction d-flex">
            <div
              class="p-0 m-0 sfProfileActionItem sfProfileActionLine"
              :key="'service2_' + index"
              v-for="(service, index) in services_ordered"
              :class="{ disabled: service.active == 0 }"
            >
              <v-btn
                :disabled="!service.active"
                @click="iniChat(service)"
                style="height: 50px !important"
                color="#EBF4FD"
              >
                <img
                  v-if="service.active"
                  :src="'/images/profile/box_' + service.service.icon"
                  :alt="service.service.name"
                />
                <img
                  v-else
                  style="padding: 0px 10px 4px 10px"
                  :src="'/images/profile/inactive-' + service.service.icon"
                  :alt="service.service.name"
                />

                <span>{{ service.service.name }} </span>
                <span
                  class="text-lowercase"
                  v-if="service.service.id == 1 || service.service.id == 3"
                  >${{ service.rate }} per min</span
                >
                <span class="text-lowercase" v-if="service.service.id == 2"
                  >${{ service.rate }} per msg</span
                >
              </v-btn>
            </div>
          </div>
        </div>

        <v-row class="m-0">
          <v-col cols="7" class="pl-0">
            <v-card>
              <v-card-text>
                <v-row class="sfProfileFixtures ml-0">
                  <v-col class="p-0" v-if="item.specialties.length > 0">
                    <v-card elevation="0">
                      <v-card-title>Specialties</v-card-title>
                      <v-card-text>
                        <v-list-item
                          v-for="(sp, index) in item.specialties"
                          :key="'specialties_' + index"
                        >
                          <v-list-item-content>
                            {{ sp.name }}
                          </v-list-item-content>
                        </v-list-item>
                      </v-card-text>
                    </v-card>
                  </v-col>
                  <v-col class="p-0" v-if="item.categories.length > 0">
                    <v-card elevation="0">
                      <v-card-title>Abilities</v-card-title>
                      <v-card-text
                        ><v-list-item
                          v-for="(category, index) in item.categories"
                          :key="'category_' + index"
                        >
                          <v-list-item-content>
                            {{ category.name }}
                          </v-list-item-content>
                        </v-list-item></v-card-text
                      >
                    </v-card>
                  </v-col>
                  <v-col class="p-0" v-if="item.tools.length > 0">
                    <v-card elevation="0" col="4">
                      <v-card-title>Tools</v-card-title>
                      <v-card-text
                        ><v-list-item
                          v-for="(tool, index) in item.tools"
                          :key="'tools_' + index"
                        >
                          <v-list-item-content>
                            {{ tool.name }}
                          </v-list-item-content>
                        </v-list-item></v-card-text
                      >
                    </v-card>
                  </v-col>
                </v-row>
                <v-row class="sfProfileFixtures ml-0">
                  <v-col class="p-0" v-if="item.languages.length > 0">
                    <v-card elevation="0">
                      <v-card-title>Languages</v-card-title>
                      <v-card-text>
                        <v-list-item
                          v-for="(language, index) in item.languages"
                          :key="'language_' + index"
                        >
                          <v-list-item-content>
                            {{ language.name }}
                          </v-list-item-content>
                        </v-list-item>
                      </v-card-text>
                    </v-card>
                  </v-col>
                  <v-col class="p-0" v-if="item.styles.length > 0">
                    <v-card elevation="0">
                      <v-card-title>Style</v-card-title>
                      <v-card-text>
                        <v-list-item
                          v-for="(style, index) in item.styles"
                          :key="'style_' + index"
                        >
                          <v-list-item-content>
                            {{ style.name }}
                          </v-list-item-content>
                        </v-list-item>
                      </v-card-text>
                    </v-card>
                  </v-col>
                  <v-col>
                    <!-- <v-card elevation="0">
                    <v-card-title>Known For</v-card-title>
                    <v-card-text>
                      <v-list-item
                        v-for="(category, index) in item.categories"
                        :key="index"
                      >
                        <v-list-item-content>
                          {{ category.name }}
                        </v-list-item-content>
                      </v-list-item>
                    </v-card-text>
                  </v-card> -->
                  </v-col>
                </v-row>

                <div class="sfProfileBio" v-if="item.profile.description">
                  <h2>Background</h2>
                  {{ item.profile.description }}
                </div>

                <div
                  v-if="item.works.length > 0 || item.credentials.length > 0"
                  class="sfProfileCredentials"
                >
                  <h2
                    v-if="
                      (item.works[0] && item.works[0].position) ||
                      (item.credentials[0] &&
                        item.credentials[0].institution_name)
                    "
                  >
                    Credentials
                  </h2>

                  <div v-if="item.works[0] && item.works[0].position">
                    <v-list-item
                      v-for="(work, index) in item.works"
                      :key="'work_' + index"
                    >
                      <v-list-item-title v-if="work.position">
                        {{ work.position }}
                      </v-list-item-title>
                      <v-subheader v-if="work.company">{{
                        work.company
                      }}</v-subheader>
                      <v-list-item-content>
                        <span v-if="work.from_year && work.to_year"
                          >{{ work.from_year }} - {{ work.to_year }}</span
                        >
                        {{ work.description }}
                      </v-list-item-content>
                    </v-list-item>
                  </div>

                  <div
                    v-if="
                      item.credentials[0] &&
                      item.credentials[0].institution_name
                    "
                  >
                    <v-list-item
                      v-for="(credential, indexcredential) in item.credentials"
                      :key="indexcredential"
                    >
                      <v-list-item-title v-if="credential.degree">
                        {{ credential.degree }}
                      </v-list-item-title>
                      <v-subheader v-if="credential.institution_name">{{
                        credential.institution_name
                      }}</v-subheader>
                      <v-list-item-content>
                        <span v-if="credential.from_year && credential.to_year"
                          >{{ credential.from_year }} -
                          {{ credential.to_year }}</span
                        >
                        {{ credential.description }}
                      </v-list-item-content>
                    </v-list-item>
                  </div>
                </div>
              </v-card-text>
            </v-card>
          </v-col>
          <v-col cols="5" class="pl-0 pr-0">
            <v-card class="sfProfileRating">
              <v-card-title> Rating & Reviews </v-card-title>
              <v-card-text class="pb-0">
                <v-row
                  v-for="(values, index) in reviewStars"
                  :key="'rating_' + index"
                >
                  <v-col cols="3" class="d-flex align-center">
                    <label v-if="values.rating > 1">
                      {{ values.rating }}
                      Stars
                    </label>
                    <label v-else>
                      {{ values.rating }}
                      Star
                    </label>
                  </v-col>
                  <v-col ols="9" class="d-flex justify-center align-center">
                    <v-progress-linear
                      class="d-inline reviews-bars"
                      :value="(values.total * 100) / item.reviews_count"
                      color="#F4C150"
                      background-color="#F4F4F4"
                      height="15"
                      reactive
                    ></v-progress-linear>
                  </v-col>
                </v-row>
              </v-card-text>
              <v-card-actions class="d-flex justify-content-between">
                <v-rating
                  class="d-inline starBtn"
                  dense
                  half-increments
                  readonly
                  size="15"
                  background-color="#C7C7C7"
                  empty-icon="mdi-star"
                ></v-rating>
                <v-btn text class="text-right p-0 TapRate" @click="openReviewDialog"
                  >Tap to Rate this Psychic</v-btn
                >
              </v-card-actions>
            </v-card>
            <!-- Start filter here -->

            <v-row
              v-if="item.reviews.length > 0"
              class="sfProfileListRating p-0"
            >
              <v-select
                v-model="rev_filter"
                :items="rev_filter_list"
                item-text="name"
                item-value="key"
                label="Newest"
                filled
                background-color="white"
                dense
                solo
                :height="32"
                class="widthSelect"
                :menu-props="{ contentClass: 'checkList-line' }"
                v-on:change="getReviews"
                solo-inverted
              ></v-select>
            </v-row>

            <!-- End filter -->
            <v-card
              class="sfProfileListRating"
              v-for="(i, index) in item.reviews"
              :key="'review_' + index"
            >
              <v-badge color="transparent" avatar>
                <!-- <template
                 v-if="i.helpful"
                 v-slot:badge>
                  <v-img
                    height="30"
                    width="30"
                    src="/images/icons/helpful_icon.svg"
                  ></v-img>
                </template> -->

                <template v-slot:badge>
                  <v-btn
                    text
                    @click="saveHelpfuls(i)"
                    class="text-right saveHelpful"
                  >
                    <div v-if="i.helpfuls === false">Helpful?</div>

                    <div v-else style="color: #a163c1">Helpful!</div>
                  </v-btn>
                </template>

                <v-list-item>
                  <v-list-item-avatar size="40" color="grey" left>
                    <v-img :src="i.user.profile.profile_headshot_url"></v-img>
                  </v-list-item-avatar>
                  <v-list-item-content>
                    <v-list-item-title>
                      {{ i.user.profile.name | truncate(18, "...") }}
                    </v-list-item-title>
                    <v-list-item-subtitle v-if="i.service">
                      {{ i.service.name }}
                    </v-list-item-subtitle>
                    <span>{{ i.created_at | formatDate }}</span>
                  </v-list-item-content>
                </v-list-item>
              </v-badge>

              <v-card-subtitle
                >{{ i.title }}
                <v-rating
                  style="bottom: 1px; position: relative"
                  class="d-inline starBtn"
                  :value="parseFloat(i.rating)"
                  color="amber"
                  background-color="#C7C7C7"
                  empty-icon="mdi-star"
                  dense
                  half-increments
                  readonly
                  size="17"
                ></v-rating
              ></v-card-subtitle>
              <v-card-text class="pb-0"> “{{ i.text }}” </v-card-text>
            </v-card>
            <div class="pb-2 d-flex justify-content-center">
              <v-btn
                :loading="loadingReviews"
                :disabled="loadingReviews"
                v-if="this.item.reviews.length == this.numberReviews"
                @click="showMore()"
                >More Reviews ▽</v-btn
              >
              <v-btn
                :loading="loadingReviews"
                :disabled="loadingReviews"
                v-if="this.numberReviews > 5"
                @click="showLess()"
                >Less Reviews △</v-btn
              >
            </div>
          </v-col>
        </v-row>
      </div>

      <v-dialog
        v-model="cancelDialog"
        width="650"
        :fullscreen="$vuetify.breakpoint.smAndDown"
      >
        <v-card>
          <v-card-text class="p-0">
            <div class="row m-0">
              <div class="col-12 text-right">
                <v-btn icon light @click="cancelDialog = false" class="right">
                  <i class="far fa-times-circle fa-2x pink_icon"></i>
                </v-btn>
              </div>
              <div class="col-12">
                <div class="text-center">
                  <h2>Cancel request?</h2>
                </div>

                <div class="card-body p-0 p-lg-5 pt-3">
                  <form
                    method="POST"
                    action
                    class="registration_form p-lg-5 pt-0 pb-0 text-center"
                  >
                    <div class="form-row mb-3">
                      <div class="col-12 mt-3 mb-5">
                        <p>Are you sure you want to cancel the chat request?</p>
                      </div>
                    </div>
                    <div class="form-row mb-3">
                      <div class="col-12">
                        <v-btn
                          class="mr-3"
                          color="primary"
                          :loading="loadingCancel"
                          :disabled="loadingCancel"
                          @click="cancelVChatRequest()"
                          >Yes, cancel</v-btn
                        >

                        <v-btn
                          class
                          color="secondary"
                          :loading="loadingCancel"
                          :disabled="loadingCancel"
                          @click="cancelDialog = false"
                          >Nevermind</v-btn
                        >
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </v-card-text>
        </v-card>
      </v-dialog>
      <!-- :fullscreen="$vuetify.breakpoint.smAndDown" -->
    </div>

    <div
      class="sfNavLeftb"
      style="width: 100%; max-width: 100%"
      v-if="$vuetify.breakpoint.smAndDown"
    >
      <div
        class="sfNavLeftMo d-flex m-0 p-0"
        style="position: relative !important; background: #ebf4fd; top: 0px"
      >
        <div class="sfNavProfile" style="width: 100%; background: #ebf4fd">
          <v-card style="background: #ebf4fd; width: 100%" class="p-0 m-0">
            <div class="text-center border-0" style="padding-top: 50px">
              <div style="position: absolute; right: 20px">
                <v-tooltip top v-if="!currentUser || currentUserRole != 1">
                  <template v-slot:activator="{ on }">
                    <v-icon
                      v-if="item.favorite"
                      @click="saveFavorite(item)"
                      v-on="on"
                      size="35"
                      color="#1D1C2F"
                      style="font-size: 25px !important"
                      class="ml-3 cursor-pointer"
                      >mdi-heart</v-icon
                    >
                    <v-icon
                      v-else
                      @click="saveFavorite(item)"
                      v-on="on"
                      size="35"
                      color="#1D1C2F"
                      style="font-size: 25px !important"
                      class="ml-3 cursor-pointer"
                      >mdi-heart-outline</v-icon
                    >
                  </template>
                  <span>{{
                    item.favorite ? "Remove from favorites" : "Add to favorites"
                  }}</span>
                </v-tooltip>
                <a
                  v-if="item.profile.intro_video_path"
                  @click.stop="
                    video = true;
                    videoAudioDialog = true;
                  "
                  class="d-block"
                  style="text-decoration: none; white-space: nowrap"
                >
                  <i class="fab ico-profile-watch-h ml-3 mt-6"></i>
                </a>

                <a
                  v-if="item.profile.intro_audio_path"
                  @click.stop="
                    audio = true;
                    videoAudioDialog = true;
                  "
                  class="d-block"
                  style="text-decoration: none; white-space: nowrap"
                >
                  <i class="fab ico-profile-listen-h ml-3  mt-4"></i>
                </a>
              </div>

              <v-badge
                overlap
                bottom
                :color="this.item.online ? '#2CC05F' : '#C7C7C7'"
              >
                <template v-slot:badge>{{ item.online.color }}</template>
                <v-avatar
                  class="user_avatar_lg"
                  style="
                    object-fit: cover;
                    min-width: 148px;
                    min-height: 148px;
                    margin-bottom: 25px;
                  "
                  size="150"
                >
                  <v-img
                    :alt="item.profile.display_name"
                    :src="item.profile.profile_headshot_url"
                  ></v-img>
                </v-avatar>
              </v-badge>
            </div>

            <v-card-title
              style="
                font-size: 16px !important;
                text-align: center;
                margin: 0px 20px;
                line-height: 22px;
              "
              class="justify-center"
              >{{ item.profile.display_name }}</v-card-title
            >

            <v-card-text style="margin-top: 5px">
              <v-row  align="center" class="justify-center sfProfileStar">
                <v-rating
                   v-if="item.reviews_rating" 
                  class="d-inline starBtn"
                  :value="parseFloat(item.reviews_rating)"
                  color="amber"
                  background-color="#C7C7C7"
                  empty-icon="mdi-star"
                  dense
                  half-increments
                  readonly
                  size="17"
                ></v-rating>
              </v-row>

              <div
                class="d-flex sfProfileInfo noOutlined"
                style="background: #ebf4fd; padding: 10px 20px 20px 20px"
              >
                <v-card
                  class="col transparent p-0"
                  elevation="0"
                  style="background: #ebf4fd"
                >
                  <v-card-text class="justify-center" v-if="item.reviews_count"
                    ><b style="font-weight: 600; color: #656b72; opacity:1">{{ item.reviews_count }}</b>
                    <font class="sfCarTexSub" style="color: #43425d; opacity: 0.5;font-weight: 500;"> Reviews</font>
                  </v-card-text>

                  <v-card-text class="justify-center" v-else>
                    <a href="#reviews" style="text-decoration: none; ">
                    <font class="sfCarTexSub" style="font-weight: 600; color: #656b72; opacity:1"> Review </font> <font style="color: #43425d; opacity: 0.5;font-weight: 500;">Me</font> </a>
                    
                  </v-card-text>
                </v-card>
                <v-card
                  class="colx transparent p-0"
                  elevation="0"
                  v-if="item.profile.years_experience"
                >
                  <v-card-text
                    class="justify-center"
                    v-if="item.profile.years_experience === 1"
                    >
                    <b style="font-weight: 600; color: #656b72; opacity:1">{{ item.profile.years_experience }}</b>
                    <font class="sfCarTexSub" style="padding-left: 5px; color: #656b72; font-weight: 500;">year<span style="padding-left: 5px;">Experience</span></font></v-card-text
                  >
                  <v-card-text class="justify-center" v-else
                    >
                    <b style="font-weight: 600; color: #656b72; opacity:1">{{ item.profile.years_experience }}</b>
                    <font class="sfCarTexSub" style="padding-left: 5px; color: #656b72; font-weight: 500;">years<span style="padding-left: 5px;">Experience</span></font></v-card-text
                  >
                </v-card>
                <v-card
                  class="col transparent mr-0  p-0"
                  elevation="0"
                  v-if="item.profile.t_clients"
                >
                  <v-card-text class="justify-center" 
                    ><b style="font-weight: 600; color: #656b72; opacity:1">{{ item.profile.t_clients }}</b>
                    <font class="sfCarTexSub" style="color: #43425d; opacity: 0.5;font-weight: 500;"> Clients </font>
                  </v-card-text>
                </v-card>
                <v-card class="col transparent p-0" elevation="0" v-else>
                  <v-card-text class="justify-center">
                    <font class="sfCarTexSub" style="font-weight: 600; color: #656b72; opacity:1">New</font> <font style="color: #43425d; opacity: 0.5;font-weight: 500;">Psychic</font></v-card-text
                  >
                </v-card>
              </div>

              <h1
                class="sfTagline mb-0"
                style="background: #fff; padding: 20px; text-align: center"
              >
                {{ item.profile.tagline }}
              </h1>
              <div class="" style="background: #fff; margin: auto" v-if="item.profile.elevator_pitch">
                <div
                  class="sfElevator mt-0 mb-0"
                  style="background: #f4f4f4; padding: 20px"
                >
                  {{ item.profile.elevator_pitch }}
                </div>
              </div>
              <v-row
                style="
                  margin: auto;
                  padding: 20px 20px 10px 40px;
                  background: #fff;
                "
              >
                <v-col cols="12" class="pl-0 pr-0">
                  <v-card class="sfNavLeftMoOutlined">
                    <v-card-text>
                      <v-row class="sfProfileFixtures">
                        <v-col class="p-0" v-if="item.specialties.length > 0">
                          <v-card elevation="0">
                            <v-card-title>Specialties</v-card-title>
                            <v-card-text>
                              <v-list-item
                                v-for="(sp, index) in item.specialties"
                                :key="'specialtie2_' + index"
                              >
                                <v-list-item-content>
                                  {{ sp.name }}
                                </v-list-item-content>
                              </v-list-item>
                            </v-card-text>
                          </v-card>
                        </v-col>
                        <v-col class="p-0" v-if="item.categories.length > 0">
                          <v-card elevation="0">
                            <v-card-title>Abilities</v-card-title>
                            <v-card-text
                              ><v-list-item
                                v-for="(category, index) in item.categories"
                                :key="'category2_' + index"
                              >
                                <v-list-item-content>
                                  {{ category.name }}
                                </v-list-item-content>
                              </v-list-item></v-card-text
                            >
                          </v-card>
                        </v-col>
                      </v-row>

                      <v-row class="sfProfileFixtures">
                        <v-col class="p-0" v-if="item.tools.length > 0">
                          <v-card elevation="0" col="4">
                            <v-card-title>Tools</v-card-title>
                            <v-card-text
                              ><v-list-item
                                v-for="(tool, index) in item.tools"
                                :key="'tool2_' + index"
                              >
                                <v-list-item-content>
                                  {{ tool.name }}
                                </v-list-item-content>
                              </v-list-item></v-card-text
                            >
                          </v-card>
                        </v-col>
                        <v-col class="p-0" v-if="item.languages.length > 0">
                          <v-card elevation="0">
                            <v-card-title>Languages</v-card-title>
                            <v-card-text>
                              <v-list-item
                                v-for="(language, index) in item.languages"
                                :key="'language2_' + index"
                              >
                                <v-list-item-content>
                                  {{ language.name }}
                                </v-list-item-content>
                              </v-list-item>
                            </v-card-text>
                          </v-card>
                        </v-col>
                      </v-row>
                      <v-row class="sfProfileFixtures">
                        <v-col class="p-0" v-if="item.styles.length > 0">
                          <v-card elevation="0">
                            <v-card-title>Style</v-card-title>
                            <v-card-text>
                              <v-list-item
                                v-for="(style, index) in item.styles"
                                :key="'style2_' + index"
                              >
                                <v-list-item-content>
                                  {{ style.name }}
                                </v-list-item-content>
                              </v-list-item>
                            </v-card-text>
                          </v-card>
                        </v-col>
                      </v-row>
                    </v-card-text>
                  </v-card>
                </v-col>
              </v-row>

              <v-row
                class="m-0"
                style="padding: 0px 20px; margin: auto; background: #fff"
              >
                <v-col cols="12" class="pl-0 pr-0">
                  <v-card
                    class="sfProfileRating sfNavLeftMoOutlined"
                    style="background: #f4f4f4; padding: 20px"
                  >
                    <v-card-title class="mb-3"> Status & Rates </v-card-title>
                    <v-card-text class="sfProfileAction">
                      <v-row class="mb-2">
                        <v-col
                          class="col pr-0 textOline pl-0"
                          style="max-width: 78px;"
                          :style="
                            this.item.online
                              ? 'color: #2CC05F;'
                              : 'color: #C7C7C7;'
                          "
                          >{{ this.item.online ? "Online" : "Offline" }}</v-col
                        >
                             <!-- :style="
                            this.reading_in_progress ? 'color: #FFAC3B;' : 'color: ##FFAC3B;'
                          " -->
                        <v-col
                          class="col-8 pl-0 textOline"
                          style="color: #FFAC3B"
                        
                          >
                          
                          <font v-if="services_ordered[0].active != 0 ||
                              services_ordered[1].active != 0 ||
                              services_ordered[2].active != 0">  
                          
                          
                          {{
                            this.reading_in_progress 
                              ? "Reading in Progress"
                              : "Appointments Available"
                          }}
                          </font>
                          </v-col
                        >
                      </v-row>
                      <div
                        class="p-0 m-0"
                        :key="'servicem' + index"
                        v-for="(service, index) in services_ordered"
                        :class="{ disabled: service.active == 0 }"
                      >
                        <v-btn
                          :disabled="!service.active"
                          @click="iniChat(service)"
                          color="#EBF4FD"
                          class="statusMob"
                        >
                          <v-row
                            class="p-0 d-flex flex-row align-items-center"
                            style="width: 100%; margin-left: -21px"
                          >
                            <v-col
                              class="p-0 m-0 d-flex justify-content-start"
                              style="
                                max-width: 55px;
                                width: 50px;
                                text-align: left;
                                padding-left: 15px !important;
                              "
                            >
                              <img
                                v-if="service.active"
                                style="padding-top: 5px"
                                :src="
                                  '/images/profile/box_' + service.service.icon
                                "
                                :alt="service.service.name"
                              />
                              <img
                                v-else
                                style="padding: 0px 10px 4px 10px"
                                :src="
                                  '/images/profile/inactive-' +
                                  service.service.icon
                                "
                                :alt="service.service.name"
                              />

                              <!-- <img width="30px" height="30px"
                                :src="'/images/profile/' + service.service.icon"
                                :alt="service.service.name"
                              />
 -->
                            </v-col>
                            <v-col
                              class="pl-0 pr-0 m-0 text-Serv"
                              style="
                                min-width: 115px;
                                text-align: left;
                                font-weight: normal;
                                padding-left: 20px !important;
                              "
                            >
                              {{ service.service.name }}
                            </v-col>
                            <v-col class="p-0 m-0" style="">
                              <span
                                style="font-weight: normal"
                                class="text-lowercase"
                                v-if="
                                  service.service.id == 1 ||
                                  service.service.id == 3
                                "
                                >${{ service.rate }} per min</span
                              >
                              <span
                                style="font-weight: normal"
                                class="text-lowercase"
                                v-if="service.service.id == 2"
                                >${{ service.rate }} per msg</span
                              >
                            </v-col>
                          </v-row>
                        </v-btn>
                      </div>
                    </v-card-text>
                  </v-card>
                </v-col>
              </v-row>

              <v-row
                style="
                  margin: auto;
                  padding: 20px 20px 0px 20px;
                  background: #fff;
                "
              >
                <v-col cols="12" class="pl-0 pr-0">
                  <v-card class="sfNavLeftMoOutlined">
                    <v-card-text style="padding: 0px 20px 0px 20px">
                      <div v-if="item.profile.description"
                        class="sfProfileBio m-0"
                        style="padding-bottom: 20px"
                      >
                        <h2>Background</h2>
                        {{ item.profile.description }}
                      </div>

                      <div
                        v-if="
                          item.works.length > 0 || item.credentials.length > 0
                        "
                        class="sfProfileCredentials"
                      >
                        <h2
                          v-if="
                            (item.works[0] && item.works[0].position) ||
                            (item.credentials[0] &&
                              item.credentials[0].institution_name)
                          "
                        >
                          Credentials
                        </h2>

                        <div
                          class="mt-0 mb-0"
                          v-if="item.works[0] && item.works[0].position"
                        >
                          <v-list-item
                            v-for="(work, index) in item.works"
                            :key="'work_' + index"
                            style="margin-bottom: 20px"
                          >
                            <v-list-item-title v-if="work.position">
                              {{ work.position }}
                            </v-list-item-title>
                            <v-subheader v-if="work.company">{{
                              work.company
                            }}</v-subheader>
                            <v-list-item-content>
                              <span v-if="work.from_year && work.to_year"
                                >{{ work.from_year }} - {{ work.to_year }}</span
                              >
                              {{ work.description }}
                            </v-list-item-content>
                          </v-list-item>
                        </div>

                        <div
                          class="mt-0 mb-0"
                          v-if="
                            item.credentials[0] &&
                            item.credentials[0].institution_name
                          "
                        >
                          <v-list-item
                            v-for="(credential,
                            indexcredential) in item.credentials"
                            :key="indexcredential"
                            style="margin-bottom: 20px"
                          >
                            <v-list-item-title v-if="credential.degree">
                              {{ credential.degree }}
                            </v-list-item-title>
                            <v-subheader v-if="credential.institution_name">{{
                              credential.institution_name
                            }}</v-subheader>
                            <v-list-item-content>
                              <span
                                v-if="
                                  credential.from_year && credential.to_year
                                "
                                >{{ credential.from_year }} -
                                {{ credential.to_year }}</span
                              >
                              {{ credential.description }}
                            </v-list-item-content>
                          </v-list-item>
                        </div>
                      </div>
                    </v-card-text>
                  </v-card>
                </v-col>
              </v-row>
              <v-row
                class="m-0"
                style="padding: 0px 20px; margin: auto; background: #fff"
                id="reviews"
              >
                <v-col cols="12" class="pl-0 pr-0">
                  <v-card
                    class="sfProfileRating sfNavLeftMoOutlined"
                    style="background: #f4f4f4; padding: 20px"
                  >
                    <v-card-title class="mb-3" > Rating & Reviews </v-card-title>
                    <v-card-text class="pb-0">
                      <v-row
                        v-for="(values, index) in reviewStars"
                        :key="'review2_' + index"
                      >
                        <v-col cols="3" class="align-center pl-0">
                          <label v-if="values.rating > 1">
                            {{ values.rating }}
                            Stars
                          </label>
                          <label v-else>
                            {{ values.rating }}
                            Star
                          </label>
                        </v-col>
                        <v-col
                          cols="9"
                          class="d-flex justify-center align-center pr-0 pl-0"
                        >
                          <v-progress-linear
                            class="d-inline reviews-bars"
                            :value="(values.total * 100) / item.reviews_count"
                            color="#F4C150"
                            background-color="#C7C7C7"
                            height="15"
                            reactive
                          ></v-progress-linear>
                        </v-col>
                      </v-row>
                    </v-card-text>
                    <v-card-actions
                      class="row p-0 m-0"
                      style="margin-top: 20px !important"
                    >
                      <v-rating
                        class="col-6 pl-0 text-left d-inline starBtn"
                        color="amber"
                        background-color="#C7C7C7"
                        empty-icon="mdi-star"
                        dense
                        half-increments
                        readonly
                        size="17"
                      ></v-rating>
                      <v-btn
                        text
                        class="col-6 text-right p-0 m-0 TapRate"
                        style="height: auto !important"
                        @click="openReviewDialog"
                        >Tap to Rate this Psychic</v-btn
                      >
                    </v-card-actions>
                  </v-card>
                  <!-- Start filter here -->

                  <v-row
                    v-if="item.reviews.length > 0"
                    class="sfProfileListRating p-0"
                  >
                    <div class="col m-0 p-0">
                      <v-select
                        v-model="rev_filter"
                        :items="rev_filter_list"
                        item-text="name"
                        item-value="key"
                        label="Newest"
                        filled
                        background-color="#F4F4F4"
                        dense
                        solo
                        :height="32"
                        class="widthSelect sfNavLeftMoS text-right"
                        style="float: right"
                        :menu-props="{ contentClass: 'checkListGrays' }"
                        v-on:change="getReviews"
                        solo-inverted
                      ></v-select>
                    </div>
                  </v-row>

                  <!-- End filter -->
                  <v-card
                    class="sfProfileListRating mt-0"
                    v-for="(i, index) in item.reviews"
                    :key="'review3_' + index"
                  >
                    <v-badge v-if="i.helpful > 0" color="transparent" avatar>
                      <!-- <template
                 v-if="i.helpful"
                 v-slot:badge>
                  <v-img
                    height="30"
                    width="30"
                    src="/images/icons/helpful_icon.svg"
                  ></v-img>
                </template> -->

                      <template v-slot:badge>
                        <v-btn
                          text
                          @click="saveHelpfuls(i)"
                          class="text-right saveHelpful"
                        >
                          <div v-if="i.helpfuls === false">Helpful?</div>

                          <div v-else style="color: #a163c1">Helpful!</div>
                        </v-btn>
                      </template>

                      <v-list-item>
                        <v-list-item-avatar size="40" color="grey" left>
                          <v-img
                            :src="i.user.profile.profile_headshot_url"
                          ></v-img>
                        </v-list-item-avatar>
                        <v-list-item-content>
                          <v-list-item-title>
                            {{ i.user.profile.name | truncate(18, "...") }}
                          </v-list-item-title>
                          <v-list-item-subtitle v-if="i.service">
                            {{ i.service.name }}
                          </v-list-item-subtitle>
                          <span>{{ i.created_at | formatDate }}</span>
                        </v-list-item-content>
                      </v-list-item>
                    </v-badge>
                    <v-list-item v-else>
                      <v-list-item-avatar size="40" color="grey" left>
                        <v-img
                          :src="i.user.profile.profile_headshot_url"
                        ></v-img>
                      </v-list-item-avatar>
                      <v-list-item-content>
                        <v-list-item-title>
                          {{ i.user.profile.name | truncate(18, "...") }}
                        </v-list-item-title>
                        <v-list-item-subtitle v-if="i.service">
                          {{ i.service.name }}
                        </v-list-item-subtitle>
                        <span>{{ i.created_at | formatDate }}</span>
                      </v-list-item-content>
                    </v-list-item>
                    <v-card-subtitle
                      >{{ i.title }}
                      <v-rating
                        style="bottom: 1px; position: relative"
                        class="d-inline starBtn"
                        :value="parseFloat(i.rating)"
                        color="amber"
                        background-color="#C7C7C7"
                        empty-icon="mdi-star"
                        dense
                        half-increments
                        readonly
                        size="17"
                      ></v-rating
                    ></v-card-subtitle>
                    <v-card-text class="pb-0"> “{{ i.text }}” </v-card-text>
                  </v-card>
                  <div class="pb-4 d-flex justify-content-center">
                    <v-btn
                      :loading="loadingReviews"
                      :disabled="loadingReviews"
                      v-if="this.item.reviews.length == this.numberReviews"
                      @click="showMore()"
                      >More Reviews ▽</v-btn
                    >
                    <v-btn
                      :loading="loadingReviews"
                      :disabled="loadingReviews"
                      v-if="this.numberReviews > 5"
                      @click="showLess()"
                      >Less Reviews △</v-btn
                    >
                  </div>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </div>
      </div>
    </div>
    <div class="divNavButtom" v-if="$vuetify.breakpoint.smAndDown"></div>
    <div
      class="sfBottomNav"
      v-if="$vuetify.breakpoint.smAndDown"
      style="padding: 0px 40px"
    >
      <div style="margin: auto 0; width: 100%; text-align: center" class="row">
        <div
          :key="'servicem2_' + index"
          v-for="(service, index) in services_ordered"
          class="col-4"
        >
          <div
            class="bottom_menu_round sfbottom_menu_round mr-0 ml-0"
            style="width: auto"
          >
            <v-btn
              class="m-0 p-0 radiusNav"
              style="background: #ebf4fd"
              block
              :disabled="!service.active"
              @click="iniChat(service)"
            >
              <img
                style="padding-top: 3px"
                :src="'/images/profile/menu-' + service.service.icon"
                :alt="service.service.name"
              />
              <div class="sfBottomNavText">
                {{ service.service.name }}
              </div>
            </v-btn>
          </div>
        </div>
      </div>
    </div>

    <v-dialog v-if="item.profile" v-model="schedule_appointment" width="335px">
      <v-card
        class="appointment"
        style="background: #f0f0f8 0% 0% no-repeat padding-box"
      >
        <v-icon
          style="
            position: absolute;
            right: 21px;
            top: 3px;
            cursor: pointer;
            z-index: 5;
          "
          @click="schedule_appointment = false"
          >mdi-close</v-icon
        >

        <v-card-text class="pb-0">
          <v-row class="mb-5">
            <v-col cols="12" class="d-flex justify-center">
              <div style="padding: 20px 0px 20px 0px; line-height: 0px">
                <div
                  :aria-label="item.profile.display_name"
                  class="user_avatar_lg"
                  :style="{
                    'background-image':
                      'url(' + item.profile.profile_headshot_url + ')',
                    border: '3px solid #F3F3F3',
                    height: '62px',
                    width: '62px',
                  }"
                ></div>
                <v-icon
                  :color="item.online ? 'green' : '#C7C8C7'"
                  style="
                    position: absolute;
                    top: 63px;
                    left: 55%;
                    font-size: 13px;
                    right: 132px;
                    border: 2px solid white;
                    width: 13px;
                    height: 13px;
                    border-radius: 50%;
                  "
                  >mdi-circle</v-icon
                >
              </div>
            </v-col>
            <v-col cols="12" class="d-flex justify-center">
              <div>
                <div
                  style="
                    color: #1f1e34;
                    font-size: 16px !important;
                    font-weight: 600;
                  "
                >
                  {{ item.profile.display_name }}
                </div>
              </div>
            </v-col>
          </v-row>

          <v-row style="margin-bottom: 20px">
            <v-col cols="12" class="d-flex justify-center">
              <div
                style="padding: 3px; background: white; border-radius: 50px"
                class="toogle2"
              >
                <input
                  id="toggle-on"
                  class="toggle toggle-left"
                  name="toggle"
                  value="false"
                  :checked="now_or_later == 'later'"
                  type="radio"
                  @change="appointmentLATER()"
                />
                <label
                  for="toggle-on"
                  class="btn-switch schedule"
                  style="font-size: 12px !important"
                >
                  <span>Schedule</span>
                </label>
                <input
                  id="toggle-off"
                  class="toggle toggle-right"
                  name="toggle"
                  value="true"
                  type="radio"
                  :disabled="!item.online"
                  :checked="now_or_later == 'now'"
                  @change="appointmentNOW()"
                />
                <label
                  for="toggle-off"
                  class="btn-switch"
                  style="font-size: 12px !important"
                >
                  <span>Now</span>
                </label>
              </div>
            </v-col>
          </v-row>
          <!-- <v-row class="mb-5">
            <v-col cols="12" class="d-flex justify-center">
              <div style="padding: 5px; background: white; border-radius: 50px;" >
                <v-btn
                  style="max-width: 70px; font-size: 12px"
                  :style="{color: possible_appointment.now_or_later =='later' ? 'white' : '#1F1E34', opacity: possible_appointment.now_or_later =='later' ? '1' : '0.5'}"
                  rounded
                  depressed
                  @click="appointmentLATER()"
                  :color="possible_appointment.now_or_later == 'later' ? '#8EBEF8' : ''"
                >Schedule</v-btn>
                <v-btn
                  style="max-width: 56px; font-size: 12px"
                  :style="{color: possible_appointment.now_or_later =='now' ? 'white' : '#1F1E34', opacity: possible_appointment.now_or_later =='now' ? '1' : '0.5'}"
                  rounded
                  depressed
                  @click="appointmentNOW()"
                  :color="possible_appointment.now_or_later == 'now' ? '#8EBEF8' : ''"
                >Now</v-btn>
              </div>
            </v-col>
          </v-row>-->

          <form v-on:submit.prevent="submit_appointment" style="color: #656b72">
            <div class="form-group" style="margin-bottom: 0px !important">
              <div class="d-flex justify-center">
                <v-select
                  v-model="possible_appointment.category.id"
                  :items="item.categories"
                  :disabled="possible_appointment.status == 'Confirmed'"
                  label="Select Reading"
                  filled
                  item-text="name"
                  item-value="id"
                  hide-details
                  solo
                  style="max-width: 180px; border-radius: 6px"
                  height="32"
                  :background-color="
                    errors['category.id'] ? '#E85D4E4D' : '#FFFFFF'
                  "
                  :menu-props="{
                    contentClass:
                      'checkList-line checkBoxMin checkBoxMinProfile',
                  }"
                  class="widthSelect"
                >
                  <template v-slot:selection="{ item }">
                    <label
                      style="
                        color: #1f1e34 !important;
                        opacity: 0.5;
                        font-weight: 500 !important;
                        font-size: 12px !important;
                      "
                      >{{ item.name }}</label
                    >
                  </template>
                  <template v-slot:item="{ item }">
                    <label
                      style="
                        color: #1f1e34 !important;
                        opacity: 0.5;
                        font-weight: 500 !important;
                        font-size: 12px !important;
                      "
                      >{{ item.name }}</label
                    >
                  </template>
                </v-select>
              </div>
            </div>
            <div v-if="now_or_later == 'later'">
              <div
                class="d-flex justify-center form-group"
                style="margin: 20px 0px !important"
              >
                <v-row>
                  <v-col cols="12" class="d-flex justify-center">
                    <div class="d-flex justify-start">
                      <v-select
                        v-model="possible_appointment.duration"
                        :items="minutes"
                        filled
                        dense
                        solo
                        hide-details
                        :menu-props="{
                          contentClass:
                            'checkList-line checkBoxMin checkBoxMinProfile',
                        }"
                        class="widthSelect"
                        :background-color="
                          errors.duration ? '#E85D4E4D' : '#FFFFFF'
                        "
                        label="Length"
                        style="border-radius: 6px; max-width: 90px; !important;"
                      ></v-select>
                      <div
                        class="appointment-date"
                        style="
                          border-radius: 6px;
                          width: 75px !important;
                          margin-left: 15px;
                        "
                      >
                        <v-menu
                          v-model="datepicker_menu"
                          :close-on-content-click="false"
                          :nudge-right="-184"
                          transition="scale-transition"
                          offset-y
                          min-width="336"
                          width="336"
                        >
                          <template v-slot:activator="{ on }">
                            <v-text-field
                              v-model="computedDateFormatted"
                              hide-details
                              label="Date"
                              readonly
                              :disabled="appointment.status == 'Confirmed'"
                              filled
                              dense
                              solo
                              v-on="on"
                              style="font-size: 12px"
                              append-icon="mdi-menu-down"
                              @click:append="datepicker_menu = true"
                              :background-color="
                                errors.date ? '#E85D4E4D' : '#FFFFFF'
                              "
                            ></v-text-field>
                          </template>

                          <v-date-picker
                            :show-current="today"
                            :min="today"
                            width="336"
                            class="appointment-picker"
                            :allowed-dates="allowedDates"
                            v-model="appointment_date"
                            @input="datepicker_menu = false"
                            no-title
                          ></v-date-picker>
                        </v-menu>
                      </div>
                    </div>
                  </v-col>
                  <!-- <v-col cols="6" class="pa-0 pl-1">
                    <div style="background-color: #FFFFFF;border-radius: 6px;  width: 75px !important;">
                      <v-menu
                        v-model="datepicker_menu"
                        :close-on-content-click="false"
                        :nudge-right="0"
                        :nudge-top="32"
                        transition="scale-transition"
                        offset-y
                        min-width="290px"
                      >
                        <template v-slot:activator="{ on }">
                          <v-text-field
                            v-model="computedDateFormatted"
                            hide-details
                            label="Date"
                            readonly
                            :disabled="appointment.status == 'Confirmed'"
                            background-color="#FFFFFF"
                            filled
                            dense
                            solo
                            v-on="on"
                            style="font-size: 12px;"
                            append-icon="mdi-menu-down"
                          ></v-text-field>
                        </template>

                        <v-date-picker :allowed-dates="allowedDates"
                          v-model="possible_appointment.date"
                          @input="datepicker_menu = false"
                          no-title
                        ></v-date-picker>
                      </v-menu>
                    </div>
                  </v-col>-->
                </v-row>
              </div>
              <div class="d-flex justify-center form-group">
                <v-row style="max-width: 220px">
                  <v-col cols="12" class="d-flex justify-center">
                    <div class="d-flex justify-start">
                      <div
                        style="
                          border-radius: 6px;
                          width: 90px;
                          margin-right: 15px;
                        "
                      >
                        <!-- v-if="browser == 'Chrome'" -->
                        <v-text-field
                          v-mask="mask"
                          label="Start Time"
                          :background-color="
                            errors.date_and_time ? '#E85D4E4D' : '#FFFFFF'
                          "
                          filled
                          dense
                          solo
                          @keydown.13.32.stop.prevent
                          hide-details
                          v-model="possible_appointment.start"
                          style="
                            font-size: 12px !important;
                            color: #1f1e34 !important;
                          "
                          color="#1F1E34"
                          @keyup="validateTimeInput()"
                        ></v-text-field>
                      </div>

                      <v-select
                        v-model="possible_appointment.ampm"
                        :items="['AM', 'PM']"
                        solo
                        hide-details
                        style="border-radius: 6px; max-width: 75px"
                        :menu-props="{ contentClass: 'checkList-line' }"
                        class="widthSelect"
                        :background-color="
                          errors.duration ? '#E85D4E4D' : '#FFFFFF'
                        "
                      >
                        <template v-slot:selection="{ item }">
                          <label
                            style="
                              color: #1f1e34 !important;
                              opacity: 0.5;
                              font-size: 12px;
                              font-weight: 500 !important;
                            "
                            >{{ item }}</label
                          >
                        </template>
                        <template v-slot:item="{ item }">
                          <label
                            style="
                              color: #1f1e34 !important;
                              opacity: 0.5;
                              font-size: 12px;
                              font-weight: 500 !important;
                            "
                            >{{ item }}</label
                          >
                        </template>
                      </v-select>
                    </div>
                  </v-col>
                </v-row>
              </div>

              <div class="form-group" v-if="_currentUserAppointmentCount == 0">
                <label>Your Timezone</label>

                <v-select
                  :items="timezonesok"
                  label="Select"
                  background-color="#FFFFFF"
                  filled
                  dense
                  flat
                  hide-details
                  solo
                  v-model="possible_appointment.timezone"
                ></v-select>
              </div>
            </div>

            <div class="d-flex justify-center">
              <button
                type="submit"
                class="btn primary white--text"
                style="
                  border-radius: 20px;
                  font-weight: 600;
                  font-size: 14px;
                  margin: 30px 0px;
                  width: 100px;
                  height: 38px;
                "
              >
                Confirm
              </button>
            </div>
          </form>
        </v-card-text>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="psychic_cant_make_appointment"
      width="320px"
      :fullscreen="$vuetify.breakpoint.smAndDown"
    >
      <v-card color="#F0F0F7">
        <v-card-text style="padding: 15px 20px">
          <div class="text-right mb-2">
            <v-icon
              class="text-right"
              @click="psychic_cant_make_appointment = false"
              >mdi-close</v-icon
            >
          </div>

          <p>To talk to this psychic please create a client account.</p>

          <p>
            <a href="/signup">Sign Up As A Client</a>
          </p>
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- <v-dialog
      v-model="end_of_vhcat_alert"
      width="420px"
      :fullscreen="$vuetify.breakpoint.smAndDown"
    >
      <v-card color="#F0F0F7">
        <v-card-text style="padding: 15px 20px">
          <div class="text-right mb-2">
            <v-icon class="text-right" @click="end_of_vhcat_alert = false"
              >mdi-close</v-icon
            >
          </div>

          <div class="text-center mb-8">
            <h3>Your reading is complete.</h3>

            <p>
              For questions please contact
              <a href="mailto:support@psychics1on1.com"
                >support@psychics1on1.com</a
              >
            </p>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog> -->

    <v-dialog
      v-model="low_credits_alert"
      width="420px"
      :fullscreen="$vuetify.breakpoint.smAndDown"
    >
      <v-card color="#F0F0F7">
        <v-card-text style="padding: 15px 20px">
          <div class="text-right mb-2">
            <v-icon class="text-right" @click="low_credits_alert = false"
              >mdi-close</v-icon
            >
          </div>

          <div class="text-center mb-8">
            <h3>Your are running out of credits.</h3>

            <p>
              <v-btn
                class="mt-5"
                depressed
                color="primary"
                style="color: #fff !important"
                rounded
                @click="add_credits()"
                >Reload Wallet</v-btn
              >
            </p>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>

    <v-dialog
      v-if="item.profile"
      v-model="psychic_disabled_service_alert"
      width="420px"
      :fullscreen="$vuetify.breakpoint.smAndDown"
    >
      <v-card>
        <v-card-title class="d-block text-right">
          <v-btn icon light @click="psychic_disabled_service_alert = false">
            <i class="far fa-times-circle fa-2x"></i>
          </v-btn>
        </v-card-title>
        <v-card-text class="text-center" v-if="item">
          <div
            :aria-label="item.profile.display_name"
            class="user_avatar_lg mb-3"
            style="padding: 3px; object-fit: cover; width: 100px; height: 100px"
            :style="{
              'background-image':
                'url(' + item.profile.profile_headshot_url + ')',
              border: '3px solid #F3F3F3',
            }"
          ></div>
          <p>{{ service_disabled_message }}</p>
        </v-card-text>
      </v-card>
    </v-dialog>

    <v-dialog v-model="modal_not_e_credits" width="420px">
      <v-card color="#fff">
        <v-card-text style="padding: 15px 20px">
               <div class="text-right">
                <v-icon class="text-right" @click="modal_not_e_credits=false">mdi-close</v-icon>
              </div>
          <div class="text-danger text-center my-3">
            <v-subheader
              class="message my-10"
              v-if="item.profile && buyCreditOpcion == 1"
              >Get $5 free with your first purchase!</v-subheader
            >

            <v-subheader
              class="message my-10"
              v-else-if="item.profile && buyCreditOpcion == 2"
              >Get $5 free with your next purchase!</v-subheader
            >

            <v-subheader class="message my-10" v-else-if="item.profile"
              >You do not have enough funds to request service with
              {{ item.profile.display_name }}.</v-subheader
            >

            <v-btn
              color="primary"
              depressed
              style="color: #fff !important"
              rounded
              @click="add_credits()"
            >
              <span v-if="buyCreditOpcion == 1">Start Now</span>
              <span v-else-if="buyCreditOpcion == 2">Add Now</span>
              <span v-else>Reload Wallet</span>
            </v-btn>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>

    <v-dialog
      content-class="videoAudioDialog"
      elevation="0"
      class="video-audio"
      v-model="videoAudioDialog"
    >
      <v-card
        style="
          margin: auto;
          width: 100%;
          max-width: 700px;
          background-color: transparent;
        "
        @mouseover="hover = true"
        @mouseleave="hover = true"
      >
        <v-icon
          class="w-100 d-flex justify-end pb-2"
          style="color: #ffffff"
          v-show="!audio"
          @click="videoAudioDialog = false"
          >mdi-close-circle-outline</v-icon
        >
        <v-card-text class="pa-0">
          <div class="w-100 d-flex align-center justify-center">
            <video
              controls
              controlslist="nodownload"
              v-if="video"
              style="max-width: 700px; max-height: 500px"
              :poster="item.profile.intro_video_thumbnail"
            >
              <source
                v-bind:src="item.profile.intro_video_path"
                type="video/mp4"
              />
              <source
                v-bind:src="item.profile.intro_video_path"
                type="video/ogg"
              />
              Your browser does not support HTML5 video.
            </video>

            <audio
              controls
              controlslist="nodownload"
              v-if="audio"
              style="max-width: 700px"
            >
              <source v-bind:src="item.profile.intro_audio_path" />
              Your browser does not support the audio element.
            </audio>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>

    <v-dialog v-model="reviewDialog" width="500">
      <v-card>
        <v-subheader class style="position: absolute; right: 0">
          <v-icon
            class="d-block text-right"
            style="position: absolute; right: 15px; z-index: 9"
            @click="reviewDialog = false"
            >mdi-close</v-icon
          >
        </v-subheader>
        <v-card-text class="p-0" style="overflow: hidden">
          <div class="row p-md-5 pb-0 p-2" v-if="item.profile">
            <v-col :lg="2" :md="2" :sm="12" cols="12">
              <div
                :aria-label="item.profile.display_name"
                class="user_avatar mr-3"
                :style="{
                  'background-image':
                    'url(' + item.profile.profile_headshot_url + ')',
                }"
              ></div>
            </v-col>
            <v-col cols="10">
              <div class="primary--text h4 pt-5 pl-4">
                <b>{{ item.profile.display_name }}</b>
              </div>
            </v-col>

            <div class="col-12 my-5 d-flex justify-content-between">
              <div>
                <div :class="review_errors.rating ? 'text-danger' : ''">
                  <b>Select your rating</b>
                </div>
                <v-rating
                  color="amber"
                  dense
                  background-color="#C7C7C7"
                  empty-icon="mdi-star"
                  v-model="review.rating"
                ></v-rating>
              </div>
              <div class="text-right">
                <b>Date</b>
                <div>{{ new Date() | formatDate }}</div>
              </div>
            </div>

            <div class="col-12 mb-5">
              <div
                class="mb-1"
                :class="review_errors.title ? 'text-danger' : ''"
              >
                <b>Headline</b>
              </div>
              <v-text-field
                v-model="review.title"
                filled
                solo
                dense
              ></v-text-field>
            </div>

            <div class="col-12">
              <div
                class="mb-1"
                :class="review_errors.text ? 'text-danger' : ''"
              >
                <b>Write a review</b>
              </div>
              <v-textarea
                filled
                solo
                name="input-7-4"
                v-model="review.text"
              ></v-textarea>
            </div>
          </div>
        </v-card-text>

        <div class="text-right px-md-10 pb-4 pt-2 px-3">
          <v-spacer></v-spacer>

          <v-btn
            class="text-right"
            rounded
            depressed
            :loading="reviewLoading"
            color="primary"
            @click="saveReview"
            >Submit Review</v-btn
          >
        </div>
      </v-card>
    </v-dialog>

    <v-dialog v-model="browserDialog" width="500">
      <v-card>
        <v-subheader class style="position: absolute; right: 0">
          <v-icon
            class="d-block text-right"
            style="position: absolute; right: 15px; z-index: 9"
            @click="browserDialog = false"
            >mdi-close</v-icon
          >
        </v-subheader>
        <v-card-text>
          <div
            class="row p-md-5 pb-0 p-2"
            style="
              color: #757575;
              text-align: center;
              font-weight: 500;
              font-stretch: normal;
              font-style: normal;
              line-height: 1.77;
              letter-spacing: 0.26px;
            "
          >
            <v-col cols="12">
              <div
                style="
                  width: 38px;
                  height: 38px;
                  border: 3px solid #e93030;
                  border-radius: 50%;
                "
                class="d-flex justify-center align-center m-auto"
              >
                <i
                  class="fa fa-exclamation"
                  aria-hidden="true"
                  style="color: #e93030; font-size: 18px"
                ></i>
              </div>

              <p class="mt-5">
                Your browser or device is not compatible with Video Chat and
                Calling. For the best experience please use the following:
              </p>

              <p class="mt-5">
                Desktop & Android: Chrome or Firefox (enable microphone and
                camera)
              </p>

              <p class="mt-5">
                iPhone: Safari (go to settings > allow camera and microphone)
              </p>

              <v-btn
                class="my-5"
                rounded
                large
                color="primary"
                dark
                @click="iniChat(tempService)"
                >Request Anyway</v-btn
              >
            </v-col>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
    <SearchFilter v-if="$vuetify.breakpoint.smAndDown" />
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import moment from "moment";

// Main JS (in UMD format)
import VueTimepicker from "vue2-timepicker";
// CSS
import "vue2-timepicker/dist/VueTimepicker.css";

export default {
  components: { VueTimepicker },
  data: () => ({
    displayPlay: true,
    options: {
      responsive: true,
      height: 130,
      waveColor: "#999999",
      progressColor : "#43425D",
      hideScrollbar: true,
      backend: "MediaElement",
      backgroundColor: "#F4F4F4",
      barWidth: 2,
      cursorWidth: 0
    },
    loadingReviews: false,
    rev_filter: "Newest",
    rev_filter_list: [
      { name: "Newest", key: "Newest" },
      { name: "Oldest", key: "Oldest" },
      { name: "Most Helpful", key: "Helpful" },
    ],
    reviewLoading: false,
    review: {
      rating: 0,
      text: "",
      title: "",
    },
    review_errors: {
      rating: null,
      text: null,
      title: null,
    },
    publisherAudio: true,
    reviewDialog: false,
    reviewSent: false,
    reviewPage: null,
    user_timezone: "",
    hover: false,
    videoAudioDialog: false,
    audio: false,
    video: false,
    categories: [],
    specialties: [],
    styles: [],
    numberReviews: 5,
    tools: [],
    languages: [],
    item: {},
    readMore: false,
    reviewStars: [],
    items: [
      {
        text: "Home",
        disabled: false,
        href: "/",
      },
      {
        text: "Specialties",
        disabled: false,
        href: "/specialties",
      },
    ],
    errors: {},
    service_id: 0,
    slug: "",
    loadingRequest: false,
    loadingCancel: false,
    cancelDialog: false,
    model_tokbox: false,
    tokbox_session: {},
    tokbox_subscriber: {},
    tokbox_caster: {},
    current_request: {},
    choosenService: {
      service: {},
    },

    service_min_duration: 0,
    schedule_appointment: false,

    possible_appointment: {},

    datepicker_menu: false,
    appointment: { category: {} },

    successful_created_appointment: false,
    error_message_created_appointment: false,

    steppedtime: [
      { label: "5 mins", value: 5 },
      { label: "10 mins", value: 10 },
      { label: "15 mins", value: 15 },
      { label: "20 mins", value: 20 },
      { label: "25 mins", value: 25 },
      { label: "30 mins", value: 30 },
      { label: "35 mins", value: 35 },
      { label: "40 mins", value: 40 },
      { label: "45 mins", value: 45 },
      { label: "50 mins", value: 50 },
      { label: "1 hour", value: 60 },
    ],

    psychic_cant_make_appointment: 0,
    psychic_disabled_service_alert: 0,
    service_disabled_message: "",
    end_of_vhcat_alert: 0,
    modal_not_e_credits: 0,
    buyCreditOpcion: -1,
    timezonesok: [],

    other_user_joined_at: new Date(),
    display_timer: "00:00:00",
    timer_loop: {},
    // dialog_new_message: false,
    message: "",
    height_textarea: 45,
    _currentUserAppointmentCount: 1,
    low_credits_alert: false,

    browserDialog: false,
    tempService: false,

    showPopup: false,
    mask: "#:## SS",

    now_or_later: null,
    appointment_date: null,

    start: null,
  }),
  props: {
    userId: {
      type: Number,
      require: true,
    },
    currentUser: {},
    timezones: {
      type: Object,
      require: true,
    },
    currentUserRole: {
      type: Number,
    },
    currentUserAppointmentCount: {
      type: Number,
    },
    currentUserTimezone: {
      type: String,
    },
    reviewLunch: {
      default: null,
    },
    guest: {
      default: true,
    },
    browserAllow: {},
    browser: String,
  },
  computed: {
    services_ordered() {
      if (this.item.services.length) {
        return [
          this.item.services[1],
          this.item.services[2],
          this.item.services[0],
        ];
      }
    },
    today() {
      const d = new Date();
      return d.toISOString().substr(0, 10);
    },
    computedDateFormatted() {
      if (this.appointment_date)
        return moment(this.appointment_date).format("MM-DD");
    },
    ...mapGetters({
      mobile: "util/mobile",
      view: "psychic/view",
      space_header : "util/space",
      loadingFavorite: "favorite/loading",
      loadingHelpfuls: "helpfuls/loading",
    }),
    minutes() {
      let minutes = [];

      for (let i = 0, j = 5; i < 14; i++) {
        if (j < 60) {
          minutes.push({ text: j + " min", value: j });
          j += j < 20 ? 5 : 10;
        } else {
          if (j == 60) minutes.push({ text: "1 hr", value: j });
          else if (j < 120)
            minutes.push({ text: "1:" + (j - 60) + " hr", value: j });
          else minutes.push({ text: "2 hr", value: j });
          j += 10;
        }
      }
      return minutes;
    },
    review_text() {
      return this.review.text;
    },
    review_rating() {
      return this.review.rating;
    },
    review_title() {
      return this.review.title;
    },
    reading_in_progress() {
      return this.item.reading_in_progress;
    },
    item_online() {
      return this.item.online;
    },
    allowedDays() {
      if (!this.item.schedule) return false;
      return this.item.schedule.map((i) => {
        if (i.day == "mon") return 1;
        if (i.day == "tue") return 2;
        if (i.day == "wed") return 3;
        if (i.day == "thu") return 4;
        if (i.day == "fri") return 5;
        if (i.day == "sat") return 6;
        if (i.day == "sun") return 0;
      });
    },
  },
  filters: {
    formatDate(date) {
      return moment(date).format("MM/DD/YYYY");
    },
    formatSchedulaDate(time) {
      return moment(time, "HH:mm:ss").format("h:mm a");
    },
    formatScheduleDateDay(date) {
      return moment(date).format("MM-DD");
    },
    statusString(status) {
      var status_filtered = status;
      if (status == "ENQUEUED") {
        status_filtered = "Pending...";
      } else if (status == "WAITING") {
        status_filtered = "Waiting for Psychic...";
      } else if (status == "LIVE") {
        status_filtered = "LIVE";
      }
      return status_filtered;
    },
    statusMessage(status) {
      var status_filtered = status;
      if (status == "ENQUEUED") {
        status_filtered = "You will be notified when the Psychic is ready.";
      } else if (status == "WAITING") {
        status_filtered = "Psychic is ready to chat.";
      } else if (status == "LIVE") {
        status_filtered = "You are live";
      }
      return status_filtered;
    },
  },
  methods: {
    play() {
      document.querySelector("audio").play();
      this.displayPlay = false;
    },
    pause() {
      document.querySelector("audio").pause();
      this.displayPlay = true;
    },
    showMore() {
      this.loadingReviews = true;
      this.numberReviews += 5;
      this.getReviews();
    },
    showLess() {
      this.loadingReviews = true;
      this.numberReviews = 5;
      this.getReviews();
    },
    allowedDates(val) {
      if (!this.allowedDays) return true;
      return this.allowedDays.includes(parseInt(moment(val).format("d")));
    },
    setPublisherAudio() {
      if (!this.tokbox_caster) return;
      this.publisherAudio = !this.publisherAudio;
      this.tokbox_caster.publishAudio(this.publisherAudio);
    },
    copyLinkToClipboard: function (e) {
      e.preventDefault();
      this.showPopup = true;
      setTimeout(() => {
        this.showPopup = false;
      }, 2000);

      let link = "https://psychics1on1.com/" + this.item.profile.profile_link;
      let textArea = document.createElement("textarea");
      textArea.value = link;
      document.body.appendChild(textArea);
      textArea.select();
      document.execCommand("copy");
      document.body.removeChild(textArea);
    },
    saveReview() {
      if (
        this.review.text.replace(/\s+/g, "") === "" ||
        this.review.title.replace(/\s+/g, "") === "" ||
        this.review.rating === 0
      ) {
        this.f_checkReviewValidation();
        return;
      } else {
        let review = {
          text: this.review.text,
          headline: this.review.title,
          rating: this.review.rating,
          psychic: this.item.id,
        };
        this.reviewLoading = true;
        axios
          .post("/api/v1/user/review/create", review)
          .then((response) => {
            this.reviewLoading = false;
            this.reviewDialog = false;
            //this.reviewSent = true;
            this.$root.$emit("open_dialog_message", {
              message: "Your review was successfully received.",
              message_title: "",
            });
          })
          .catch((error) => {});
      }
    },
    openReviewDialog() {
      if (!this.currentUser) {
        EventBus.$emit("open_login", { same_page_login: true });
        return;
      }
      this.reviewDialog = true;
    },
    hasCredential() {
      if (this.item)
        return this.item.credentials.filter((item) => item.institution_name)
          .length;
      return null;
    },
    getReviews() {
      // if (!this.currentUser) {
      //   EventBus.$emit("open_login", { same_page_login: true });
      //   return;
      // }

      axios
        .get(
          "/api/v1/psychic/reviews_by_psychic?filter=" +
            this.rev_filter +
            "&per_page=" +
            this.numberReviews +
            "&page=" +
            this.reviewPage +
            "&id=" +
            this.item.id
        )
        .then((response) => {
          this.item.reviews = response.data.data;
          this.loadingReviews = false;
          if (response.data.meta.to == this.item.reviews_count)
            this.reviewPage = null;
        })
        .catch((error) => {});
    },
    saveFavorite(item) {
      // if (this.guest) EventBus.$emit("open_login", { same_page_login: true });

      if (!this.currentUser) {
        EventBus.$emit("open_login", { same_page_login: true });
      } else if (!this.loadingFavorite) {
        console.log(item.favorite);

        this.$store
          .dispatch("favorite/saveFavorite", {
            id: item.id,
            type: item.favorite ? "remove" : "save",
          })
          .then(() => (item.favorite = !item.favorite));
      } else {
      }
    },

    saveHelpfuls(item) {
      if (!this.currentUser) {
        EventBus.$emit("open_login", { same_page_login: true });
      } else if (!this.loadingHelpfuls) {
        console.log(item.helpfuls);

        this.$store
          .dispatch("helpfuls/saveHelpfuls", {
            id: item.id,
            type: item.helpfuls ? "remove" : "save",
          })
          .then(() => (item.helpfuls = !item.helpfuls));
      } else {
      }
    },

    getModel() {
      let offset = new Date().getTimezoneOffset(),
        o = Math.abs(offset);
      offset =
        (offset < 0 ? "+" : "-") +
        ("00" + Math.floor(o / 60)).slice(-2) +
        ":" +
        ("00" + (o % 60)).slice(-2);

      this.reviewStars = [];
      this.$store
        .dispatch("psychic/getItem", {
          user: this.userId,
          offset: offset,
          client: this.currentUser,
        })
        .then(() => {
          this.item = this.view.data;

          this.setTimezone();

          if (this.item.reviews_count > 5) this.reviewPage = 1;

          for (let i = 1; i < 6; i++) {
            this.reviewStars.push(
              this.item.reviews_count_start.filter(
                (item) => item.rating == i
              )[0] || {
                rating: i,
                total: 0,
              }
            );
          }

          this.reviewStars.reverse();
          this.readMore =
            this.item.profile.description &&
            this.item.profile.description.length > 500;

          if (typeof this.choosenService.id != "undefined") {
            let i = this.item.services
              .map((item) => item.id)
              .indexOf(this.choosenService.id);

            this.choosenService = this.item.services[i];
            this.service_id = this.item.services[i].service.id;
          } else {
            this.item.services.forEach((service) => {
              if (service.chat_request != null) {
                this.choosenService = service;
                this.service_id = service.service.id;
              }
            });
          var url = window.location.href;
          if (url.lastIndexOf("#reviews") !== -1) {
            setTimeout(function () {
              var element = document.getElementById("reviews");
              var pos = element.getBoundingClientRect().top;
              window.scrollTo({ top: pos - 50, behavior: "smooth" });
            }, 300);
          }
          }
        });
    },
    clickedService(service) {
      if (
        this.choosenService == false ||
        this.choosenService.id != service.id
      ) {
        this.choosenService = service;
      } else {
        this.choosenService = {
          service: {},
        };
      }
    },
    openCancelDialog(service_id) {
      this.service_id = service_id;
      this.cancelDialog = true;
    },
    iniChat(service) {
      this.service_id = service.service.id;

      this.possible_appointment.duration = service.duration;

      this.$set(this, "service_min_duration", service.duration);

      if (!this.currentUser) {
        EventBus.$emit("open_login", { same_page_login: true });
      } else {
        if (this.userId == this.currentUser) {
        } else if (this.currentUserRole === 1) {
          this.psychic_cant_make_appointment = 1;
          return;
        } else if (service.active === 0) {
          this.psychic_disabled_service_alert = true;
        } else {
          if (this.service_id == 2) {
            this.sendTxtChatRequest();
          } else {
            if (!this.browserAllow && !this.browserDialog) {
              this.browserDialog = true;
              this.tempService = service;
              return;
            } else if (this.browserDialog) {
              this.browserDialog = false;
              this.tempService = false;
            }
            if (this.service_id == 1) {
              //this.sendCallRequest();
              this.schedule_appointment = true;
            } else if (this.service_id == 3) {
              this.schedule_appointment = true;
              // this.sendVChatRequest();
            }
          }
        }
      }
    },
    open_sign_up() {
      EventBus.$emit("open_sign_up_user", {});
    },
    sendTxtChatRequest() {
      window.open("/chat?user=" + this.userId, "_self");
      // axios
      //   .get("/api/v1/user/chat/start?receiver=" + this.userId)
      //   .then(response => {
      //     if (response.data) {
      //       window.open("/chat?user=" + this.userId, "_self");
      //     } else {
      //       this.dialog_new_message = true;
      //     }
      //   })
      //   .catch(error => {});
    },
    sendVChatRequest(appointment_id) {
      this.loadingRequest = true;
      axios
        .get(
          "/api/v1/user/vchat/request/" +
            this.userId +
            "/" +
            this.service_id +
            (appointment_id ? "/" + appointment_id : "")
        )
        .then((response) => {
          if (
            response.data.error &&
            response.data.error.message == "Not enough credits"
          ) {
            this.modal_not_e_credits = true;

            this.loadingRequest = false;
          } else {
            this.request_message = response.data.success.message;
            //this.requestDialog = true;
            this.loadingRequest = false;
            let i = this.item.services
              .map((item) => item.service.id)
              .indexOf(this.service_id); // find index of your object

            //var cancelled_service = this.item.services.map((item) => item.id === this.cancelled_service_id);
            this.$set(
              this.item.services[i],
              "chat_request",
              response.data.success.request
            );
            
            this.$root.$emit("open_standard_dialog", {buttom_text:'Ok',title: 'Request Sent',subtitle: 'Please stand by while Psychic accepts.'});
            EventBus.$emit("new_chat_request", response.data.success.request);

            if (typeof this.service_id != "undefined") {
              this.choosenService = this.item.services[i];
            }
          }
        })
        .catch((error) => {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
        });
    },
    add_credits() {
      this.modal_not_e_credits = false;
      this.low_credits_alert = false;
      EventBus.$emit("open-credits", {});
    },
    cancelVChatRequest() {
      this.loadingCancel = true;
      axios
        .get("/api/v1/user/vchat/request_cancel/" + this.userId + "/")
        .then((response) => {
          this.choosenService = {};

          this.request_message = response.data.message;
          this.cancelDialog = false;
          //this.requestDialog = true;
          this.loadingCancel = false;
          let i = this.item.services
            .map((item) => item.id)
            .indexOf(this.service_id); // find index of your object
          console.log("sprofile2");
          console.log(i);
          //var cancelled_service = this.item.services.map((item) => item.id === this.cancelled_service_id);
          EventBus.$emit(
            "cancel_chat_request",
            this.item.services[i].chat_request
          );
          EventBus.$emit("update_credits");
          this.$set(this.item.services[i], "chat_request", null);
          this.service_id = "";
        })
        .catch(function (error) {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
        });
    },
    endVChatRequest() {
      this.loadingCancel = true;
      axios
        .get("/api/v1/user/vchat/end/" + this.user_chat_room_id + "/")
        .then((response) => {
          this.request_message = response.data.message;
          this.cancelDialog = false;
          //this.requestDialog = true;
          this.loadingCancel = false;
          let i = this.item.services
            .map((item) => item.id)
            .indexOf(this.service_id); // find index of your object
          console.log("sprofile3");
          console.log(i);
          //var cancelled_service = this.item.services.map((item) => item.id === this.cancelled_service_id);
          EventBus.$emit(
            "cancel_chat_request",
            this.item.services[i].chat_request
          );
          EventBus.$emit("update_credits");
          this.$set(this.item.services[i], "chat_request", null);

          this.choosenService = {};

          this.service_id = "";

          this.getModel();
        })
        .catch(function (error) {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
        });
    },
    joinVideoChat(service) {
      /* this.loadingCancel = true;
      axios
        .get("/api/v1/user/vchat/available")
        .then(response => {
          this.loadingCancel = false;

          console.log(response.data);
          this.user_chat_room_id = response.data.success[0].user_chat_room_id;
          this.connectTokBox(service);
        })
        .catch(function(error) {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
        });*/

      this.$root.$emit("join_video_chat", {
        chat_request: service.chat_request,
      });
    },
    connectTokBox(service) {
      this.service_id = service.id;
      this.model_tokbox = true;
      this.tokbox_session = OT.initSession(
        "46445262",
        service.chat_request.model_chat_room.tokbox_session_id
      );
      this.tokbox_session.on("streamCreated", (event) => {
        this.other_user_joined_at = new Date();
        this.timer_loop = setInterval(() => {
          var time_now = new Date();

          var diff = time_now.getTime() - this.other_user_joined_at.getTime();

          this.display_timer = new Date(diff).toISOString().substr(11, 8);
        }, 1000);

        var options = {
          insertMode: "append",
          width: "100%",
          height: "100%",
          showControls: true,
          fitMode: "cover",
          preferredResolution: { width: 1280, height: 720 },
        };

        if (service.id == 1) {
          options.subscribeToAudio = true;
          options.subscribeToVideo = false;

          options.name = service.chat_request.model.profile.display_name;
          options.style = { nameDisplayMode: "on" };
        }

        this.tokbox_subscriber = this.tokbox_session.subscribe(
          event.stream,
          "tokbox-subscriber",
          options,
          (error) => {
            console.log("sprofile6");
            console.log(error);

            if (this.tokbox_subscriber.stream.hasVideo) {
              var imgData = this.tokbox_subscriber.getImgData();
              this.tokbox_subscriber.setStyle("backgroundImageURI", imgData);
            } else {
              this.tokbox_subscriber.setStyle(
                "backgroundImageURI",
                service.chat_request.model.profile.profile_headshot_url
              );
            }
          }
        );
      });
      this.tokbox_session.on("streamDestroyed", (event) => {
        console.log("sprofile7");
        console.log(event);
        this.model_tokbox = false;
        this.end_of_vhcat_alert = true;

        this.choosenService = {};
        this.tokbox_session.disconnect();
        //let i = this.item.services.map(item => item.service.id).indexOf(this.service_id); // find index of your object
        //var cancelled_service = this.item.services.map((item) => item.id === this.cancelled_service_id);
        EventBus.$emit("cancel_chat_request", service.chat_request);
        EventBus.$emit("update_credits");
        this.$set(service, "chat_request", null);
        this.service_id = "";
        //this.getModel(); // still has chat_request in there.... make join btn show after ended...

        // clearInterval(this.timer_loop);
        this.display_timer = "00:00:00";
      });
      this.tokbox_session.on("sessionDisconnected", (event) => {
        console.log("sprofile8");
        console.log(event);
      });

      this.tokbox_session.on("signal", (event) => {
        if (event.type === "signal:collide_server") {
          // back end signals
          if (event.data) {
            var eventDataObj = JSON.parse(event.data);
            if (eventDataObj.action) {
              if (eventDataObj.action === "TERMINATE") {
                var terminateMessage = "";
                if (eventDataObj.message) {
                  if (eventDataObj.message === "Not enough credits") {
                    this.model_tokbox = false;
                    this.end_of_vhcat_alert = true;

                    this.choosenService = {};
                    this.tokbox_session.disconnect();
                    //let i = this.item.services.map(item => item.service.id).indexOf(this.service_id); // find index of your object
                    //var cancelled_service = this.item.services.map((item) => item.id === this.cancelled_service_id);
                    EventBus.$emit("cancel_chat_request", service.chat_request);
                    EventBus.$emit("update_credits");
                    this.$set(service, "chat_request", null);
                    this.service_id = "";
                    //this.getModel(); // still has chat_request in there.... make join btn show after ended...

                    // clearInterval(this.timer_loop);
                    this.display_timer = "00:00:00";
                  }
                }
              } else if (eventDataObj.action === "WARNING") {
                var terminateMessage = "";
                if (eventDataObj.message) {
                  if (eventDataObj.message === "LOW CREDITS") {
                    EventBus.$emit("update_credits");
                    this.low_credits_alert = true;
                  }
                }
              }
            }
          }
        }
      });

      // Connect to the session
      this.tokbox_session.connect(
        service.chat_request.model_chat_room.tokbox_model_token,
        (error) => {
          // If the connection is successful, publish to the session
          if (error) {
            console.log("sprofile9");
            console.log(error);
          } else {
            var options = {
              insertMode: "append",
              width: "100%",
              height: "100%",
              showControls: true,
              fitMode: "cover",
              preferredResolution: { width: 1280, height: 720 },
            };
            if (service.chat_request.service_id == 1) {
              options.videoSource = null;

              options.name =
                service.chat_request.user.profile.name +
                " " +
                service.chat_request.user.profile.last_name;
              options.style = { nameDisplayMode: "on" };
            }

            this.tokbox_caster = this.tokbox_session.publish(
              OT.initPublisher("tokbox-publisher", options, (error) => {
                console.log(error);
              }),
              (error) => {
                console.log("sprofile11");
                console.log(error);
                console.log("sprofile12");
                console.log(
                  this.choosenService.chat_request.user.profile
                    .profile_headshot_url
                );

                if (this.tokbox_caster.stream.hasVideo) {
                  var imgData = this.tokbox_caster.getImgData();

                  this.tokbox_caster.setStyle("backgroundImageURI", imgData);
                } else {
                  this.tokbox_caster.setStyle(
                    "backgroundImageURI",
                    this.choosenService.chat_request.user.profile
                      .profile_headshot_url
                  );
                }
              }
            );
          }
        }
      );
    },
    end_video_call() {
      this.model_tokbox = false;
      this.end_of_vhcat_alert = true;
      this.choosenService = {};

      this.tokbox_session.disconnect();

      this.endVChatRequest();
      /*
                let i = this.item.services.map(item => item.service.id).indexOf(this.service_id); // find index of your object
                EventBus.$emit('cancel_chat_request',  this.item.services[i].chat_request);

                this.$set(this.item.services[i], 'chat_request', null);
                this.service_id="";*/

      // clearInterval(this.timer_loop);
      this.display_timer = "00:00:00";
    },

    makePossibleAppointment() {
      this.possible_appointment = {
        category: {},

        now_or_later:
          !this.item_online || this.reading_in_progress ? "later" : "now",

        date: moment().format("YYYY-MM-DD"),
        start: moment().format("HH:mm"),
        duration: 15,
        timezone: this.currentUserTimezone,
        //end: moment().add(1, 'hours').format('HH:mm'),
      };
    },

    appointmentNOW() {
      this.possible_appointment.now_or_later = "now";
      this.now_or_later = "now";
      this.possible_appointment.date = this.appointment_date = moment().format(
        "YYYY-MM-DD"
      );
      this.possible_appointment.start = moment().format("hh:mm");
      this.possible_appointment.ampm = moment().format("A");
      //this.possible_appointment.end=moment().add(1, 'hours').format('HH:mm');
    },

    appointmentLATER() {
      this.possible_appointment = { category: {} };
      this.possible_appointment.now_or_later = "later";
      this.now_or_later = "later";
      this.possible_appointment.date = this.possible_appointment.start = this.appointment_date = null;
      //this.possible_appointment.date = new Date().toISOString().substr(0, 10);//moment()
      //   .add(2, "days")
      //   .format("YYYY-MM-DD");
      // this.possible_appointment.start = moment().format("hh:mm");
      this.possible_appointment.ampm = moment().format("A");
      //this.possible_appointment.end=moment().add(1, 'hours').format('HH:mm');
    },
    validateTimeInput() {
      if (!this.possible_appointment.start) return;
      this.mask = "#:## SS";

      const value = this.possible_appointment.start.split(":");

      let time = this.possible_appointment.start;

      if (
        value[0].substring(0, 1) == 1 &&
        value[1] &&
        value[1].length > 1 &&
        value[1].substring(0, 1) <= 2
      ) {
        this.mask = "##:## SS";

        if (value[0].substring(1, 2) > 2) {
          this.mask = "#:## SS";
          time = value[0].substring(0, 1);

          if (value[0].substring(1, 2) < 6 && value[1]) {
            time =
              time + ":" + value[0].substring(1, 2) + value[1].substring(0, 1);
          } else if (value[0].substring(1, 2) >= 6) {
            this.mask = "#:59 SS";
            time = time + ":" + "59";
          }
        }
      } else if (value[1] && parseInt(value[1]) > 59) {
        this.mask = "#:59 SS";
        time = value[0] + ":59";
      }

      this.start = time;
    },
    validateTime(appointment) {
      if (!this.item.schedule) return true;
      const day = this.item.schedule.filter((i) => {
        if (
          i.day == "mon" &&
          moment(this.possible_appointment.date).format("d") == 1
        )
          return i;
        if (
          i.day == "tue" &&
          moment(this.possible_appointment.date).format("d") == 2
        )
          return i;
        if (
          i.day == "wed" &&
          moment(this.possible_appointment.date).format("d") == 3
        )
          return i;
        if (
          i.day == "thu" &&
          moment(this.possible_appointment.date).format("d") == 4
        )
          return i;
        if (
          i.day == "fri" &&
          moment(this.possible_appointment.date).format("d") == 5
        )
          return i;
        if (
          i.day == "sat" &&
          moment(this.possible_appointment.date).format("d") == 6
        )
          return i;
        if (
          i.day == "sun" &&
          moment(this.possible_appointment.date).format("d") == 0
        )
          return i;
        return false;
      });
      if (day.length) {
        let from = moment(appointment.date + " " + day[0].from);
        let till = moment(appointment.date + " " + day[0].till);

        const currentTime = moment(appointment.date_and_time);

        if (from > till) {
          till.add(1, "days");

          if (
            appointment.now_or_later == "later" &&
            appointment.ampm == "AM" &&
            from.format("A") == "PM" &&
            currentTime.format("A") == "AM" &&
            till > currentTime
          ) {
            currentTime.add(1, "days");
            appointment.date_and_time = currentTime.format("YYYY-MM-DD HH:mm");
            appointment.date = currentTime.format("YYYY-MM-DD");
          }
        }

        return currentTime.isBetween(from, till, undefined, "[]");
      }
      return false;
    },

    submit_appointment() {
      this.errors = {};
      this.possible_appointment.psychic_id = this.userId;

      if (
        !this.possible_appointment.category ||
        !this.possible_appointment.category.id
      ) {
        this.errors = { "category.id": true };
        return;
      }

      this.possible_appointment.service_id = this.service_id;
      if (this.possible_appointment.now_or_later == "later") {
        if (!this.possible_appointment.duration) {
          this.errors = { duration: true };
          return;
        }
        if (!this.appointment_date) {
          this.errors = { date: true };
          return;
        }
        this.possible_appointment.date = this.appointment_date;

        if (!this.possible_appointment.start) {
          this.errors = { date_and_time: true };
          return;
        }
      }

      let appointment = Object.assign({}, this.possible_appointment);

      let time = appointment.start;

      if (appointment.ampm == "PM") {
        if (
          moment(appointment.start, "HH:mm") >= moment("12:00", "HH:mm") &&
          moment(appointment.start, "HH:mm") < moment("13:00", "HH:mm")
        )
          appointment.start = time = appointment.start;
        else
          appointment.start = time = moment(appointment.start, "HH:mm")
            .add(12, "hour")
            .format("HH:mm");
      } else {
        if (
          moment(appointment.start, "HH:mm") >= moment("12:00", "HH:mm") &&
          moment(appointment.start, "HH:mm") < moment("13:00", "HH:mm")
        ) {
          appointment.start = time = moment(appointment.start, "HH:mm")
            .subtract(12, "hours")
            .format("HH:mm");
        }
      }

      if (appointment.now_or_later == "now") {
        appointment.date_and_time = appointment.date + " " + time;
      } else {
        appointment.date_and_time = appointment.date + " " + time;

        if (!this.validateTime(appointment)) {
          this.errors = { date_and_time: true };
          return;
        } else this.errors = {};
      }

      axios
        .post("/api/v1/user/appointment/create", appointment)
        .then((response) => {
          this.loadingCancel = false;

          if (
            response.data.length &&
            response.data[1].message == "Not enough credits"
          ) {
            this.buyCreditOpcion = response.data[1].buyCreditOpcion;
            this.modal_not_e_credits = true;
            this.schedule_appointment = false;

            this.loadingRequest = false;
          } else if (response.data.message == "Appointment created") {
            if (this.possible_appointment.now_or_later == "now") {
              // if here for vocie only....
              this.sendVChatRequest(response.data.data.id);
            } else {
              this.successful_created_appointment = true;

              setTimeout(() => {
                this.successful_created_appointment = false;
              }, 1500);
            }

            this.makePossibleAppointment();

            this.schedule_appointment = false;

            this._currentUserAppointmentCount++;
          }
        })
        .catch((error) => {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }

          if (error.response && typeof error.response.data === "object") {
            this.errors = error.response.data.errors;
          } else {
            this.errors = ["Something went wrong. Please try again."];
          }
        });
    },
    setTimezone() {
      self = this;
      var entries = Object.entries(this.timezones);

      entries.forEach((the_s) => {
        if (the_s[1] == self.item.profile.timezone) {
          self.user_timezone = the_s[0];
        }
      });
    },
    // f_send_first_message() {
    //   if (this.message) {
    //     let text_to_send = this.message;
    //     this.message = "";

    //     axios
    //       .post("/api/v1/user/chat/start", {
    //         text: text_to_send,
    //         receiver: this.userId,
    //       })
    //       .then((response) => {
    //         setTimeout((x) => {
    //           this.$nextTick(() => this.$refs.message.focus());
    //         }, 500);
    //         this.dialog_new_message = false;
    //         window.location.replace("/chat?user=" + this.userId);
    //       })
    //       .catch((error) => {
    //         this.dialog_new_message = false;
    //         if (
    //           error.response.status === 419 ||
    //           error.response.status === 401
    //         ) {
    //           location.reload();
    //         }
    //         if (error.response.status === 400) {
    //           this.$root.$emit("open_dialog_message", {
    //             message: error.response.data.error,
    //             message_title: "ERROR",
    //           });
    //         }
    //       });
    //   } else {
    //     this.$refs.message.focus();
    //   }
    // },
    f_checkReviewValidation(review_property) {
      switch (review_property) {
        case "text":
          this.review_errors.text = !this.review.text.replace(/\s+/g, "");
          break;
        case "title":
          this.review_errors.title = !this.review.title.replace(/\s+/g, "");
          break;
        case "rating":
          this.review_errors.rating = !this.review.rating;
          break;
        default:
          this.review_errors.rating = !this.review.rating;
          this.review_errors.title = !this.review.title.replace(/\s+/g, "");
          this.review_errors.text = !this.review.text.replace(/\s+/g, "");
      }
    },
    removeNotification() {
      /* let i = this.item.services
              .map(item => item.id)
              .indexOf(this.service_id); // find index of your object

      this.$set(this.item.services[i], "chat_request", null);*/
      this.choosenService = {};
      this.service_id = "";
    },
  },
  watch: {
    // datepicker_menu(val){
    //   if(val && !this.appointment_date) {
    //     this.appointment_date = new Date().toISOString().substr(0, 10);
    //   }
    // },
    start() {
      this.$set(this.possible_appointment, "start", this.start);
    },
    schedule_appointment(val) {
      if (val) {
        if (this.item.online && !this.reading_in_progress)
          this.appointmentNOW();
        else this.appointmentLATER();
      }
    },
    reading_in_progress() {
      let now_or_l =
        !this.item_online || this.reading_in_progress ? "later" : "now";
      this.$set(this.possible_appointment, "now_or_later", now_or_l);
    },
    psychic_disabled_service_alert(val) {
      if (val) {
        this.service_disabled_message =
          "Sorry, I’m not accepting new clients right now.";
        let serviceActive = this.item.services.filter((i) => i.active);
        if (serviceActive.length) {
          let enableServices = "";
          serviceActive.forEach((i, index) => {
            enableServices =
              index > 0
                ? `${enableServices} or ${i.service.name}`
                : i.service.name;
          });
          if (serviceActive.length == 1) enableServices = enableServices;

          this.service_disabled_message = `Sorry, I don't offer ${
            this.item.services.filter((i) => i.service.id == this.service_id)[0]
              .service.name
          } right now.
                                        Let's connect via ${enableServices}!`;
        }
      }
    },
    review_text() {
      if (this.reviewDialog) {
        this.f_checkReviewValidation("text");
      }
    },
    review_title() {
      if (this.reviewDialog) {
        this.f_checkReviewValidation("title");
      }
    },
    review_rating() {
      if (this.reviewDialog) {
        this.f_checkReviewValidation("rating");
      }
    },
    reviewDialog(val) {
      if (!val) {
        this.review = { rating: 0, text: "", title: "" };
        this.review_errors = { rating: null, text: null, title: null };
        this.reviewSent = false;
      }
    },
    videoAudioDialog(val) {
      if (!val) {
        this.audio = "";
        this.video = "";
      }
    },
    message: function (val, old) {
      if (this.$refs.message.clientWidth / val.length < 7.7) {
        this.$nextTick(() => {
          if (this.$refs.message.clientWidth / val.length < 4) {
            this.height_textarea = 85;
          } else {
            this.height_textarea = 65;
          }
        });
      } else {
        this.height_textarea = 45;
      }
    },
  },
  created() {
    EventBus.$on("cancel_chat_request", (chat_request) => {
      this.removeNotification();
    });
    this.$root.$on("canceled_or_expired_request", () => {
      this.getModel();
    });

    this.makePossibleAppointment();
    this.getModel();

    Echo.private("privatevideo." + this.currentUser)
      .listen("ModelAcceptTokboxChat", (data) => {
        this.getModel();
      })
      .listen("ModelCancelsTokboxChat", (data) => {
        this.getModel();
      })
      .listen("FanCancelsTokboxChat", (data) => {
        this.getModel();
      });

    Echo.private("privatereading." + this.userId).listen(
      "PsychicCheckIsInReadingProgress",
      (data) => {
        this.$set(this.item, "reading_in_progress", data.is_in_progress);
      }
    );

    var entries = Object.entries(this.timezones);

    entries.forEach((the_s) => {
      this.timezonesok.push({
        text: the_s[0],
        value: the_s[1],
      });
    });

    this._currentUserAppointmentCount = this.currentUserAppointmentCount;

    if (this.reviewLunch == "review") {
      if (!this.currentUser) {
        EventBus.$emit("open_login", { same_page_login: true });
        return;
      }
      this.reviewDialog = true;
    }
  },
};
</script>

<style>
.bottom_menu {
  background-color: #ebf4fd;
  height: 45px;
}
.message {
    display: block;
    text-align: center;
    font-size: 16px;
    color: #1F1E34 !important;
    font-weight: 600;
}
.no-background-hover::before {
  background-color: transparent !important;
}

.no-background-hover:focus {
  outline: 0 !important;
}

video {
  object-fit: cover;
}

wave {
    width: 136px;
    height: 62px !important;
    border-radius: 5px !important;
}
.spaceWave {
  padding: 10px 10px 0px 10px !important;
}

.v-badge__wrapper .v-badge__badge {
  top: 110px !important;
  left: 121px !important;
}

.sfContainerProfile {
  width: 1349px;
  min-height: 200px;
  /* margin-top: 118px; */
}
.sfProfileDetail {
  width: 825px;
  margin-left: 20px;
  background: transparent;
}

.sfProfileFixtures .v-card {
  margin-right: 15px;
}

.sfProfileCredentials {
  margin-top: 20px;
}

.sfNavLeftMo .sfProfileCredentials {
  margin-top: 0px;
}

.sfProfileCredentials h2 {
  font-size: 14px;
  font-weight: 600;
  letter-spacing: 0.28px;
  color: #43425d;
  opacity: 1;
  padding: 0px;
  margin-bottom: 20px;
}

.sfProfileCredentials .v-list-item {
  min-height: auto !important;
  padding: 0px !important;
  display: block;
  margin-bottom: 20px;
}

.sfProfileCredentials .v-list-item__title {
  letter-spacing: 0px;
  color: #656b72 !important;
  opacity: 1;
  font-weight: 600;
  font-size: 12px !important;
  line-height: 18px;
}

.checkBoxMinProfile .v-list-item__title {
  margin-left: 20px !important;
}

.checkBoxMinProfile label {
  margin-left: 20px !important;
  margin-top: 10px !important;
}

.sfProfileCredentials .v-list-item__content {
  font-size: 12px;
  text-align: left;
  font-weight: 500;
  letter-spacing: 0px;
  color: #656b72;
  opacity: 1;
  line-height: 18px;
  padding: 0px;
}

.sfProfileCredentials .v-subheader {
  text-align: left;
  letter-spacing: 0px;
  color: #656b72 !important;
  opacity: 1;
  font-size: 12px !important;
  padding: 0px;
  height: auto;
}

.sfProfileCredentials span {
  text-align: left;
  letter-spacing: 0px;
  font-weight: 500;
  color: #a2a2a2 !important;
  opacity: 1;
  font-size: 12px !important;
  line-height: 18px;
}

.sfProfileBio h2,
.sfProfileFixtures .v-card__title {
  font-size: 14px;
  font-weight: 600;
  letter-spacing: 0.28px;
  color: #43425d;
  opacity: 1;
  padding: 0px;
  margin-bottom: 20px;
  line-height: 19px;
}
.sfProfileFixtures .v-card__text {
  padding: 0px;
}

.sfProfileFixtures .v-list-item {
  padding: 0px !important;
  margin-bottom: 10px;
  min-height: auto !important;
}

.sfNavLeftMo .sfProfileFixtures {
  margin-bottom: 10px;
}

.sfProfileBio,
.sfProfileFixtures .v-list-item__content {
  font-size: 12px;
  letter-spacing: 0px;
  color: #656b72;
  opacity: 1;
  line-height: 18px;
  font-weight: 500;
  padding: 0px;
}

.sfProfileRates {
  box-shadow: 0px 3px 4px -2px rgba(0, 0, 0, 0.1);
  background: #fff;
  min-height: 90px;
  margin-bottom: 20px;
}
.sfProfileRates .v-btn {
  margin: 20px 0px;
  width: 223px;
  height: 50px;
  padding: 0px !important;
}

.sfRatesTitle {
  height: 50px;

  margin: 20px 24px 20px 20px;
}

.sfRatesTitle p {
  margin: 0;
  position: relative;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-size: 14px;
  font-weight: 600;
  letter-spacing: 0.28px;
  color: #43425d;
  opacity: 1;
}

.sfProfileActionLine {
  color: #43425d;
  letter-spacing: 0.24px;
  font-size: 12px;
  line-height: 15px;
  font-weight: 500;
}

.sfProfileActionLine .v-btn__content {
  display: inline-flex !important;
  padding-top: 5px;
  padding-left: 0px;
  padding-right: 10px;
}

.sfProfileAction .sfProfileActionItem button {
  margin-right: 20px;
}

.sfProfileAction .v-btn__content {
  font-weight: 500;
  font-size: 12px;
  line-height: 15px;
  letter-spacing: 0.2px;
  color: #43425d;
  opacity: 1;
}
.sfProfileAction .v-btn__content .text-lowercase {
  margin-left: 10px;
}
.sfProfileAction .v-btn__content span{ 
  margin-bottom: 5px;
}


.sfNavLeft {
  /* top: 118px; */

  position: fixed;
  width: 408px;
  max-width: 408px;
  /* height: calc(100% - 121px); */
  z-index: 200;
}

.sfNavLeftMo {
  /* top: 118px; */

  position: relative;
  width: 100%;
  max-width: 100%;
  /* z-index: 200; */
}

.sfNavLeftb {
  width: 408px;
  max-width: 408px;
  /* height: calc(100% - 121px);
  min-height: calc(100% - 121px); */
}
.sfNavBtn {
  width: 80px;
  background: #ebf4fd;
  display: grid;
  /* height: calc(100% - 0px); */
  min-height: calc(100% - 0px);
}

.sfNavLeft .v-btn__content {
  display: grid;
  font-size: 14px;
  text-align: center;
  letter-spacing: 0.28px;
  color: #1f1e34;
  font-weight: 600;
  line-height: 18px;
}

.sfNavLeft .v-btn__content span {
  white-space: break-spaces;
  width: 44px;
}

.sfNavLeftMo .v-btn__content {
  /* display: grid; */
  font-size: 12px;
  text-align: center;
  letter-spacing: 0.28px;
  color: #1f1e34;
  font-weight: 600;
  line-height: 18px;
}

.statusMob.v-btn:not(.v-btn--round).v-size--default {
  padding: 0px !important;
}

/* .sfNavLeft {
  height: 33%;
} */
.sfNavLeft img {
  margin: 0 auto;
  margin-bottom: 16px;
}

.sfProfileRates button:focus,
.sfProfileRates button:hover,
.sfProfileRates button::before,
.sfNavLeft button:focus,
.sfNavLeft button:hover,
.sfNavLeft button::before,
.sfNavLeftMo button:focus,
.sfNavLeftMo button:hover,
.sfNavLeftMo button::before {
  border: none !important;
  outline: none !important;
}
.sfProfileStar {
  margin-bottom: 20px;
  height: 32px;
}
.sfNavProfile {
  width: 328px;

  background: #ffffff;
  padding: 0px;
  height: calc(100% - 0px);
  min-height: calc(100% - 0px);
}
.sfNavProfile .v-card__title {
  font-size: 18px;
  font-weight: 600;
  letter-spacing: 0px;
  color: #1f1e34;
  opacity: 1;
  padding: 0px;
  word-break: break-word;
}

.sfNavLeftMo .v-card__title {
  font-size: 14px;
  font-weight: 600;
  letter-spacing: 0px;
  color: #43425d;
  opacity: 1;
  padding: 0px;
  word-break: break-word;
}

.sfNavProfile .v-card__text {
  padding: 0px;
}

.sfTagline {
  font-size: 12px;
  font-weight: 600;
  letter-spacing: 0px;
  color: #a2a2a2;
  opacity: 1;
  text-align: left;
  line-height: 18px;
  padding: 30px 20px 0px 20px;
}

.sfElevator {
  font-size: 12px;
  font-weight: 500;
  letter-spacing: 0px;
  color: #656b72;
  opacity: 1;
  text-align: left;
  line-height: 18px;
  margin: 20px 20px 0px 20px;
}

.sfMedia {
  margin: 10px 40px 30px 20px;
}

.sfProfileInfo {
  padding: 10px 20px 10px 20px;
  background: #f4f4f4;
}

.sfProfileInfo .v-card__title {
  font-size: 12px !important;
  font-weight: 500;
  letter-spacing: 0.24px;
  color: #43425d;
  opacity: 0.5;
  text-align: left;
  line-height: 19px;
  padding: 0px;
}

.sfProfileInfo .v-card__text {
  font-size: 12px;
  font-weight: 600;
  letter-spacing: 0.24px;
  color: #656b72 !important;
  opacity: 1;
  text-align: left;
  line-height: 15px;
  text-align: center;
  padding: 0px;
  margin-top: 4px;
}

.noOutlined .v-sheet.v-card:not(.v-sheet--outlined),
.sfProfileFixtures .v-sheet.v-card:not(.v-sheet--outlined),
.sfNavLeft .v-sheet.v-card:not(.v-sheet--outlined),
.sfNavLeftMoOutlined.v-sheet.v-card:not(.v-sheet--outlined) {
  box-shadow: none !important;
}
.sfProfileListRating,
.sfProfileRating {
  padding: 0px;
}
.sfNavLeftMoS.widthSelect .v-input__slot {
  padding: 0px !important;
  margin: 0px !important;
}
.checkListGrays.v-menu__content .theme--light.v-list-item--active {
  border-bottom: 1px solid #f4f4f4 !important;
  background: #f4f4f4 !important;
  color: #8e8d99 !important;
}

.checkListGrays .v-list-item {
  border-bottom: none !important;
  background: #f4f4f4 !important;
  color: #8e8d99 !important;
  padding: 0px 7px !important;
}

.sfProfileRating .v-card__title {
  font-size: 14px;
  line-height: 19px;
  font-weight: 600;
  letter-spacing: 0.28px;
  color: #43425d;
  opacity: 1;
}

.sfProfileRating label {
  font-size: 12px !important;
  line-height: 18px;
  text-align: left;
  letter-spacing: 0px;
  color: #656b72 !important;
  opacity: 1;
  font-weight: 500 !important;
}

.sfProfileRating .v-progress-linear__background {
  border-radius: 18px;
  position: absolute;
  left: 0px !important;
  width: 100% !important;
}

.sfProfileRating .v-progress-linear__determinate {
  border-radius: 18px;
}

.sfProfileRating .v-card__actions {
  padding: 10px 20px 20px 20px;
}

.sfProfileRating .v-card__actions .v-btn {
  height: auto;
  min-width: auto;
}

.sfProfileRating .v-card__actions button:focus,
.sfProfileRating .v-card__actions :focus,
.sfProfileRating .v-card__actions :before,
.sfProfileRating .v-card__actions button,
.sfProfileRating .v-card__actions .button:hover,
.sfProfileRating .v-card__actions :hover {
  outline: 0px !important;
  background: none !important;
  opacity: 1;
}

.sfProfileRating .v-card__actions .v-btn__content {
  font-size: 12px !important;
  font-weight: 500 !important;
  letter-spacing: 0px;
  color: #a2a2a2;
  opacity: 1;
}

.sfProfileListRating {
  margin: 20px 0px;
  padding: 15px;
}

.sfProfileListRating .v-card__text {
  font-size: 12px !important;
  font-weight: 500 !important;
  letter-spacing: 0px;
  color: #656b72 !important;
  opacity: 1;
  line-height: 18px;
  padding: 0px !important;
}

.sfProfileListRating .v-card__subtitle {
  font-size: 15px !important;
  font-weight: 600 !important;
  letter-spacing: 0px;
  color: #656b72 !important;
  opacity: 1;
  padding-bottom: 19px;
  padding: 0px !important;
  margin-bottom: 10px;
}
.sfProfileListRating .v-list-item {
  padding: 0px !important;
  margin: 0px;
}

.sfProfileListRating .v-list-item__title {
  font-size: 15px !important;
  font-weight: 600 !important;
  letter-spacing: 0px;
  color: #1f1e34 !important;
  opacity: 1;
  line-height: 18px;
}

.sfProfileListRating .v-list-item__subtitle {
  font-size: 12px !important;
  letter-spacing: 0px;
  color: #656b72 !important;
  opacity: 1;
  line-height: 15px;
}
.sfProfileListRating .v-list-item__content {
  align-self: start;
}
.sfProfileListRating .v-list-item__content span {
  font-size: 12px !important;
  font-weight: 500 !important;
  letter-spacing: 0px;
  color: #656b72 !important;
  opacity: 1;
  line-height: 15px;
}

.sfProfileListRating .v-select__selections,
.sfProfileListRating .v-input__slot {
  height: 32px !important;
  min-height: 32px !important;
}

.sfProfileListRating .widthSelect {
  width: 126px !important;
  max-width: 126px !important;
}

.textOline {
  font-weight: 600;
  font-size: 12px;
}

.sfBottomNav {
  position: fixed;
  width: 100%;
  margin: 0px;
  bottom: 0px;
  z-index: 5;
  margin-bottom: 30px;
}

.sfBottomNavText {
  font-size: 12px;
  text-align: center;
  font-weight: 600;
  letter-spacing: 0.24px;
  color: #1f1e34;
  text-transform: capitalize;
  opacity: 1;
  background: #ebf4fd;
  margin-top: 8px;
}

.sfbottom_menu_round {
  height: 50px !important;
  border: 0px;
  border-top-left-radius: 25px;
  border-top-right-radius: 25px;
  width: 50px !important;

  display: inline-table;
  margin: 0px 27px;
}
.sfbottom_menu_round button,
.sfbottom_menu_round .v-btn:not(.v-btn--round).v-size--default {
  height: 100% !important;
}

.radiusNav {
  background: #ebf4fd;
  border-radius: 70px !important;
  height: 20px !important;
  width: 50px !important;
  padding: 0px !important;
}

.radiusNav.v-btn--block {
  width: 50px !important;
  min-width: 50px !important;
}
.radiusNav.theme--light.v-btn.v-btn--disabled:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined),
.radiusNav.theme--light.v-btn.v-btn--disabled .v-btn__content div {
  background: #ebf4fd !important;
  color: #c1c8d4 !important;
}
.radiusNav.theme--light.v-btn.v-btn--disabled .v-btn__content img {
  opacity: 0.2;
}
.statusMob {
  width: 100%;
}
.statusMob.v-btn {
  box-shadow: 0px 3px 6px #0000000f !important;
  margin-bottom: 10px;
}

.statusMob .text-lowercase,
.statusMob .text-Serv {
  letter-spacing: 0.24px;
  color: #43425d !important;
  font-weight: 500 !important;
}
.statusMob.v-btn:not(.v-btn--round).v-size--default {
  height: 50px !important;
}

.statusMob.theme--light.v-btn.v-btn--disabled:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined) {
  background: none !important;
}
.statusMob.theme--light.v-btn.v-btn--disabled .v-btn__content .col,
.statusMob.theme--light.v-btn.v-btn--disabled .v-btn__content span {
  /* opacity: 0.5; */
  color: #c7c7c7 !important;
}

.divNavButtom {
  background: #ebf4fd;
  z-index: 5;
  height: 69px;
  bottom: 0px;
  position: fixed;
  width: 100%;
}

.bottom_menu_round .v-btn__content {
  display: flow-root;
}

.sfNavLeftMo .row {
  margin-left: 0px !important;
  margin-right: 0px !important;
}

.sfProfileListRating .v-badge__badge {
  right: -9px !important;
  bottom: calc(100% - 4px);
  left: unset !important;
  right: auto;
  top: auto !important;
}

.sfProfileListRating .v-badge.v-badge--avatar.theme--light {
  width: 100%;
}

/* @media only screen and (min-width: 1281px) {
  .sfNavLeft {
    height: 710px;
    min-height: 710px;
  }
  .sfNavLeftb {
    height: 710px;
    min-height: 710px;
  }
 
  .sfNavProfile {
    height: 710px;
    min-height: 710px;
  }
} */

.ico-profile-favorites-h {
  background: url("/images/profile/favorites.svg");
  background-position: center;
  height: 30px;
  width: 30px;
  background-repeat: no-repeat;
}

.ico-profile-listen-h {
  background: url("/images/profile/listen.svg");
  background-position: center;
  height: 30px;
  width: 30px;
  background-repeat: no-repeat;
}

.ico-profile-watch-h {
  background: url("/images/profile/watch.svg");
  background-position: center;
  height: 30px;
  width: 30px;
  background-repeat: no-repeat;
}

.sfNavBtn
  .theme--light.v-btn.v-btn--disabled:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined) {
  background: #ebf4fd !important;
}

.sfNavBtn
  .theme--light.v-btn.v-btn--disabled:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined)
  span,
.sfNavBtn .theme--light.v-btn.v-btn--disabled .v-btn__content span {
  color: #c7c7c7 !important;
}

.sfNavBtn .theme--light.v-btn.v-btn--disabled .v-btn__content img {
  /* opacity: 0.4; */
}



.sfProfileActionItem
  .theme--light.v-btn.v-btn--disabled:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined) {
  background-color: rgb(244, 244, 244) !important;
  border-color: rgb(244, 244, 244) !important;
}

.sfProfileActionItem
  .theme--light.v-btn.v-btn--disabled:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined)
  span,
.sfProfileActionItem .theme--light.v-btn.v-btn--disabled .v-btn__content span {
  /* opacity: 0.5; */
  color: #c7c7c7 !important;
}

.sfCarTexSub {
  color: #43425d;
  opacity: 0.5;
  font-weight: 500;
}
.saveHelpful {
  margin: 10px 5px 0px 0px;
  padding: 0px;
  height: auto !important;
}
.saveHelpful.v-btn:not(.v-btn--round).v-size--default {
  min-width: auto !important;
  height: auto !important;
  padding: 0px !important;
}
.saveHelpful .v-btn__content {
  height: auto !important;
  letter-spacing: 0px;
  color: #8ebef8;
  opacity: 1;
  font-weight: 600;
  line-height: 15px;
  font-size: 12px;
}

.TapRate,
.sfProfileRating .v-card__actions .TapRate .v-btn__content,
.TapRate .v-btn__content
{
  font-weight: 600 !important;
  color: #8EBEF8 !important;
}


</style>