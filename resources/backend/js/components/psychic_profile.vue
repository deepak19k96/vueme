<template>
  <div v-if="!loading" class="mb-4">
    <form
      style="max-width: 770px"
      class="form-dashboard sfFormProfile"
      @submit="(e) => e.preventDefault()"
      v-if="!$vuetify.breakpoint.xsOnly"
    >
      <!-- Media Edit/Upload row starts -->
      <div class="row sfHeaderProfile m-0">
        <!-- Photo upload -->
        <div class="col-10 d-flex align-between">
          <div class="col-4">
            <div
              v-if="image.search('AVATAR_DEFAULT.png') >= 0"
              class="col-12 my-5"
            >
              <div style="position: relative; margin-bottom: 20px">
                <div
                  id="profile-pic2"
                  class="overlay-upload-btn d-flex align-center"
                >
                  <image_cropper
                    :visible="avatarBlob"
                    :empty="true"
                    :profile="user.profile"
                    @onImageCropped="assignBlob"
                    target-preview-element="profile-img"
                    outputWidth="250"
                    outputHeight="250"
                    ratioX="1"
                    ratioY="1"
                    blobRef="avatarBlob"
                  >
                    <img
                      :alt="user.profile.display_name"
                      id="profile-img"
                      src="/images/profile/empty-image.png"
                      class="profile-input-img"
                    />
                  </image_cropper>
                  <span
                    v-if="this.saveImageMsn"
                    id="saveImageMsn"
                    class="hover-text-success text-center"
                  >
                    {{ message_upload }}</span
                  >
                </div>
                <div
                  v-if="this.saveImage & !this.saveImageMsn"
                  class="sfSavePic hover hoverProfile text-center sfSavePic"
                  style="
                    width: 100%;
                    bottom: 21px !important;
                    position: absolute !important;
                  "
                >
                  <v-btn
                    :loading="savingImage"
                    :disabled="savingImage"
                    depressed
                    small
                    text
                    class="white--text"
                    @click="saveAvatar()"
                    >Save</v-btn
                  >
                </div>
              </div>
            </div>

            <div v-else class="col-12 my-5">
              <div style="position: relative; margin-bottom: 20px">
                <div
                  id="profile-pic2"
                  class="overlay-upload-btn d-flex align-center"
                >
                  <image_cropper
                    :profile="user.profile"
                    @onImageCropped="assignBlob"
                    target-preview-element="profile-img"
                    outputWidth="250"
                    outputHeight="250"
                    ratioX="1"
                    ratioY="1"
                    blobRef="avatarBlob"
                  >
                    <img
                      :alt="user.profile.display_name"
                      id="profile-img"
                      v-bind:src="image"
                      class="profile-input-img"
                      style="box-shadow: 0px 3px 6px #0000000d"
                    />
                  </image_cropper>
                  <span
                    v-if="this.saveImageMsn"
                    id="saveImageMsn"
                    class="hover-text-success text-center"
                  >
                    {{ message_upload }}</span
                  >
                </div>
                <div
                  v-if="this.saveImage & !this.saveImageMsn"
                  class="sfSavePic hover hoverProfile text-center sfSavePic"
                  style="
                    width: 100%;
                    bottom: 21px !important;
                    position: absolute !important;
                  "
                >
                  <v-btn
                    :loading="savingImage"
                    :disabled="savingImage"
                    depressed
                    small
                    text
                    class="white--text"
                    @click="saveAvatar()"
                    >Save</v-btn
                  >
                </div>
              </div>
            </div>
          </div>
          <!-- Video upload -->
          <div class="col-4 mt-4 ml-8 pl-0 pr-0" style="max-width: 100px;max-width: 120px;">
            <div v-if="video" class="media_uploader sfProfileFormVideo">
              <v-btn
                class="no-background-hover p-0 m-0"
                text
                style="height: 90px"
                v-if="video"
                @click.stop="
                  videoPlay = true;
                  videoDialog = true;
                "
              >
                <video
                  class="p-0 m-0"
                  style="height: 90px; width: 90px"
                  v-if="video != '' && !edit_video"
                  v-bind:src="video"
                  preload="auto"
                  :poster="thumbnail"
                ></video>
              </v-btn>
              <div class=" text-danger msnInput" v-if="format_error != ''">
                {{ format_error }}
              </div>
              <file-upload
                v-show="files.length == 0"
                input-id="video_upload_top1"
                post-action="/api/v1/user/profile/video/upload"
                ref="upload"
                v-model="files"
                :drop="!$refs.upload || !$refs.upload.active"
                :disabled="$refs.upload && $refs.upload.active"
                @input-filter="inputFilter"
                @input="updatetValue"
                @input-file="inputFile"
                :headers="{ 'X-CSRF-TOKEN': token }"
              >
                 <v-btn
                  v-if="
                    (!$refs.upload || !$refs.upload.active) && files.length > 0
                  "
                  class="buttonVideoSub"
                  @click.prevent="$refs.upload.active = true"
                  
                  >Start</v-btn
                >
                <v-btn style="margin-top: 38px;" v-else>Update </v-btn>
                <v-progress-circular
                class="buttonVideoSub"
                  v-if="$refs.upload && $refs.upload.active"
                  :width="2"
                  color="primary"
                  indeterminate
                ></v-progress-circular>

              </file-upload>
             
            </div>
            <div
              v-else
              class="sfProfileVideo sfProfileVideotOP sfProfileVideoIco d-flex align-center justify-center"
            >
              <div class="buttons-area text-center">
                <div
                  class="grey--text mb-3"
                  :key="file.name"
                  v-for="file in files"
                >
                  {{ file.name }}
                </div>
                <div v-if="files.length == 0">
                  <file-upload
                    input-id="video_upload_top1"
                    :post-action="'/api/v1/user/profile/video/upload'"
                    ref="upload"
                    v-model="files"
                    :drop="!$refs.upload || !$refs.upload.active"
                    :disabled="$refs.upload && $refs.upload.active"
                    @input-filter="inputFilter"
                    @input="updatetValue"
                    @input-file="inputFile"
                    :headers="{ 'X-CSRF-TOKEN': token }"
                  >
                    <v-btn>
                      <div style="padding-bottom: 10px">
                        <img src="/images/profile/add-video.svg" style="opacity: 0.5;" />
                      </div>
                      Add <br />intro video
                    </v-btn>

                    
                  </file-upload>
                </div>
                <div class="mt-3">
                  <v-btn
                    v-if="
                      (!$refs.upload || !$refs.upload.active) &&
                      files.length > 0
                    "
                    class="buttonVideoSub buttonVideoSubEmpty"
                    text
                    @click.prevent="$refs.upload.active = true"
                    >Start upload</v-btn
                  >
                  <v-progress-circular
                    v-if="$refs.upload && $refs.upload.active"
                    :width="2"
                    color="primary"
                    indeterminate
                  ></v-progress-circular>
                </div>
                <div class=" text-danger msnInput" v-if="format_error != ''">
                  {{ format_error }}
                </div>
              </div>
            </div>
          </div>
          <!-- Audio upload top-->
          <div class="col-4 mt-4 ml-0 pl-0">
            <div v-if="audio" class="media_uploader sfProfileFormAudio">
              <v-btn
                class="no-background-hover m-0"
                text
                style="
                  height: 90px;
                  padding: 0px !important;
                  margin-top: 20px;
                  border-radius: 5px;
                "
                v-if="displayPlay"
                @click="play"
                ><vue-wave-surfer
                  class="m-0 p-0"
                  style="width: 140px"
                  :src="audio"
                  :options="options"
                ></vue-wave-surfer>
              </v-btn>
              <v-btn
                class="no-background-hover m-0"
                text
                style="
                  height: 90px;
                  width: 140px;
                  margin-top: 20px;
                  border-radius: 5px;
                "
                v-else
                @click="pause"
              >
                <vue-wave-surfer
                  class="m-0 p-0"
                  style="width: 140px"
                  :src="audio"
                  :options="options"
                ></vue-wave-surfer>
              </v-btn>
              <div class=" text-danger msnInput" v-if="format_error_audio != ''">
                {{ format_error_audio }}
              </div>
              <file-upload
                v-show="filesAudio.length == 0"
                input-id="audio_upload_top1"
                post-action="/api/v1/user/profile/audio/upload"
                ref="uploadAudio"
                v-model="filesAudio"
                :drop="!$refs.uploadAudio || !$refs.uploadAudio.active"
                :disabled="$refs.uploadAudio && $refs.uploadAudio.active"
                @input-filter="inputFilterAudio"
                @input="updateValueAudio"
                @input-file="inputFileAudio"
                :headers="{ 'X-CSRF-TOKEN': token }"
              >
                


              <v-btn
                v-if="
                  (!$refs.uploadAudio || !$refs.uploadAudio.active) &&
                  filesAudio.length > 0
                "
                @click.prevent="$refs.uploadAudio.active = true"
                class="buttonVideo"
                >Start upload</v-btn
              >
              <v-btn style="" v-else>Update</v-btn>



              <v-progress-circular
                v-if="$refs.uploadAudio && $refs.uploadAudio.active"
                :width="2"
               class="buttonVideo"
                color="primary"
                indeterminate
              ></v-progress-circular>


              </file-upload>

            </div>

            <div
              v-else
              class="sfProfileAudio sfProfileAudiotOP sfProfileAudioIco d-flex align-center justify-center"
            >
              <div class="buttons-area text-center">
                <div
                  class="grey--text mb-3"
                  :key="file.name"
                  v-for="file in filesAudio"
                >
                  {{ file.name }}
                </div>

                <div v-show="filesAudio.length == 0" class="btn-upload-wrapper">
                  <file-upload
                    input-id="audio_upload_top1"
                    :post-action="'/api/v1/user/profile/audio/upload'"
                    ref="uploadAudio"
                    v-model="filesAudio"
                    :drop="!$refs.uploadAudio || !$refs.uploadAudio.active"
                    :disabled="$refs.uploadAudio && $refs.uploadAudio.active"
                    @input-filter="inputFilterAudio"
                    @input="updateValueAudio"
                    @input-file="inputFileAudio"
                    :headers="{ 'X-CSRF-TOKEN': token }"
                  >
                    <v-btn>
                      <div style="padding-bottom: 10px">
                        <img src="/images/profile/add-audio.svg" />
                      </div>
                      Add <br />intro Audio
                    </v-btn>
                  </file-upload>
                </div>
                <div>
                  <v-btn
                    v-if="
                      (!$refs.uploadAudio || !$refs.uploadAudio.active) &&
                      filesAudio.length > 0
                    "
                    @click.prevent="$refs.uploadAudio.active = true"
                    class="buttonVideo buttonVideoIco buttonVideoEmpty"
                    >Start upload</v-btn
                  >
                  <v-progress-circular
                    v-show="$refs.uploadAudio && $refs.uploadAudio.active"
                    :width="2"
                    color="primary"
                    indeterminate
                  ></v-progress-circular>
                </div>
                <div class=" text-danger msnInput" v-if="format_error_audio != ''">
                  {{ format_error_audio }}
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Social share buttons -->
        <div
          class="col-2 d-flex align-items-end justify-content-between flex-column"
        >
          <v-tooltip bottom>
            <template v-slot:activator="{ on }">
              <a
                v-on="on"
                @click.stop="share('linkedin')"
                class="primary--text"
              >
                <i class="fab ico-profile-linkedin-h"></i>
              </a>
            </template>
            <span>Share on Linkedin</span>
          </v-tooltip>
          <v-tooltip bottom class="ml-1">
            <template v-slot:activator="{ on }">
              <a
                v-on="on"
                @click.stop="share('facebook')"
                class="primary--text"
              >
                <i class="fab ico-profile-facebook-h"></i>
              </a>
            </template>
            <span>Share on Facebook</span>
          </v-tooltip>
          <v-tooltip bottom>
            <template v-slot:activator="{ on }">
              <a v-on="on" @click.stop="share('twitter')" class="primary--text">
                <i class="fab ico-profile-twitter-h"></i>
              </a>
            </template>
            <span>Share on Twitter</span>
          </v-tooltip>

          <v-tooltip bottom>
            <template v-slot:activator="{ on }">
              <a v-on="on" @click.stop="copyUrl()" class="primary--text">
                <i class="fab ico-profile-copy-h"></i>
              </a>
            </template>
            <span>Copy URL</span>
          </v-tooltip>
        </div>
      </div>
      <!-- Media Edit/Upload row ends -->
      <!-- Tabs start -->
      <v-tabs
        slider-size="0"
        align-with-title
        centered
        grow
        v-model="active_tab"
      >
        <v-tabs-slider></v-tabs-slider>
        <!-- Tab Account -->
        <v-tab tabindex="0" style="margin-left: 0px">Account</v-tab>
        <v-tab-item class="mt-5">
          <div class="d-flex justify-content-between m-1 pl-0 pb-1 pr-2">
            <v-card class="col-6 mr-1 ml-0 pt-1 sfVcard">
              <div class="col-lg-12 col-md-12 form-group p-0 m-0">
                <div
                  class="row ml-0 pr-0"
                  style="margin: 0px 0px 10px 0px !important"
                >
                  <div class="col subtitle-1 pl-0">Account Info</div>

                  <div>
                    <div v-if="profileSaved[0]">
                      <v-btn
                        class="sfProfileSave"
                        color="#fff"
                        small
                        max-width="1"
                      >
                        Saved

                        <img
                          src="/images/icons/save_inactive.svg"
                          style="
                            margin-left: 5px !important;
                            margin-right: -5px;
                          "
                        />
                      </v-btn>
                    </div>
                    <div v-else>
                      <v-btn
                        class="sfProfileSave"
                        color="#fff"
                        small
                        max-width="1"
                        @click="updateProfile(0)"
                        :loading="savingProfile"
                        :disabled="savingProfile"
                      >
                        Save

                        <img
                          src="/images/icons/save_inactive.svg"
                          style="
                            margin-left: 5px !important;
                            margin-right: -5px;
                          "
                        />
                      </v-btn>
                    </div>
                  </div>
                </div>

                <v-text-field
                  id="profile_display_name"
                  label="Display Name"
                  :maxlength="46"
                  @input="
                    textErr = [];
                    errors = [];
                  "
                  @keyup="
                    user.profile.display_name = validateText(
                      user.profile.display_name,
                      0
                    )
                  "
                  solo
                  flat
                  dense
                  hide-details
                  :disabled="user.profile.displayNameEdit != 1"
                  :filled="user.profile.displayNameEdit == 1"
                  :class="[
                    user.profile.displayNameEdit
                      ? 'sfInputClass'
                      : 'sfInputClassInactive',
                  ]"
                  prepend-icon="ico-profile-name"
                  v-model="user.profile.display_name"
                >
                </v-text-field>

                <div v-if="user.profile.displayNameEdit">
                  <div
                    v-if="
                      this.errors != [] && this.errors['profile.display_name']
                    "
                    class="sfHelperCharacters"
                    style="color: red"
                  >
                    {{ this.errors["profile.display_name"][0] }}
                  </div>
                  <div
                    v-else-if="this.textErr != []"
                    class="sfHelperCharacters"
                    style="color: red"
                  >
                    {{ this.textErr[0] }}
                  </div>
                  <span
                    v-if="
                      !this.textErr[0] && !this.errors['profile.display_name']
                    "
                  >
                    <!-- <div
                      class="sfHelperCharacters"
                      v-if="!this.user.profile.display_name"
                      style="color: red"
                    >
                      3 characters to minimum required
                    </div> -->
                    <!-- <div
                      class="sfHelperCharacters"
                      v-else-if="
                        this.user.profile.display_name &&
                        parseInt(this.user.profile.display_name.length) < 3
                      "
                      style="color: red"
                    >
                      {{
                        3 - parseInt(this.user.profile.display_name.length)
                      }}
                      characters to minimum required
                    </div> -->
                    <div
                      class="sfHelperCharacters"
                      v-if="!this.user.profile.display_name"
                    >
                      46 characters left
                    </div>
                    <div v-else class="sfHelperCharacters">
                      {{ 46 - parseInt(this.user.profile.display_name.length) }}
                      characters left
                    </div>
                  </span>
                </div>
              </div>

              <div
                class="col-lg-12 col-md-12 form-group p-0 m-0"
                style="margin-top: 14px !important"
              >
                <v-text-field
                  id="email"
                  label="Email Address"
                  solo
                  flat
                  dense
                  hide-details
                  disabled
                  filled
                  v-model="user.email"
                  class="sfInputClassInactive"
                  prepend-icon="ico-profile-inactive"
                ></v-text-field>
                <span v-if="errors.email" class="float-left text-danger small">
                  {{ errors.email[0] }}
                </span>
              </div>

              <div
                class="col-lg-12 col-md-12 p-0 m-0"
                style="margin-top: 14px !important"
              >
                <div class="row">
                  <div class="col">
                    <v-text-field
                      id="phone_numbers_0_number"
                      label="(555) 555-5555"
                      solo
                      flat
                      disabled
                      dense
                      hide-details
                      filled
                      type="tel"
                      class="sfInputClassInactive sfInputClassLeft"
                      prepend-icon="ico-profile-inactive"
                      v-model="user.phone_numbers[0].number"
                    ></v-text-field>
                    <span
                      v-if="errors['phone_numbers.0.number']"
                      class="float-left text-danger small"
                      >{{ errors["phone_numbers.0.number"][0] }}</span
                    >
                  </div>
                  <div class="col pr-0">
                    <v-select
                      id="phone_numbers_0_code2"
                      :items="country_all"
                      label="Select"
                      class="checkDisabledRigth right-align"
                      filled
                      flat
                      item-text="prefix"
                      item-value="code2"
                      hide-details
                      disabled
                      dense
                      solo
                      auto
                      autocomplete
                      v-model="user.phone_numbers[0].code2"
                      :menu-props="{ contentClass: 'checkList-lineBlue' }"
                    >
                      <template slot="selection" slot-scope="data">
                        <!-- // HTML that describe how select should render selected items -->
                        +{{ data.item.prefix }} - {{ data.item.code3 }}
                      </template>
                      <template slot="item" slot-scope="data">
                        <!-- // HTML that describe how select should render items when the select is open -->
                        +{{ data.item.prefix }} - {{ data.item.code3 }}
                      </template>
                    </v-select>
                    <span
                      v-if="errors['phone_numbers.0.code2']"
                      class="float-left text-danger small"
                      >{{ errors["phone_numbers.0.code2"][0] }}</span
                    >
                  </div>
                </div>
              </div>
            </v-card>
            <v-card class="col-6 ml-1 mr-0 pt-1 sfVcard">
              <div class="col-lg-12 col-md-12 form-group p-0 m-0">
                <div
                  class="row ml-0 pr-0"
                  style="margin: 0px 0px 10px 0px !important"
                >
                  <div class="col subtitle-1 pl-0">Personal Info</div>

                  <div>
                    <div v-if="profileSaved[1]">
                      <v-btn
                        class="sfProfileSave"
                        color="#fff"
                        small
                        max-width="1"
                      >
                        Saved

                        <img
                          src="/images/icons/save_inactive.svg"
                          style="
                            margin-left: 5px !important;
                            margin-right: -5px;
                          "
                        />
                      </v-btn>
                    </div>
                    <div v-else>
                      <v-btn
                        class="sfProfileSave"
                        color="#fff"
                        small
                        max-width="1"
                        @click="updateProfile(1)"
                        :loading="savingProfile"
                        :disabled="savingProfile"
                      >
                        Save

                        <img
                          src="/images/icons/save_inactive.svg"
                          style="
                            margin-left: 5px !important;
                            margin-right: -5px;
                          "
                        />
                      </v-btn>
                    </div>
                  </div>
                </div>

                <v-text-field
                  id="profile_name"
                  label="First Name"
                  :maxlength="50"
                  @input="
                    textErr = [];
                    errors = [];
                  "
                  @keyup="
                    user.profile.name = validateText(user.profile.name, 1)
                  "
                  solo
                  flat
                  dense
                  filled
                  hide-details
                  v-model="user.profile.name"
                  class="sfInputClass"
                  prepend-icon="ico-profile-finger"
                ></v-text-field>
                <div
                  v-if="this.errors != [] && this.errors['profile.name']"
                  class="sfHelperCharacters"
                  style="color: red"
                >
                  {{ this.errors["profile.name"][0] }}
                </div>
                <div
                  v-else-if="this.textErr != []"
                  class="sfHelperCharacters"
                  style="color: red"
                >
                  {{ this.textErr[1] }}
                </div>
                <span v-if="!this.textErr[1] && !this.errors['profile.name']">
                  <div
                    class="sfHelperCharacters"
                    v-if="!this.user.profile.name"
                  >
                    50 characters left
                  </div>
                  <div v-else class="sfHelperCharacters">
                    {{ 50 - parseInt(this.user.profile.name.length) }}
                    characters left
                  </div>
                </span>
              </div>

              <div class="col-lg-12 col-md-12 form-group p-0 m-0">
                <div class="subtitle-1 mb-3"></div>

                <v-text-field
                  id="profile_last_name"
                  label="Last Name"
                  :maxlenght="50"
                  @input="
                    textErr = [];
                    errors = [];
                  "
                  @keyup="
                    user.profile.last_name = validateText(
                      user.profile.last_name,
                      2
                    )
                  "
                  solo
                  flat
                  dense
                  hide-details
                  filled
                  v-model="user.profile.last_name"
                  class="sfInputClass"
                  prepend-icon="ico-profile-finger"
                ></v-text-field>
                <div
                  v-if="this.errors != [] && this.errors['profile.last_name']"
                  class="sfHelperCharacters"
                  style="color: red"
                >
                  {{ this.errors["profile.last_name"][0] }}
                </div>
                <div
                  v-else-if="this.textErr != []"
                  class="sfHelperCharacters"
                  style="color: red"
                >
                  {{ this.textErr[2] }}
                </div>
                <span
                  v-if="!this.textErr[2] && !this.errors['profile.last_name']"
                >
                  <div
                    class="sfHelperCharacters"
                    v-if="!this.user.profile.last_name"
                  >
                    50 characters left
                  </div>
                  <div v-else class="sfHelperCharacters">
                    {{ 50 - parseInt(this.user.profile.last_name.length) }}
                    characters left
                  </div>
                </span>
              </div>

              <div
                class="col-lg-12 col-md-12 p-0 m-0"
                style="margin-top: 20px !important"
              >
                <div class="row">
                  <div class="col">
                    <v-text-field
                      id="profile_birth_date"
                      background-color="#EBF4FD"
                      label="01/15/2001"
                      solo
                      flat
                      dense
                      hide-details
                      filled
                      v-model="user.profile.birth_date"
                      type="text"
                      v-mask="'##/##/####'"
                      class="sfInputClass sfInputClassLeft"
                      prepend-icon="ico-profile-birthday"
                    ></v-text-field>
                    <span
                      v-if="errors['profile.birth_date']"
                      class="float-left text-danger small"
                      >{{ errors["profile.birth_date"][0] }}</span
                    >
                  </div>
                  <div class="col pr-0">
                    <v-select
                      id="profile_gender"
                      :items="gender"
                      label="Select"
                      filled
                      flat
                      hide-details
                      dense
                      solo
                      v-model="user.profile.gender"
                      class="checkRigth right-align"
                      :menu-props="{ contentClass: 'checkList-lineBlue' }"
                    ></v-select>
                    <span
                      v-if="errors['profile.gender']"
                      class="float-left text-danger small"
                      >{{ errors["profile.gender"][0] }}</span
                    >
                  </div>
                </div>
              </div>
            </v-card>
          </div>
          <div class="d-flex justify-content-between m-1 pl-0 pt-1 pb-1 pr-2">
            <v-card class="col-6 mr-1 ml-0 pt-1 sfVcard">
              <div class="col-lg-12 col-md-12 form-group p-0 m-0">
                <div
                  class="row ml-0 pr-0"
                  style="margin: 0px 0px 10px 0px !important"
                >
                  <div class="col subtitle-1 pl-0">Preferences</div>

                  <div>
                    <div v-if="profileSaved[2]">
                      <v-btn
                        class="sfProfileSave"
                        color="#fff"
                        small
                        max-width="1"
                      >
                        Saved

                        <img
                          src="/images/icons/save_inactive.svg"
                          style="
                            margin-left: 5px !important;
                            margin-right: -5px;
                          "
                        />
                      </v-btn>
                    </div>
                    <div v-else>
                      <v-btn
                        class="sfProfileSave"
                        color="#fff"
                        small
                        max-width="1"
                        @click="updateProfile(2)"
                        :loading="savingProfile"
                        :disabled="savingProfile"
                      >
                        Save

                        <img
                          src="/images/icons/save_inactive.svg"
                          style="
                            margin-left: 5px !important;
                            margin-right: -5px;
                          "
                        />
                      </v-btn>
                    </div>
                  </div>
                </div>
                <v-text-field
                  id="profile_city"
                  background-color="#EBF4FD"
                  solo
                  flat
                  hide-details
                  dense
                  filled
                  label="City"
                  v-model="user.profile.city"
                  class="sfInputClass"
                  prepend-icon="ico-profile-city"
                ></v-text-field>

                <span
                  v-if="errors['profile.city']"
                  class="float-left text-danger small"
                  >{{ errors["profile.city"][0] }}</span
                >
              </div>

              <div
                class="col-lg-12 col-md-12 p-0 m-0"
                style="margin-top: 14px !important"
              >
                <div class="row">
                  <div
                    class="col pr-0"
                    style="max-width: fit-content; margin-right: 10px"
                  >
                    <v-select
                      id="profile_country"
                      :items="countries"
                      label="Select"
                      filled
                      dense
                      flat
                      hide-details
                      item-value="code"
                      item-text="name"
                      solo
                      v-model="user.profile.country"
                      class="checkRigth right-align"
                      :menu-props="{ contentClass: 'checkList-lineBlue' }"
                    ></v-select>

                    <span
                      v-if="errors['profile.country']"
                      class="float-left text-danger small"
                      >{{ errors["profile.country"][0] }}</span
                    >
                  </div>
                  <div class="col pr-0 pl-0">
                    <v-select
                      id="profile_timezone"
                      :items="timezonesok"
                      label="Select"
                      filled
                      dense
                      flat
                      hide-details
                      solo
                      v-model="user.profile.timezone"
                      required
                      class="checkRigthLong"
                      :menu-props="{ contentClass: 'checkList-lineBlue' }"
                    ></v-select>

                    <span
                      v-if="errors['profile.timezone']"
                      class="float-left text-danger small"
                      >{{ errors["profile.timezone"][0] }}</span
                    >
                  </div>
                </div>
              </div>

              <div
                class="col-lg-12 col-md-12 p-0 m-0"
                style="margin-top: 10px !important"
              >
                <div
                  class="row"
                  :key="index"
                  v-for="(language, index) in user.languages"
                  style="margin-top: 10px !important"
                >
                  <div class="col">
                    <v-select
                      :id="'languages_' + index + '_languages_id'"
                      :items="languages"
                      item-text="name"
                      item-value="id"
                      label="Language"
                      background-color="#EBF4FD"
                      filled
                      dense
                      flat
                      hide-details
                      solo
                      v-model="language.languages_id"
                      required
                      class="checklefLanguage"
                      :menu-props="{ contentClass: 'checkList-lineBlue' }"
                    ></v-select>
                    <span
                      v-if="errors['languages.' + index + '.languages_id']"
                      class="float-left text-danger small"
                    >
                      {{ errors["languages." + index + ".languages_id"][0] }}
                    </span>
                  </div>
                  <div class="col pr-0">
                    <a
                      v-if="
                        index == 0 && user.languages.length < languages.length
                      "
                      @click.prevent="addLanguage"
                      class="removeLanguage"
                    >
                      Add
                      <i class="fas fa-plus ml-1 ico-profile-add"></i>
                    </a>

                    <a
                      v-else
                      class="removeLanguage"
                      @click="removeLanguage(index, language)"
                    >
                      Remove
                      <i class="fas fa-minus ml-1 ico-profile-delete"></i>
                    </a>
                  </div>
                </div>
              </div>
            </v-card>
            <v-card class="col-6 mr-1 ml-1 pt-1 sfVcard">
              <div class="col-lg-12 col-md-12 form-group p-0 m-0">
                <div
                  class="row ml-0 pr-0"
                  style="margin: 0px 0px 10px 0px !important"
                >
                  <div class="col subtitle-1 pl-0">Media</div>

                  <div>
                    <div v-if="profileSaved[3]">
                      <v-btn
                        class="sfProfileSave"
                        color="#fff"
                        small
                        max-width="1"
                      >
                        Saved

                        <img
                          src="/images/icons/save_inactive.svg"
                          style="
                            margin-left: 5px !important;
                            margin-right: -5px;
                          "
                        />
                      </v-btn>
                    </div>
                    <div v-else>
                      <v-btn
                        class="sfProfileSave"
                        color="#fff"
                        small
                        max-width="1"
                        @click="updateProfile(3)"
                        :loading="savingProfile"
                        :disabled="savingProfile"
                      >
                        Save

                        <img
                          src="/images/icons/save_inactive.svg"
                          style="
                            margin-left: 5px !important;
                            margin-right: -5px;
                          "
                        />
                      </v-btn>
                    </div>
                  </div>
                </div>
                <p class="sfProfileText">
                  Upload an intro video or audio message to make a good first
                  impression. Introduce yourself, your services and why clients
                  should choose you. Psychics with intro media have priority
                  visibility and secure more clients.
                </p>
              </div>
              <div class="row">
                <div class="col-4 form-group p-0 pl-3">
                  <div class="subtitle-1 mb-1"></div>
                  <!-- VIDEO UPLOADER START -->
                  <div v-if="video" class="media_uploader sfProfileFormVideo sfProfileFormVideoBox">
              <v-btn
                class="no-background-hover p-0 pr-2 m-0"
                text
                style="height: 90px"
                v-if="video"
                @click.stop="
                  videoPlay = true;
                  videoDialog = true;
                "
              >
                <video
                  class="p-0 m-0"
                  style="height: 90px; width: 90px"
                  v-if="video != '' && !edit_video"
                  v-bind:src="video"
                  preload="auto"
                  :poster="thumbnail"
                ></video>
              </v-btn>
              <div class=" text-danger msnInput" v-if="format_error != ''">
                {{ format_error }}
              </div>
              <file-upload
                v-show="files.length == 0"
                input-id="video_upload_top"
                post-action="/api/v1/user/profile/video/upload"
                ref="upload"
                v-model="files"
                :drop="!$refs.upload || !$refs.upload.active"
                :disabled="$refs.upload && $refs.upload.active"
                @input-filter="inputFilter"
                @input="updatetValue"
                @input-file="inputFile"
                :headers="{ 'X-CSRF-TOKEN': token }"
              >

   <v-btn
                  v-if="
                    (!$refs.upload || !$refs.upload.active) && files.length > 0
                  "
                  class="buttonVideoSub buttonVideoSubDown"
                  @click.prevent="$refs.upload.active = true"
                  >Start</v-btn
                >

                 <v-btn style="margin-top: 35px;" v-else>Update </v-btn>
                <v-progress-circular
                  v-if="$refs.upload && $refs.upload.active"
                  :width="2"
                  color="primary"
                    class="buttonVideoSub buttonVideoSubDown"
                    style="bottom:6bot0px"
                  indeterminate
                ></v-progress-circular>

               
              </file-upload>
             
            </div>
                  <div  v-else
                    class="sfProfileVideo sfProfileVideoBox d-flex align-center justify-center"
                  >
                    <div class="buttons-area text-center">
                      <div
                        class="grey--text mb-3"
                        :key="file.name"
                        v-for="file in files"
                      >
                        {{ file.name }}
                      </div>
                      <div v-show="files.length == 0">
                        <file-upload
                          input-id="video_upload_bottom"
                          :post-action="'/api/v1/user/profile/video/upload'"
                          ref="upload"
                          v-model="files"
                          :drop="!$refs.upload || !$refs.upload.active"
                          :disabled="$refs.upload && $refs.upload.active"
                          @input-filter="inputFilter"
                          @input="updatetValue"
                          @input-file="inputFile"
                          :headers="{ 'X-CSRF-TOKEN': token }"
                        >
                          <v-btn style="opacity: 0.5; background: transparent;">
                            <div style="padding-bottom: 10px">
                              <img  src="/images/profile/add-video.svg"  />
                            </div>
                            Add <br />intro video
                          </v-btn>
                        </file-upload>
                      </div>

                      <div class="mt-3">
                        <v-btn
                        style=""
                        class="sfProfileVideoBoxMob"
                          v-show="
                            (!$refs.upload || !$refs.upload.active) &&
                            files.length > 0
                          "
                          @click.prevent="$refs.upload.active = true"
                          >Start upload</v-btn
                        >
                        <v-progress-circular
                          v-show="$refs.upload && $refs.upload.active"
                          :width="2"
                          color="primary"
                          indeterminate
                        ></v-progress-circular>
                      </div>
                      <div class=" text-danger msnInput" v-if="format_error != ''">
                        {{ format_error }}
                      </div>
                    </div>
                  </div>

                  <!-- VIDEO UPLOADER END-->
                </div>

                <div class="col-8  p-0 pl-3">
                  <!-- AUDIO UPLOADER START -->
                  <div v-if="audio" class="media_uploader sfProfileFormAudio sfProfileFormAudioDown">
              <v-btn
                class="no-background-hover m-0 sfProfileFormAudioDownColor"
                text
                style="
                  height: 90px;
                  padding: 0px !important;
                  margin-top: 20px;
                  border-radius: 5px;
                "
                v-if="displayPlay"
                @click="play"
                ><vue-wave-surfer
                  class="m-0 p-0"
                  style="width: 140px"
                  :src="audio"
                  :options="optionsDown"
                ></vue-wave-surfer>
              </v-btn>
              <v-btn
                class="no-background-hover m-0 sfProfileFormAudioDownColor"
                text
                style="
                  height: 90px;
                  width: 140px;
                  margin-top: 20px;
                  border-radius: 5px;
                "
                v-else
                @click="pause"
              >
                <vue-wave-surfer
                  class="m-0 p-0"
                  style="width: 140px"
                  :src="audio"
                  :options="options"
                ></vue-wave-surfer>
              </v-btn>
              <div class=" text-danger msnInput" v-if="format_error_audio != ''">
                {{ format_error_audio }}
              </div>
              <file-upload
                v-show="filesAudio.length == 0"
                input-id="audio_upload_top"
                post-action="/api/v1/user/profile/audio/upload"
                ref="uploadAudio"
                v-model="filesAudio"
                :drop="!$refs.uploadAudio || !$refs.uploadAudio.active"
                :disabled="$refs.uploadAudio && $refs.uploadAudio.active"
                @input-filter="inputFilterAudio"
                @input="updateValueAudio"
                @input-file="inputFileAudio"
                :headers="{ 'X-CSRF-TOKEN': token }"
              >
                


              <v-btn
                v-if="
                  (!$refs.uploadAudio || !$refs.uploadAudio.active) &&
                  filesAudio.length > 0
                "
                @click.prevent="$refs.uploadAudio.active = true"
                class="buttonVideo"
                >Start upload</v-btn
              >
              <v-btn style="" v-else>Update</v-btn>



              <v-progress-circular
                v-if="$refs.uploadAudio && $refs.uploadAudio.active"
                :width="2"
               class="buttonVideo"
                color="primary"
                indeterminate
              ></v-progress-circular>


              </file-upload>

            </div>
                  <div v-else
                    class="sfProfileAudio sfProfileAudioBox d-flex align-center justify-center"
                  >
                    <div class="buttons-area text-center">
                      <div
                        class="grey--text mb-3"
                        :key="file.name"
                        v-for="file in filesAudio"
                      >
                        {{ file.name }}
                      </div>

                      <div
                        v-show="filesAudio.length == 0"
                        class="btn-upload-wrapper"
                      >
                        <file-upload
                          input-id="audio_upload_bottom"
                          :post-action="'/api/v1/user/profile/audio/upload'"
                          ref="uploadAudio"
                          v-model="filesAudio"
                          :drop="
                            !$refs.uploadAudio || !$refs.uploadAudio.active
                          "
                          :disabled="
                            $refs.uploadAudio && $refs.uploadAudio.active
                          "
                          @input-filter="inputFilterAudio"
                          @input="updateValueAudio"
                          @input-file="inputFileAudio"
                          :headers="{ 'X-CSRF-TOKEN': token }"
                        >
                          <v-btn>
                            <div style="padding-bottom: 10px">
                              <img src="/images/profile/add-audio.svg" />
                            </div>
                            <font style="opacity: 0.5;">Add <br />intro Audio</font>
                          </v-btn>
                        </file-upload>
                      </div>

                      <div>
                        <v-btn
                          v-if="
                            (!$refs.uploadAudio || !$refs.uploadAudio.active) &&
                            filesAudio.length > 0
                          "
                          @click.prevent="$refs.uploadAudio.active = true"
                          class="buttonVideo buttonVideoBox buttonVideoEmpty"
                          >Start upload</v-btn
                        >
                        <v-progress-circular
                          v-show="$refs.uploadAudio && $refs.uploadAudio.active"
                          :width="2"
                          color="primary"
                          indeterminate
                        ></v-progress-circular>
                      </div>
                      <div
                        class=" text-danger msnInput"
                        v-if="format_error_audio != ''"
                      >
                        {{ format_error_audio }}
                      </div>
                    </div>
                  </div>

                  <!-- AUDIO UPLOADER END -->
                </div>
              </div>
            </v-card>
          </div>
        </v-tab-item>
        <!-- Tab Profile -->
        <v-tab tabindex="1">Profile</v-tab>
        <v-tab-item class="mt-5">
          <v-card class="m-1 mb-2 p-1 pr-2 sfVcard">
            <div class="row pt-1 mb-0">
              <div
                class="col-sm-6 m-0 form-group"
                style="max-width: 287px; margin-right: 20px !important"
              >
                <div
                  class="col-lg-12 col-md-12 form-group mb-0 p-0"
                  style="min-width: 270px; margin-right: 30px !important"
                >
                  <div class="subtitle-1 mb-3">Tagline</div>

                  <v-textarea
                    id="profile_tagline"
                    background-color="#F4F4F4"
                    label="Grab a client’s attention in a single phrase. 20 character min., limit 50."
                    :maxlength="50"
                    @input="
                      textErr = [];
                      errors = [];
                    "
                    @keyup="
                      user.profile.tagline = validateText(
                        user.profile.tagline,
                        3
                      )
                    "
                    solo
                    flat
                    dense
                    filled
                    height="60"
                    width="270"
                    hide-details
                    class="sfInputTaglineClass"
                    v-model="user.profile.tagline"
                  ></v-textarea>
                  <div
                    v-if="this.errors != [] && this.errors['profile.tagline']"
                    class="sfHelperCharacters"
                    style="color: red"
                  >
                    {{ this.errors["profile.tagline"][0] }}
                  </div>
                  <div
                    v-else-if="this.textErr != []"
                    class="sfHelperCharacters"
                    style="color: red"
                  >
                    {{ this.textErr[3] }}
                  </div>
                  <span
                    v-if="!this.textErr[3] && !this.errors['profile.tagline']"
                  >
                    <!-- <div
                      class="sfHelperCharacters"
                      v-if="!this.user.profile.tagline"
                      style="color: red"
                    >
                      20 characters to minimum required
                    </div> -->
                    <!-- <div
                      class="sfHelperCharacters"
                      v-else-if="
                        this.user.profile.tagline &&
                        parseInt(this.user.profile.tagline.length) < 20
                      "
                      style="color: red"
                    >
                      {{
                        20 - parseInt(this.user.profile.tagline.length)
                      }}
                      characters to minimum required
                    </div> -->
                    <div
                      class="sfHelperCharacters"
                      v-if="!this.user.profile.tagline"
                    >
                      50 characters left
                    </div>
                    <div v-else class="sfHelperCharacters">
                      {{ 50 - parseInt(this.user.profile.tagline.length) }}
                      characters left
                    </div>
                  </span>
                </div>
                <div
                  class="col-lg-12 col-md-12 form-group mb-0 p-0"
                  style="max-width: 270px; margin-right: 30px !important"
                >
                  <div class="subtitle-1 mb-3"></div>

                  <v-text-field
                    id="profile_years_experience"
                    type="number"
                    min="0"
                    oninput="validity.valid||(value='');"
                    background-color="#EBF4FD"
                    label="Years Experience"
                    solo
                    width="270"
                    flat
                    dense
                    filled
                    hide-details
                    class="sfInputClass sfInputYearsClass"
                    prepend-icon="ico-profile-years"
                    v-model="user.profile.years_experience"
                  ></v-text-field>

                  <span
                    v-if="errors['profile.years_experience']"
                    class="float-left text-danger small"
                    >{{ errors["profile.years_experience"][0] }}</span
                  >
                </div>
              </div>
              <div class="pl-0">
                <div class="col-lg-12 col-md-12 form-group mb-0 p-0">
                  <div>
                    <div v-if="profileSaved[4]">
                      <v-btn
                        class="sfProfileSave"
                        color="#fff"
                        small
                        max-width="1"
                      >
                        Saved

                        <img
                          src="/images/icons/save_inactive.svg"
                          style="
                            margin-left: 5px !important;
                            margin-right: -5px;
                          "
                        />
                      </v-btn>
                    </div>
                    <div v-else>
                      <v-btn
                        class="sfProfileSave"
                        color="#fff"
                        small
                        max-width="1"
                        @click="updateProfile(4)"
                        :loading="savingProfile"
                        :disabled="savingProfile"
                      >
                        Save

                        <img
                          src="/images/icons/save_inactive.svg"
                          style="
                            margin-left: 5px !important;
                            margin-right: -5px;
                          "
                        />
                      </v-btn>
                    </div>
                  </div>

                  <div class="row mb-0">
                    <div class="col-6 subtitle-1">Elevator Pitch</div>
                  </div>

                  <v-textarea
                    id="profile_elevator_pitch"
                    label="Sell yourself! Summarize your experience, what makes you unique, how clients will benefit and why they should choose your services over any other Psychic. 100 character min., limit 160."
                    background-color="#F4F4F4"
                    style="margin-top: 13px"
                    :maxlength="160"
                    solo
                    @input="
                      textErr = [];
                      errors = [];
                    "
                    @keyup="
                      user.profile.elevator_pitch = validateText(
                        user.profile.elevator_pitch,
                        4
                      )
                    "
                    flat
                    dense
                    filled
                    width="440"
                    height="110"
                    hide-details
                    class="sfInputElevatorClass"
                    v-model="user.profile.elevator_pitch"
                  ></v-textarea>
                  <div
                    v-if="
                      this.errors != [] && this.errors['profile.elevator_pitch']
                    "
                    class="sfHelperCharacters"
                    style="color: red"
                  >
                    {{ this.errors["profile.elevator_pitch"][0] }}
                  </div>
                  <div
                    v-else-if="this.textErr != []"
                    class="sfHelperCharacters"
                    style="color: red"
                  >
                    {{ this.textErr[4] }}
                  </div>
                  <span
                    v-if="
                      !this.textErr[4] && !this.errors['profile.elevator_pitch']
                    "
                  >
                    <!-- <div
                      class="sfHelperCharacters"
                      v-if="!this.user.profile.elevator_pitch"
                      style="color: red"
                    >
                      100 characters to minimum required
                    </div>
                    <div
                      class="sfHelperCharacters"
                      v-else-if="
                        this.user.profile.elevator_pitch &&
                        parseInt(this.user.profile.elevator_pitch.length) < 100
                      "
                      style="color: red"
                    >
                      {{
                        100 - parseInt(this.user.profile.elevator_pitch.length)
                      }}
                      characters to minimum required
                    </div> -->
                    <div
                      class="sfHelperCharacters"
                      v-if="!this.user.profile.elevator_pitch"
                    >
                      160 characters left
                    </div>
                    <div v-else class="sfHelperCharacters">
                      {{
                        160 - parseInt(this.user.profile.elevator_pitch.length)
                      }}
                      characters left
                    </div>
                  </span>
                </div>
              </div>
            </div>
            <div class="row mt-4" style="margin-right: 0px !important">
              <div class="col-lg-12 col-md-12 form-group mb-0 mr-0 pr-0">
                <div class="subtitle-1 mb-3">Background</div>

                <v-textarea
                  id="profile_description"
                  v-model="user.profile.description"
                  @input="
                    textErr = [];
                    errors = [];
                  "
                  @keyup="
                    user.profile.description = validateText(
                      user.profile.description,
                      5
                    )
                  "
                  solo
                  :maxlength="400"
                  background-color="#f4f4f4"
                  class="sfInputBackgroundClass"
                  filled
                  flat
                  width="730"
                  height="113"
                  name="input-7-4"
                  hide-details
                  label="Think of your background like your professional bio - it’s your opportunity to persuade readers to become new clients! Include details about your unique approach to readings, your experience and your favorite spiritual accomplishment. Let your personality shine for a lasting impression. 200 character min., limit 400."
                ></v-textarea>
                <div
                  v-if="this.errors != [] && this.errors['profile.description']"
                  class="sfHelperCharacters"
                  style="color: red"
                >
                  {{ this.errors["profile.description"][0] }}
                </div>
                <div
                  v-else-if="this.textErr != []"
                  class="sfHelperCharacters"
                  style="color: red"
                >
                  {{ this.textErr[5] }}
                </div>
                <span
                  v-if="!this.textErr[5] && !this.errors['profile.description']"
                >
                  <!-- <div
                    class="sfHelperCharacters"
                    v-if="!this.user.profile.description"
                    style="color: red"
                  >
                    200 characters to minimum required
                  </div> -->
                  <!-- <div
                    class="sfHelperCharacters"
                    v-else-if="
                      this.user.profile.description &&
                      parseInt(this.user.profile.description.length) < 200
                    "
                    style="color: red"
                  >
                    {{
                      200 - parseInt(this.user.profile.description.length)
                    }}
                    characters to minimum required
                  </div> -->
                  <div
                    class="sfHelperCharacters"
                    v-if="!this.user.profile.description"
                  >
                    400 characters left
                  </div>
                  <div
                    class="sfHelperCharacters"
                    v-else-if="
                      this.user.profile.description &&
                      parseInt(this.user.profile.description.length) > 400
                    "
                    style="color: red"
                  >
                    {{ parseInt(this.user.profile.description.length) - 400 }}
                    characters over
                  </div>
                  <div class="sfHelperCharacters" v-else>
                    {{ 400 - parseInt(this.user.profile.description.length) }}
                    characters left
                  </div>
                </span>
              </div>
            </div>
          </v-card>

          <v-card class="m-1 p-1 pr-2">
            <div
              class="col-lg-12 col-md-12 form-group m-0 p-0"
              :id="'specialties'"
            >
              <div class="subtitle-1">Specialties</div>
              <div class="sfProfileTip">Select up to 4</div>

              <div class="row mb-5 m-0">
                <div
                  class="col-md-3 col-12 col-sm-3 col-lg-3 sfProfileList p-0 m-0"
                  :key="index"
                  v-for="(item, index) in specialties"
                >
                  <v-checkbox
                    :disabled="
                      user.specialties.length > 3 &&
                      !user.specialties.map((t) => t.id).includes(item.id)
                    "
                    v-model="user.specialties"
                    :label="item.name"
                    :value="item"
                    color="primary"
                  ></v-checkbox>
                </div>
              </div>
              <span v-if="errors['specialties']" class="text-danger small">{{
                errors["specialties"][0]
              }}</span>
            </div>
          </v-card>
          <div class="d-flex justify-content-between m-1 pl-0 pt-1 pb-1 pr-2">
            <v-card class="col-6 mr-1 ml-0 p-0 pl-1">
              <div
                class="col-lg-12 col-md-12 form-group m-0 p-0"
                :id="'categories'"
              >
                <div class="subtitle-1">Abilities</div>
                <div class="sfProfileTip">Select up to 4</div>
                <div class="row mb-5 m-0">
                  <div
                    class="col-md-6 col-12 col-sm-6 col-lg-6 p-0 sfProfileList"
                    :key="index"
                    v-for="(item, index) in categories"
                  >
                    <v-checkbox
                      :disabled="
                        user.categories.length > 3 &&
                        !user.categories.map((t) => t.id).includes(item.id)
                      "
                      v-model="user.categories"
                      :label="item.name"
                      :value="item"
                      color="primary"
                    ></v-checkbox>
                  </div>
                </div>
                <span v-if="errors['categories']" class="text-danger small">
                  {{ errors["categories"][0] }}
                </span>
              </div>
            </v-card>

            <v-card class="col-6 ml-1 mr-0 p-0 pl-1">
              <div class="col-lg-12 col-md-12 form-group m-0 p-0" :id="'tools'">
                <div class="subtitle-1">Tools</div>
                <div class="sfProfileTip">Select up to 3</div>
                <div class="row mb-5 m-0">
                  <div
                    class="col-md-6 col-12 col-sm-6 col-lg-6 p-0 sfProfileList"
                    :key="index"
                    v-for="(item, index) in tools"
                  >
                    <v-checkbox
                      :disabled="
                        user.tools.length > 2 &&
                        !user.tools.map((t) => t.id).includes(item.id)
                      "
                      v-model="user.tools"
                      :label="item.name"
                      :value="item"
                      color="primary"
                    ></v-checkbox>
                  </div>
                </div>
                <span v-if="errors['tools']" class="text-danger small">{{
                  errors["tools"][0]
                }}</span>
              </div>
            </v-card>
          </div>
          <v-card class="m-1 p-1 pr-2">
            <div
              class="col-lg-12 col-md-12 form-group m-0 sfProfileList p-0"
              :id="'styles'"
            >
              <div class="subtitle-1">Style</div>
              <div class="sfProfileTip">Select One</div>
              <div class="row mb-5 m-0">
                <div
                  class="col-md-3 col-12 col-sm-3 col-lg-3 p-0"
                  :key="index"
                  v-for="(item, index) in styles"
                >
                  <v-checkbox
                    :disabled="
                      user.styles.length > 0 &&
                      !user.styles.map((t) => t.id).includes(item.id)
                    "
                    v-model="user.styles"
                    :label="item.name"
                    :value="item"
                    color="primary"
                  ></v-checkbox>
                </div>
              </div>
              <span v-if="errors['styles']" class="text-danger small">{{
                errors["styles"][0]
              }}</span>
            </div>
          </v-card>
          <div class="d-flex justify-content-between m-1 pl-0 pt-1 pb-1 pr-2">
            <v-card class="col-6 mr-1 ml-0 p-0 pl-1">
              <div class="col-lg-12 col-md-12 form-group mb-0">
                <div class="subtitle-1 mb-3">Work</div>
                <div>
                  <div v-if="profileSaved[5]">
                    <v-btn
                      class="sfProfileSave"
                      color="#fff"
                      small
                      max-width="1"
                    >
                      Saved

                      <img
                        src="/images/icons/save_inactive.svg"
                        style="margin-left: 5px !important; margin-right: -5px"
                      />
                    </v-btn>
                  </div>
                  <div v-else>
                    <v-btn
                      class="sfProfileSave"
                      color="#fff"
                      small
                      max-width="1"
                      @click="updateProfile(5)"
                      :loading="savingProfile"
                      :disabled="savingProfile"
                    >
                      Save

                      <img
                        src="/images/icons/save_inactive.svg"
                        style="margin-left: 5px !important; margin-right: -5px"
                      />
                    </v-btn>
                  </div>
                </div>
                <div
                  class="mb-5"
                  :key="index"
                  v-for="(work, index) in user.works"
                >
                  <div class="row">
                    <div class="col-sm-12 form-group p-0">
                      <v-text-field
                        :id="'works_' + index + '_position'"
                        label="Position"
                        solo
                        flat
                        dense
                        filled
                        hide-details
                        v-model="work.position"
                        class="sfInputClass"
                        prepend-icon="ico-profile-work"
                      ></v-text-field>
                      <span
                        v-if="errors['works.' + index + '.position']"
                        class="float-left text-danger small"
                      >
                        {{ errors["works." + index + ".position"][0] }}
                      </span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-12 form-group p-0">
                      <v-text-field
                        label="Company"
                        :id="'works_' + index + '_company'"
                        background-color="#EBF4FD"
                        solo
                        flat
                        dense
                        filled
                        hide-details
                        class="sfInputClass"
                        prepend-icon="ico-profile-work"
                        v-model="work.company"
                      ></v-text-field>
                      <span
                        v-if="errors['works.' + index + '.company']"
                        class="float-left text-danger small"
                        >{{ errors["works." + index + ".company"][0] }}</span
                      >
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-12 form-group p-0">
                      <v-textarea
                        :id="'works_' + index + '_description'"
                        v-model="work.description"
                        label="Provide a brief description of your role and responsibilities. Description optional, character limit 400."
                        solo
                        flat
                        background-color="#F4F4F4"
                        filled
                        hide-details
                        height="149"
                        width="335"
                        name="input-7-4"
                        class="sfInputWorkClass"
                      ></v-textarea>
                      <span
                        v-if="errors['works.' + index + '.description']"
                        class="float-left text-danger small"
                        >{{
                          errors["works." + index + ".description"][0]
                        }}</span
                      >
                    </div>
                  </div>

                  <div class="row">
                    <div class="col p-0" style="max-width: 110px">
                      <v-select
                        :id="'works_' + index + '_from_year'"
                        :items="years"
                        label="Year From"
                        background-color="#EBF4FD"
                        filled
                        flat
                        dense
                        hide-details
                        solo
                        v-model="work.from_year"
                        class="checkYearFrom"
                        :menu-props="{ contentClass: 'checkList-lineBlue' }"
                      ></v-select>
                      <span
                        v-if="errors['works.' + index + '.from_year']"
                        class="float-left text-danger small"
                        >{{ errors["works." + index + ".from_year"][0] }}</span
                      >
                    </div>

                    <div
                      class="col p-0"
                      style="max-width: 110px; margin-left: 10px"
                    >
                      <v-select
                        :id="'works_' + index + '_to_year'"
                        :items="years"
                        label="Year To"
                        background-color="#EBF4FD"
                        filled
                        dense
                        flat
                        hide-details
                        solo
                        v-model="work.to_year"
                        class="checkYearTo"
                        :menu-props="{ contentClass: 'checkList-lineBlue' }"
                      ></v-select>
                      <span
                        v-if="errors['works.' + index + '.to_year']"
                        class="float-left text-danger small"
                        >{{ errors["works." + index + ".to_year"][0] }}</span
                      >
                    </div>

                    <div class="col p-0" style="max-width: 100px">
                      <a
                        @click.prevent="removeWork(index, work)"
                        v-if="index != 0"
                        class="removeLanguage"
                      >
                        Remove
                        <i class="fas fa-minus ml-1 ico-profile-delete"></i>
                      </a>
                      <div v-else>
                        <a
                          v-if="user.works.length < 3"
                          @click.prevent="addWork"
                          class="removeLanguage"
                        >
                          Add
                          <i class="fas fa-plus ml-1 ico-profile-add"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </v-card>

            <v-card class="col-6 ml-1 mr-0 p-0 pl-1">
              <div class="col-lg-12 col-md-12 form-group mb-0">
                <div class="subtitle-1 mb-3">Education</div>
                <div>
                  <div v-if="profileSaved[6]">
                    <v-btn
                      class="sfProfileSave"
                      color="#fff"
                      small
                      max-width="1"
                    >
                      Saved

                      <img
                        src="/images/icons/save_inactive.svg"
                        style="margin-left: 5px !important; margin-right: -5px"
                      />
                    </v-btn>
                  </div>
                  <div v-else>
                    <v-btn
                      class="sfProfileSave"
                      color="#fff"
                      small
                      max-width="1"
                      @click="updateProfile(6)"
                      :loading="savingProfile"
                      :disabled="savingProfile"
                    >
                      Save

                      <img
                        src="/images/icons/save_inactive.svg"
                        style="margin-left: 5px !important; margin-right: -5px"
                      />
                    </v-btn>
                  </div>
                </div>
                <div
                  class="mb-5"
                  :key="index"
                  v-for="(credential, index) in user.credentials"
                >
                  <div class="row">
                    <div class="col-sm-12 form-group p-0">
                      <v-text-field
                        :id="'credentials_' + index + '_institution_name'"
                        label="Institution Name"
                        solo
                        flat
                        dense
                        filled
                        hide-details
                        v-model="credential.institution_name"
                        class="sfInputClass"
                        prepend-icon="ico-profile-credential"
                      ></v-text-field>
                      <span
                        v-if="
                          errors['credentials.' + index + '.institution_name']
                        "
                        class="float-left text-danger small"
                      >
                        {{
                          errors[
                            "credentials." + index + ".institution_name"
                          ][0]
                        }}
                      </span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-12 form-group p-0">
                      <v-text-field
                        label="Degree"
                        :id="'credentials_' + index + '_degree'"
                        background-color="#EBF4FD"
                        solo
                        flat
                        dense
                        filled
                        hide-details
                        class="sfInputClass"
                        prepend-icon="ico-profile-credential"
                        v-model="credential.degree"
                      ></v-text-field>
                      <span
                        v-if="errors['credentials.' + index + '.degree']"
                        class="float-left text-danger small"
                        >{{
                          errors["credentials." + index + ".degree"][0]
                        }}</span
                      >
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-12 form-group p-0">
                      <v-textarea
                        :id="'credentials_' + index + '_description'"
                        v-model="credential.description"
                        label="Provide certifications or further details. Description optional, character limit 400."
                        solo
                        flat
                        background-color="#F4F4F4"
                        filled
                        hide-details
                        height="149"
                        width="335"
                        name="input-7-4"
                        class="sfInputcredentialClass"
                      ></v-textarea>
                      <span
                        v-if="errors['credentials.' + index + '.description']"
                        class="float-left text-danger small"
                        >{{
                          errors["credentials." + index + ".description"][0]
                        }}</span
                      >
                    </div>
                  </div>

                  <div class="row">
                    <div class="col p-0" style="max-width: 110px">
                      <v-select
                        :id="'credentials_' + index + '_from_year'"
                        :items="years"
                        label="Year From"
                        background-color="#EBF4FD"
                        filled
                        flat
                        dense
                        hide-details
                        solo
                        v-model="credential.from_year"
                        class="checkYearFrom"
                        :menu-props="{ contentClass: 'checkList-lineBlue' }"
                      ></v-select>
                      <span
                        v-if="errors['credentials.' + index + '.from_year']"
                        class="float-left text-danger small"
                        >{{
                          errors["credentials." + index + ".from_year"][0]
                        }}</span
                      >
                    </div>

                    <div
                      class="col p-0"
                      style="max-width: 110px; margin-left: 10px"
                    >
                      <v-select
                        :id="'credentials_' + index + '_to_year'"
                        :items="years"
                        label="Year To"
                        background-color="#EBF4FD"
                        filled
                        dense
                        flat
                        hide-details
                        solo
                        v-model="credential.to_year"
                        class="checkYearTo"
                        :menu-props="{ contentClass: 'checkList-lineBlue' }"
                      ></v-select>
                      <span
                        v-if="errors['credentials.' + index + '.to_year']"
                        class="float-left text-danger small"
                        >{{
                          errors["credentials." + index + ".to_year"][0]
                        }}</span
                      >
                    </div>

                    <div class="col p-0" style="max-width: 100px">
                      <a
                        @click.prevent="removeCredential(index, credential)"
                        v-if="index != 0"
                        class="removeLanguage"
                      >
                        Remove
                        <i class="fas fa-minus ml-1 ico-profile-delete"></i>
                      </a>
                      <div v-else>
                        <a
                          v-if="user.credentials.length < 3"
                          @click.prevent="addCredential"
                          class="removeLanguage"
                        >
                          Add
                          <i class="fas fa-plus ml-1 ico-profile-add"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </v-card>
          </div>
        </v-tab-item>
        <!-- Tab Social -->
        <v-tab
          tabindex="2"
          style="margin-right: 0px; padding-right: 0px; border-radius: 18px"
          >Social</v-tab
        >
        <v-tab-item class="mt-5">
          <v-card
            class="d-flex justify-content-between m-1 mb-2 pl-0 pt-1 pb-1 pr-2"
          >
            <div
              class="col-6 m-0 p-0 form-group subtitle-1"
              id="profile_url_control"
            >
              <label class="subtitle-1">Profile URL</label>
              <v-text-field
                background-color="#EDEDED"
                label="Profile URL"
                solo
                flat
                dense
                disabled
                filled
                hide-details
                prefix="Psychics1on1.com/"
                class="sfInputClass"
                v-model="user.profile.profile_link"
              ></v-text-field>
            </div>
            <div class="col-6 m-0 p-0">
              <label class="subtitle-1">Share Profile</label>
              <div class="d-flex">
                <v-tooltip bottom class="ml-2">
                  <template v-slot:activator="{ on }">
                    <a
                      v-on="on"
                      @click.stop="share('facebook')"
                      class="primary--text"
                    >
                      <i class="fab ico-profile-facebook"></i>
                    </a>
                  </template>
                  <span>Share on Facebook</span>
                </v-tooltip>

                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <a
                      v-on="on"
                      @click.stop="share('linkedin')"
                      class="primary--text"
                    >
                      <i class="fab ico-profile-linkedin-h ml-5"></i>
                    </a>
                  </template>
                  <span>Share on LinkedIn</span>
                </v-tooltip>

                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <a
                      v-on="on"
                      @click.stop="share('twitter')"
                      class="primary--text"
                    >
                      <i class="fab ico-profile-twitter ml-5"></i>
                    </a>
                  </template>
                  <span>Share on Twitter</span>
                </v-tooltip>

                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <a v-on="on" @click.stop="copyUrl()" class="primary--text">
                      <i class="fas ico-profile-link ml-5"></i>
                    </a>
                  </template>
                  <span>Copy URL</span>
                </v-tooltip>
              </div>
            </div>
          </v-card>

          <v-card
            class="d-flex justify-content-between m-1 pl-0 pt-1 pb-1 pr-2"
          >
            <div class="col-6 subtitle-1 m-0 p-0">
              <div class="row" style="margin-bottom: 20px">
                <span class="col-6">Social Info</span>
                <div>
                  <div v-if="profileSaved[7]">
                    <v-btn
                      class="sfProfileSave"
                      style="right: 27px"
                      color="#fff"
                      small
                      max-width="1"
                    >
                      Saved

                      <img
                        src="/images/icons/save_inactive.svg"
                        style="margin-left: 5px !important; margin-right: -5px"
                      />
                    </v-btn>
                  </div>
                  <div v-else>
                    <v-btn
                      class="sfProfileSave"
                      style="right: 27px"
                      color="#fff"
                      small
                      max-width="1"
                      @click="updateProfile(7)"
                      :loading="savingProfile"
                      :disabled="savingProfile"
                    >
                      Save

                      <img
                        src="/images/icons/save_inactive.svg"
                        style="margin-left: 5px !important; margin-right: -5px"
                      />
                    </v-btn>
                  </div>
                </div>
              </div>
              <div class="col-12 pl-0" style="margin-bottom: 10px">
                <v-text-field
                  id="profile_social_link_three"
                  placeholder="Instagram username"
                  solo
                  dense
                  hide-details
                  filled
                  flat
                  class="sfInputClass"
                  prepend-icon="ico-profile-instagram-i"
                  v-model="user.profile.social_link_three"
                ></v-text-field>

                <span
                  v-if="errors['profile.social_link_three']"
                  class="float-left text-danger small"
                  >{{ errors["profile.social_link_three"][0] }}</span
                >
              </div>

              <div class="col-12 pl-0" style="margin-bottom: 10px">
                <v-text-field
                  id="profile_social_link_two"
                  placeholder="Twitter handle"
                  solo
                  hide-details
                  flat
                  dense
                  class="sfInputClass"
                  prepend-icon="ico-profile-twitter-i"
                  filled
                  v-model="user.profile.social_link_two"
                ></v-text-field>

                <span
                  v-if="errors['profile.social_link_two']"
                  class="float-left text-danger small"
                  >{{ errors["profile.social_link_two"][0] }}</span
                >
              </div>

              <div class="col-12 pl-0" style="margin-bottom: 10px">
                <v-text-field
                  id="profile_social_link_one"
                  placeholder="Facebook link"
                  background-color="#EBF4FD"
                  solo
                  dense
                  hide-details
                  flat
                  class="sfInputClass"
                  prepend-icon="ico-profile-facebook-i"
                  filled
                  v-model="user.profile.social_link_one"
                ></v-text-field>

                <span
                  v-if="errors['profile.social_link_one']"
                  class="float-left text-danger small"
                  >{{ errors["profile.social_link_one"][0] }}</span
                >
              </div>
            </div>
            <div class="col-6 m-0 p-0">
              <label class="subtitle-1">Get Featured</label>
              <p class="sfProfileText">
                If you’d like to be featured on @psychics1on1 social accounts,
                check the box below and follow us!
              </p>
              <p class="sfProfileText mb-0">
                <v-checkbox
                  id="profile_get_featured"
                  v-model="user.profile.get_featured"
                  label="I'd like to be featured on @psychics1on1"
                  :value="1"
                  color="primary"
                  class="mb-0"
                ></v-checkbox>
              </p>

              <div class="sfFollow">
                <div>Follow @psychics1on1</div>
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <a
                      href="https://www.instagram.com/psychics1on1/"
                      class="primary--text p-0 m-0"
                      style="margin-top: -5px !important"
                    >
                      <i class="fab ico-profile-instagram-h ml-3"></i>
                    </a>
                  </template>
                  <span>Follow on instagram</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <a
                      href="https://www.linkedin.com/company/psychics1on1/about/"
                      class="primary--text p-0 m-0"
                      style="margin-top: -5px !important"
                    >
                      <i class="fab ico-profile-linkedin-h ml-3"></i>
                    </a>
                  </template>
                  <span>Follow on linkedin</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <a
                      href="https://www.facebook.com/Psychics1on1/"
                      class="primary--text p-0 m-0"
                      style="margin-top: -5px !important"
                    >
                      <i class="fab ico-profile-facebook-h ml-3"></i>
                    </a>
                  </template>
                  <span>Follow on facebook</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <a
                      href="https://twitter.com/psychics1on1/"
                      class="primary--text p-0 m-0"
                      style="margin-top: -5px !important"
                    >
                      <i class="fab ico-profile-twitter-h ml-3"></i>
                    </a>
                  </template>
                  <span>Follow on twitter</span>
                </v-tooltip>
              </div>
            </div>
          </v-card>
        </v-tab-item>
      </v-tabs>
      <!-- Tabs end -->
    </form>

    <form
      v-else
      class="form-dashboard sfFormProfile sfFormProfileMo"
      @submit="(e) => e.preventDefault()"
    >
      <!-- Media Edit/Upload row starts -->
      <div class="row sfHeaderProfile m-0">
        <!-- Photo upload -->
        <div class="col-12 p-0 m-0">
          <div style="margin: 0 auto">
            <div
              id="profile-pic2"
              class="overlay-upload-btn sfMoPic mr-0 ml-0 pr-0"
            >
              <image_cropper
                :profile="user.profile"
                @onImageCropped="assignBlob"
                target-preview-element="profile-img"
                outputWidth="250"
                outputHeight="250"
                ratioX="1"
                ratioY="1"
                blobRef="avatarBlob"
              >
                <img
                  :alt="user.profile.display_name"
                  id="profile-img"
                  v-bind:src="image"
                  class="profile-input-img"
                  style="box-shadow: 0px 3px 6px #0000000d"
                />
              </image_cropper>
              <span
                v-if="this.saveImageMsn"
                id="saveImageMsn"
                class="hover-text-success text-center"
              >
                {{ message_upload }}</span
              >
            </div>
            <div
              v-if="this.saveImage & !this.saveImageMsn"
              class="sfSavePic hover hoverProfile text-center sfSavePic"
              style="
                width: 100%;
                bottom: 21px !important;
                position: absolute !important;
              "
            >
              <v-btn
                :loading="savingImage"
                :disabled="savingImage"
                depressed
                small
                text
                class="white--text"
                @click="saveAvatar()"
                >Save</v-btn
              >
            </div>
          </div>
        </div>
      </div>
      <!-- Media Edit/Upload row ends -->
      <!-- Tabs start -->
      <v-tabs
        slider-size="0"
        align-with-title
        centered
        grow
        v-model="active_tab"
      >
        <v-tabs-slider></v-tabs-slider>
        <!-- Tab Account -->
        <v-tab tabindex="0" style="margin-left: 0px">Account</v-tab>
        <v-tab-item class="mt-5 mb-5">
          <div class="p-0">
            <v-card class="col-12 m-0 pt-1 sfVcard">
              <div class="col-lg-12 col-md-12 form-group p-0 m-0">
                <div
                  class="row ml-0 pr-0"
                  style="margin: 0px 0px 10px 0px !important"
                >
                  <div class="col subtitle-1 pl-0">Account Info</div>

                  <div>
                    <div v-if="profileSaved[0]">
                      <v-btn
                        class="sfProfileSave"
                        color="#fff"
                        small
                        max-width="1"
                      >
                        Saved

                        <img
                          src="/images/icons/save_inactive.svg"
                          style="
                            margin-left: 5px !important;
                            margin-right: -5px;
                          "
                        />
                      </v-btn>
                    </div>
                    <div v-else>
                      <v-btn
                        class="sfProfileSave"
                        color="#fff"
                        small
                        max-width="1"
                        @click="updateProfile(0)"
                        :loading="savingProfile"
                        :disabled="savingProfile"
                      >
                        Save

                        <img
                          src="/images/icons/save_inactive.svg"
                          style="
                            margin-left: 5px !important;
                            margin-right: -5px;
                          "
                        />
                      </v-btn>
                    </div>
                  </div>
                </div>

                <v-text-field
                  id="profile_display_name"
                  label="Display Name"
                  :maxlength="46"
                  @input="
                    textErr = [];
                    errors = [];
                  "
                  @keyup="
                    user.profile.display_name = validateText(
                      user.profile.display_name,
                      0
                    )
                  "
                  solo
                  flat
                  dense
                  hide-details
                  :disabled="user.profile.displayNameEdit != 1"
                  :filled="user.profile.displayNameEdit == 1"
                  :class="[
                    user.profile.displayNameEdit
                      ? 'sfInputClass'
                      : 'sfInputClassInactive',
                  ]"
                  prepend-icon="ico-profile-name"
                  v-model="user.profile.display_name"
                >
                </v-text-field>
                <div v-if="user.profile.displayNameEdit">
                  <div
                    v-if="
                      this.errors != [] && this.errors['profile.display_name']
                    "
                    class="sfHelperCharacters"
                    style="color: red"
                  >
                    {{ this.errors["profile.display_name"][0] }}
                  </div>
                  <div
                    v-else-if="this.textErr != []"
                    class="sfHelperCharacters"
                    style="color: red"
                  >
                    {{ this.textErr[0] }}
                  </div>
                  <span
                    v-if="
                      !this.textErr[0] && !this.errors['profile.display_name']
                    "
                  >
                    <!-- <div
                      class="sfHelperCharacters"
                      v-if="!this.user.profile.display_name"
                      style="color: red"
                    >
                      3 characters to minimum required
                    </div>
                    <div
                      class="sfHelperCharacters"
                      v-else-if="
                        this.user.profile.display_name &&
                        parseInt(this.user.profile.display_name.length) < 3
                      "
                      style="color: red"
                    >
                      {{
                        3 - parseInt(this.user.profile.display_name.length)
                      }}
                      characters to minimum required
                    </div> -->
                    <div
                      class="sfHelperCharacters"
                      v-if="!this.user.profile.display_name"
                    >
                      46 characters left
                    </div>
                    <div v-else class="sfHelperCharacters">
                      {{ 46 - parseInt(this.user.profile.display_name.length) }}
                      characters left
                    </div>
                  </span>
                </div>
              </div>

              <div
                class="col-lg-12 col-md-12 form-group p-0 m-0"
                style="margin-top: 14px !important"
              >
                <v-text-field
                  id="email"
                  label="Email Address"
                  solo
                  flat
                  dense
                  hide-details
                  disabled
                  filled
                  v-model="user.email"
                  class="sfInputClassInactive"
                  prepend-icon="ico-profile-inactive"
                ></v-text-field>
                <span v-if="errors.email" class="float-left text-danger small">
                  {{ errors.email[0] }}
                </span>
              </div>

              <div
                class="col-lg-12 col-md-12 p-0 m-0"
                style="margin-top: 14px !important"
              >
                <div class="d-flex m-0 p-0">
                  <div class="col-7 pl-0">
                    <v-text-field
                      id="phone_numbers_0_number"
                      label="(555) 555-5555"
                      solo
                      flat
                      disabled
                      dense
                      hide-details
                      filled
                      type="tel"
                      class="sfInputClassInactive sfInputClassLeft"
                      prepend-icon="ico-profile-inactive"
                      v-model="user.phone_numbers[0].number"
                    ></v-text-field>
                    <span
                      v-if="errors['phone_numbers.0.number']"
                      class="float-left text-danger small"
                      >{{ errors["phone_numbers.0.number"][0] }}</span
                    >
                  </div>
                  <div class="col-5 pr-0">
                    <v-select
                      id="phone_numbers_0_code2"
                      :items="country_all"
                      label="Select"
                      class="checkDisabledRigth right-align"
                      filled
                      flat
                      item-text="prefix"
                      item-value="code2"
                      hide-details
                      disabled
                      dense
                      solo
                      auto
                      autocomplete
                      v-model="user.phone_numbers[0].code2"
                      :menu-props="{ contentClass: 'checkList-lineBlue' }"
                    >
                      <template slot="selection" slot-scope="data">
                        <!-- // HTML that describe how select should render selected items -->
                        +{{ data.item.prefix }} - {{ data.item.code3 }}
                      </template>
                      <template slot="item" slot-scope="data">
                        <!-- // HTML that describe how select should render items when the select is open -->
                        +{{ data.item.prefix }} - {{ data.item.code3 }}
                      </template>
                    </v-select>
                    <span
                      v-if="errors['phone_numbers.0.code2']"
                      class="float-left text-danger small"
                      >{{ errors["phone_numbers.0.code2"][0] }}</span
                    >
                  </div>
                </div>
              </div>
            </v-card>
            <v-card class="col-12 ml-0 mt-4 pt-1 sfVcard">
              <div class="col-lg-12 col-md-12 form-group p-0 m-0">
                <div
                  class="row ml-0 pr-0"
                  style="margin: 0px 0px 10px 0px !important"
                >
                  <div class="col subtitle-1 pl-0">Personal Info</div>

                  <div>
                    <div v-if="profileSaved[1]">
                      <v-btn
                        class="sfProfileSave"
                        color="#fff"
                        small
                        max-width="1"
                      >
                        Saved

                        <img
                          src="/images/icons/save_inactive.svg"
                          style="
                            margin-left: 5px !important;
                            margin-right: -5px;
                          "
                        />
                      </v-btn>
                    </div>
                    <div v-else>
                      <v-btn
                        class="sfProfileSave"
                        color="#fff"
                        small
                        max-width="1"
                        @click="updateProfile(1)"
                        :loading="savingProfile"
                        :disabled="savingProfile"
                      >
                        Save

                        <img
                          src="/images/icons/save_inactive.svg"
                          style="
                            margin-left: 5px !important;
                            margin-right: -5px;
                          "
                        />
                      </v-btn>
                    </div>
                  </div>
                </div>

                <v-text-field
                  id="profile_name"
                  label="First Name"
                  solo
                  @input="
                    textErr = [];
                    errors = [];
                  "
                  @keyup="
                    user.profile.name = validateText(user.profile.name, 1)
                  "
                  :maxlength="50"
                  flat
                  dense
                  filled
                  hide-details
                  v-model="user.profile.name"
                  class="sfInputClass"
                  prepend-icon="ico-profile-finger"
                ></v-text-field>
                <div
                  v-if="this.errors != [] && this.errors['profile.name']"
                  class="sfHelperCharacters"
                  style="color: red"
                >
                  {{ this.errors["profile.name"][0] }}
                </div>
                <div
                  v-else-if="this.textErr != []"
                  class="sfHelperCharacters"
                  style="color: red"
                >
                  {{ this.textErr[1] }}
                </div>
                <span v-if="!this.textErr[1] && !this.errors['profile.name']">
                  <div
                    class="sfHelperCharacters"
                    v-if="!this.user.profile.name"
                  >
                    50 characters left
                  </div>
                  <div v-else class="sfHelperCharacters">
                    {{ 50 - parseInt(this.user.profile.name.length) }}
                    characters left
                  </div>
                </span>
              </div>

              <div class="col-lg-12 col-md-12 form-group p-0 m-0">
                <div class="subtitle-1 mb-3"></div>

                <v-text-field
                  id="profile_last_name"
                  label="Last Name"
                  :maxlength="50"
                  @input="
                    textErr = [];
                    errors = [];
                  "
                  @keyup="
                    user.profile.last_name = validateText(
                      user.profile.last_name,
                      2
                    )
                  "
                  solo
                  flat
                  dense
                  hide-details
                  filled
                  v-model="user.profile.last_name"
                  class="sfInputClass"
                  prepend-icon="ico-profile-finger"
                ></v-text-field>
                <div
                  v-if="this.errors != [] && this.errors['profile.last_name']"
                  class="sfHelperCharacters"
                  style="color: red"
                >
                  {{ this.errors["profile.last_name"][0] }}
                </div>
                <div
                  v-else-if="this.textErr != []"
                  class="sfHelperCharacters"
                  style="color: red"
                >
                  {{ this.textErr[2] }}
                </div>
                <span
                  v-if="!this.textErr[2] && !this.errors['profile.last_name']"
                >
                  <div
                    class="sfHelperCharacters"
                    v-if="!this.user.profile.last_name"
                  >
                    50 characters left
                  </div>
                  <div v-else class="sfHelperCharacters">
                    {{ 50 - parseInt(this.user.profile.last_name.length) }}
                    characters left
                  </div>
                </span>
              </div>

              <div
                class="col-lg-12 col-md-12 p-0 m-0"
                style="margin-top: 20px !important"
              >
                <div class="d-flex m-0 p-0">
                  <div class="col-7 pl-0">
                    <v-text-field
                      id="profile_birth_date"
                      background-color="#EBF4FD"
                      label="01/15/2001"
                      solo
                      flat
                      dense
                      hide-details
                      filled
                      v-model="user.profile.birth_date"
                      type="text"
                      v-mask="'##/##/####'"
                      class="sfInputClass sfInputClassLeft"
                      prepend-icon="ico-profile-birthday"
                    ></v-text-field>
                    <span
                      v-if="errors['profile.birth_date']"
                      class="float-left text-danger small"
                      >{{ errors["profile.birth_date"][0] }}</span
                    >
                  </div>
                  <div class="col-5 p-0">
                    <v-select
                      id="profile_gender"
                      :items="gender"
                      label="Select"
                      filled
                      flat
                      hide-details
                      dense
                      solo
                      v-model="user.profile.gender"
                      class="checkRigth right-align"
                      :menu-props="{ contentClass: 'checkList-lineBlue' }"
                    ></v-select>
                    <span
                      v-if="errors['profile.gender']"
                      class="float-left text-danger small"
                      >{{ errors["profile.gender"][0] }}</span
                    >
                  </div>
                </div>
              </div>
            </v-card>

            <v-card class="col-12 ml-0 mt-4 pt-1 sfVcard">
              <div class="col-lg-12 col-md-12 form-group p-0 m-0">
                <div
                  class="row ml-0 pr-0"
                  style="margin: 0px 0px 10px 0px !important"
                >
                  <div class="col subtitle-1 pl-0">Preferences</div>

                  <div>
                    <div v-if="profileSaved[2]">
                      <v-btn
                        class="sfProfileSave"
                        color="#fff"
                        small
                        max-width="1"
                      >
                        Saved

                        <img
                          src="/images/icons/save_inactive.svg"
                          style="
                            margin-left: 5px !important;
                            margin-right: -5px;
                          "
                        />
                      </v-btn>
                    </div>
                    <div v-else>
                      <v-btn
                        class="sfProfileSave"
                        color="#fff"
                        small
                        max-width="1"
                        @click="updateProfile(2)"
                        :loading="savingProfile"
                        :disabled="savingProfile"
                      >
                        Save

                        <img
                          src="/images/icons/save_inactive.svg"
                          style="
                            margin-left: 5px !important;
                            margin-right: -5px;
                          "
                        />
                      </v-btn>
                    </div>
                  </div>
                </div>
                <v-text-field
                  id="profile_city"
                  background-color="#EBF4FD"
                  solo
                  flat
                  hide-details
                  dense
                  filled
                  label="City"
                  v-model="user.profile.city"
                  class="sfInputClass"
                  prepend-icon="ico-profile-city"
                ></v-text-field>

                <span
                  v-if="errors['profile.city']"
                  class="float-left text-danger small"
                  >{{ errors["profile.city"][0] }}</span
                >
              </div>

              <div
                class="col-lg-12 col-md-12 p-0 m-0"
                style="margin-top: 14px !important"
              >
                <div class="d-flex m-0 p-0">
                  <div class="col-5 pl-0" style="max-width: fit-content">
                    <v-select
                      id="profile_country"
                      :items="countries"
                      label="Select"
                      filled
                      dense
                      flat
                      hide-details
                      item-value="code"
                      item-text="name"
                      solo
                      v-model="user.profile.country"
                      class="checkRigth right-align"
                      :menu-props="{ contentClass: 'checkList-lineBlue' }"
                    ></v-select>

                    <span
                      v-if="errors['profile.country']"
                      class="float-left text-danger small"
                      >{{ errors["profile.country"][0] }}</span
                    >
                  </div>
                  <div class="col-7 pr-0">
                    <v-select
                      id="profile_timezone"
                      :items="timezonesok"
                      label="Select"
                      filled
                      dense
                      flat
                      hide-details
                      solo
                      v-model="user.profile.timezone"
                      required
                      class="checkRigthLong"
                      :menu-props="{ contentClass: 'checkList-lineBlue' }"
                    ></v-select>

                    <span
                      v-if="errors['profile.timezone']"
                      class="float-left text-danger small"
                      >{{ errors["profile.timezone"][0] }}</span
                    >
                  </div>
                </div>
              </div>

              <div
                class="col-lg-12 col-md-12 p-0 m-0 mt-4"
                style="margin-top: 15px !important"
              >
                <div
                  class="row"
                  :key="index"
                  v-for="(language, index) in user.languages"
                  style="margin-top: 10px !important"
                >
                  <div class="col">
                    <v-select
                      :id="'languages_' + index + '_languages_id'"
                      :items="languages"
                      item-text="name"
                      item-value="id"
                      label="Language"
                      background-color="#EBF4FD"
                      filled
                      dense
                      flat
                      hide-details
                      solo
                      v-model="language.languages_id"
                      required
                      class="checklefLanguage"
                      :menu-props="{ contentClass: 'checkList-lineBlue' }"
                    ></v-select>
                    <span
                      v-if="errors['languages.' + index + '.languages_id']"
                      class="float-left text-danger small"
                    >
                      {{ errors["languages." + index + ".languages_id"][0] }}
                    </span>
                  </div>
                  <div class="col pr-0">
                    <a
                      v-if="
                        index == 0 && user.languages.length < languages.length
                      "
                      @click.prevent="addLanguage"
                      class="removeLanguage"
                    >
                      Add
                      <i class="fas fa-plus ml-1 ico-profile-add"></i>
                    </a>

                    <a
                      v-else
                      class="removeLanguage"
                      @click.prevent="removeLanguage(index, language)"
                    >
                      Remove
                      <i class="fas fa-minus ml-1 ico-profile-delete"></i>
                    </a>
                  </div>
                </div>
              </div>
            </v-card>
            <v-card class="col-12 ml-0 mt-4 pt-1 sfVcard">
              <div class="col-lg-12 col-md-12 form-group p-0 m-0">
                <div
                  class="row ml-0 pr-0"
                  style="margin: 0px 0px 10px 0px !important"
                >
                  <div class="col subtitle-1 pl-0">Media</div>

                  <div>
                    <div v-if="profileSaved[3]">
                      <v-btn
                        class="sfProfileSave"
                        color="#fff"
                        small
                        max-width="1"
                      >
                        Saved

                        <img
                          src="/images/icons/save_inactive.svg"
                          style="
                            margin-left: 5px !important;
                            margin-right: -5px;
                          "
                        />
                      </v-btn>
                    </div>
                    <div v-else>
                      <v-btn
                        class="sfProfileSave"
                        color="#fff"
                        small
                        max-width="1"
                        @click="updateProfile(3)"
                        :loading="savingProfile"
                        :disabled="savingProfile"
                      >
                        Save

                        <img
                          src="/images/icons/save_inactive.svg"
                          style="
                            margin-left: 5px !important;
                            margin-right: -5px;
                          "
                        />
                      </v-btn>
                    </div>
                  </div>
                </div>
                <p class="sfProfileText">
                  Upload an intro video or audio message to make a good first
                  impression. Introduce yourself, your services and why clients
                  should choose you. Psychics with intro media have priority
                  visibility and secure more clients.
                </p>
              </div>
              <div class="row">
                <div class="col-4 form-group p-0 pl-3">
                  <div class="subtitle-1 mb-1"></div>
                  <!-- VIDEO UPLOADER START -->

                       <div v-if="video" class="media_uploader sfProfileFormVideo sfProfileFormVideoBox">
              <v-btn
                class="no-background-hover p-0 pr-2 m-0"
                text
                style="height: 90px"
                v-if="video"
                @click.stop="
                  videoPlay = true;
                  videoDialog = true;
                "
              >
                <video
                  class="p-0 m-0"
                  style="height: 90px; width: 90px"
                  v-if="video != '' && !edit_video"
                  v-bind:src="video"
                  preload="auto"
                  :poster="thumbnail"
                ></video>
              </v-btn>
              <div class=" text-danger msnInput" v-if="format_error != ''">
                {{ format_error }}
              </div>
                 <file-upload
                v-show="files.length == 0"
                input-id="video_upload_top"
                post-action="/api/v1/user/profile/video/upload"
                ref="upload"
                v-model="files"
                :drop="!$refs.upload || !$refs.upload.active"
                :disabled="$refs.upload && $refs.upload.active"
                @input-filter="inputFilter"
                @input="updatetValue"
                @input-file="inputFile"
                :headers="{ 'X-CSRF-TOKEN': token }"
              >

   <v-btn
                  v-if="
                    (!$refs.upload || !$refs.upload.active) && files.length > 0
                  "
                  class="buttonVideoSub buttonVideoSubDown"
                  @click.prevent="$refs.upload.active = true"
                  >Start</v-btn
                >

                 <v-btn style="margin-top: 35px;" v-else>Update</v-btn>
                <v-progress-circular
                  v-if="$refs.upload && $refs.upload.active"
                  :width="2"
                  color="primary"
                    class="buttonVideoSub buttonVideoSubDown"
                    style="bottom:6bot0px"
                  indeterminate
                ></v-progress-circular>

               
              </file-upload>
            </div>
                  <div  v-else
                    class="sfProfileVideo sfProfileVideoBox d-flex align-center justify-center"
                    style="margin-left: 5px;"
                  >
                    <div class="buttons-area text-center">
                      <div
                        class="grey--text mb-3"
                        :key="file.name"
                        v-for="file in files"
                      >
                        {{ file.name }}
                      </div>
                      <div v-show="files.length == 0">
                        <file-upload
                          input-id="video_upload_bottom"
                          :post-action="'/api/v1/user/profile/video/upload'"
                          ref="upload"
                          v-model="files"
                          :drop="!$refs.upload || !$refs.upload.active"
                          :disabled="$refs.upload && $refs.upload.active"
                          @input-filter="inputFilter"
                          @input="updatetValue"
                          @input-file="inputFile"
                          :headers="{ 'X-CSRF-TOKEN': token }"
                        >
                          <v-btn style="opacity: 0.5; background: transparent;">
                            <div style="padding-bottom: 10px">
                              <img  src="/images/profile/add-video.svg"  />
                            </div>
                            Add <br />intro video
                          </v-btn>
                        </file-upload>
                      </div>

                      <div class="mt-3">
                        <v-btn
                        style=""
                        class="sfProfileVideoBoxMob"
                          v-show="
                            (!$refs.upload || !$refs.upload.active) &&
                            files.length > 0
                          "
                          @click.prevent="$refs.upload.active = true"
                          >Start upload</v-btn
                        >
                        <v-progress-circular
                          v-show="$refs.upload && $refs.upload.active"
                          :width="2"
                          color="primary"
                          indeterminate
                        ></v-progress-circular>
                      </div>
                      <div class=" text-danger msnInput" v-if="format_error != ''">
                        {{ format_error }}
                      </div>
                    </div>
                  </div>
                  <!-- VIDEO UPLOADER END-->
                </div>

                <div class="col-8  p-0 pl-3">
                  <!-- AUDIO UPLOADER START -->
                  <div v-if="audio" class="media_uploader sfProfileFormAudio sfProfileFormAudioDown">
              <v-btn
                class="no-background-hover m-0 sfProfileFormAudioDownColor "
                text
                style="
                  height: 90px;
                  padding: 0px !important;
                  margin-top: 20px;
                  border-radius: 5px;
                 
                "
                v-if="displayPlay"
                @click="play"
                ><vue-wave-surfer
                  class="m-0 p-0"
                  style="width: 140px;   "
                  :src="audio"
                  :options="optionsDown"
                ></vue-wave-surfer>
              </v-btn>
              <v-btn
                class="no-background-hover m-0 sfProfileFormAudioDownColor "
                text
                style="
                  height: 90px;
                  width: 140px;
                  margin-top: 20px;
                  border-radius: 5px;
                    
                "
                v-else
                @click="pause"
              >
                <vue-wave-surfer
                  class="m-0 p-0"
                  style="width: 140px;   "
                  :src="audio"
                  :options="optionsDown"
                ></vue-wave-surfer>
              </v-btn>
              <div class=" text-danger msnInput" v-if="format_error_audio != ''">
                {{ format_error_audio }}
              </div>
              <file-upload
                v-show="filesAudio.length == 0"
                class="sfProfileFormAudioDownMob"
                input-id="audio_upload_top"
                post-action="/api/v1/user/profile/audio/upload"
                ref="uploadAudio"
                v-model="filesAudio"
                :drop="!$refs.uploadAudio || !$refs.uploadAudio.active"
                :disabled="$refs.uploadAudio && $refs.uploadAudio.active"
                @input-filter="inputFilterAudio"
                @input="updateValueAudio"
                @input-file="inputFileAudio"
                :headers="{ 'X-CSRF-TOKEN': token }"
              >
                


              <v-btn
                v-if="
                  (!$refs.uploadAudio || !$refs.uploadAudio.active) &&
                  filesAudio.length > 0
                "
                @click.prevent="$refs.uploadAudio.active = true"
                class="buttonVideo buttonVideoEmpty buttonAudioEmpty"
                >Start upload</v-btn
              >
              <v-btn style="" v-else>Update</v-btn>



              <v-progress-circular
                v-if="$refs.uploadAudio && $refs.uploadAudio.active"
                :width="2"
               class="buttonVideo"
                color="primary"
                indeterminate
              ></v-progress-circular>


              </file-upload>

            </div>
                  <div v-else
                    class="sfProfileAudio sfProfileAudioBox d-flex align-center justify-center"
                  >
                    <div class="buttons-area text-center">
                      <div
                        class="grey--text mb-3"
                        :key="file.name"
                        v-for="file in filesAudio"
                      >
                        {{ file.name }}
                      </div>

                      <div
                        v-show="filesAudio.length == 0"
                        class="btn-upload-wrapper"
                      >
                        <file-upload
                          input-id="audio_upload_bottom"
                          :post-action="'/api/v1/user/profile/audio/upload'"
                          ref="uploadAudio"
                          v-model="filesAudio"
                          :drop="
                            !$refs.uploadAudio || !$refs.uploadAudio.active
                          "
                          :disabled="
                            $refs.uploadAudio && $refs.uploadAudio.active
                          "
                          @input-filter="inputFilterAudio"
                          @input="updateValueAudio"
                          @input-file="inputFileAudio"
                          :headers="{ 'X-CSRF-TOKEN': token }"
                        >
                          <v-btn>
                            <div style="padding-bottom: 10px">
                              <img src="/images/profile/add-audio.svg" />
                            </div>
                            <font style="opacity: 0.5;">Add <br />intro Audio</font>
                          </v-btn>
                        </file-upload>
                      </div>

                      <div>
                        <v-btn
                          v-if="
                            (!$refs.uploadAudio || !$refs.uploadAudio.active) &&
                            filesAudio.length > 0
                          "
                          @click.prevent="$refs.uploadAudio.active = true"
                          class="buttonVideo buttonVideoBox buttonVideoEmpty"
                          >Start upload</v-btn
                        >
                        <v-progress-circular
                          v-show="$refs.uploadAudio && $refs.uploadAudio.active"
                          :width="2"
                          color="primary"
                          indeterminate
                        ></v-progress-circular>
                      </div>
                      <div
                        class=" text-danger msnInput"
                        v-if="format_error_audio != ''"
                      >
                        {{ format_error_audio }}
                      </div>
                    </div>
                  </div>

                  <!-- AUDIO UPLOADER END -->
                </div>
              </div>
            </v-card>
          </div>
        </v-tab-item>
        <!-- Tab Profile -->
        <v-tab tabindex="2">Profile</v-tab>
        <v-tab-item class="mt-5">
          <v-card class="m-1 mb-2 p-1 pr-2 sfVcard">
            <div class="m-0 p-0">
              <div class="col-sm-12 m-0 p-0">
                <div class="col-lg-12 col-md-12 m-0 p-0">
                  <div>
                    <div v-if="profileSaved[4]">
                      <v-btn
                        class="sfProfileSave"
                        color="#fff"
                        style="right: 0px"
                        small
                        max-width="1"
                      >
                        Saved

                        <img
                          src="/images/icons/save_inactive.svg"
                          style="
                            margin-left: 5px !important;
                            margin-right: -5px;
                          "
                        />
                      </v-btn>
                    </div>
                    <div v-else>
                      <v-btn
                        class="sfProfileSave"
                        color="#fff"
                        small
                        max-width="1"
                        @click="updateProfile(4)"
                        :loading="savingProfile"
                        :disabled="savingProfile"
                        style="ight: 0px"
                      >
                        Save

                        <img
                          src="/images/icons/save_inactive.svg"
                          style="
                            margin-left: 5px !important;
                            margin-right: -5px;
                          "
                        />
                      </v-btn>
                    </div>
                  </div>

                  <div class="subtitle-1 mb-3">Tagline</div>

                  <v-textarea
                    id="profile_tagline"
                    background-color="#F4F4F4"
                    :maxlength="50"
                    label="Grab a client’s attention in a single phrase. 20 character min., limit 50."
                    @input="
                      textErr = [];
                      errors = [];
                    "
                    @keyup="
                      user.profile.tagline = validateText(
                        user.profile.tagline,
                        3
                      )
                    "
                    solo
                    flat
                    dense
                    filled
                    height="60"
                    width="100%"
                    hide-details
                    class="sfInputTaglineClass"
                    v-model="user.profile.tagline"
                  ></v-textarea>
                  <div
                    v-if="this.errors != [] && this.errors['profile.tagline']"
                    class="sfHelperCharacters"
                    style="color: red"
                  >
                    {{ this.errors["profile.tagline"][0] }}
                  </div>
                  <div
                    v-else-if="this.textErr != []"
                    class="sfHelperCharacters"
                    style="color: red"
                  >
                    {{ this.textErr[3] }}
                  </div>
                  <span
                    v-if="!this.textErr[3] && !this.errors['profile.tagline']"
                  >
                    <!-- <div
                      class="sfHelperCharacters"
                      v-if="!this.user.profile.tagline"
                      style="color: red"
                    >
                      20 characters to minimum required
                    </div>
                    <div
                      class="sfHelperCharacters"
                      v-else-if="
                        this.user.profile.tagline &&
                        parseInt(this.user.profile.tagline.length) < 20
                      "
                      style="color: red"
                    >
                      {{
                        20 - parseInt(this.user.profile.tagline.length)
                      }}
                      characters to minimum required
                    </div> -->
                    <div
                      class="sfHelperCharacters"
                      v-if="!this.user.profile.tagline"
                    >
                      50 characters left
                    </div>
                    <div v-else class="sfHelperCharacters">
                      {{ 50 - parseInt(this.user.profile.tagline.length) }}
                      characters left
                    </div>
                  </span>
                </div>
                <div class="col-lg-12 col-md-12 form-group m-0 p-0">
                  <div class="subtitle-1 mb-3"></div>

                  <v-text-field
                    id="profile_years_experience"
                    background-color="#EBF4FD"
                    label="Years Experience"
                    solo
                    width="270"
                    flat
                    dense
                    filled
                    hide-details
                    class="sfInputClass sfInputYearsClass"
                    prepend-icon="ico-profile-years"
                    v-model="user.profile.years_experience"
                  ></v-text-field>

                  <span
                    v-if="errors['profile.years_experience']"
                    class="float-left text-danger small"
                    >{{ errors["profile.years_experience"][0] }}</span
                  >
                </div>
              </div>
              <div class="col-sm-12 m-0 mt-4 p-0">
                <div class="col-lg-12 col-md-12 m-0 p-0">
                  <div class="m-0">
                    <div class="col-12 subtitle-1 mb-4">Elevator Pitch</div>
                  </div>

                  <v-textarea
                    id="profile_elevator_pitch"
                    label="Sell yourself! Summarize your experience, what makes you unique, how clients will benefit and why they should choose your services over any other Psychic. 100 character min., limit 160."
                    background-color="#F4F4F4"
                    style="margin-top: 13px"
                    @input="
                      textErr = [];
                      errors = [];
                    "
                    @keyup="
                      user.profile.elevator_pitch = validateText(
                        user.profile.elevator_pitch,
                        4
                      )
                    "
                    :maxlength="160"
                    solo
                    flat
                    dense
                    filled
                    width="100%"
                    height="110"
                    hide-details
                    class="sfInputElevatorClass"
                    v-model="user.profile.elevator_pitch"
                  ></v-textarea>
                  <div
                    v-if="
                      this.errors != [] && this.errors['profile.elevator_pitch']
                    "
                    class="sfHelperCharacters"
                    style="color: red"
                  >
                    {{ this.errors["profile.elevator_pitch"][0] }}
                  </div>
                  <div
                    v-else-if="this.textErr != []"
                    class="sfHelperCharacters"
                    style="color: red"
                  >
                    {{ this.textErr[4] }}
                  </div>
                  <span
                    v-if="
                      !this.textErr[4] && !this.errors['profile.elevator_pitch']
                    "
                  >
                    <!-- <div
                      class="sfHelperCharacters"
                      v-if="!this.user.profile.elevator_pitch"
                      style="color: red"
                    >
                      100 characters to minimum required
                    </div>
                    <div
                      class="sfHelperCharacters"
                      v-else-if="
                        this.user.profile.elevator_pitch &&
                        parseInt(this.user.profile.elevator_pitch.length) < 100
                      "
                      style="color: red"
                    >
                      {{
                        100 - parseInt(this.user.profile.elevator_pitch.length)
                      }}
                      characters to minimum required
                    </div> -->
                    <div
                      class="sfHelperCharacters"
                      v-if="!this.user.profile.elevator_pitch"
                    >
                      160 characters left
                    </div>
                    <div v-else class="sfHelperCharacters">
                      {{
                        160 - parseInt(this.user.profile.elevator_pitch.length)
                      }}
                      characters left
                    </div>
                  </span>
                </div>
              </div>
            </div>
            <div class="m-0 mt-4 p-0">
              <div class="col-lg-12 col-md-12 m-0 p-0">
                <div class="subtitle-1 mb-4">Background</div>

                <v-textarea
                  id="profile_description"
                  v-model="user.profile.description"
                  @input="
                    textErr = [];
                    errors = [];
                  "
                  @keyup="
                    user.profile.description = validateText(
                      user.profile.description,
                      5
                    )
                  "
                  solo
                  :maxlength="400"
                  background-color="#f4f4f4"
                  class="sfInputBackgroundClass"
                  filled
                  flat
                  autosize="false"
                  width="100%"
                  height="205"
                  name="input-7-4"
                  hide-details
                  label="Think of your background like your professional bio - it’s your opportunity to persuade readers to become new clients! Include details about your unique approach to readings, your experience and your favorite spiritual accomplishment. Let your personality shine for a lasting impression. 200 character min., limit 400."
                ></v-textarea>
                <div
                  v-if="this.errors != [] && this.errors['profile.description']"
                  class="sfHelperCharacters"
                  style="color: red"
                >
                  {{ this.errors["profile.description"][0] }}
                </div>
                <div
                  v-else-if="this.textErr != []"
                  class="sfHelperCharacters"
                  style="color: red"
                >
                  {{ this.textErr[5] }}
                </div>
                <span
                  v-if="!this.textErr[5] && !this.errors['profile.description']"
                >
                  <!-- <div
                    class="sfHelperCharacters"
                    v-if="!this.user.profile.description"
                    style="color: red"
                  >
                    200 characters to minimum required
                  </div>
                  <div
                    class="sfHelperCharacters"
                    v-else-if="
                      this.user.profile.description &&
                      parseInt(this.user.profile.description.length) < 200
                    "
                    style="color: red"
                  >
                    {{
                      200 - parseInt(this.user.profile.description.length)
                    }}
                    characters to minimum required
                  </div> -->
                  <div
                    class="sfHelperCharacters"
                    v-if="!this.user.profile.description"
                  >
                    400 characters left
                  </div>
                  <div
                    class="sfHelperCharacters"
                    v-else-if="
                      this.user.profile.description &&
                      parseInt(this.user.profile.description.length) > 400
                    "
                    style="color: red"
                  >
                    {{ parseInt(this.user.profile.description.length) - 400 }}
                    characters over
                  </div>
                  <div class="sfHelperCharacters" v-else>
                    {{ 400 - parseInt(this.user.profile.description.length) }}
                    characters left
                  </div>
                </span>
              </div>
            </div>
          </v-card>

          <v-card
            class="m-1 p-1 pr-2 mb-0 pb-0"
            style="box-shadow: none !important"
          >
            <div
              class="col-lg-12 col-md-12 form-group m-0 p-0"
              :id="'specialties'"
            >
              <div class="subtitle-1">Specialties</div>
              <div class="sfProfileTip">Select up to 4</div>
              <div class="row mb-0 m-0">
                <div
                  class="col-md-3 col-6 col-sm-3 col-lg-6 sfProfileList p-0 m-0"
                  :key="index"
                  v-for="(item, index) in specialties"
                >
                  <v-checkbox
                    :disabled="
                      user.specialties.length > 3 &&
                      !user.specialties.map((t) => t.id).includes(item.id)
                    "
                    v-model="user.specialties"
                    :label="item.name"
                    :value="item"
                    color="primary"
                  ></v-checkbox>
                </div>
              </div>
              <span v-if="errors['specialties']" class="text-danger small">{{
                errors["specialties"][0]
              }}</span>
            </div>
          </v-card>
          <div class="m-1 mt-0 mb-0 p-0">
            <v-card class="col-12 m-0" style="box-shadow: none !important">
              <div
                class="col-lg-4 col-md-12 form-group m-0 p-0"
                :id="'categories'"
              >
                <div class="subtitle-1">Abilities</div>
                <div class="sfProfileTip">Select up to 4</div>
                <div class="row mb-5 m-0">
                  <div
                    class="col-md-6 col-5 col-sm-6 col-lg-6 p-0 sfProfileList"
                    :key="index"
                    v-for="(item, index) in categories"
                  >
                    <v-checkbox
                      :disabled="
                        user.categories.length > 3 &&
                        !user.categories.map((t) => t.id).includes(item.id)
                      "
                      v-model="user.categories"
                      :label="item.name"
                      :value="item"
                      color="primary"
                    ></v-checkbox>
                  </div>
                </div>
                <span v-if="errors['categories']" class="text-danger small">
                  {{ errors["categories"][0] }}
                </span>
              </div>
            </v-card>

            <v-card class="col-12 m-0" style="box-shadow: none !important">
              <div class="col-lg-12 col-md-12 form-group m-0 p-0" :id="'tools'">
                <div class="subtitle-1">Tools</div>
                <div class="sfProfileTip">Select up to 3</div>
                <div class="row mb-5 m-0">
                  <div
                    class="col-md-6 col-6 col-sm-6 col-lg-6 p-0 sfProfileList"
                    :key="index"
                    v-for="(item, index) in tools"
                  >
                    <v-checkbox
                      :disabled="
                        user.tools.length > 2 &&
                        !user.tools.map((t) => t.id).includes(item.id)
                      "
                      v-model="user.tools"
                      :label="item.name"
                      :value="item"
                      color="primary"
                    ></v-checkbox>
                  </div>
                </div>
                <span v-if="errors['tools']" class="text-danger small">{{
                  errors["tools"][0]
                }}</span>
              </div>
            </v-card>
          </div>
          <v-card
            class="m-1 p-1 pr-2 mt-0 pt-0"
            style="box-shadow: none !important"
          >
            <div
              class="col-lg-12 col-md-12 m-0 sfProfileList p-0"
              :id="'styles'"
            >
              <div class="subtitle-1">Style</div>
              <div class="sfProfileTip">Select One</div>
              <div class="row mb-5 m-0">
                <div
                  class="col-md-6 col-6 col-sm-6 col-lg-6 p-0"
                  :key="index"
                  v-for="(item, index) in styles"
                >
                  <v-checkbox
                    :disabled="
                      user.styles.length > 0 &&
                      !user.styles.map((t) => t.id).includes(item.id)
                    "
                    v-model="user.styles"
                    :label="item.name"
                    :value="item"
                    color="primary"
                  ></v-checkbox>
                </div>
              </div>
              <span v-if="errors['styles']" class="text-danger small">{{
                errors["styles"][0]
              }}</span>
            </div>
          </v-card>
          <div class="m-1 mt-4 p-0">
            <v-card class="col-12 mr-1 ml-0 p-0 pl-1">
              <div class="col-lg-12 col-md-12 mb-0">
                <div class="subtitle-1 mb-3">Work</div>
                <div>
                  <div v-if="profileSaved[5]">
                    <v-btn
                      class="sfProfileSave"
                      color="#fff"
                      small
                      max-width="1"
                    >
                      Saved

                      <img
                        src="/images/icons/save_inactive.svg"
                        style="margin-left: 5px !important; margin-right: -5px"
                      />
                    </v-btn>
                  </div>
                  <div v-else>
                    <v-btn
                      class="sfProfileSave"
                      color="#fff"
                      small
                      max-width="1"
                      @click="updateProfile(5)"
                      :loading="savingProfile"
                      :disabled="savingProfile"
                    >
                      Save

                      <img
                        src="/images/icons/save_inactive.svg"
                        style="margin-left: 5px !important; margin-right: -5px"
                      />
                    </v-btn>
                  </div>
                </div>
                <div
                  class="mb-5"
                  :key="index"
                  v-for="(work, index) in user.works"
                >
                  <div class="row">
                    <div class="col-sm-12 form-group p-0">
                      <v-text-field
                        :id="'works_' + index + '_position'"
                        label="Position"
                        solo
                        flat
                        dense
                        filled
                        hide-details
                        v-model="work.position"
                        class="sfInputClass"
                        prepend-icon="ico-profile-work"
                      ></v-text-field>
                      <span
                        v-if="errors['works.' + index + '.position']"
                        class="float-left text-danger small"
                      >
                        {{ errors["works." + index + ".position"][0] }}
                      </span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-12 form-group p-0">
                      <v-text-field
                        label="Company"
                        :id="'works_' + index + '_company'"
                        background-color="#EBF4FD"
                        solo
                        flat
                        dense
                        filled
                        hide-details
                        class="sfInputClass"
                        prepend-icon="ico-profile-work"
                        v-model="work.company"
                      ></v-text-field>
                      <span
                        v-if="errors['works.' + index + '.company']"
                        class="float-left text-danger small"
                        >{{ errors["works." + index + ".company"][0] }}</span
                      >
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-12 form-group p-0">
                      <v-textarea
                        :id="'works_' + index + '_description'"
                        v-model="work.description"
                        label="Provide a brief description of your role and responsibilities. Description optional, character limit 400."
                        solo
                        flat
                        background-color="#F4F4F4"
                        filled
                        hide-details
                        height="149"
                        width="100%"
                        name="input-7-4"
                        class="sfInputWorkClass"
                      ></v-textarea>
                      <span
                        v-if="errors['works.' + index + '.description']"
                        class="float-left text-danger small"
                        >{{
                          errors["works." + index + ".description"][0]
                        }}</span
                      >
                    </div>
                  </div>

                  <div class="row">
                    <div class="col p-0" style="max-width: 110px">
                      <v-select
                        :id="'works_' + index + '_from_year'"
                        :items="years"
                        label="Year From"
                        background-color="#EBF4FD"
                        filled
                        flat
                        dense
                        hide-details
                        solo
                        v-model="work.from_year"
                        class="checkYearFrom"
                        :menu-props="{ contentClass: 'checkList-lineBlue' }"
                      ></v-select>
                      <span
                        v-if="errors['works.' + index + '.from_year']"
                        class="float-left text-danger small"
                        >{{ errors["works." + index + ".from_year"][0] }}</span
                      >
                    </div>

                    <div
                      class="col p-0"
                      style="max-width: 110px; margin-left: 10px"
                    >
                      <v-select
                        :id="'works_' + index + '_to_year'"
                        :items="years"
                        label="Year To"
                        background-color="#EBF4FD"
                        filled
                        dense
                        flat
                        hide-details
                        solo
                        v-model="work.to_year"
                        class="checkYearTo"
                        :menu-props="{ contentClass: 'checkList-lineBlue' }"
                      ></v-select>
                      <span
                        v-if="errors['works.' + index + '.to_year']"
                        class="float-left text-danger small"
                        >{{ errors["works." + index + ".to_year"][0] }}</span
                      >
                    </div>

                    <div class="col p-0" style="max-width: 100px">
                      <a
                        @click.prevent="removeWork(index, work)"
                        v-if="index != 0"
                        class="removeLanguage"
                      >
                        Remove
                        <i class="fas fa-minus ml-1 ico-profile-delete"></i>
                      </a>
                      <div v-else>
                        <a
                          v-if="user.works.length < 3"
                          @click.prevent="addWork"
                          class="removeLanguage"
                        >
                          Add
                          <i class="fas fa-plus ml-1 ico-profile-add"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </v-card>

            <v-card class="col-12 mr-1 ml-0 p-0 pl-1 mt-4 mb-4">
              <div class="col-lg-12 col-md-12 mb-0">
                <div class="subtitle-1 mb-3">Education</div>
                <div>
                  <div v-if="profileSaved[6]">
                    <v-btn
                      class="sfProfileSave"
                      color="#fff"
                      small
                      max-width="1"
                    >
                      Saved

                      <img
                        src="/images/icons/save_inactive.svg"
                        style="margin-left: 5px !important; margin-right: -5px"
                      />
                    </v-btn>
                  </div>
                  <div v-else>
                    <v-btn
                      class="sfProfileSave"
                      color="#fff"
                      small
                      max-width="1"
                      @click="updateProfile(6)"
                      :loading="savingProfile"
                      :disabled="savingProfile"
                    >
                      Save

                      <img
                        src="/images/icons/save_inactive.svg"
                        style="margin-left: 5px !important; margin-right: -5px"
                      />
                    </v-btn>
                  </div>
                </div>
                <div
                  class="mb-5"
                  :key="index"
                  v-for="(credential, index) in user.credentials"
                >
                  <div class="row">
                    <div class="col-sm-12 form-group p-0">
                      <v-text-field
                        :id="'credentials_' + index + '_institution_name'"
                        label="Institution Name"
                        solo
                        flat
                        dense
                        filled
                        hide-details
                        v-model="credential.institution_name"
                        class="sfInputClass"
                        prepend-icon="ico-profile-credential"
                      ></v-text-field>
                      <span
                        v-if="
                          errors['credentials.' + index + '.institution_name']
                        "
                        class="float-left text-danger small"
                      >
                        {{
                          errors[
                            "credentials." + index + ".institution_name"
                          ][0]
                        }}
                      </span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-12 form-group p-0">
                      <v-text-field
                        label="Degree"
                        :id="'credentials_' + index + '_degree'"
                        background-color="#EBF4FD"
                        solo
                        flat
                        dense
                        filled
                        hide-details
                        class="sfInputClass"
                        prepend-icon="ico-profile-credential"
                        v-model="credential.degree"
                      ></v-text-field>
                      <span
                        v-if="errors['credentials.' + index + '.degree']"
                        class="float-left text-danger small"
                        >{{
                          errors["credentials." + index + ".degree"][0]
                        }}</span
                      >
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-12 form-group p-0">
                      <v-textarea
                        :id="'credentials_' + index + '_description'"
                        v-model="credential.description"
                        label="Provide certifications or further details. Description optional, character limit 400."
                        solo
                        flat
                        background-color="#F4F4F4"
                        filled
                        hide-details
                        height="149"
                        width="100%"
                        name="input-7-4"
                        class="sfInputcredentialClass"
                      ></v-textarea>
                      <span
                        v-if="errors['credentials.' + index + '.description']"
                        class="float-left text-danger small"
                        >{{
                          errors["credentials." + index + ".description"][0]
                        }}</span
                      >
                    </div>
                  </div>

                  <div class="row">
                    <div class="col p-0" style="max-width: 110px">
                      <v-select
                        :id="'credentials_' + index + '_from_year'"
                        :items="years"
                        label="Year From"
                        background-color="#EBF4FD"
                        filled
                        flat
                        dense
                        hide-details
                        solo
                        v-model="credential.from_year"
                        class="checkYearFrom"
                        :menu-props="{ contentClass: 'checkList-lineBlue' }"
                      ></v-select>
                      <span
                        v-if="errors['credentials.' + index + '.from_year']"
                        class="float-left text-danger small"
                        >{{
                          errors["credentials." + index + ".from_year"][0]
                        }}</span
                      >
                    </div>

                    <div
                      class="col p-0"
                      style="max-width: 110px; margin-left: 10px"
                    >
                      <v-select
                        :id="'credentials_' + index + '_to_year'"
                        :items="years"
                        label="Year To"
                        background-color="#EBF4FD"
                        filled
                        dense
                        flat
                        hide-details
                        solo
                        v-model="credential.to_year"
                        class="checkYearTo"
                        :menu-props="{ contentClass: 'checkList-lineBlue' }"
                      ></v-select>
                      <span
                        v-if="errors['credentials.' + index + '.to_year']"
                        class="float-left text-danger small"
                        >{{
                          errors["credentials." + index + ".to_year"][0]
                        }}</span
                      >
                    </div>

                    <div class="col p-0" style="max-width: 100px">
                      <a
                        @click.prevent="removeCredential(index, credential)"
                        v-if="index != 0"
                        class="removeLanguage"
                      >
                        Remove
                        <i class="fas fa-minus ml-1 ico-profile-delete"></i>
                      </a>
                      <div v-else>
                        <a
                          v-if="user.credentials.length < 3"
                          @click.prevent="addCredential"
                          class="removeLanguage"
                        >
                          Add
                          <i class="fas fa-plus ml-1 ico-profile-add"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </v-card>
          </div>
        </v-tab-item>
        <!-- Tab Social -->
        <v-tab tabindex="2" style="margin-right: 0px; padding-right: 0px"
          >Social</v-tab
        >
        <v-tab-item class="mt-5">
          <v-card class="m-1 p-0 mt-4">
            <div
              class="col-12 m-0 p-0 form-group subtitle-1"
              id="profile_url_control"
            >
              <label class="subtitle-1">Profile URL</label>
              <v-text-field
                background-color="#EDEDED"
                label="Profile URL"
                solo
                flat
                dense
                disabled
                filled
                hide-details
                prefix="Psychics1on1.com/"
                class="sfInputClass"
                v-model="user.profile.profile_link"
              ></v-text-field>
            </div>
            <div class="col-12 m-0 p-0 mt-4">
              <label class="subtitle-1">Share Profile</label>
              <div class="d-flex">
                <v-tooltip bottom class="ml-2">
                  <template v-slot:activator="{ on }">
                    <a
                      v-on="on"
                      @click.stop="share('facebook')"
                      class="primary--text"
                    >
                      <i class="fab ico-profile-facebook"></i>
                    </a>
                  </template>
                  <span>Share on Facebook</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <a
                      v-on="on"
                      @click.stop="share('linkedin')"
                      class="primary--text"
                    >
                      <i class="fab ico-profile-linkedin-h ml-5"></i>
                    </a>
                  </template>
                  <span>Share on LinkedIn</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <a
                      v-on="on"
                      @click.stop="share('twitter')"
                      class="primary--text"
                    >
                      <i class="fab ico-profile-twitter ml-5"></i>
                    </a>
                  </template>
                  <span>Share on Twitter</span>
                </v-tooltip>
                
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <a v-on="on" @click.stop="copyUrl()" class="primary--text">
                      <i class="fas ico-profile-link ml-5"></i>
                    </a>
                  </template>
                  <span>Copy URL</span>
                </v-tooltip>
              </div>
            </div>
          </v-card>

          <v-card class="m-1 mt-4 mb-4 p-0">
            <div class="col-12 subtitle-1 m-0 p-0">
              <div class="row p-0" style="margin-bottom: 20px">
                <span class="col-12">Social Info</span>
                <div>
                  <div v-if="profileSaved[7]">
                    <v-btn
                      class="sfProfileSave"
                      color="#fff"
                      small
                      max-width="1"
                    >
                      Saved

                      <img
                        src="/images/icons/save_inactive.svg"
                        style="margin-left: 5px !important; margin-right: -5px"
                      />
                    </v-btn>
                  </div>
                  <div v-else>
                    <v-btn
                      class="sfProfileSave"
                      color="#fff"
                      small
                      max-width="1"
                      @click="updateProfile(7)"
                      :loading="savingProfile"
                      :disabled="savingProfile"
                    >
                      Save

                      <img
                        src="/images/icons/save_inactive.svg"
                        style="margin-left: 5px !important; margin-right: -5px"
                      />
                    </v-btn>
                  </div>
                </div>
              </div>
              <div class="col-12 p-0" style="margin-bottom: 10px">
                <v-text-field
                  id="profile_social_link_three"
                  placeholder="Instagram username"
                  solo
                  dense
                  hide-details
                  filled
                  flat
                  class="sfInputClass"
                  prepend-icon="ico-profile-instagram-i"
                  v-model="user.profile.social_link_three"
                ></v-text-field>

                <span
                  v-if="errors['profile.social_link_three']"
                  class="float-left text-danger small"
                  >{{ errors["profile.social_link_three"][0] }}</span
                >
              </div>

              <div class="col-12 p-0" style="margin-bottom: 10px">
                <v-text-field
                  id="profile_social_link_two"
                  placeholder="Twitter handle"
                  solo
                  hide-details
                  flat
                  dense
                  class="sfInputClass"
                  prepend-icon="ico-profile-twitter-i"
                  filled
                  v-model="user.profile.social_link_two"
                ></v-text-field>

                <span
                  v-if="errors['profile.social_link_two']"
                  class="float-left text-danger small"
                  >{{ errors["profile.social_link_two"][0] }}</span
                >
              </div>

              <div class="col-12 p-0" style="margin-bottom: 10px">
                <v-text-field
                  id="profile_social_link_one"
                  placeholder="Facebook link"
                  background-color="#EBF4FD"
                  solo
                  dense
                  hide-details
                  flat
                  class="sfInputClass"
                  prepend-icon="ico-profile-facebook-i"
                  filled
                  v-model="user.profile.social_link_one"
                ></v-text-field>

                <span
                  v-if="errors['profile.social_link_one']"
                  class="float-left text-danger small"
                  >{{ errors["profile.social_link_one"][0] }}</span
                >
              </div>
            </div>
            <div class="col-12 m-0 p-0 mt-4">
              <label class="subtitle-1">Get Featured</label>
              <p class="sfProfileText">
                If you’d like to be featured on @psychics1on1 social accounts,
                check the box below and follow us!
              </p>

              <p class="sfProfileText mb-0">
                <v-checkbox
                  id="profile_get_featured"
                  v-model="user.profile.get_featured"
                  label="I'd like to be featured on @psychics1on1"
                  :value="1"
                  color="primary"
                  class="mb-0"
                ></v-checkbox>
              </p>

              <div class="sfFollow">
                <div>Follow @psychics1on1</div>
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <a
                      href="https://www.instagram.com/psychics1on1/"
                      class="primary--text p-0 m-0"
                      style="margin-top: -5px !important"
                    >
                      <i class="fab ico-profile-instagram-h ml-3"></i>
                    </a>
                  </template>
                  <span>Follow on instagram</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <a
                      href="https://www.linkedin.com/company/psychics1on1/about/"
                      class="primary--text p-0 m-0"
                      style="margin-top: -5px !important"
                    >
                      <i class="fab ico-profile-linkedin-h ml-3"></i>
                    </a>
                  </template>
                  <span>Follow on linkedin</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <a
                      href="https://www.facebook.com/Psychics1on1/"
                      class="primary--text p-0 m-0"
                      style="margin-top: -5px !important"
                    >
                      <i class="fab ico-profile-facebook-h ml-3"></i>
                    </a>
                  </template>
                  <span>Follow on facebook</span>
                </v-tooltip>
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <a
                      href="https://twitter.com/psychics1on1/"
                      class="primary--text p-0 m-0"
                      style="margin-top: -5px !important"
                    >
                      <i class="fab ico-profile-twitter-h ml-3"></i>
                    </a>
                  </template>
                  <span>Follow on twitter</span>
                </v-tooltip>
              </div>
            </div>
          </v-card>
        </v-tab-item>
      </v-tabs>
      <!-- Tabs end -->
    </form>

    <v-dialog
      content-class="videoDialog"
      elevation="0"
      class="video-audio dialogVid"
      v-model="videoDialog"
      style="margin: auto"
    >
      <v-card
        style="
          
          max-height: 500px;
          background-color: transparent;
        "
      >
        <v-card-text class="pa-0">
          <div class="w-100 d-flex align-center justify-center">
            <video
              controls
              controlslist="nodownload"
              v-if="videoPlay"
              style=" max-height: 500px"
              :poster="thumbnail"
            >
              <source v-bind:src="video" type="video/mp4" />
              <source v-bind:src="video" type="video/ogg" />
              Your browser does not support HTML5 video.
            </video>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import moment from "moment";
