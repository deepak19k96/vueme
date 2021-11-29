<template>
  <div>
    <v-dialog v-model="newProfileDialog" width="335" height="350">
      <v-card class="newProfileDataVCard">
        <v-card-title class="newProfileDataVCTitle text-center justify-center"
          >Better Than Personalized, <br />New Profiles Get
          Personal</v-card-title
        >
        <v-card-text class="newProfileDataVCText1 text-center">
          Take advantage now, your upgraded profile page awaits! Be first to
          launch the new look, get seen by more clients.
        </v-card-text>

        <v-flex
          class="d-flex align-sm-center justify-sm-center align-center justify-center pb-5"
        >
          <a href="/dashboard/profile" @click="newProfileDialog = false"
            ><v-btn class="newProfileDataVBtn rounded-pill" color="primary" dark
              >Launch</v-btn
            ></a
          >
        </v-flex>
        <v-spacer></v-spacer>
      </v-card>
    </v-dialog>

    <!--v-dialog for the new profile fields-->
    <div
      class="d-block d-md-none"
      v-if="$vuetify.breakpoint.smAndDown && !display"
    >
      <p-header-data v-bind:user="this.user"></p-header-data>
    </div>
    <div class="container mb-0 pb-0 pt-0 pl-0">
      <div :style="[!$vuetify.breakpoint.xsOnly ? {'top':space_header+'px'}:{}]" :class="{ stickyTop: !$vuetify.breakpoint.xsOnly }">
        <div class="row row-gray-area mt-0" v-if="!display">
          <v-row class="ml-0 mr-0 mt-0">
            <v-col :cols="12">
              <span class="h2Title" style="font-size: 14px !important"
                >Appointments</span
              >
            </v-col>
          </v-row>
        </div>

        <div class="row row-gray-area">
          <v-row
            class="ml-0 mr-0 mb-1 mt-0"
            v-if="$vuetify.breakpoint.smAndDown && display"
          >
            <date-pick
              v-model="datePicker"
              :hasInputElement="false"
              :weekdays="['M', 'T', 'W', 'T', 'F', 'S', 'S']"
              :startWeekOnSunday="true"
            ></date-pick>
            <!-- <v-date-picker v-model="datePicker" :events="appoimentsCheck" no-title :picker-date.sync="month"
          ></v-date-picker>-->
          </v-row>
          <v-row
            class="ml-0 mr-0 pb-0 mb-0"
            style="margin: 20px 0px; padding-bottom: 20px !important"
            :style="[
              $vuetify.breakpoint.xsOnly
                ? { 'padding-bottom': '20px !important' }
                : { 'padding-bottom': '0px !important' },
            ]"
          >
            <v-col :sm="6" v-if="$vuetify.breakpoint.smAndDown">
              <v-checkbox
                class="checkboxList"
                background-color="white"
                v-model="display"
                label="Calendar View"
                :style="[
                  !$vuetify.breakpoint.smAndDown
                    ? { width: '135px !important' }
                    : { width: '135px !important' },
                ]"
              ></v-checkbox>
            </v-col>
            <v-col :sm="2" :lg="2" class="text-lg-right text-center">
              <v-select
                v-model="status"
                :items="appointment_list"
                label="Show all"
                item-text="name"
                item-value="key"
                background-color="white"
                multiple
                filled
                dense
                solo
                selectSlot="true"
                v-on:change="filterAppointments"
                append-icon="ico-sort-arrows"
                :style="[
                  !$vuetify.breakpoint.smAndDown
                    ? { width: '135px !important' }
                    : { width: '135px !important', float: 'right' },
                ]"
                class="checkboxList"
                :menu-props="{ contentClass: 'checkList' }"
              >
                <template v-slot:selection="{ item, index }">
                  <div v-if="status.length <= 1" class>{{ item.name }}</div>
                  <span v-if="index === 1">Show Filtered</span>
                </template>
              </v-select>
            </v-col>
            <v-col
              :lg="10"
              class="textList pt-0"
              v-if="!$vuetify.breakpoint.xsOnly"
            >
              <span class="mr-4 ml-4">
                <v-avatar
                  class="mr-1 ml-lg-0 ml-0 mb-1"
                  color="#f9a825"
                  size="10"
                >
                  <span class="white--text headline"></span>
                </v-avatar>
                <span>Pending</span>
              </span>

              <span class="mr-4 ml-4">
                <v-avatar
                  class="mr-1 ml-lg-0 ml-1 mb-1"
                  color="#00c853"
                  size="10"
                >
                  <span class="white--text headline"></span>
                </v-avatar>
                <span>Confirmed</span>
              </span>

              <span class="mr-4 ml-4">
                <v-avatar
                  class="mr-1 ml-lg-0 ml-1 mb-1"
                  color="#4899FA"
                  size="10"
                >
                  <span class="white--text headline"></span>
                </v-avatar>
                <span>Completed</span>
              </span>

              <span class="mr-4 ml-4">
                <v-avatar
                  class="mr-1 ml-lg-0 ml-1 mb-1"
                  color="#F05252"
                  size="10"
                >
                  <span class="white--text headline"></span>
                </v-avatar>
                <span>Cancelled</span>
              </span>
            </v-col>
          </v-row>
        </div>
      </div>

      <div class="row row-gray-area">
        <v-row class="ml-0 mr-0">
          <v-col
            style="height: 100%; min-height: calc(100vh - 176px)"
            :lg="7"
            :md="7"
            :sm="12"
          >
            <!-- TODO Appointments all -->

            <span v-if="focus != today">
              <v-row no-gutters class="pb-3">
                <v-col
                  class="d-flex justify-content-between"
                  style="
                    font-size: 12px;
                    padding-left: 0px !important;
                    padding-right: 0px !important ;
                    color: #656b72 !important;
                  "
                >
                  <span>
                    <span>{{ focus | formatDate("MMMM D") }}</span>
                  </span>

                  <span class="text-right">
                    <span v-if="today_appointments.length == 1"
                      >{{ today_appointments.length }} event</span
                    >
                    <span v-else>{{ today_appointments.length }} events</span>
                  </span>
                </v-col>
              </v-row>

              <!-- Appointments for specific date -->
              <div
                v-for="appointment in today_appointments"
                :key="appointment.id"
              >
                <v-card
                  flat
                  :style="{
                    borderLeft: '5px solid ' + status_color(appointment.status),
                  }"
                >
                  <v-row
                    class="py-3 mb-4 v-badge-list"
                    no-gutters
                    style="border-bottom: solid 1px #eee"
                  >
                    <v-col :lg="1" :md="1" :cols="1" class="pl-3">
                      <v-avatar size="40">
                        <v-img
                          :src="appointment.user.profile.profile_headshot_url"
                        ></v-img>
                      </v-avatar>
                    </v-col>

                    <v-col
                      :lg="11"
                      :md="10"
                      :cols="11"
                      :class="
                        !$vuetify.breakpoint.xsOnly ? 'pr-0 pl-6' : 'pr-0 pl-10'
                      "
                    >
                      <div class="h2Title">
                        {{ appointment.user.profile.name }}
                      </div>
                      <div class="textList subList">
                        {{ appointment.date | formatDate("MMMM D") }},
                        {{ appointment.start | formatDate("h:mm a") }},
                        {{ appointment.duration | ftime }} minutes,
                        {{ appointment.status }}
                      </div>
                      <div class="textList servList">
                        {{ appointment.service.name }},
                        {{ appointment.category.description }}
                      </div>
                    </v-col>

                    <!-- FIXME MODAL NEW STARTS -->

                    <v-container
                      v-if="selectedEvent.id == appointment.id"
                      class="m-0 p-0 mt-2"
                    >
                      <v-row class="m-0 white p-0" no-gutters>
                        <v-col :lg="6" :md="6" :sm="12" cols="12">
                          <v-text-field
                            v-model="appointment.category.name"
                            class="textList inputDesign"
                            filled
                            label="Category"
                            readonly
                            :disabled="true"
                            dense
                            solo
                            hide-details
                          ></v-text-field>
                          <span
                            v-if="errors['name']"
                            class="float-left text-danger small"
                            >{{ errors["name"][0] }}</span
                          >
                        </v-col>

                        <v-col :lg="6" :md="6" :sm="12" cols="12">
                          <v-menu
                            v-model="datepicker_menu"
                            :close-on-content-click="false"
                            :nudge-right="40"
                            transition="scale-transition"
                            offset-y
                            min-width="290px"
                          >
                            <template v-slot:activator="{ on }">
                              <v-text-field
                                :value="appointment.date | formatDate"
                                label="Appointment Date"
                                readonly
                                disabled
                                class="textList inputDesign"
                                filled
                                dense
                                solo
                                v-on="on"
                                hide-details
                              ></v-text-field>
                            </template>
                            <!-- <v-date-picker
                              v-model="appointment.date"
                              @input="datepicker_menu = false"
                              ></v-date-picker>-->
                          </v-menu>
                          <span
                            v-if="errors['last_name']"
                            class="float-left text-danger small"
                            >{{ errors["last_name"][0] }}</span
                          >
                        </v-col>

                        <v-col :lg="6" :md="6" :sm="12" cols="12" class="mb-1">
                          <v-text-field
                            v-model="start_time"
                            label="00:00 AM/PM"
                            class="textList inputDesign"
                            filled
                            disabled
                            dense
                            v-mask="mask"
                            type="time"
                            solo
                            hide-details
                          ></v-text-field>
                          <span
                            v-if="errors['start']"
                            class="float-left text-danger small"
                            >{{ errors["start"][0] }}</span
                          >
                        </v-col>
                        <v-col :lg="6" :md="6" :sm="12" cols="12" class="mb-1">
                          <v-text-field
                            v-model="appointment.duration"
                            class="textList inputDesign"
                            filled
                            label="Duration"
                            readonly
                            :disabled="true"
                            dense
                            solo
                            hide-details
                          ></v-text-field>

                          <span
                            v-if="errors.duration"
                            class="text-danger small"
                          >
                            {{ appointment.psychic.profile.display_name }}
                            {{ errors.duration[0] }}
                          </span>
                        </v-col>
                      </v-row>

                      <v-row class="mt-0 white p-0" no-gutters>
                        <v-col cols="4">
                          <div
                            v-if="errors.date_and_time"
                            class="form-group text-danger small"
                          >
                            {{ errors.date_and_time[0] }}
                          </div>

                          <v-btn
                            class="btnDesign"
                            rounded
                            color="primary"
                            style
                            @click="selectedEvent = {}"
                          >
                            <span>Close</span>
                          </v-btn>
                          <span class="success--text">{{ message }}</span>
                        </v-col>

                        <v-col cols="8" class="text-right">
                          <v-btn
                            class="btnDesign fa-align-right"
                            rounded
                            color="gray"
                            style
                            @click="requestReview(appointment)"
                            v-if="
                              appointment.status == 'Completed' &&
                              !appointment.review_requested
                            "
                          >
                            <span>Request review</span>
                          </v-btn>

                          <v-btn
                            v-if="appointment.status == 'Pending'"
                            class="white--text btnDesign"
                            @click="
                              updateAppointmentStatus(appointment, 'Cancelled')
                            "
                            :loading="loadingUpdate"
                            :disabled="loadingUpdate"
                            small
                            rounded
                            color="red darken-1"
                            style
                          >
                            <span>Decline</span>
                          </v-btn>

                          <v-btn
                            v-if="appointment.status == 'Pending'"
                            class="white--text btnDesign"
                            @click="
                              updateAppointmentStatus(appointment, 'Confirmed')
                            "
                            :loading="loadingUpdate"
                            :disabled="loadingUpdate"
                            small
                            rounded
                            color="green accent-4"
                            style
                          >
                            <span>Confirm</span>
                          </v-btn>
                        </v-col>
                      </v-row>
                    </v-container>
                    <!-- FIXME NEW MODAL ENDS -->
                  </v-row>
                </v-card>
              </div>

              <!-- Currently Empty  -->
              <div class v-if="today_appointments.length == 0">
                <v-card flat :style="{ borderLeft: '5px solid #A2A2A2' }">
                  <v-row class="py-5 mb-5 contentEmpty" no-gutters>
                    <v-col :lg="1" :md="1" :sm="2" cols="1"></v-col>
                    <v-col
                      :lg="9"
                      :md="9"
                      :sm="10"
                      cols="11"
                      class="pr-0 mt-4 mb-4"
                    >
                      <span>
                        <div
                          class="mr-1 ml-lg-0 ml-1"
                          style="float: left"
                          size="24"
                        >
                          <span class="far empty icoEmpty"></span>
                        </div>
                        <span class="textEmpty empty">Currently Empty</span>
                      </span>
                    </v-col>
                  </v-row>
                </v-card>
              </div>
            </span>
            <!-- Today  -->

            <span v-if="focus == today">
              <v-row no-gutters class="pb-3">
                <v-col
                  class="d-flex justify-content-between"
                  style="
                    font-size: 12px;
                    padding-left: 0px !important;
                    padding-right: 0px !important;
                    color: #656b72 !important;
                  "
                >
                  <span>
                    <span>Today</span>
                  </span>

                  <span class="text-right">
                    <span v-if="today_appointments.length == 1"
                      >{{ today_appointments.length }} event</span
                    >
                    <span v-else>{{ today_appointments.length }} events</span>
                  </span>
                </v-col>
              </v-row>
              <div
                v-for="appointment in today_appointments"
                :key="appointment.id"
              >
                <v-card
                  flat
                  :style="{
                    borderLeft: '5px solid ' + status_color(appointment.status),
                  }"
                >
                  <v-row
                    class="py-3 mb-4 v-badge-list"
                    no-gutters
                    style="border-bottom: solid 1px #eee"
                  >
                    <v-col :lg="1" :md="1" :cols="1" class="pl-3">
                      <v-avatar size="40">
                        <v-img
                          :src="appointment.user.profile.profile_headshot_url"
                        ></v-img>
                      </v-avatar>
                    </v-col>

                    <v-col
                      :lg="11"
                      :md="10"
                      :cols="11"
                      :class="
                        !$vuetify.breakpoint.xsOnly ? 'pr-0 pl-6' : 'pr-0 pl-10'
                      "
                    >
                      <div class="h2Title">
                        {{ appointment.user.profile.name }}
                      </div>
                      <div class="textList subList">
                        {{ appointment.date | formatDate("MMMM D") }},
                        {{ appointment.start | formatDate("h:mm a") }},
                        {{ appointment.duration | ftime }} minutes,
                        {{ appointment.status }}
                      </div>
                      <div class="textList servList">
                        {{ appointment.service.name }},
                        {{ appointment.category.description }}
                      </div>
                    </v-col>

                    <!-- FIXME MODAL NEW STARTS -->

                    <v-container
                      v-if="selectedEvent.id == appointment.id"
                      class="m-0 p-0 mt-2"
                    >
                      <v-row class="m-0 white p-0" no-gutters>
                        <v-col :lg="6" :md="6" :sm="12" cols="12">
                          <v-text-field
                            v-model="appointment.category.name"
                            class="textList inputDesign"
                            filled
                            label="Category"
                            readonly
                            :disabled="true"
                            dense
                            solo
                            hide-details
                          ></v-text-field>
                          <span
                            v-if="errors['name']"
                            class="float-left text-danger small"
                            >{{ errors["name"][0] }}</span
                          >
                        </v-col>

                        <v-col :lg="6" :md="6" :sm="12" cols="12">
                          <v-menu
                            v-model="datepicker_menu"
                            :close-on-content-click="false"
                            :nudge-right="40"
                            transition="scale-transition"
                            offset-y
                            min-width="290px"
                          >
                            <template v-slot:activator="{ on }">
                              <v-text-field
                                :value="appointment.date | formatDate"
                                label="Appointment Date"
                                readonly
                                disabled
                                class="textList inputDesign"
                                filled
                                dense
                                solo
                                v-on="on"
                                hide-details
                              ></v-text-field>
                            </template>
                            <v-date-picker
                              v-model="appointment.date"
                              @input="datepicker_menu = false"
                            ></v-date-picker>
                          </v-menu>
                          <span
                            v-if="errors['last_name']"
                            class="float-left text-danger small"
                            >{{ errors["last_name"][0] }}</span
                          >
                        </v-col>

                        <v-col :lg="6" :md="6" :sm="12" cols="12" class="mb-1">
                          <v-text-field
                            v-model="start_time"
                            label="00:00 AM/PM"
                            class="textList inputDesign"
                            filled
                            disabled
                            dense
                            v-mask="mask"
                            type="time"
                            solo
                            hide-details
                          ></v-text-field>
                          <span
                            v-if="errors['start']"
                            class="float-left text-danger small"
                            >{{ errors["start"][0] }}</span
                          >
                        </v-col>
                        <v-col :lg="6" :md="6" :sm="12" cols="12" class="mb-1">
                          <v-text-field
                            v-model="appointment.duration"
                            class="textList inputDesign"
                            filled
                            label="Duration"
                            readonly
                            :disabled="true"
                            dense
                            solo
                            hide-details
                          ></v-text-field>

                          <span
                            v-if="errors.duration"
                            class="text-danger small"
                          >
                            {{ appointment.psychic.profile.display_name }}
                            {{ errors.duration[0] }}
                          </span>
                        </v-col>
                      </v-row>

                      <v-row class="mt-0 white p-0" no-gutters>
                        <v-col cols="4">
                          <div
                            v-if="errors.date_and_time"
                            class="form-group text-danger small"
                          >
                            {{ errors.date_and_time[0] }}
                          </div>

                          <v-btn
                            class="btnDesign"
                            rounded
                            color="primary"
                            style
                            @click="selectedEvent = {}"
                          >
                            <span>Close</span>
                          </v-btn>
                          <span class="success--text">{{ message }}</span>
                        </v-col>

                        <v-col cols="8" class="text-right">
                          <v-btn
                            class="btnDesign fa-align-right"
                            rounded
                            color="gray"
                            style
                            @click="requestReview(appointment)"
                            v-if="
                              appointment.status == 'Completed' &&
                              !appointment.review_requested
                            "
                          >
                            <span>Request review</span>
                          </v-btn>

                          <v-btn
                            v-if="appointment.status == 'Pending'"
                            class="white--text btnDesign"
                            @click="
                              updateAppointmentStatus(appointment, 'Cancelled')
                            "
                            :loading="loadingUpdate"
                            :disabled="loadingUpdate"
                            small
                            rounded
                            color="red darken-1"
                            style
                          >
                            <span>Decline</span>
                          </v-btn>

                          <v-btn
                            v-if="appointment.status == 'Pending'"
                            class="white--text btnDesign"
                            @click="
                              updateAppointmentStatus(appointment, 'Confirmed')
                            "
                            :loading="loadingUpdate"
                            :disabled="loadingUpdate"
                            small
                            rounded
                            color="green accent-4"
                            style
                          >
                            <span>Confirm</span>
                          </v-btn>
                        </v-col>
                      </v-row>
                    </v-container>
                    <!-- FIXME NEW MODAL ENDS -->
                  </v-row>
                </v-card>
              </div>

              <!-- Currently Empty  -->

              <div class v-if="today_appointments.length == 0">
                <v-card flat :style="{ borderLeft: '5px solid #A2A2A2' }">
                  <v-row class="py-5 mb-5 contentEmpty" no-gutters>
                    <v-col :lg="1" :md="1" :sm="2" cols="1"></v-col>
                    <v-col
                      :lg="9"
                      :md="9"
                      :sm="10"
                      cols="11"
                      class="pr-0 mt-4 mb-4"
                    >
                      <span>
                        <div
                          class="mr-1 ml-lg-0 ml-1"
                          style="float: left"
                          size="24"
                        >
                          <span class="far empty icoEmpty"></span>
                        </div>
                        <span class="textEmpty empty">Currently Empty</span>
                      </span>
                    </v-col>
                  </v-row>
                </v-card>
              </div>
              <!-- End Currently Empty  -->
              <!-- EndToday  -->

              <v-row no-gutters class="pb-3">
                <v-col
                  class="d-flex justify-content-between"
                  style="
                    font-size: 12px;
                    padding-left: 0px !important;
                    padding-right: 0px !important;
                    color: #656b72 !important;
                  "
                >
                  <span>
                    <span>Tomorrow</span>
                  </span>

                  <span class="text-right">
                    <span v-if="tomorrow_appointments.length == 1"
                      >{{ tomorrow_appointments.length }} event</span
                    >
                    <span v-else
                      >{{ tomorrow_appointments.length }} events</span
                    >
                  </span>
                </v-col>
              </v-row>

              <!-- Tomorrow  -->
              <div
                v-for="appointment in tomorrow_appointments"
                :key="appointment.id"
              >
                <v-card
                  flat
                  :style="{
                    borderLeft: '5px solid ' + status_color(appointment.status),
                  }"
                >
                  <v-row
                    class="py-3 mb-4 v-badge-list"
                    no-gutters
                    style="border-bottom: solid 1px #eee"
                  >
                    <v-col :lg="1" :md="1" :cols="1" class="pl-3">
                      <v-avatar size="40">
                        <v-img
                          :src="appointment.user.profile.profile_headshot_url"
                        ></v-img>
                      </v-avatar>
                    </v-col>

                    <v-col
                      :lg="11"
                      :md="10"
                      :cols="11"
                      :class="
                        !$vuetify.breakpoint.xsOnly ? 'pr-0 pl-6' : 'pr-0 pl-10'
                      "
                    >
                      <div class="h2Title">
                        {{ appointment.user.profile.name }}
                      </div>
                      <div class="textList subList">
                        {{ appointment.date | formatDate("MMMM D") }},
                        {{ appointment.start | formatDate("h:mm a") }},
                        {{ appointment.duration | ftime }} minutes,
                        {{ appointment.status }}
                      </div>
                      <div class="textList servList">
                        {{ appointment.service.name }},
                        {{ appointment.category.description }}
                      </div>
                    </v-col>

                    <!-- FIXME MODAL NEW STARTS -->

                    <v-container
                      v-if="selectedEvent.id == appointment.id"
                      class="m-0 p-0 mt-2"
                    >
                      <v-row class="m-0 white p-0" no-gutters>
                        <v-col :lg="6" :md="6" :sm="12" cols="12">
                          <v-text-field
                            v-model="appointment.category.name"
                            class="textList inputDesign"
                            filled
                            label="Category"
                            readonly
                            :disabled="true"
                            dense
                            solo
                            hide-details
                          ></v-text-field>
                          <span
                            v-if="errors['name']"
                            class="float-left text-danger small"
                            >{{ errors["name"][0] }}</span
                          >
                        </v-col>

                        <v-col :lg="6" :md="6" :sm="12" cols="12">
                          <v-menu
                            v-model="datepicker_menu"
                            :close-on-content-click="false"
                            :nudge-right="40"
                            transition="scale-transition"
                            offset-y
                            min-width="290px"
                          >
                            <template v-slot:activator="{ on }">
                              <v-text-field
                                :value="appointment.date | formatDate"
                                label="Appointment Date"
                                readonly
                                disabled
                                class="textList inputDesign"
                                filled
                                dense
                                solo
                                v-on="on"
                                hide-details
                              ></v-text-field>
                            </template>
                            <v-date-picker
                              v-model="appointment.date"
                              @input="datepicker_menu = false"
                            ></v-date-picker>
                          </v-menu>
                          <span
                            v-if="errors['last_name']"
                            class="float-left text-danger small"
                            >{{ errors["last_name"][0] }}</span
                          >
                        </v-col>

                        <v-col :lg="6" :md="6" :sm="12" cols="12" class="mb-1">
                          <v-text-field
                            v-model="start_time"
                            label="00:00 AM/PM"
                            class="textList inputDesign"
                            filled
                            disabled
                            dense
                            v-mask="mask"
                            type="time"
                            solo
                            hide-details
                          ></v-text-field>
                          <span
                            v-if="errors['start']"
                            class="float-left text-danger small"
                            >{{ errors["start"][0] }}</span
                          >
                        </v-col>
                        <v-col :lg="6" :md="6" :sm="12" cols="12" class="mb-1">
                          <v-text-field
                            v-model="appointment.duration"
                            class="textList inputDesign"
                            filled
                            label="Duration"
                            readonly
                            :disabled="true"
                            dense
                            solo
                            hide-details
                          ></v-text-field>

                          <span
                            v-if="errors.duration"
                            class="text-danger small"
                          >
                            {{ appointment.psychic.profile.display_name }}
                            {{ errors.duration[0] }}
                          </span>
                        </v-col>
                      </v-row>

                      <v-row class="mt-0 white p-0" no-gutters>
                        <v-col cols="4">
                          <div
                            v-if="errors.date_and_time"
                            class="form-group text-danger small"
                          >
                            {{ errors.date_and_time[0] }}
                          </div>

                          <v-btn
                            class="btnDesign"
                            rounded
                            color="primary"
                            style
                            @click="selectedEvent = {}"
                          >
                            <span>Close</span>
                          </v-btn>
                          <span class="success--text">{{ message }}</span>
                        </v-col>

                        <v-col cols="8" class="text-right">
                          <v-btn
                            class="btnDesign fa-align-right"
                            rounded
                            color="gray"
                            style
                            @click="requestReview(appointment)"
                            v-if="
                              appointment.status == 'Completed' &&
                              !appointment.review_requested
                            "
                          >
                            <span>Request review</span>
                          </v-btn>

                          <v-btn
                            v-if="appointment.status == 'Pending'"
                            class="white--text btnDesign"
                            @click="
                              updateAppointmentStatus(appointment, 'Cancelled')
                            "
                            :loading="loadingUpdate"
                            :disabled="loadingUpdate"
                            small
                            rounded
                            color="red darken-1"
                            style
                          >
                            <span>Decline</span>
                          </v-btn>

                          <v-btn
                            v-if="appointment.status == 'Pending'"
                            class="white--text btnDesign"
                            @click="
                              updateAppointmentStatus(appointment, 'Confirmed')
                            "
                            :loading="loadingUpdate"
                            :disabled="loadingUpdate"
                            small
                            rounded
                            color="green accent-4"
                            style
                          >
                            <span>Confirm</span>
                          </v-btn>
                        </v-col>
                      </v-row>
                    </v-container>
                    <!-- FIXME NEW MODAL ENDS -->
                  </v-row>
                </v-card>
              </div>

              <!-- Currently Empty  -->
              <div class v-if="tomorrow_appointments.length == 0">
                <v-card flat :style="{ borderLeft: '5px solid #A2A2A2' }">
                  <v-row class="py-5 mb-5 contentEmpty" no-gutters>
                    <v-col :lg="1" :md="1" :sm="2" cols="1"></v-col>
                    <v-col
                      :lg="9"
                      :md="9"
                      :sm="10"
                      cols="11"
                      class="pr-0 mt-4 mb-4"
                    >
                      <span>
                        <div
                          class="mr-1 ml-lg-0 ml-1"
                          style="float: left"
                          size="24"
                        >
                          <span class="far empty icoEmpty"></span>
                        </div>
                        <span class="textEmpty empty">Currently Empty</span>
                      </span>
                    </v-col>
                  </v-row>
                </v-card>
              </div>
              <!-- End Currently Empty  -->
              <!-- EndTomorrow  -->

              <v-row no-gutters class="pb-3">
                <v-col
                  class="d-flex justify-content-between"
                  style="
                    font-size: 12px;
                    padding-left: 0px !important;
                    padding-right: 0px !important;
                    color: #656b72 !important;
                  "
                >
                  <span>
                    <span>{{ after_tomorrow_day }}</span>
                  </span>

                  <span class="text-right">
                    <span v-if="after_tomorrow_appointments.length == 1"
                      >{{ after_tomorrow_appointments.length }} event</span
                    >
                    <span v-else
                      >{{ after_tomorrow_appointments.length }} events</span
                    >
                  </span>
                </v-col>
              </v-row>

              <!-- After - Tomorrow  -->
              <div
                v-for="appointment in after_tomorrow_appointments"
                :key="appointment.id"
              >
                <v-card
                  flat
                  :style="{
                    borderLeft: '5px solid ' + status_color(appointment.status),
                  }"
                >
                  <v-row
                    class="py-3 mb-4 v-badge-list"
                    no-gutters
                    style="border-bottom: solid 1px #eee"
                  >
                    <v-col :lg="1" :md="1" :cols="1" class="pl-3">
                      <v-avatar size="40">
                        <v-img
                          :src="appointment.user.profile.profile_headshot_url"
                        ></v-img>
                      </v-avatar>
                    </v-col>

                    <v-col
                      :lg="11"
                      :md="10"
                      :cols="11"
                      :class="
                        !$vuetify.breakpoint.xsOnly ? 'pr-0 pl-6' : 'pr-0 pl-10'
                      "
                    >
                      <div class="h2Title">
                        {{ appointment.user.profile.name }}
                      </div>
                      <div class="textList subList">
                        {{ appointment.date | formatDate("MMMM D") }},
                        {{ appointment.start | formatDate("h:mm a") }},
                        {{ appointment.duration | ftime }} minutes,
                        {{ appointment.status }}
                      </div>
                      <div class="textList servList">
                        {{ appointment.service.name }},
                        {{ appointment.category.description }}
                      </div>
                    </v-col>

                    <!-- FIXME MODAL NEW STARTS -->

                    <v-container
                      v-if="selectedEvent.id == appointment.id"
                      class="m-0 p-0 mt-2"
                    >
                      <v-row class="m-0 white p-0" no-gutters>
                        <v-col :lg="6" :md="6" :sm="12" cols="12">
                          <v-text-field
                            v-model="appointment.category.name"
                            class="textList inputDesign"
                            filled
                            label="Category"
                            readonly
                            :disabled="true"
                            dense
                            solo
                            hide-details
                          ></v-text-field>
                          <span
                            v-if="errors['name']"
                            class="float-left text-danger small"
                            >{{ errors["name"][0] }}</span
                          >
                        </v-col>

                        <v-col :lg="6" :md="6" :sm="12" cols="12">
                          <v-menu
                            v-model="datepicker_menu"
                            :close-on-content-click="false"
                            :nudge-right="40"
                            transition="scale-transition"
                            offset-y
                            min-width="290px"
                          >
                            <template v-slot:activator="{ on }">
                              <v-text-field
                                :value="appointment.date | formatDate"
                                label="Appointment Date"
                                readonly
                                disabled
                                class="textList inputDesign"
                                filled
                                dense
                                solo
                                v-on="on"
                                hide-details
                              ></v-text-field>
                            </template>
                            <v-date-picker
                              v-model="appointment.date"
                              @input="datepicker_menu = false"
                            ></v-date-picker>
                          </v-menu>
                          <span
                            v-if="errors['last_name']"
                            class="float-left text-danger small"
                            >{{ errors["last_name"][0] }}</span
                          >
                        </v-col>

                        <v-col :lg="6" :md="6" :sm="12" cols="12" class="mb-1">
                          <v-text-field
                            v-model="start_time"
                            label="00:00 AM/PM"
                            class="textList inputDesign"
                            filled
                            disabled
                            dense
                            v-mask="mask"
                            type="time"
                            solo
                            hide-details
                          ></v-text-field>
                          <span
                            v-if="errors['start']"
                            class="float-left text-danger small"
                            >{{ errors["start"][0] }}</span
                          >
                        </v-col>
                        <v-col :lg="6" :md="6" :sm="12" cols="12" class="mb-1">
                          <v-text-field
                            v-model="appointment.duration"
                            class="textList inputDesign"
                            filled
                            label="Duration"
                            readonly
                            :disabled="true"
                            dense
                            solo
                            hide-details
                          ></v-text-field>

                          <span
                            v-if="errors.duration"
                            class="text-danger small"
                          >
                            {{ appointment.psychic.profile.display_name }}
                            {{ errors.duration[0] }}
                          </span>
                        </v-col>
                      </v-row>

                      <v-row class="mt-0 white p-0" no-gutters>
                        <v-col cols="4">
                          <div
                            v-if="errors.date_and_time"
                            class="form-group text-danger small"
                          >
                            {{ errors.date_and_time[0] }}
                          </div>

                          <v-btn
                            class="btnDesign"
                            rounded
                            color="primary"
                            style
                            @click="selectedEvent = {}"
                          >
                            <span>Close</span>
                          </v-btn>
                          <span class="success--text">{{ message }}</span>
                        </v-col>

                        <v-col cols="8" class="text-right">
                          <v-btn
                            class="btnDesign fa-align-right"
                            rounded
                            color="gray"
                            style
                            @click="requestReview(appointment)"
                            v-if="
                              appointment.status == 'Completed' &&
                              !appointment.review_requested
                            "
                          >
                            <span>Request review</span>
                          </v-btn>

                          <v-btn
                            v-if="appointment.status == 'Pending'"
                            class="white--text btnDesign"
                            @click="
                              updateAppointmentStatus(appointment, 'Cancelled')
                            "
                            :loading="loadingUpdate"
                            :disabled="loadingUpdate"
                            small
                            rounded
                            color="red darken-1"
                            style
                          >
                            <span>Decline</span>
                          </v-btn>

                          <v-btn
                            v-if="appointment.status == 'Pending'"
                            class="white--text btnDesign"
                            @click="
                              updateAppointmentStatus(appointment, 'Confirmed')
                            "
                            :loading="loadingUpdate"
                            :disabled="loadingUpdate"
                            small
                            rounded
                            color="green accent-4"
                            style
                          >
                            <span>Confirm</span>
                          </v-btn>
                        </v-col>
                      </v-row>
                    </v-container>
                    <!-- FIXME NEW MODAL ENDS -->
                  </v-row>
                </v-card>
              </div>

              <!-- Currently Empty  -->
              <div class v-if="after_tomorrow_appointments.length == 0">
                <v-card flat :style="{ borderLeft: '5px solid #A2A2A2' }">
                  <v-row class="py-5 mb-5 contentEmpty" no-gutters>
                    <v-col :lg="1" :md="1" :sm="2" cols="1"></v-col>
                    <v-col
                      :lg="9"
                      :md="9"
                      :sm="10"
                      cols="11"
                      class="pr-0 mt-4 mb-4"
                    >
                      <span>
                        <div
                          class="mr-1 ml-lg-0 ml-1"
                          style="float: left"
                          size="24"
                        >
                          <span class="far empty icoEmpty"></span>
                        </div>
                        <span class="textEmpty empty">Currently Empty</span>
                      </span>
                    </v-col>
                  </v-row>
                </v-card>
              </div>
              <!-- End Currently Empty  -->
              <!-- EndAfter-Tomorrow  -->
            </span>
            <!-- End - Appointments all -->
          </v-col>

          <v-col
            class="pl-0 pr-0 calendarCol"
            v-if="!$vuetify.breakpoint.smAndDown"
            style="background-color: #ebf4fd"
          >
            <div
              class="stickyTopCalendar"
              style="background-color: #ebf4fd; width: 290px;top: 234px;"
            >
              <date-pick
                v-model="datePicker"
                :hasInputElement="false"
                :weekdays="['M', 'T', 'W', 'T', 'F', 'S', 'S']"
                :startWeekOnSunday="true"
              ></date-pick>
            </div>
          </v-col>
        </v-row>
      </div>
    </div>

    <v-dialog
      v-model="messageDialog"
      width="750"
      :fullscreen="$vuetify.breakpoint.xsOnly"
    >
      <v-card>
        <v-card-text class="p-0">
          <div class="row m-0">
            <div class="col-12 text-right">
              <v-btn icon light @click="messageDialog = false" class="right">
                <i class="far fa-times-circle fa-2x pink_icon"></i>
              </v-btn>
            </div>
            <div class="col-12">
              <div class="text-center p-5">
                <h2>{{ message }}</h2>
              </div>
            </div>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import moment from "moment";
