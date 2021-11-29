<template>
  <div v-if="!loading">
    <form class="form-dashboard" @submit="updateProfile">
      <div class="row">
        <!--<div class="col-12"><span class="subtitle-1 primary&#45;&#45;text">Please tell us about you</span></div>
        <div class="col-12"><hr></div>-->
        <div class="col-12">
          <span class="subtitle-1">About</span>
        </div>
        <div class="col-12 my-5">
          <div style="position: relative; margin-bottom: 20px ">
            <div id="profile-pic" class="overlay-upload-btn d-flex align-center">
              <div
                :aria-label="user.profile.display_name"
                class="user_avatar"
                :style="{ 'background-image': 'url(' + image  + ')' }"
              >
                <div class="hover">
                  <div class="btn-upload-wrapper">
                    <!--<input type="file" name="headshot_img" accept='image/*' @change="processFile($event)" data-img="profile-headshot-img" style="max-width: 100%;"/>-->
                    <input
                      data-img="profile-headshot-img"
                      accept="image/*"
                      type="file"
                      v-on:change="onFileChange"
                      id="file_upload"
                      style="max-width: 100%"
                    />
                    <br />
                    <i class="fas fa-camera"></i>
                    <br />Change
                  </div>
                </div>
              </div>

              <div class="ml-3">Profile Image</div>
            </div>
            <div style="margin-left: 80px;margin-top: -20px;">
              <v-btn
                v-if="this.saveImage"
                color="primary"
                :loading="savingImage"
                :disabled="savingImage"
                depressed
                small
                @click.prevent="upload"
              >Save</v-btn>
              <span class="text-success">{{message_upload}}</span>
            </div>
          </div>
        </div>
      </div>

      <div class="mt-5">
        <div class="row">
          <div class="col-sm-6 form-group">
            <v-text-field
              id="profile_name"
              background-color="#EBF4FD"
              label="First Name"
              solo
              dense
              flat
              filled
              hide-details
              v-model="user.profile.name"
              class="inputBlueClass"
            ></v-text-field>

            <span
              v-if="errors['profile.name']"
              class="float-left text-danger small"
            >{{ errors['profile.name'][0] }}</span>
          </div>
          <div class="col-sm-6 form-group">
            <v-text-field
              id="profile_last_name"
              class="inputBlueClass"
              background-color="#EBF4FD"
              label="Last Name"
              solo
              flat
              dense
              hide-details
              filled
              v-model="user.profile.last_name"
            ></v-text-field>
            <span
              v-if="errors['profile.last_name']"
              class="float-left text-danger small"
            >{{ errors['profile.last_name'][0] }}</span>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-3 px-3 form-group">
          <label>
            Country Code
            <span class="text-danger">*</span>
          </label>
          <v-select
            id="phone_numbers_0_code2"
            :items="country_all"
            label="Select"
            background-color="#F4F4F4"
            class="checkListDisabled"
            color="#656b72"
            filled
            flat
            item-text="prefix"
            item-value="code2"
            hide-details
            disabled
            height="32"
            dense
            solo
            auto
            autocomplete
            v-model="user.phone_numbers[0].code2"
            append-icon="ico-sort-arrows"
            :menu-props="{contentClass: 'checkList'}"
          >
            <template slot="selection" slot-scope="data">
              <!-- // HTML that describe how select should render selected items -->
              {{ data.item.country }}({{data.item.prefix}})
            </template>
            <template slot="item" slot-scope="data">
              <!-- // HTML that describe how select should render items when the select is open -->
              {{ data.item.country }}({{data.item.prefix}})
            </template>
          </v-select>
          <span
            v-if="errors['phone_numbers.0.code2']"
            class="float-left text-danger small"
          >{{ errors['phone_numbers.0.code2'][0] }}</span>
        </div>

        <div class="col-sm-3 form-group">
          <label>Mobile</label>
          <v-text-field
            id="phone_numbers_0_number"
            background-color="#F4F4F4"
            color="#656b72"
            label="(555) 555-5555"
            solo
            flat
            dense
            disabled
            hide-details
            filled
            type="tel"
            v-model="user.phone_numbers[0].number"
            class="inputFontDisabled"
          ></v-text-field>
          <span
            v-if="errors['phone_numbers.0.number']"
            class="float-left text-danger small"
          >{{ errors['phone_numbers.0.number'][0] }}</span>
        </div>
        <div class="col-sm-6 form-group">
          <label>Email</label>
          <v-text-field
            id="email"
            background-color="#F4F4F4"
            label="Email Address"
            solo
            flat
            dense
            hide-details
            disabled
            filled
            v-model="user.email"
            class="inputFontDisabled"
          ></v-text-field>
          <span v-if="errors.email" class="float-left text-danger small">{{ errors.email[0] }}</span>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label>City</label>
            <v-text-field
              id="profile_city"
              background-color="#EBF4FD"
              solo
              flat
              hide-details
              dense
              filled
              v-model="user.profile.city"
              class="inputBlueClass"
            ></v-text-field>
            <span
              v-if="errors['profile.city']"
              class="float-left text-danger small"
            >{{ errors['profile.city'][0] }}</span>
          </div>
          <div class="row form-group">
            <div class="col-sm-6 px-3 form-group">
              <label>Date of Birth</label>
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
                class="inputBlueClass"
              ></v-text-field>
              <!-- <v-menu
                                    ref="datepicker_menu"
                                    v-model="datepicker_menu"
                                    :close-on-content-click="false"
                                    transition="scale-transition"
                                    offset-y
                                    full-width
                                    min-width="290px"
                            >
                                <template v-slot:activator="{ on }">
                                    <v-text-field id="profile_birth_date"
                                                  background-color="#F4F4F4"
                                                  label="01/01/2001"
                                                  solo
                                                  flat
                                                  dense
                                                  hide-details
                                                  filled
                                                  v-on="on"
                                                  v-model="computedDateOfBirth"
                                    ></v-text-field>
                                </template>

                                <v-date-picker
                                        ref="picker"
                                        v-model="user.profile.birth_date"
                                        :max="new Date().toISOString().substr(0, 10)"
                                        min="1950-01-01"
                                        @change="save"
                                ></v-date-picker>
              </v-menu>-->

              <span
                v-if="errors['profile.birth_date']"
                class="float-left text-danger small"
              >{{ errors['profile.birth_date'][0] }}</span>
            </div>
            <div class="col-sm-6 px-3 form-group">
              <label>Gender</label>
              <v-select
                id="profile_gender"
                :items="gender"
                label="Select"
                background-color="#ebf4fd"
                color="#1f1e34"
                filled
                flat
                hide-details
                dense
                solo
                v-model="user.profile.gender"
                append-icon="ico-sort-arrows"
                class="blueCheckList"
                :menu-props="{contentClass: 'checkList-lineBlue'}"
              ></v-select>
              <span
                v-if="errors['profile.gender']"
                class="float-left text-danger small"
              >{{ errors['profile.gender'][0] }}</span>
            </div>
          </div>
        </div>
        <div class="col-sm-6 form-group">
          <div class="row">
            <div class="col-sm-6 px-3 form-group">
              <label>Country</label>
              <v-select
                id="profile_country"
                :items="countries"
                label="Select"
                background-color="#ebf4fd"
                filled
                dense
                flat
                hide-details
                item-value="code"
                item-text="name"
                solo
                append-icon="ico-sort-arrows"
                v-model="user.profile.country"
                class="blueCheckList"
                :menu-props="{contentClass: 'checkList-lineBlue'}"
              ></v-select>

              <span
                v-if="errors['profile.country']"
                class="float-left text-danger small"
              >{{ errors['profile.country'][0] }}</span>
            </div>

            <div class="col-sm-6 px-3 form-group" v-if="user.profile.country == 'US'">
              <label>State</label>
              <v-select
                id="profile_state"
                :items="states"
                label="Select"
                background-color="#ebf4fd"
                filled
                flat
                dense
                hide-details
                item-value="code"
                item-text="name"
                solo
                v-model="user.profile.state"
                append-icon="ico-sort-arrows"
                class="blueCheckList"
                :menu-props="{contentClass: 'checkList-lineBlue'}"
              ></v-select>

              <span
                v-if="errors['profile.state']"
                class="float-left text-danger small"
              >{{ errors['profile.state'][0] }}</span>
            </div>

            <div class="col-sm-6 px-3 form-group">
              <label>
                Timezone
                <span class="text-danger">*</span>
              </label>
              <v-select
                id="profile_timezone"
                :items="timezonesok"
                label="Select"
                background-color="#ebf4fd"
                filled
                dense
                flat
                hide-details
                solo
                v-model="user.profile.timezone"
                required
                append-icon="ico-sort-arrows"
                class="blueCheckList"
                :menu-props="{contentClass: 'checkList-lineBlue'}"
              ></v-select>

              <span
                v-if="errors['profile.timezone']"
                class="float-left text-danger small"
              >{{ errors['profile.timezone'][0] }}</span>
            </div>
          </div>
        </div>
      </div>
      <!--<div class="row">
                <div class="col-lg-12 col-md-12 form-group">
                    <hr>
                    <label>Bio</label>

                    <v-textarea
                            id="profile_description"
                            v-model="user.profile.description"
                            solo
                            flat
                            background-color="#F4F4F4"
                            filled
                            name="input-7-4"
                            hide-details
                            label=""
                    ></v-textarea>
                    <span v-if="errors['profile.description']" class="float-left text-danger small">{{ errors['profile.description'][0] }}</span>
                </div>

      </div>-->

      <div class="form-group mt-5">
        <!-- <button type="submit" class="btn btn-pink">Save</button> -->

        <v-btn  style="height: auto!important; min-width: auto !important; padding: 10px 20px !important;"
          type="submit"
          color="primary"
          rounded
          :loading="savingProfile"
          :disabled="savingProfile"
        >Save Information</v-btn>

        <span style="color: #01BF16; font-size: 75%;" v-if="profileSaved">Successfully Saved.</span>
      </div>
    </form>
  </div>