const csrf = $('meta[name="csrf-token"]').attr("content");
import image_cropper from "./psychic/image_cropper";
export default {
  components: { image_cropper },
  props: [
    "countries",
    "states",
    "categories",
    "specialties",
    "tools",
    "styles",
    "languages",
    "timezones",
    "country_all",
  ],
  data() {
    return {
      textErr: [],
      regex: /^[a-z\d,.!'’?\-_\s]+$/i,
      active_tab: null,
      videoPlay: false,
      videoDialog: false,
      displayPlay: true,
      options: {
        responsive: true,
        height: 130,
        hideScrollbar: true,
        backend: "MediaElement",
        backgroundColor: "white",
        barWidth: 2,
        cursorWidth: 0,
      },
      optionsDown: {
        responsive: true,
        height: 130,
        hideScrollbar: true,
        backend: "MediaElement",
        backgroundColor: "#f4f4f4",
        barWidth: 2,
        cursorWidth: 0,
      },
      datepicker_menu: false,
      loading: true,
      savingProfile: false,
      profileSaved: [false, false, false, false, false, false, false, false],
      user: { phone_numbers: [{ number: "" }] },
      profileObj: {},
      profile: {},
      errors: [],
      message: "",
      format_error: "",
      format_error_audio: "",
      message_upload: "",
      message_upload_cover: "",
      gender: ["Male", "Female", "Prefer Not to Say"],
      test: [],
      saveImage: false,
      saveCover: false,
      savingImage: false,
      savingCover: false,
      saveImageMsn: false,
      fileUploadFormData: new FormData(),
      fileUploadFormDataCover: new FormData(),
      image: "",
      cover_path: "",
      edit_abilities: false,
      edit_specialties: false,
      edit_tools: false,
      edit_styles: false,
      edit_languages: false,
      files: [],
      filesAudio: [],
      fileAudio: {},
      token: csrf,
      video: "",
      audio: "",
      upload_is_active: false,
      message_blob: {
        image: "",
        type: "",
      },
      edit_video: false,
      edit_audio: false,
      timezonesok: [],

      avatarBlob: "",
      fullBodyBlob: "",
    };
  },
  watch: {
    datepicker_menu(val) {
      val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
    },
    avatarBlob(val) {
      this.saveImage = true;
    },
    fullBodyBlob(val) {
      this.saveCover = true;
    },
    videoDialog(val) {
      if (!val) {
        this.videoPlay = "";
      }
    },
  },
  computed: {
    years() {
      var years = [];
      var currentYear = new Date().getFullYear();
      for (var i = 1940; i <= currentYear; i++) {
        years.push(i);
      }
      return years.reverse();
    },
    computedDateOfBirth() {
      return this.user.profile.birth_date
        ? moment(this.user.profile.birth_date).format("MM-DD-YYYY")
        : "";
    },
  },

  methods: {
    validateText(inputString, n) {
      if (inputString.length == 1) {
        if (!this.regex.test(inputString)) {
          this.textErr[n] = `Symbol ${inputString} is not permitted`;
          return "";
        } else {
          return inputString;
        }
      } else if (inputString.length > 1 && !this.regex.test(inputString)) {
        const notValidArr = inputString.split("");
        const validArr = [];

        notValidArr.map((char) =>
          this.regex.test(char)
            ? validArr.push(char)
            : (this.textErr[n] = `Symbol ${char} is not permitted`)
        );

        return validArr.join("");
      } else {
        return inputString;
      }
    },
    play() {
      document.querySelector("audio").play();
      this.displayPlay = false;
    },
    pause() {
      document.querySelector("audio").pause();
      this.displayPlay = true;
    },
    assignBlob(data) {
      this[data.ref] = data.file;
    },
    saveAvatar() {
      var fd = new FormData();

      fd.append("headshot", this.avatarBlob);

      this.savingImage = true;
      axios
        .post("/api/v1/user/profile/images/save", fd)
        .then((response) => {
          console.log(response);
          setTimeout(() => {
            this.savingImage = false;
            this.saveImage = true;
            this.saveImageMsn = true;
            this.message_upload = "Saved";

            setTimeout(function () {
              if (document.getElementById("profile")) {
                var imgProfile =
                  document
                    .getElementById("profile")
                    .getElementsByClassName("v-image__image--cover")[0]
                    .style.backgroundImage.replace(/(url\(|\)|")/g, "") +
                  "?" +
                  new Date().getTime();
                document
                  .getElementById("profile")
                  .getElementsByClassName(
                    "v-image__image--cover"
                  )[0].style.backgroundImage = "url(" + imgProfile + ")";
              }

              document.getElementById("saveImageMsn").style.visibility =
                "hidden";
              [].forEach.call(
                document.querySelectorAll(".btn-upload-wrapper"),
                function (el) {
                  el.style.visibility = "unset";
                }
              );
            }, 2000);

            setTimeout(() => {
              this.saveImage = false;
            }, 2000);
          }, 1000);

          this.message = response.data.message;
          this.errors = [];
        })
        .catch((error) => {
          this.savingImage = true;
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
          if (typeof error.response.data === "object") {
            this.errors = error.response.data.errors;
          } else {
            this.errors = ["Something went wrong. Please try again."];
          }
          this.message = "";
        });
    },
    saveBodyCover() {
      var fd = new FormData();

      fd.append("fullbody", this.fullBodyBlob);

      this.savingCover = true;

      axios
        .post("/api/v1/user/profile/images/save", fd)
        .then((response) => {
          this.savingCover = false;
          this.saveCover = false;
          this.message = response.data.message;
          this.errors = [];
          this.message_upload_cover = "Cover saved";
        })
        .catch((error) => {
          this.savingCover = false;
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
          if (typeof error.response.data === "object") {
            this.errors = error.response.data.errors;
          } else {
            this.errors = ["Something went wrong. Please try again."];
          }
          this.message = "";
        });
    },
    save(date) {
      this.$refs.datepicker_menu.save(date);
    },
    /**
     * Has changed
     * @param  Object|undefined   newFile   Read only
     * @param  Object|undefined   oldFile   Read only
     * @return undefined
     */
    inputFile: function (newFile, oldFile) {
      if (newFile && oldFile && !newFile.active && oldFile.active) {
        // Get response data
        console.log("newVideo", newFile);
        console.log("response", newFile.response);
        if (newFile.xhr) {
          //  Get the response status code
          console.log("status", newFile.xhr.status);
          if ((newFile.xhr.status == 200) || (newFile.xhr.status == 0)) {
            this.video = newFile.response.success.video_path;
            this.files = [];
            this.edit_video = false;
          }
        }
      }
    },

    inputFileAudio: function (newFile, oldFile) {
      if (newFile && oldFile && !newFile.active && oldFile.active) {
        // Get response data
        console.log("newAudio", newFile);
        console.log("response", newFile.response);
        if (newFile.xhr) {
          //  Get the response status code
          console.log("status", newFile.xhr.status);
          if ((newFile.xhr.status == 200) || (newFile.xhr.status == 0)) {
            this.audio = newFile.response.success.audio_path;
            this.filesAudio = [];
            this.edit_audio = false;
          }
        }
      }
    },
    /**
     * Pretreatment
     * @param  Object|undefined   newFile   Read and write
     * @param  Object|undefined   oldFile   Read only
     * @param  Function           prevent   Prevent changing
     * @return undefined
     */
    inputFilter(newFile, oldFile, prevent) {
      if (newFile && !oldFile) {
        if (!/\.(mp4|mov|wmv|avi|flv|f4v|mpeg|mpg)$/i.test(newFile.name)) {
          console.log("Not permitted");
          this.format_error = "File type not supported";
          return prevent();
        }

         
        // if (Math.round((newFile.size / 1024)) >= 4096) {
        //   console.log("File too Big, please select a file less than 4mb");
        //   this.format_error = "File too Big, please select a file less than 4mb";
        //   return prevent();
        // }


        newFile.blob = "";
        let URL = window.URL || window.webkitURL;
        if (URL && URL.createObjectURL) {
          newFile.blob = URL.createObjectURL(newFile.file);
          this.format_error = "";
        }
      }
    },

    inputFilterAudio(newFile, oldFile, prevent) {
      if (newFile && !oldFile) {
        // Add file

        // Filter non-image file
        // Will not be added to files
        if (
          !/\.(wav|aiff|aif|aifc|flac|m4a|caf|mp3|aac|wma|ogg)$/i.test(
            newFile.name
          )
        ) {
          console.log("Audio Not permitted");
          this.format_error_audio = "File type not supported";
          return prevent();
        }


               
        // if (Math.round((newFile.size / 1024)) >= 4096) {
        //   console.log("File too Big, please select a file less than 4mb");
        //   this.format_error = "File too Big, please select a file less than 4mb";
        //   return prevent();
        // }


        // Create the 'blob' field for thumbnail preview
        newFile.blob = "";
        let URL = window.URL || window.webkitURL;
        if (URL && URL.createObjectURL) {
          newFile.blob = URL.createObjectURL(newFile.file);
          //this.message_blob.image = newFile.blob;
          //this.message_blob.type = this.f_get_mime(newFile.file.type);
          //this.privateMessages.push(this.message_blob);
          // setTimeout(this.scrollToEnd, 500);
          this.format_error_audio = "";
        }
      }
    },

    f_get_mime(type) {
      return type.includes("image") ? "IMAGEB" : "VIDEOB";
    },
    updatetValue(value) {
      this.file = value[value.length - 1];
    },
    updateValueAudio(value) {
      this.fileAudio = value[value.length - 1];
    },
    getProfile() {
      axios
        .get("/api/v1/user/profile")
        .then((response) => {
          this.user = response.data.success.profile;
          // this.profile = response.data.success.profile.profile;
          this.image = this.user.profile.profile_headshot_url;
          this.cover_path = this.user.profile.cover_path;
          this.saveCover = false;
          this.video = this.user.profile.intro_video_path;
          this.thumbnail = this.user.profile.intro_video_thumbnail;
          this.audio = this.user.profile.intro_audio_path;
          this.loading = false;
          if (this.video == "") {
            this.edit_video = true;
          }
          if (this.audio == "") {
            this.edit_audio = true;
          }

          //this.setupDragDrop();
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
    updateProfile(action) {
      this.savingProfile = true;
      this.textErr = [];
      var input = this.user;
      let tab = 1;

      if (action >= 4) {
        tab = 2;
      }
      if (action == 7) {
        tab = 3;
      }

      console.log(tab);
      axios
        .post(`/api/v1/user/profile/save?tab=${tab}`, input)
        .then((response) => {
          setTimeout(() => {
            this.savingProfile = false;
            this.profileSaved[action] = true;

            console.log(response);

            setTimeout(() => {
              this.profileSaved[action] = false;
            }, 2000);
          }, 1000);

          this.user.profile.profile_link =
            response.data.success.profile.profile_link;

          document.querySelector("#view_profile")
            ? (document.querySelector("#view_profile").href =
                "/" + response.data.success.profile.profile_link)
            : (document.querySelector("#view_profile_mobile").href =
                "/" + response.data.success.profile.profile_link);
          this.message = response.data.message;
          this.errors = [];
        })
        .catch((error) => {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }

          if (typeof error.response.data === "object") {
            this.errors = error.response.data.errors;
            var key = Object.keys(this.errors)[0];
            var str = key.replace(/\./g, "_");

            console.log(str);

            if (
              str == "profile_elevator_pitch" ||
              str == "profile_tagline" ||
              str == "profile_years_experience" ||
              str == "specialties" ||
              str == "categories" ||
              str == "tools" ||
              str == "styles" ||
              str == "profile_description"
            ) {
              this.active_tab = 1;
            }

            if (
              str == "profile_display_name" ||
              str == "profile_name" ||
              str == "profile_last_name" ||
              str == "profile_birth_date"
            ) {
              this.active_tab = 0;
            }
          } else {
            this.errors = ["Something went wrong. Please try again."];
          }

          this.savingProfile = false;
          this.message = "";
        });
    },

    processFile(event) {
      var reader = new FileReader();

      reader.onload = function (e) {
        document
          .getElementById(event.target.getAttribute("data-img"))
          .setAttribute("src", e.target.result);
      };

      reader.readAsDataURL(event.target.files[0]);
    },
    addCredential() {
      this.user.credentials.push({
        id: null,
        institution_name: "",
        from_year: null,
        to_year: null,
        degree: "",
        area_of_study: "",
        description: "",
      });
    },

    addWork() {
      this.user.works.push({
        id: null,
        position: "",
        from_year: null,
        to_year: null,
        company: "",
        description: "",
      });
    },

    addLanguage() {
      this.user.languages.push({
        id: null,
        languages_id: null,
      });
    },

    removeCredential(index, credential) {
      // send ajax request in case we want to delete
      if (credential.id != null) {
        axios
          .post("/api/v1/user/profile/credential/delete/" + credential.id)
          .then((response) => {
            console.log(response.data);
            this.user.credentials = this.user.credentials.filter(function (
              item
            ) {
              return item.id != credential.id;
            });
            //this.profile.phoneNumbers.splice(index, 1);
            //this.message = response.data.message;
            //this.errors = [];
          })
          .catch((error) => {
            if (
              error.response &&
              (error.response.status === 401 || error.response.status === 419)
            ) {
              location.reload();
            }
            if (typeof error.response.data === "object") {
              this.errors = error.response.data.errors;
            } else {
              this.errors = ["Something went wrong. Please try again."];
            }

            this.message = "";
          });
      } else {
        this.user.credentials.splice(index, 1);
      }
    },
    removeWork(index, work) {
      // send ajax request in case we want to delete
      if (work.id != null) {
        axios
          .post("/api/v1/user/profile/work/delete/" + work.id)
          .then((response) => {
            console.log(response.data);
            this.user.works = this.user.works.filter(function (item) {
              return item.id != work.id;
            });
            //this.profile.phoneNumbers.splice(index, 1);
            //this.message = response.data.message;
            //this.errors = [];
          })
          .catch((error) => {
            if (
              error.response &&
              (error.response.status === 401 || error.response.status === 419)
            ) {
              location.reload();
            }
            if (typeof error.response.data === "object") {
              this.errors = error.response.data.errors;
            } else {
              this.errors = ["Something went wrong. Please try again."];
            }

            this.message = "";
          });
      } else {
        this.user.works.splice(index, 1);
      }
    },

    removeLanguage(index, language) {
      // send ajax request in case we want to delete
      if (language.languages_id != null) {
        axios
          .post("/api/v1/user/profile/language/delete/" + language.languages_id)
          .then((response) => {
            console.log(response.data);
            this.user.languages.splice(index, 1);
          })
          .catch((error) => {
            if (
              error.response &&
              (error.response.status === 401 || error.response.status === 419)
            ) {
              location.reload();
            }
            if (typeof error.response.data === "object") {
              this.errors = error.response.data.errors;
            } else {
              this.errors = ["Something went wrong. Please try again."];
            }

            this.message = "";
          });
      } else {
        this.user.languages.splice(index, 1);
      }
    },

    copyUrl() {
      const str = "https://psychics1on1.com/" + this.user.profile.profile_link;
      const el = document.createElement("textarea");
      el.value = str;
      document.body.appendChild(el);
      el.select();
      document.execCommand("copy");
      document.body.removeChild(el);
      /* unselect the range */
      /*     testingCodeToCopy.setAttribute('type', 'hidden')
                 window.getSelection().removeAllRanges()*/
    },

    share(type) {
      this.dialog = false;
      var top = window.screen.height - 400;
      top = top > 0 ? top / 2 : 0;

      var left = window.screen.width - 400;
      left = left > 0 ? left / 2 : 0;

      if (type == "facebook") {
        window.open(
          "https://www.facebook.com/sharer.php?u=https://www.psychics1on1.com/" +
            this.user.profile.display_name,
          "psychics1on1.com",
          "width=500,height=500,top=" + top + ",left=" + left + ""
        );
      } else if (type == "twitter") {
        window.open(
          "https://twitter.com/share?url=https://www.psychics1on1.com/" +
            this.user.profile.display_name,
          "psychics1on1.com",
          "width=500,height=500,top=" + top + ",left=" + left + ""
        );
      } else if (type == "linkedin") {
        window.open(
          "https://www.linkedin.com/shareArticle?mini=true&url=https://www.psychics1on1.com/" +
            this.user.profile.display_name,
          "psychics1on1.com",
          "width=500,height=500,top=" + top + ",left=" + left + ""
        );
      }
    },
    f_text_prefix() {
      return (country = "+" + country.code2);
    },
  },

  /**
   * Prepare the component (Vue 2.x).
   */ mounted() {
    this.getProfile();

    setTimeout(() => {
      console.log(this.image);
    }, 3000);

    var entries = Object.entries(this.timezones);
    entries.forEach((the_s) => {
      this.timezonesok.push({
        text: the_s[0],
        value: the_s[1],
      });
    });
  },
};
</script>
<style>
input[type="date"]::-webkit-inner-spin-button,
input[type="date"]::-webkit-calendar-picker-indicator {
  display: none;
  -webkit-appearance: none;
}

.no-background-hover::before {
  background-color: transparent !important;
}

.no-background-hover:focus {
  outline: 0 !important;
}

wave {
  width: 120px;
  height: 60px !important;
  border-radius: 5px !important;
  z-index: 0;
  /* margin-left: 10px !important;
  margin-bottom: 15px !important;
  margin-top: 15px !important; */
}

.v-tab {
  box-shadow: 0px 3px 6px #0000000d;
  opacity: 1;
}

.v-tab:hover {
  border: 2px solid #c1dbfb;
  border-radius: 18px;
  background: #c1dbfb;
  box-shadow: 0px 3px 6px #0000000d;
  opacity: 1;
}

.theme--light.v-tabs > .v-tabs-bar {
  background-color: white !important;
  border-radius: 18px;
}

.theme--light.v-tabs-items {
  background-color: transparent !important;
}

.v-tab--active {
  border: 2px solid #c1dbfb;
  border-radius: 18px;
  background: #c1dbfb;
}

.sfFormProfile .v-card {
  padding: 20px !important;
}

.sfFormProfileMo .v-card {
  padding: 20px 10px !important;
}

.sfFormProfile textarea,
.sfFormProfileMo textarea {
  resize: none;
}

.sfFormProfileMo .checkRigth,
.sfFormProfileMo .checkRigth select,
.sfFormProfileMo .checkRigth .v-input__control,
.sfFormProfileMo .checkRigth .v-select__slot,
.sfFormProfileMo .checkRigth .v-input__slot,
.sfFormProfileMo .checkDisabledRigth,
.sfFormProfileMo .checkDisabledRigth select,
.sfFormProfileMo .checkDisabledRigth .v-input__control,
.sfFormProfileMo .checkDisabledRigth .v-select__slot,
.sfFormProfileMo .checkDisabledRigth .v-input__slot,
.sfFormProfileMo .checkRigth,
.sfFormProfileMo .checkRigthLong,
.sfFormProfileMo .checkRigthLong,
.sfFormProfileMo .checkRigthLong select,
.sfFormProfileMo .checkRigthLong .v-input__control,
.sfFormProfileMo .checkRigthLong .v-select__slot,
.sfFormProfileMo .checkRigthLong .v-input__slot {
  width: 100%;
  max-width: 100%;
}

.sfFormProfile .subtitle-1 {
  font-size: 14px !important;
  line-height: 19px;
  font-weight: 600 !important;
  letter-spacing: 0.28px !important;
  color: #43425d !important;
  opacity: 1;
  font-family: "Montserrat", sans-serif !important;
}

.sfFormProfile .v-tabs-bar {
  background: #f4f4f4;
  box-shadow: 0px 3px 6px #0000000d;
  height: 60px !important;
}
.sfFormProfile .v-slide-group__wrapper {
  background: #f4f4f4;
  padding-bottom: 20px;
  padding-left: 20px;
  padding-right: 20px;
  text-align: center;
  font-weight: 500;
  letter-spacing: 0.28px;
  color: #43425d;
  opacity: 1;
}
.sfFormProfile .v-tab {
  text-transform: none !important;
  font-size: 14px;
}

.sfFormProfile .v-tabs-bar__content {
  background: #fff;
  border-radius: 18px;
}

.sfInputClass,
.sfInputClass input,
.sfInputClass .v-input__control,
.sfInputClass .v-text-field__slot,
.sfInputClassInactive,
.sfInputClassInactive input,
.sfInputClassInactive .v-input__control {
  /* width: 335px; */
  max-width: 335px;
  min-height: 40px !important;
  max-height: 40px;
  height: 40px;
  min-height: 40px;
  background: #f4f4f4 !important;
  border-radius: 5px !important;
  padding: 0px !important;
}

.sfInputClass .v-text-field__prefix {
  padding-left: 10px;
}

.sfInputYearsClass,
.sfInputYearsClass input,
.sfInputYearsClass .v-input__control {
  width: 224px;
  max-width: 270px;
}

.sfInputClassLeft,
.sfInputClassLeft input,
.sfInputClassLeft .v-input__control {
  width: 133px;
  max-width: 177px;
  min-height: 40px !important;
  max-height: 40px;
  height: 40px;
  min-height: 40px;
}

.checkRigth,
.checkRigth select,
.checkRigth .v-input__control,
.checkRigth .v-select__slot,
.checkRigth .v-input__slot,
.checkDisabledRigth,
.checkDisabledRigth select,
.checkDisabledRigth .v-input__control,
.checkDisabledRigth .v-select__slot,
.checkDisabledRigth .v-input__slot {
  width: 138px;
  max-width: 138px;
  min-height: 40px !important;
  max-height: 40px;
  height: 40px;
  min-height: 40px;
  background: #f4f4f4 !important;
  border-radius: 5px !important;
  padding: 0px !important;
  opacity: 1 !important;
}

.checkRigthLong,
.checkRigthLong select,
.checkRigthLong .v-input__control,
.checkRigthLong .v-select__slot,
.checkRigthLong .v-input__slot {
  width: 187px;
  max-width: 187px;
  min-height: 40px !important;
  max-height: 40px;
  height: 40px;
  min-height: 40px;
  background: #f4f4f4 !important;
  border-radius: 5px !important;
  padding: 0px !important;
  opacity: 1 !important;
}

.checklefLanguage,
.checklefLanguage select,
.checklefLanguage .v-input__control,
.checklefLanguage .v-select__slot,
.checklefLanguage .v-input__slot {
  width: 177px;
  max-width: 177px;
  min-height: 40px !important;
  max-height: 40px;
  height: 40px;
  min-height: 40px;
  background: #f4f4f4 !important;
  border-radius: 5px !important;
  padding: 0px !important;
  opacity: 1 !important;
}

.checkYearFrom,
.checkYearFrom select,
.checkYearFrom .v-input__control,
.checkYearFrom .v-select__slot,
.checkYearFrom .v-input__slot {
  width: 110px;
  max-width: 110px;
  min-height: 40px !important;
  max-height: 40px;
  height: 40px;
  min-height: 40px;
  background: #f4f4f4 !important;
  border-radius: 5px !important;
  padding: 0px !important;
  opacity: 1 !important;
}

.checkYearTo,
.checkYearTo select,
.checkYearTo .v-input__control,
.checkYearTo .v-select__slot,
.checkYearTo .v-input__slot {
  width: 110px;
  max-width: 110px;
  min-height: 40px !important;
  max-height: 40px;
  height: 40px;
  min-height: 40px;
  background: #f4f4f4 !important;
  border-radius: 5px !important;
  padding: 0px !important;
  opacity: 1 !important;
}

.checklefLanguage.v-text-field--filled.v-input--dense.v-text-field--single-line
  .v-label,
.checkYearFrom.v-text-field--filled.v-input--dense.v-text-field--single-line
  .v-label,
.checkYearTo.v-text-field--filled.v-input--dense.v-text-field--single-line
  .v-label {
  top: 11px !important;
}

.sfInputClass.v-text-field.v-text-field--enclosed .v-text-field__details,
.sfInputClass.v-text-field.v-text-field--enclosed
  > .v-input__control
  > .v-input__slot,
.sfInputClassInactive.v-text-field.v-text-field--enclosed
  .v-text-field__details,
.sfInputClassInactive.v-text-field.v-text-field--enclosed
  > .v-input__control
  > .v-input__slot {
  padding: 0px !important;
}

.sfInputClass input,
.sfInputClass.v-text-field--filled.v-input--dense.v-text-field--single-line
  .v-label,
.sfInputClassInactive input,
.sfInputClassInactive.v-text-field--filled.v-input--dense.v-text-field--single-line
  .v-label {
  font-size: 14px !important;
  line-height: 18px !important;
  font-weight: 500 !important;
  letter-spacing: 0px;
  opacity: 1;
}

.checkDisabledRigth.v-text-field--filled.v-input--dense.v-text-field--single-line
  .v-label,
.checkDisabledRigth.theme--light.v-input--is-disabled .v-select__selections {
  color: #a2a2a2 !important;
  top: 11px !important;
  margin-left: 10px;
  margin-right: 10px;
  opacity: 0.5;
  letter-spacing: 0px;
  font-weight: 500;
  line-height: 18px;
}

.checkRigthLong.v-text-field--filled.v-input--dense.v-text-field--single-line
  .v-label,
.checkRigthLong.theme--light.v-select__selections,
.checkRigthLong .v-select__selection .v-select__selection--comma,
.checkRigthLong .v-select__selections div,
.checkRigth.v-text-field--filled.v-input--dense.v-text-field--single-line
  .v-label,
.checkRigth.theme--light.v-select__selections,
.checkRigth .v-select__selection .v-select__selection--comma,
.checkRigth .v-select__selections div {
  color: #1f1e34 !important;
  top: 11px !important;
  margin-left: 10px;
  margin-right: 10px;
  opacity: 1 !important;
  letter-spacing: 0px;
  font-weight: 500;
  line-height: 18px;
}

.sfInputClass.v-text-field--filled.v-input--dense.v-text-field--single-line
  .v-label,
.sfInputClassInactive.v-text-field--filled.v-input--dense.v-text-field--single-line
  .v-label {
  color: #c7c7c7 !important;
  top: 11px !important;
}

.sfInputClass input {
  color: #1f1e34 !important;
}

.sfInputClassInactive input,
.sfInputClassInactive.theme--light.v-input--is-disabled input,
.checkDisabled .v-select__selections {
  color: #a2a2a2 !important;
  opacity: 0.5;
}

.sfInputClass .v-input__icon,
.sfInputClassInactive .v-input__icon {
  height: 32px;
  width: 28px;
  margin-right: 10px;
  margin-left: 10px;
}
.sfInputClass .v-input__prepend-outer,
.sfInputClassInactive .v-input__prepend-outer {
  margin: 0px !important;
  margin-top: 3px !important;
}

.sfVcard .row {
  margin-right: -32px !important;
  margin-left: -16px !important;
}

.checkDisabledRigth .v-input__icon.v-input__icon--append i::before {
  width: 30px;
  background: url(/images/icons/sort.svg);
  background-size: 30px;
  right: -12px !important;
  top: -17px !important;
  position: absolute;
  content: "";
  display: inline-block;
  height: 30px;
  opacity: 0.5;
}

.checkRigthLong .v-input__icon.v-input__icon--append i::before {
  width: 30px;
  background: url(/images/icons/sort.svg);
  background-size: 30px;
  right: -12px !important;
  top: -17px !important;
  position: absolute;
  content: "";
  display: inline-block;
  height: 30px;
  opacity: 0.5;
}

.checkRigth .v-input__icon.v-input__icon--append i::before {
  width: 30px;
  background: url(/images/icons/sort.svg);
  background-size: 30px;
  right: -12px !important;
  top: -17px !important;
  position: absolute;
  content: "";
  display: inline-block;
  height: 30px;
  opacity: 0.5;
}

.sfProfileSave {
  position: absolute;
  top: -6px;
  margin-right: 0px !important;
  padding-right: 0px !important;
  right: 0px;
}

.sfProfileTip {
  position: absolute;
  top: -6px;
  margin-right: 0px !important;
  padding-right: 0px !important;
  right: 0px;
  text-align: right;
  font-weight: 500;
  letter-spacing: 0px;
  color: #43425d;
  opacity: 0.5;
  font-size: 10px;
}

.sfProfileSave,
.sfProfileSave .v-btn__content {
  letter-spacing: 0.28px;
  color: #c7c7c7;
  opacity: 1;
  font-size: 14px;
  line-height: 18px;
  font-weight: 500;
  margin: 0px;
  margin-right: 0px;
  text-align: right;
  float: right;
  padding-right: 0px;
  justify-content: flex-end;
}

.sfFormProfile .v-btn:not(.v-btn--round).v-size--small {
  height: 28px;
  min-width: 95px;
  border: none !important;
  outline: none !important;
}
.sfFormProfileMo .v-btn:not(.v-btn--round).v-size--small {
  height: 28px;
  min-width: 95px;
  border: none !important;
  outline: none !important;
}

.sfProfileSave::before {
  background-color: transparent !important;
}
.sfProfileSave:focus {
  background-color: transparent !important;
}

.ico-profile-name {
  background: url("/images/profile/name.svg");
  background-position: center;
  height: 32px;
  width: 28px;
  background-repeat: no-repeat;
}

.ico-profile-work {
  background: url("/images/profile/work.svg");
  background-position: center;
  height: 32px;
  width: 28px;
  background-repeat: no-repeat;
}
.ico-profile-credential {
  background: url("/images/profile/education.svg");
  background-position: center;
  height: 32px;
  width: 28px;
  background-repeat: no-repeat;
}

.ico-profile-delete {
  border: 2px solid #43425d;
  padding: 2px 3px;
  font-size: 9px;
  color: #43425d;
}
.ico-profile-add {
  border: 2px solid #43425d;
  padding: 2px 3px;
  font-size: 9px;
  color: #43425d;
}


.ico-profile-pencil {
background: url("/images/site-images/pencil.svg");
    background-position: center;
    height: 23px;
    width: 23px;
    background-repeat: no-repeat;
    background-size: 23px;
}
.removeLanguage {
  letter-spacing: 0.28px;
  color: #43425d;
  opacity: 1;
  font-weight: 500;
  font-size: 14px;
  line-height: 18px;
  height: 40px;
  display: table-cell;
  vertical-align: middle;
  width: 134px;
  text-align: end;
}

.sfProfileText {
  letter-spacing: 0px;
  color: #43425d;
  opacity: 0.5;
  font-weight: 500;
  font-size: 12px;
  line-height: 18px;
}

.sfProfileVideo {
  background: #f4f4f4 0% 0% no-repeat padding-box;
  box-shadow: 0px 3px 6px #0000000d;
  border-radius: 5px;
  opacity: 1;
  height: 90px;
  width: 90px;
}

.sfProfileVideoIco, 
.sfProfileAudioIco
{
margin-top: 25px;
}

.sfProfileVideoBox .grey--text,
.sfProfileAudioBox .grey--text,
.sfProfileAudio .grey--text,
.sfProfileVideoIco .grey--text,
.sfProfileAudioIco .grey--text{
  font-size: 8px;
    line-height: 10px;
    margin-top: 13px;
    word-break: break-all;
}

.buttonVideox .v-btn__content{
      left: 22px;
    bottom: 17px !important;
}



.sfProfileVideoIco .theme--light.v-btn:hover::before,
.sfProfileAudioIco .theme--light.v-btn:hover::before{
  display: none;
}

.sfProfileVideoIco, .sfProfileAudioIco,
.sfProfileVideoIco .v-btn__content,
.sfProfileAudioIco .v-btn__content
{
  color:#a09fad !important;
  background: #fff !important;    font-size: 12px !important;
}
.sfProfileVideoIco .theme--light.v-btn:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined),
.sfProfileAudioIco  .theme--light.v-btn:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined){
   color: #a09fad;
  font-size: 12px;
  
}
.sfProfileVideoIco .file-uploads,
.sfProfileAudioIco .file-uploads{
border-radius: 5px;
height: 90px;
}

.sfProfileAudio {
  background: #f4f4f4 0% 0% no-repeat padding-box;
  box-shadow: 0px 3px 6px #0000000d;
  border-radius: 5px;
  opacity: 1;
  height: 90px;
  width: 140px;
}

.sfProfileVideo .buttons-area,
.sfProfileVideo .file-uploads,
.sfProfileVideo button,
.sfProfileVideo .v-btn__content {
  height: 90px;
  
  letter-spacing: 0.28px;
  color: #43425d;
  opacity: 1;
  font-size: 14px;
  font-weight: 500;
  line-height: 18px;
  cursor: pointer;
}

.sfProfileAudio .buttons-area,
.sfProfileAudio .file-uploads,
.sfProfileAudio button,
.sfProfileAudio .v-btn__content {
  height: 90px;
  
  letter-spacing: 0.28px;
  color: #43425d;
  opacity: 1;
  font-size: 12px;
  font-weight: 500;
  line-height: 18px;
  cursor: pointer;
}

.sfProfileVideo button,
.sfProfileAudio button {
  display: block;
}
.sfProfileVideo .v-btn__content,
.sfProfileAudio .v-btn__content {
  padding-top: 10px;
  display: block;
  /* margin-left: -15px; */
  cursor: pointer;
}
.sfProfileFormAudio .file-uploads{
    /* margin-left: -15px !important; */

}


.sfProfileFormVideo .file-uploads{
    /* margin-left: -15px !important; */

}
.buttonVideoIco,
.buttonVideoIco .v-btn__content,
.sfProfileAudioIco .buttonVideo{
  margin-left: -2px !important;
      width: 140px !important;
}
.sfProfileAudioIco .theme--light.v-btn:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined){

  margin-left: 0px;

}

.sfInputTaglineClass {
  background: #f4f4f4;
  border-radius: 5px;
  opacity: 1;
  padding: 12px 10px;
  width: 270px;
  max-width: 270px;
}

.sfInputTaglineClass textarea {
  letter-spacing: 0px;
  color: #a2a2a2;
  opacity: 0.5;
  font-size: 14px;
  font-weight: 500;
  line-height: 18px !important;
}

.sfInputWorkClass {
  background: #f4f4f4;
  border-radius: 5px;
  opacity: 1;
  padding: 12px 10px;
  width: 335px;
  max-width: 335px;
}

.sfInputWorkClass textarea {
  letter-spacing: 0px;
  color: #a2a2a2;
  opacity: 0.5;
  font-size: 14px;
  font-weight: 500;
  line-height: 18px !important;
}

.sfInputBackgroundClass {
  background: #f4f4f4;
  border-radius: 5px;
  opacity: 1;
  padding: 12px 10px;
  width: 100%;
  max-width: 100%;
}

.sfInputBackgroundClass textarea {
  letter-spacing: 0px;
  color: #a2a2a2;
  opacity: 0.5;
  font-size: 14px;
  font-weight: 500;
  line-height: 18px !important;
}

.sfInputElevatorClass {
  background: #f4f4f4;
  border-radius: 5px;
  opacity: 1;
  padding: 12px 10px;
  width: 430px;
  max-width: 430px;
}

.sfInputElevatorClass textarea {
  letter-spacing: 0px;
  color: #a2a2a2;
  opacity: 0.5;
  font-size: 14px;
  font-weight: 500;
  line-height: 18px !important;
}
.sfProfileList .v-label,
.sfProfileList label {
  text-align: left;
  font-weight: 500 !important;
  letter-spacing: 0px;
  color: #43425d !important;
  opacity: 1;
  font-size: 12px !important;
}

.sfProfileList .v-input__control {
  height: 21px;
}

.ico-profile-finger {
  background: url("/images/profile/finger_print.svg");
  background-position: center;
  height: 32px;
  width: 28px;
  background-repeat: no-repeat;
}

.ico-format{
    background-position: center;
  height: 32px;
  width: 28px;
  background-repeat: no-repeat;
  font-size: 19px !important;
    color: #c7c7c7 !important;

}
.ico-profile-finger {
  background: url("/images/profile/finger_print.svg");
  background-position: center;
  height: 32px;
  width: 28px;
  background-repeat: no-repeat;
}

.ico-profile-city {
  background: url("/images/profile/city.svg");
  background-position: center;
  height: 32px;
  width: 28px;
  background-repeat: no-repeat;
}

.ico-profile-birthday {
  background: url("/images/profile/birthday.svg");
  background-position: center;
  height: 32px;
  width: 28px;
  background-repeat: no-repeat;
}
.ico-profile-phone {
  background: url("/images/profile/phone.svg");
  background-position: center;
  height: 32px;
  width: 28px;
  background-repeat: no-repeat;
}

.ico-profile-inactive {
  background: url("/images/profile/inactive.svg");
  background-position: center;
  height: 32px;
  width: 28px;
  background-repeat: no-repeat;
}

.ico-profile-business {
  background: url("/images/profile/business.svg");
  background-position: center;
  height: 32px;
  width: 28px;
  background-repeat: no-repeat;
}

.ico-profile-years {
  background: url("/images/profile/years.svg");
  background-position: center;
  height: 32px;
  width: 28px;
  background-repeat: no-repeat;
}

.ico-profile-twitter {
  background: url("/images/profile/twitter-ico.svg");
  background-position: center;
  height: 32px;
  width: 28px;
  background-repeat: no-repeat;
}

.ico-profile-facebook {
  background: url("/images/profile/facebook-ico.svg");
  background-position: center;
  height: 32px;
  width: 28px;
  background-repeat: no-repeat;
}

.ico-profile-linkedin {
  background: url("/images/profile/linkedin-ico.svg");
  background-position: center;
  height: 32px;
  width: 28px;
  background-repeat: no-repeat;
}

.ico-profile-link {
  background: url("/images/profile/link-ico.svg");
  background-position: center;
  height: 32px;
  width: 28px;
  background-repeat: no-repeat;
}

.ico-profile-instagram-i {
  background: url("/images/profile/instagram-url.svg");
  background-position: center;
  height: 32px;
  width: 28px;
  background-repeat: no-repeat;
}

.ico-profile-facebook-i {
  background: url("/images/profile/facebook-url.svg");
  background-position: center;
  height: 32px;
  width: 28px;
  background-repeat: no-repeat;
}

.ico-profile-twitter-i {
  background: url("/images/profile/twitter-url.svg");
  background-position: center;
  height: 32px;
  width: 28px;
  background-repeat: no-repeat;
}
.sfHeaderProfile {
  background: #f4f4f4;
  box-shadow: 0px 3px 6px #0000000d;
  opacity: 1;
  padding: 20px;
}

.sfHeaderProfile {
}

.sfFollow {
  background: #f4f4f4;
  border-radius: 5px;
  opacity: 1 !important;
  height: 40px;
  letter-spacing: 0px;
  color: #a09fad;
  opacity: 1;
  font-size: 14px;
  font-weight: 500;
  display: flex;
  padding: 10px;
}

.ico-profile-instagram-h {
  background: url("/images/profile/instagram-h.svg");
  background-position: center;
  height: 32px;
  width: 28px;
  background-repeat: no-repeat;
}

.ico-profile-facebook-h {
  background: url("/images/profile/facebook-h.svg");
  background-position: center;
  height: 32px;
  width: 28px;
  background-repeat: no-repeat;
}

.ico-profile-twitter-h {
  background: url("/images/profile/twitter-h.svg");
  background-position: center;
  height: 32px;
  width: 28px;
  background-repeat: no-repeat;
}

.ico-profile-linkedin-h {
  background: url("/images/profile/linkedIn-h.svg");
  background-position: center;
  height: 32px;
  width: 28px;
  background-repeat: no-repeat;
  opacity: 1;
}

.ico-profile-copy-h {
  background: url("/images/profile/copy-h.svg");
  background-position: center;
  height: 32px;
  width: 28px;
  background-repeat: no-repeat;
  opacity: 0.5;
}

.sfFormProfileMo .sfInputTaglineClass {
  background: #f4f4f4;
  border-radius: 5px;
  opacity: 1;
  padding: 12px 10px;
  width: 100%;
  max-width: 100%;
}
.sfFormProfileMo .sfInputYearsClass {
  width: 100% !important;
  max-width: 100% !important;
}

.sfFormProfileMo .sfInputElevatorClass {
  width: 100%;
  max-width: 100%;
}

.sfFormProfileMo .sfInputBackgroundClass {
  width: 100%;
  max-width: 100%;
}

.sfFormProfileMo .sfInputClassInactive,
.sfFormProfileMo .sfInputClass {
  width: 100%;
  max-width: 100%;
}
.sfFormProfileMo .sfInputWorkClass {
  width: 100%;
  max-width: 100%;
}

.sfProfileFormAudio {
  border-radius: 5px;
  width: 120px;
  margin-top: 50px;
}
.sfProfileFormAudioBox{
    border-radius: 5px;
  width: 120px;
  margin-top: 32px !important;
}

.sfProfileFormAudioBox .v-btn__content{
      margin-left: 0px;
    margin-bottom: 0px;
}


.sfProfileFormAudioBox .file-uploads .v-btn__content{
    margin-bottom: 35px;
    margin-left: 13px;
}
.sfProfileFormAudioBox .buttonVideo .v-btn__content{
    margin-bottom: 18px;
    margin-left: -3px;
}


.sfProfileFormAudio .v-btn__content {
  padding-bottom: 15px;
  padding-top: 15px;
  background: #fff;
  padding-left: 10px;
  padding-right: 10px;
  border-radius:5px !important;
  width: 140px;

  font-size: 14px;
  letter-spacing: 0.28px;
  color: #f4f4f4;
  opacity: 1;
  font-weight: 500;
}

.sfProfileFormAudio .subtitle-1,
.buttonVideo.v-btn .v-btn__content {
  position: absolute;
  bottom: 0px;
  width: 100%;
  height: 40px;
  text-align: center;
  border-radius: 0px 0px 5px 5px;
  z-index: 0;
  background: rgba(67, 66, 93, 0.5) !important;
      color: #fff !important;
  font-family: "Montserrat", sans-serif !important;
}

.sfProfileFormAudio .file-uploads,
.buttonVideo {
  overflow: unset !important;
  position: absolute !important;
  text-align: center !important;
  display: block !important;
  
  z-index: 0 !important;
  top: 38px;
}

.sfProfileFormAudioDown{
  margin-top: 30px !important;
}
.sfProfileFormAudioDown .file-uploads{
  top: 22px  !important;
}

.buttonVideoSubDown{
  top: 22px !important;
}



.buttonVideo {
  width: 140px !important;
}
.buttonVideo .v-btn__content {
  padding-bottom: 4px;
  /* margin-left: -15px; */
}

.buttonVideo.v-btn:before{
  display: none;
}

.buttonVideoBox .v-btn__content{
margin-left: 8px !important;
    margin-bottom: 20px !important;
    background: none !important;
}
.sfProfileAudioBox .buttonVideoBox.v-btn__content{
    margin-left: 7px !important;
    margin-bottom: 18px !important;
    color: #43425d !important;
    background: none !important;
    opacity: 0.5 !important;
    font-weight: 500 !important;
    font-size: 12px !important;
}



.sfProfileFormAudio .file-uploads .v-btn,
.buttonVideo {
  padding-left: 0px !important;
  padding-right: 0px !important;
  /* background: transparent !important; */
}

.sfProfileFormAudio .file-uploads .v-btn span,
.buttonVideo span {
  font-size: 14px;
  letter-spacing: 0.28px;
  color: #f4f4f4;
  opacity: 0.5;
  font-weight: 500;
  background: #43425d;
  padding-bottom: 5px;
      border-radius: 0px 0px 5px 5px !important;
}

/* video  */

.sfProfileFormVideo {
  border-radius: 5px;
  width: 90px;
  margin-top: 50px;
}

.sfProfileFormVideo .v-btn__content {
  padding-bottom: 0px;
  padding-top: 0px;
  background: #fff;
  padding-left: 0px;
  padding-right: 0px;
  border-radius: 0px 0px 5px 5px !important;
  width: 90px;
  font-size: 14px;
  letter-spacing: 0.28px;
  color: #f4f4f4;
  opacity: 1;
  font-weight: 500;
}

.sfProfileFormVideo .subtitle-1,
.buttonVideoSub.v-btn .v-btn__content {
  position: absolute;
  bottom: 0px;
  width: 100%;
  height: 40px;
  text-align: center;
  border-radius: 0px 0px 5px 5px;
  z-index: 0;
  opacity: 1;
  background: rgba(67, 66, 93, 0.5) !important;
  color: #fff  !important;
  font-family: "Montserrat", sans-serif !important;
}

.sfProfileFormVideo .file-uploads,
.buttonVideoSub,.buttonVideo {
  overflow: unset !important;
  position: absolute !important;
  text-align: center !important;
  display: block !important;
  /* left: 15px !important;  */
  z-index: 0 !important;
  top: 38px;
}




.buttonVideoSub {
  width: 90px !important;
}
.buttonVideoSub .v-btn__content {
  padding-bottom: 4px;
  
}

.sfProfileFormVideo .file-uploads .v-btn
{
  padding-left: 0px !important;
  padding-right: 0px !important;
  background: transparent !important;
  
}


.buttonVideoSub {
  padding-left: 0px !important;
  padding-right: 0px !important;
  background: transparent !important;

}



.sfProfileFormVideo .file-uploads .v-btn span,
.buttonVideoSub span {
  font-size: 14px;
  letter-spacing: 0.28px;
  color: #f4f4f4;
  opacity: 1;
  font-weight: 500;
  background: rgba(67, 66, 93, 0.5);
  padding-bottom: 5px;
  height: 40px;
  padding-top: 14px;
}

.sfProfileFormVideo video {
  object-fit: cover;
  border-radius: 5px !important;
}

.sfFormProfile .v-tab {
  box-shadow: none;
}
.sfFormProfile .theme--light.v-tabs .v-tab--active:focus::before {
  opacity: 0;
}

.sfFormProfile
  .theme--light.v-text-field--solo
  > .v-input__control
  > .v-input__slot {
  background: none;
}

.sfHelperCharacters {
  text-align: right !important;
  letter-spacing: 0px !important;
  color: #43425d;
  opacity: 0.5 !important;
  font-size: 10px !important;
}

.sfInputcredentialClass .v-label.theme--light,
.sfInputWorkClass .v-label.theme--light,
.sfInputBackgroundClass .v-label.theme--light,
.sfInputElevatorClass .v-label.theme--light,
.sfInputTaglineClass .v-label.theme--light {
  white-space: break-spaces;
  height: auto;
  letter-spacing: 0px !important;
  color: #a2a2a2 !important;
  opacity: 0.5 !important;
  font-size: 12px !important;
  font-family: "Montserrat", sans-serif !important;
}

#profile-pic2.overlay-upload-btn .hoverProfile {
  display: block;
  color: #fff !important;
}
#profile-pic2.overlay-upload-btn .hoverProfile a,
#profile-pic2.overlay-upload-btn .hoverProfile {
  color: #fff !important;
}

