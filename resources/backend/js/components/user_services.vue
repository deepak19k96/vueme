<template>
  <div>
    <form class="form-dashboard" @submit="updateUserServices">
      <v-container class="row-gray-area p-0">
        <v-row no-gutters>
          <v-col class="px-lg-0 px-md-0">
            <div class="my-3">
              <b>Configure Services</b>
            </div>
          </v-col>
        </v-row>
        <v-row class="pb-2 d-none d-sm-flex" no-gutters>
          <v-col cols="3" class="small grey--text">Services</v-col>
          <v-col cols="5" class="small grey--text">Rate</v-col>
          <v-col cols="2" class="small grey--text">Minimum Duration</v-col>
          <v-col cols="2" class="small grey--text justify-center d-flex">Active</v-col>
        </v-row>
      </v-container>
      <v-container v-if="$vuetify.breakpoint.mdAndUp" class="white">
        <v-row class="pt-3" v-for="(an_s, index) in services" :key="an_s.name" no-gutters>
          <v-col
            cols="3"
            class="pt-2"
            :class="[user_service[an_s.id ].active ? 'primary--text' : '']"
          >
            <i :class="an_s.icon" style="margin-right: 5px;"></i>
            {{ an_s.name }}
          </v-col>
          <v-col cols="4" class="rate">
            <v-text-field
              background-color="#EBF4FD"
              solo
              dense
              filled
              hide-details
              :disabled="an_s.id == 2 && free_chat"
              flat
              v-model="user_service[ an_s.id ].rate"
              prefix="$"
              :placeholder="an_s.min_rate"
              :suffix="rate_suffix(an_s.id)"
              type="number"
              step=".01"
              class="inputBlueClass"
            >
              <!-- <template v-slot:append-outer>
                                <div class="mt-1 grey&#45;&#45;text">{{rate_suffix(an_s.id)}}</div>
              </template>-->
            </v-text-field>
            <v-checkbox
              v-if="an_s.id == 2"
              label="Offer chat for free"
              color="none"
              hide-details
              class="mt-0 checkBoxRem"
              v-model="free_chat"
              @change="user_service[2].rate = 0"
            ></v-checkbox>
            <span
              v-if="errors['user_services.'+index+'.rate']"
              class="float-left text-danger small"
            >{{ errors['user_services.'+index+'.rate'][0] }}</span>
          </v-col>
          <v-col cols="3" class>
            <!-- <v-text-field
              v-if="an_s.enable_duration"
              background-color="#F0F0F7"
              solo
              dense
              filled
              hide-details
              suffix="minute(s)"
              flat
              type="number"
              v-model="user_service[ an_s.id ].min_duration"
            ></v-text-field>-->
            <v-select
              v-model="user_service[ an_s.id ].min_duration"
              v-if="an_s.enable_duration"
              class="blueCheckList"
              :menu-props="{contentClass: 'checkBoxMinBlue'}"
              :items="minutes"
              solo
              background-color="#ebf4fd"
            >
              <!-- <template v-slot:item="data">
                <v-checkbox :label="data.item.text" hide-details class="m-0" style="padding-bottom:2px !important; padding-top:2px !important;"></v-checkbox>
              </template>-->
            </v-select>
            <span
              v-if="errors['user_services.'+index+'.min_duration'] && an_s.enable_duration"
              class="float-left text-danger small"
            >{{ errors['user_services.'+index+'.min_duration'][0] }}</span>
          </v-col>
          <v-col cols="2" class="justify-center d-flex">
            <v-switch
              class="ml-8 service_switch"
              style="margin-top: -5px !important"
              color="#49C874"
              v-model="user_service[ an_s.id ].active"
              :dense="true"
              inset
              :ripple="false"
            ></v-switch>
          </v-col>

          <v-col v-if="index + 1 < services.length" cols="12">
            <v-divider></v-divider>
          </v-col>
        </v-row>
        <v-row no-gutters v-if="browserSupported.length > 0">
        <v-col cols="1" style="max-width: 40px;">
        <v-icon class="mr-2 text-danger" style="margin-bottom: 2px;">mdi-alert-box-outline</v-icon>
        </v-col>
         <v-col>
        <span class="grey--text" style="font-size:14px">{{browserSupported[1]}}</span>
        <div class="mt-1" v-if="browserSupported[2] != ''" style="font-size:14px"><a target="_blank" style="color:rgb(142, 190, 248)!important" :href="browserSupported[3]">{{browserSupported[2]}}</a></div>
        </v-col>
        </v-row>
      </v-container>
      <v-container v-if="$vuetify.breakpoint.smAndDown" class="white">
        <v-row class="pt-3" v-for="(an_s, index) in services" :key="an_s.name" no-gutters>
          <v-col
            cols="6"
            class="pt-2"
            :class="[user_service[an_s.id ].active ? 'primary--text' : '']"
          >
            <i
              v-show="an_s.id == 1"
              class="fas fa-phone fa-flip-horizontal"
              style="margin-right: 5px;"
            ></i>
            <i v-show="an_s.id == 2" class="fas fa-comments" style="margin-right: 5px;"></i>
            <i v-show="an_s.id == 3" class="fas fa-video" style="margin-right: 5px;"></i>
            {{ an_s.name }}
          </v-col>
          <v-col cols="6" class="justify-end d-flex">
            <v-switch
              class="mt-1 ml-8 service_switch"
              color="#49C874"
              v-model="user_service[ an_s.id ].active"
              :dense="true"
              inset
              :ripple="false"
            ></v-switch>
          </v-col>
          <v-col cols="6" class>
            <span class="grey--text small">Rate</span>
            <v-text-field
              background-color="#F0F0F7"
              solo
              dense
              filled
              hide-details
              :suffix="rate_suffix(an_s.id)"
              :disabled="an_s.id == 2 && free_chat"
              flat
              v-model="user_service[ an_s.id ].rate"
              prefix="$"
            ></v-text-field>
            <v-checkbox
              v-if="an_s.id == 2"
              label="Offer chat for free"
              color="none"
              hide-details
              class="mt-0"
              v-model="free_chat"
              @change="user_service[2].rate = 0"
            ></v-checkbox>
            <span
              v-if="errors['user_services.'+index+'.rate']"
              class="float-left text-danger small"
            >{{ errors['user_services.'+index+'.rate'][0] }}</span>
          </v-col>
          <v-col cols="6" class>
            <span class="grey--text small" v-if="an_s.enable_duration ">Min. Duration</span>
            <!-- <v-text-field v-if="an_s.enable_duration"
                                      background-color="#F0F0F7"
                                      solo
                                      dense
                                      suffix="minute(s)"
                                      filled
                                      hide-details
                                      flat
                                      v-model="user_service[ an_s.id ].min_duration"

            ></v-text-field>-->
            <v-select
              v-model="user_service[ an_s.id ].min_duration"
              :menu-props="{contentClass: 'checkListGray-line'}"
              v-if="an_s.enable_duration"
              :items="minutes"
              solo
              background-color="#F0F0F8"
            >
              <!-- <template v-slot:item="data">
                <v-checkbox :label="data.item.text" hide-details class="mt-3"></v-checkbox>
              </template>-->
            </v-select>
            <span
              v-if="errors['user_services.'+index+'.min_duration'] && an_s.enable_duration"
              class="float-left text-danger small"
            >
            {{ errors['user_services.'+index+'.min_duration'][0] }}
            </span>
          </v-col>

          <v-col v-if="index + 1 < services.length" cols="12">
            <v-divider></v-divider>
          </v-col>
        </v-row>
         <v-row no-gutters v-if="browserSupported.length > 0">
        <v-col cols="1">
        <v-icon class="mr-2 text-danger" style="margin-bottom: 2px;">mdi-alert-box-outline</v-icon>
        </v-col>
         <v-col>
        <span class="grey--text" style="font-size:14px">{{browserSupported[1]}}</span>
        <div class="mt-1" v-if="browserSupported[2] != ''" style="font-size:14px;"><a target="_blank" style="color:rgb(142, 190, 248)!important"  :href="browserSupported[3]">{{browserSupported[2]}}</a></div>
        </v-col>
        </v-row>
      </v-container>

      <v-container class="row-gray-area p-0 mt-7 mb-7">
        <v-row no-gutters>
          <v-col class="px-lg-0 px-md-0" cols="12">
            <div class="subtitle-1 mb-0">
              <v-btn style="min-width: auto !important; padding: 10px 20px !important;"
                type="submit"
                color="primary"
                :loading="savingUserServices"
                :disabled="savingUserServices"
                rounded
              >Save Services</v-btn>

              <span style="color: #01BF16; font-size: 75%;" v-if="usSaved">Successfully Saved.</span>
            </div>
          </v-col>
        </v-row>
      </v-container>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      free_chat: true,
      savingUserServices: false,
      usSaved: false,
      services: [],
      user_services: [],
      user_service: {},
      browserSupported: [],
      user_id: 0,
      errors: {
        user_services: [],
      },
      message: "",
    };
  },

  methods: {
    rate_suffix(id) {
      if (id == 2) {
        return "per message";
      } else {
        return "per minute";
      }
    },
    /**
     * Prepare the component.
     */
    getServices() {
      axios
        .get("/api/v1/user/services")
        .then((response) => {
          this.services = response.data.success.services;
          this.user_services = response.data.success.user_services;
          this.user_id = response.data.success.user_id;
          this.free_chat = response.data.success.free_chat;
          this.browserSupported = response.data.success.browserSupported;

          if (this.user_services.length == 0) {
            this.services.forEach((the_s) => {
              this.user_services.push({
                service_id: the_s.id,
                active: false,
                rate: 0,
                min_duration: 0,
              });
            });
          }

          for (var index_us in this.user_services) {
            var the_s = this.user_services[index_us];

            this.user_service[the_s.service_id] = the_s;
          }
        })
        .catch(function (error) {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            //location.reload();
          }
        });
    },
    updateUserServices(e) {
      e.preventDefault();

      this.savingUserServices = true;

      for (var index_us in this.user_services) {
        var the_s = this.user_services[index_us];

        if (!the_s.active && the_s.rate == "") {
          the_s.rate = 0;
        }

        if (!the_s.active && the_s.min_duration == "") {
          the_s.min_duration = 0;
        }
      }

      axios
        .post("/api/v1/user/services/save", {
          user_id: this.user_id,
          user_services: this.user_services,
          free_chat: this.free_chat,
        })
        .then((response) => {
          setTimeout(() => {
            this.savingUserServices = false;
            this.usSaved = true;

            setTimeout(() => {
              this.usSaved = false;
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
          } else {
            this.errors = ["Something went wrong. Please try again."];
          }

          this.savingUserServices = false;
          this.message = "";
        });
    },
  },
  computed: {
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
  },
  mounted() {
    this.getServices();

    if (
      location.pathname == "/dashboard/services" ||
      location.pathname == "/dashboard/services/"
    ) {
      document.querySelectorAll("#sidebar-call-text-video").forEach((ele) => {
        ele.style.display = "none";
      });

      document.querySelectorAll("#online-dropdown").forEach((ele) => {
        ele.style.display = "none";
      });
    }
  },
};
</script>
<style>
.rate input[type="number"]::-webkit-inner-spin-button {
  display: none;
  -webkit-appearance: none;
}

.v-text-field--filled.v-text-field--single-line.v-input--dense input,
.v-text-field--full-width.v-text-field--single-line.v-input--dense input {
  margin-top: 0px !important;
}
.v-application--is-ltr .v-text-field__suffix {
  padding-right: 10px;
}
</style>