</template>

<script>
import moment from "moment";
const csrf = $('meta[name="csrf-token"]').attr("content");
export default {
  props: ["countries", "states", "timezones", "country_all"],
  data() {
    return {
      datepicker_menu: false,
      loading: true,
      savingProfile: false,
      profileSaved: false,
      user: { phone_numbers: [{ number: "" }] },
      profileObj: {},
      profile: {},
      errors: [],
      message: "",
      message_upload: "",
      gender: ["Male", "Female", { text: "Prefer Not to Say", value: null }],
      saveImage: false,
      savingImage: false,
      fileUploadFormData: new FormData(),
      image: "",
      edit_specialties: false,
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
    };
  },
  watch: {
    datepicker_menu(val) {
      val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
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
    save(date) {
      this.$refs.datepicker_menu.save(date);
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
    upload() {
      /* var data = new FormData();
                 data.append('image', this.image);*/
      this.savingImage = true;
      axios
        .post("/api/v1/user/profile/images/save", this.fileUploadFormData)
        .then((response) => {
          
          this.message_upload = response.data.success.message;
          document.querySelector("#profile .v-image__image--cover").style.backgroundImage = "url('" + response.data.success.url + "')";
          // document.querySelector(
          //   ".row-top-bar .user_avatar_sm"
          // ).style.backgroundImage = "url('" + response.data.success.url + "')";
          // setTimeout(() => {
          //   this.message_upload = "";
          // }, 2000);

          this.errors = [];
          this.savingImage = false;
          this.saveImage = false;
          // EventBus.$emit('profile_upload', response.data.path);
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
          this.savingImage = false;
          this.saveImage = false;
        });
    },
    /**
     * Prepare the component.
     */
    getProfile() {
      axios
        .get("/api/v1/user/profile")
        .then((response) => {
          this.user = response.data.success.profile;
          // this.profile = response.data.success.profile.profile;
          this.image = this.user.profile.profile_headshot_url;

          this.loading = false;

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
    updateProfile(e) {
      e.preventDefault();

      this.savingProfile = true;

      var input = this.user;

      axios
        .post("/api/v1/basicuser/profile/save", input)
        .then((response) => {
          setTimeout(() => {
            this.savingProfile = false;
            this.profileSaved = true;
            if (response.data && response.data.success) {
              /*document.querySelector("#sidebar #profile img").src =
                response.data.success.profile.profile_headshot_url;
              document.querySelector("#mobile-profile").src =
                response.data.profile.success.profile_headshot_url;*/
            }

            setTimeout(() => {
              this.profileSaved = false;
            }, 2000);
          }, 1000);

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

            $("html, body").animate(
              {
                scrollTop: $("#" + str).offset().top - 100,
              },
              1000
            );
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
    onFileChange(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.createImage(files[0]);
      this.fileUploadFormData.delete("headshot");
      this.fileUploadFormData.append("headshot", files[0]);
      this.saveImage = true;
    },
    createImage(file) {
      let reader = new FileReader();
      let vm = this;
      reader.onload = (e) => {
        vm.image = e.target.result;
      };
      reader.readAsDataURL(file);
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
  }
  /**
   * Prepare the component (Vue 2.x).
   */,
  mounted() {
    this.getProfile();
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