.sfFormProfileMo #profile-pic2.overlay-upload-btn .hover {
  left: unset;
  margin: 0px auto;
  bottom: 0px;
}
.sfFormProfileMo #profile-pic2 .sfHoverdiv {
  margin: 0px auto;
  width: 144px;
}

.hover-text-success {
  display: block;
  background: none !important;
  bottom: -32px !important;
  font-size: 14px !important;
  margin: 0 1em 1em 0;
  border-bottom-left-radius: 90px;
  border-bottom-right-radius: 90px;
  width: 144px;
  height: 68px;
  position: absolute;
  color: #38c172 !important;
  left: 0px;
  text-align: center;
  cursor: pointer;
}
.sfFormProfileMo .hover-text-success {
  width: 100%;
  margin: 0px auto;
}
.sfFormProfileMo .float-left.text-danger.small,
.sfFormProfile .float-left.text-danger.small {
  font-size: 12px;
}

.sfProfileVideoBox .v-btn__content{
 
    
    
 color: #43425d !important;
    background: none !important;
    font-weight: 500 !important;
    font-size: 12px !important;
            
}


.sfProfileVideoBoxMob .v-btn__content{
 
    
    
    font-weight: 500 !important;
    font-size: 12px !important;
    height: 40px;
    border-radius: 0px 0px 5px 5px;
    color: #fff !important;
        background: rgba(67, 66, 93, 0.5) !important;
            bottom: -8px;
}
.sfProfileFormVideoBox{
      margin-top: 29px;
}
.sfProfileFormVideoBox .file-uploads{
      /* left: 27px !important; */
}