import DatePick from "vue-date-pick";
import { mapGetters } from "vuex";
export default {
  props: ["user", "categories"],
  components: { DatePick },
  data() {
    return {
      newProfileDialog:
        this.user.userProfile.updated_at === null ||
        moment(this.user.userProfile.updated_at).isBefore("2020-10-20"),
      tabs: null,
      display: false,
      today_appointments: [],
      tomorrow_appointments: [],
      after_tomorrow_appointments: [],
      after_tomorrow_day: moment().add(2, "d").format("YYYY-MM-DD"),
      upcoming_appointments: [],
      pending_appointments: [],
      completed_appointments: [],
      cancelled_appointments: [],
      messageDialog: false,
      mask: "##:## SS",
      datepicker_menu: false,
      start_hour_menu: false,
      end_hour_menu: false,
      savingUserServices: false,
      usSaved: false,
      loading: true,
      loadingUpdate: false,
      appointments: [],
      errors: [],
      date_filter_list: [
        { name: "Last 3 months", key: 3 },
        { name: "Last 6 months", key: 6 },
        { name: "Last 9 months", key: 9 },
        { name: "Last year", key: 12 },
      ],
      appointment_list: [
        { name: "Show all", key: "All" },
        { name: "Pending", key: "Pending" },
        { name: "Confirmed", key: "Confirmed" },
        { name: "Completed", key: "Completed" },
        { name: "Cancelled", key: "Cancelled" },
      ],
      status: ["All"],
      date_filter: 6,
      message: "",
      today: moment().format("YYYY-MM-DD"),
      focus: moment().format("YYYY-MM-DD"),
      type: "month",
      typeToLabel: {
        month: "Month",
        week: "Week",
        day: "Day",
        "4day": "4 Days",
      },
      start: null,
      end: null,
      selectedEvent: {},
      selectedElement: null,
      selectedOpen: false,
      start_time: "",
      end_time: "",
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
      month: null,
      appoimentsMonth: null,
    };
  },
  filters: {
    formatDate(date, format = "MM/DD/YYYY") {
      return moment(date).format(format);
    },
    ftime: function (time) {
      let hour = new Date(time * 1000 * 60).toISOString().substr(11, 2);
      let init = 14;
      let end = 5;
      if (time > 60) {
        init = 11;
        end = 8;
      }
      return new Date(time * 1000 * 60).toISOString().substr(init, end);
    },
  },
  computed: {
    ...mapGetters({
      mobile: "util/mobile",
      space_header: "util/space"
    }),
    datePicker: {
      get() {
        return this.focus;
      },
      set(value) {
        this.showEvent(value);
      },
    },
    title() {
      const { start, end } = this;
      if (!start || !end) {
        return "";
      }
      const startMonth = this.monthFormatter(start);
      const endMonth = this.monthFormatter(end);
      const suffixMonth = startMonth === endMonth ? "" : endMonth;
      const startYear = start.year;
      const endYear = end.year;
      const suffixYear = startYear === endYear ? "" : endYear;
      const startDay = start.day + this.nth(start.day);
      const endDay = end.day + this.nth(end.day);
      switch (this.type) {
        case "month":
          return `${startMonth} ${startYear}`;
        case "week":
        case "4day":
          return `${startMonth} ${startDay} ${startYear} - ${suffixMonth} ${endDay} ${suffixYear}`;
        case "day":
          return `${startMonth} ${startDay} ${startYear}`;
      }
      return "";
    },
    monthFormatter() {
      return this.$refs.calendar.getFormatter({
        timeZone: "UTC",
        month: "long",
      });
    },
  },
  watch: {
    month(val) {
      axios
        .get("/api/v1/user/appointments-month?date=" + val)
        .then((response) => {
          this.appoimentsMonth = response.data;
        });
    },
  },
  methods: {
    // newDayFormat(day) {
    //   const daysOfWeek = ["S", "M", "T", "W", "T", "F", "S"];
    //   let i = day.weekday;
    //   return daysOfWeek[i];
    // },
    appoimentsCheck(date) {
      let appoiments = [];
      // console.log(this.appointments, date);
      this.appoimentsMonth.forEach((i) => {
        if (i.date == date) {
          if (i.status == "Pending" && !appoiments.includes("#F3A726"))
            appoiments.push("#F3A726");
          else if (i.status == "Completed" && !appoiments.includes("#4A99FA"))
            appoiments.push("#4A99FA");
          else if (i.status == "Confirmed" && !appoiments.includes("#4AC853"))
            appoiments.push("#4AC853");
          else if (i.status == "Cancelled" && !appoiments.includes("#E53935"))
            appoiments.push("#E53935");
        }
      });
      return appoiments;
    },
    getTimeRequested(appointment) {
      var ms = moment(appointment.end).diff(moment(appointment.start));
      var d = moment.duration(ms);
      var s = Math.floor(d.asHours()) + moment.utc(ms).format(":mm:ss");
      return s;
    },
    /**
     * Prepare the component.
     */
    getAppointments() {
      axios
        .get("/api/v1/psychic/appointments?status=&date_filter=")
        .then((response) => {
          this.appointments = response.data.data;
          this.categorizeAppointmentsbyDate();
          this.categorizeAppointments();
          this.loading = false;
          this.loadingUpdate = false;
          console.log(response.data.data);
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
    categorizeAppointments() {
      this.upcoming_appointments = [];
      this.pending_appointments = [];
      this.completed_appointments = [];
      this.cancelled_appointments = [];
      for (var i = 0; i < this.appointments.length; i++) {
        if (this.appointments[i].status == "Confirmed") {
          this.upcoming_appointments.push(this.appointments[i]);
        } else if (this.appointments[i].status == "Pending") {
          this.pending_appointments.push(this.appointments[i]);
        } else if (this.appointments[i].status == "Completed") {
          this.completed_appointments.push(this.appointments[i]);
        } else if (this.appointments[i].status == "Cancelled") {
          this.cancelled_appointments.push(this.appointments[i]);
        }
      }
    },
    categorizeAppointmentsbyDate() {
      let tomorrow = moment(this.focus, "YYYY-MM-DD")
        .add(1, "d")
        .format("YYYY-MM-DD");
      // let afterTomorrow = moment(this.focus, "YYYY-MM-DD")
      //   .add(2, "d")
      //   .format("YYYY-MM-DD");
      this.after_tomorrow_day = moment(this.focus, "YYYY-MM-DD")
        .add(2, "d")
        .format("MMMM DD");
      this.today_appointments = [];
      this.tomorrow_appointments = [];
      this.after_tomorrow_appointments = [];
      this.appointments.forEach((app) => {
        if (app.date == this.focus) {
          this.today_appointments.push(app);
        } else if (app.date == tomorrow) {
          this.tomorrow_appointments.push(app);
        } else {
          this.after_tomorrow_appointments.push(app);
        }
      });
    },
    filterAppointments() {
      if (
        (this.status.length > 1) &
        this.status.includes("All") &
        (this.status[0] != "All")
      ) {
        this.status = ["All"];
        this.showEvent(this.focus);
      } else if ((this.status.length > 1) & (this.status[0] == "All")) {
        this.status.shift();
        this.showEvent(this.focus);
      } else if (this.status.length === 4) {
        this.status = ["All"];
        this.showEvent(this.focus);
      } else {
        this.showEvent(this.focus);
      }
    },
    updateAppointmentStatus(appointment, status) {
      this.loadingUpdate = true;
      var input = { id: appointment.id, status: status };
      axios
        .post("/api/v1/psychic/appointment/update/status", input)
        .then((response) => {
          if (
            response.data.message ==
            "Appointment was cancelled because it was in the past"
          ) {
            alert("Appointment is in the past so it was cancelled.");
          }
          if (appointment.request && status == "Cancelled") {
            // appointment was created with a request now
            this.$root.$emit("canceled_or_expired_appointment", {
              id: appointment.request,
            });
          }
          this.getAppointments();
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
    editAppointmentNotes(appointment) {
      this.loadingUpdate = true;
      var input = {
        id: appointment.id,
        notes: appointment.text,
      };
      axios
        .post("/api/v1/psychic/appointment/edit/notes", input)
        .then((response) => {
          this.getAppointments();
          this.message = response.data.message;
          setTimeout(() => {
            this.message = "";
          }, 2000);
          this.selectedEvent = {};
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
          this.loadingUpdate = false;
          this.message = "";
        });
    },
    requestReview(appointment) {
      this.loadingUpdate = true;
      var input = { id: appointment.id };
      axios
        .post("/api/v1/psychic/request/review", input)
        .then((response) => {
          this.loadingUpdate = false;
          appointment.review_requested = true;
          this.$root.$emit("open_dialog_message", {
            message: response.data.message,
            message_title: "",
          });
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
    edit(appointment) {
      this.selectedEvent = appointment;
      this.updateTimes();
    },
    status_color(status) {
      var color = "";
      if (status == "Pending") {
        color = "#FFAC3B";
      } else if (status == "Confirmed") {
        color = "#2CC05F";
      } else if (status == "Cancelled") {
        color = "#E85D4E";
      } else if (status == "Completed") {
        color = "#4899FA";
      }
      return color;
    },
    duration(x, y) {
      x = new moment(x);
      y = new moment(y);
      var duration = moment.duration(x.diff(y));
    },
    viewDay({ date }) {
      this.focus = date;
      this.type = "day";
    },
    getEventColor(event) {
      return event.color;
    },
    setToday() {
      this.focus = this.today;
    },
    prev() {
      this.$refs.calendar.prev();
    },
    next() {
      this.$refs.calendar.next();
    },
    showEvent(date) {
      //   let hola = this.appointments.filter(app => {
      //     return app.status == "Cancelled";
      //   });
      //   const open = () => {
      //     this.selectedEvent = event;
      //     this.selectedElement = nativeEvent.target;
      //     setTimeout(() => (this.selectedOpen = true), 10);
      //   };
      //   if (this.selectedOpen) {
      //     this.selectedOpen = false;
      //     setTimeout(open, 10);
      //   } else {
      //     open();
      //   }
      //   this.updateTimes();
      //   this.updateTab();
      //   nativeEvent.stopPropagation();\
      //   let tomorrow = moment(this.focus, "YYYY-MM-DD")
      //     .add(1, "d")
      //     .format("YYYY-MM-DD");
      this.focus = date;
      console.log(this.focus);
      axios
        .get(
          `/api/v1/psychic/appointments?status=${this.status}&date_filter=${this.focus}`
        )
        .then((response) => {
          this.appointments = response.data.data;
          this.categorizeAppointmentsbyDate();
          this.categorizeAppointments();
          this.loading = false;
          this.loadingUpdate = false;
          console.log(response.data.data);
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
    updateTab() {
      if (this.selectedEvent.status == "Pending") {
        this.tabs = "mobile-tabs-5-2";
      } else if (this.selectedEvent.status == "Confirmed") {
        this.tabs = "mobile-tabs-5-1";
      } else if (this.selectedEvent.status == "Cancelled") {
        this.tabs = "mobile-tabs-5-4";
      } else if (this.selectedEvent.status == "Completed") {
        this.tabs = "mobile-tabs-5-3";
      }
    },
    updateTimes() {
      this.errors = [];
      this.start_time = moment(this.selectedEvent.start).format("HH:mm");
      this.end_time = moment(this.selectedEvent.end).format("HH:mm");
    },
    updateRange({ start, end }) {
      // You could load events from an outside source (like database) now that we have the start and end dates on the calendar
      this.start = start;
      this.end = end;
    },
    nth(d) {
      return d > 3 && d < 21
        ? "th"
        : ["th", "st", "nd", "rd", "th", "th", "th", "th", "th", "th"][d % 10];
    },
  },
  /**
   * Prepare the component (Vue 2.x).
   */
  mounted() {
    this.showEvent(this.today);
    // this.$refs.calendar.checkChange();
    this.$root.$on("update_appointments", (data) => {
      this.showEvent(this.focus);
    });
  },
};
</script>

<style>
/* .row{
  margin-left: 0px !important;
} */

.h2Title {
  padding-bottom: 4px !important;
}
.textList {
  padding-bottom: 4px !important;
}
.v-menu__content [role="listbox"] .v-list-item {
  color: #8e8d99 !important;
}
.v-menu__content [role="listbox"] .v-list-item__title {
  font-size: 12px !important;
}
.vdpArrow {
  font-size: 13px;
  width: 5em;
  text-indent: -999em;
  overflow: hidden;
  position: absolute;
  top: 10px;
  bottom: 2.5em;
  text-align: left;
}
.vdpPeriodControl button {
  padding-right: 0px !important;
  margin-right: 0px !important;
  padding-left: 1px !important;
}
.v-select-list .v-list-item__title {
  color: #8e8d99 !important;
}
.v-date-picker-table__events div {
  width: 4px;
  height: 4px;
}
.v-application .v-picker .v-btn--rounded.accent--text {
  background-color: #c2d1f7 !important;
  border: 0px !important;
  color: #1f1e34 !important;
}
.v-application .v-picker .v-btn--rounded.accent {
  background-color: #cc9fd9 !important;
  border: 0px !important;
  color: #1f1e34 !important;
}
.v-application .v-picker .v-btn--rounded {
  background-color: #ebf4fd !important;
  border: 0px !important;
  color: #1f1e34 !important;
}
.servList {
  margin-bottom: 0px !important;
}
.textList {
  padding-bottom: 0px !important;
}
/* Hide scrollbar for Chrome, Safari and Opera */
#scroll-target::-webkit-scrollbar {
  display: none;
}
/* Hide scrollbar for IE, Edge and Firefox */
#scroll-target {
  -ms-overflow-style: none; /* IE and Edge */
  scrollbar-width: none; /* Firefox */
}
/* #sidebar{
  position: fixed;
  z-index: 1;
  min-height: 80vh;
}
.v-footer{
  z-index: 2;
} */

.newProfileDataVCard {
  background-size: cover;
  background-repeat: no-repeat;
  position: relative;
  background-position: center;
  background-image: url("/images/back_dialog.jpg");
}
.newProfileDataVCTitle {
  color: #43425d;
  font-size: 16px !important;
  font-weight: 600 !important;
  padding-top: 55px !important;
  padding-bottom: 20px !important;
  line-height: 22px !important;
}
.newProfileDataVCText1,
.newProfileDataVCText2 {
  color: #656b72 !important;
  font-size: 14px !important;
  font-weight: normal !important;
  letter-spacing: 0px !important;
  line-height: 23px !important;
}
.newProfileDataVCText1 {
  padding-left: 50px !important;
  padding-right: 50px !important;
}
.newProfileDataVCText2 {
  padding-left: 40px !important;
  padding-right: 40px !important;
  padding-bottom: 42px !important;
}
.newProfileDataVBtn {
  font-weight: normal !important;
  height: 38px !important;
  width: 130px;
}
</style>