.sfProfileFormVideoBox .file-uploads .v-btn span{
  bottom: 18px;
}
.sfProfileFormVideoBox .v-btn__content{
    
    /* top: 57px; */
       
}

.sfProfileFormVideoBox  .buttonVideoSub.v-btn .v-btn__content {
    /* left: -3px !important; */
    bottom: 2px;
}


/* .v-card {
  width: 375px !important;
  max-width: 375px !important;
} */
.v-tab:before {
  background-color: transparent !important;
}
.sfProfileFormAudio .theme--light.v-btn:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined),
.sfFormProfile .theme--light.v-btn:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined)
{
  outline: none;

}
/* .buttonVideoIco:le{
  background: none !important; */
/* } */
.msnInput{
  font-size: 10px;
  text-align: center;
  margin-top: 36px !important;
  line-height: 11px;
}

.sfFormProfile .sfProfileAudiotOP .theme--light.v-btn:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined){
  background: #fff;
}

.sfFormProfile .sfProfileVideotOP .theme--light.v-btn:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined){
      padding: 0px;
}


.buttonAudioEmpty.v-btn:not(.v-btn--round).v-size--default{
top: 38px;
height: 0px !important;
}
.buttonVideoEmpty.v-btn:not(.v-btn--round).v-size--default{
   height: 0px !important;
}


.buttonVideoSubEmpty.v-btn:not(.v-btn--round).v-size--default{
   height: 0px !important;
   top: 115px;
}


.sfProfileVideoBoxMob.v-btn:not(.v-btn--round).v-size--default{
   height: 0px !important;
    padding-left: 0px;
    padding-right: 0px;
    width: 100%   ;
    bottom: 9px;
}

.buttonVideoEmpty{
    top: 115px;
    left: 4px !important;
    height: 0px !important;
}
.sfProfileFormAudioDownColor .v-btn__content
{
  
  background: #f4f4f4 !important;
}
.sfProfileFormAudio .file-uploads{
  position: absolute !important;
    bottom: 0px;
    top: 76px;
}

.sfProfileFormAudioDown .file-uploads{
   top: 55px !important;
}


.sfProfileFormAudio .buttonVideo,
.sfProfileFormAudioDownColor .v-btn{
 
    top: 0px;
}
.sfProfileFormAudio .audio_upload_top1{
 
    top: -53px;
}

.sfProfileFormAudioDownMob.file-uploads .v-tb{
  top: 38px;
}

.videoDialog{
      max-width: fit-content;
}
/* .sfProfileAudioBox .file-uploads{

width: unset !important;


} */
</style>
