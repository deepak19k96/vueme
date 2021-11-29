<template>
  <div>
    <div class="container mb-0 pb-0 pl-3 pt-0">
      <div
        class="row"
        v-if="$vuetify.breakpoint.smAndDown && !display"
        style="padding: 15px"
      >
        <v-card color="white" style="width: 95px; height: 95px" href="/">
          <div primary-title class="text-center">
            <img
              style="margin-top: 19px; margin-bottom: 10px"
              src="/images/icons/Explore.svg"
            />
            <div
              style="
                color: #656b72 !important;
                font-weight: 500;
                font-size: 14px !important;
              "
            >
              Explore
            </div>
          </div>
        </v-card>
        <credits :user="user" />

        <credits :user="user" />
      </div>

      <div  :style="[!$vuetify.breakpoint.xsOnly ? {'top':space_header+'px'}:{}]" :class="{ 'stickyTop paddinStik': !$vuetify.breakpoint.xsOnly }">
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
            class="ml-0 mr-0 mb-1 mt-0 mb-0"
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
          <v-row class="ml-0 mr-0 pb-0 mb-0" style="margin: 20px 0px">
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
            <v-col :lg="2" :sm="2" class="text-lg-right text-center">
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
                class="widthSelect"
                :menu-props="{ contentClass: 'checkList' }"
                :style="[
                  !$vuetify.breakpoint.smAndDown
                    ? { width: '135px !important' }
                    : { width: '135px !important', float: 'right' },
                ]"
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
                  color="#e53935"
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
                    <v-col :lg="1" :md="1" :cols="1" class="pl-0">
                      
                      <v-badge
                        overlap
                        bottom
                        v-if="appointment.psychic.online"
                        color="#2CC05F"
                        class="badgeUser v-badge-list"
                        
                      >
                      
                        <template v-slot:badge></template>
                        <v-avatar size="40">
                           
                          <v-img
                            :alt="appointment.psychic.profile.name"
                            :src="
                              appointment.psychic.profile.profile_headshot_url
                            "
                            @click="windowOpen(appointment.psychic.url)"
                          ></v-img>
                        </v-avatar>
                      </v-badge>

                      <v-badge
                        overlap
                        bottom
                        v-else
                        color="#C7C7C7"
                        class="badgeUser v-badge-list"
                        
                      >
                        <template v-slot:badge></template>
                        <v-avatar size="40">

                         
                          <v-img
                            :alt="appointment.psychic.profile.name"
                            :src="
                              appointment.psychic.profile.profile_headshot_url
                            "
                            @click="windowOpen(appointment.psychic.url)"
                          ></v-img>
                        </v-avatar>
                      </v-badge>
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
                        {{ appointment.psychic.profile.name }}
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
                      class="mt-5"
                    >
                      <v-row class="m-0 py-5 white mt-5" no-gutters>
                        <v-col :lg="6" :md="6" :sm="12" cols="12" class="mb-5">
                          <v-select
                            :items="categories"
                            label="Select service"
                            background-color="#F4F4F4"
                            filled
                            :disabled="appointment.status != 'Pending'"
                            item-text="description"
                            item-value="id"
                            hide-details
                            dense
                            solo
                            v-model="appointment.category.id"
                          ></v-select>
                          <span
                            v-if="errors['name']"
                            class="float-left text-danger small"
                            >{{ errors["name"][0] }}</span
                          >
                        </v-col>
                        <v-col :lg="6" :md="6" :sm="12" cols="12">
                          <v-menu
                            :disabled="appointment.status != 'Pending'"
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
                                :disabled="appointment.status != 'Pending'"
                                background-color="#F4F4F4"
                                filled
                                dense
                                solo
                                v-on="on"
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

                        <v-col :lg="6" :md="6" :sm="12" cols="12" class="mb-5">
                          <v-text-field
                            v-model="start_time"
                            label="00:00 AM/PM"
                            background-color="#F4F4F4"
                            filled
                            :disabled="appointment.status != 'Pending'"
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
                        <v-col :lg="6" :md="6" :sm="12" cols="12" class="mb-5">
                          <v-select
                            v-model="appointment.duration"
                            :items="steppedtime"
                            :disabled="appointment.status != 'Pending'"
                            label="Duration"
                            background-color="#F4F4F4"
                            filled
                            item-text="label"
                            item-value="value"
                            hide-details
                            dense
                            solo
                          ></v-select>

                          <span
                            v-if="errors.duration"
                            class="text-danger small"
                          >
                            {{ appointment.name }}
                            {{ errors.duration[0] }}
                          </span>
                        </v-col>

                        <v-col cols="12" class="mt-3">
                          <div
                            v-if="errors.date_and_time"
                            class="form-group text-danger small"
                          >
                            {{ errors.date_and_time[0] }}
                          </div>
                          <v-btn
                            v-if="
                              appointment.status == 'Completed' &&
                              !appointment.reviewed
                            "
                            class="white--text"
                            @click="newReview(appointment)"
                            :loading="loadingUpdate"
                            :disabled="loadingUpdate"
                            rounded
                            color="primary"
                          >
                            <span>Write a Review</span>
                          </v-btn>
                          <v-btn
                            v-if="appointment.status == 'Pending'"
                            :disabled="loadingUpdate"
                            :loading="loadingUpdate"
                            @click="editAppointment(appointment)"
                            class="white--text mr-3"
                            rounded
                            color="primary"
                          >
                            <span>Save</span>
                          </v-btn>
                          <v-btn
                            v-if="appointment.status == 'Pending'"
                            class="white--text mr-3"
                            @click="
                              updateAppointmentStatus(appointment, 'Cancelled')
                            "
                            :loading="loadingUpdate"
                            :disabled="loadingUpdate"
                            rounded
                            color="primary"
                          >
                            <span>Decline</span>
                          </v-btn>
                          <v-btn
                            class="white--text mr-3"
                            text
                            rounded
                            color="secondary"
                            @click="selectedEvent = {}"
                          >
                            <span>Cancel</span>
                          </v-btn>
                          <span
                            v-if="appointment.reviewed"
                            class="ml-3"
                            :style="{ color: '#A163C1' }"
                            >Reviewed</span
                          >
                          <span class="success&#45;&#45;text">
                            {{ message }}
                          </span>
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
                    <v-col :lg="1" :md="1" :cols="1" class="pl-0">
                      <v-badge
                        overlap
                        bottom
                        v-if="appointment.psychic.online"
                        color="#2CC05F"
                        class="badgeUser v-badge-list"
                        
                        
                      >
                        <template v-slot:badge></template>
                        <v-avatar size="40">
                          <v-img
                            :alt="appointment.psychic.profile.name"
                            :src="
                              appointment.psychic.profile.profile_headshot_url
                            "
                            v-on:click="windowOpen(appointment.psychic.url)"
                          ></v-img>
                        </v-avatar>
                      </v-badge>

                      <v-badge
                        overlap
                        bottom
                        v-else
                        color="#C7C7C7"
                        class="badgeUser v-badge-list"
                        
                      >
                        <template v-slot:badge></template>
                        <v-avatar size="40">
                          <v-img
                            :alt="appointment.psychic.profile.name"
                            :src="
                              appointment.psychic.profile.profile_headshot_url
                            "
                            @click="windowOpen(appointment.psychic.url)"
                          ></v-img>
                        </v-avatar>
                      </v-badge>
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
                        {{ appointment.psychic.profile.name }}
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
                      class="mt-5"
                    >
                      <v-row class="m-0 py-5 white mt-5" no-gutters>
                        <v-col :lg="6" :md="6" :sm="12" cols="12" class="mb-5">
                          <v-select
                            :items="categories"
                            label="Select service"
                            background-color="#F4F4F4"
                            filled
                            :disabled="appointment.status != 'Pending'"
                            item-text="description"
                            item-value="id"
                            hide-details
                            dense
                            solo
                            v-model="appointment.category.id"
                          ></v-select>
                          <span
                            v-if="errors['name']"
                            class="float-left text-danger small"
                            >{{ errors["name"][0] }}</span
                          >
                        </v-col>
                        <v-col :lg="6" :md="6" :sm="12" cols="12">
                          <v-menu
                            :disabled="appointment.status != 'Pending'"
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
                                :disabled="appointment.status != 'Pending'"
                                background-color="#F4F4F4"
                                filled
                                dense
                                solo
                                v-on="on"
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

                        <v-col :lg="6" :md="6" :sm="12" cols="12" class="mb-5">
                          <v-text-field
                            v-model="start_time"
                            label="00:00 AM/PM"
                            background-color="#F4F4F4"
                            filled
                            :disabled="appointment.status != 'Pending'"
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
                        <v-col :lg="6" :md="6" :sm="12" cols="12" class="mb-5">
                          <v-select
                            v-model="appointment.duration"
                            :items="steppedtime"
                            :disabled="appointment.status != 'Pending'"
                            label="Duration"
                            background-color="#F4F4F4"
                            filled
                            item-text="label"
                            item-value="value"
                            hide-details
                            dense
                            solo
                          ></v-select>

                          <span
                            v-if="errors.duration"
                            class="text-danger small"
                          >
                            {{ appointment.name }}
                            {{ errors.duration[0] }}
                          </span>
                        </v-col>

                        <v-col cols="12" class="mt-3">
                          <div
                            v-if="errors.date_and_time"
                            class="form-group text-danger small"
                          >
                            {{ errors.date_and_time[0] }}
                          </div>
                          <v-btn
                            v-if="
                              appointment.status == 'Completed' &&
                              !appointment.reviewed
                            "
                            class="white--text"
                            @click="newReview(appointment)"
                            :loading="loadingUpdate"
                            :disabled="loadingUpdate"
                            rounded
                            color="primary"
                          >
                            <span>Write a Review</span>
                          </v-btn>
                          <v-btn
                            v-if="appointment.status == 'Pending'"
                            :disabled="loadingUpdate"
                            :loading="loadingUpdate"
                            @click="editAppointment(appointment)"
                            class="white--text mr-3"
                            rounded
                            color="primary"
                          >
                            <span>Save</span>
                          </v-btn>
                          <v-btn
                            v-if="appointment.status == 'Pending'"
                            class="white--text mr-3"
                            @click="
                              updateAppointmentStatus(appointment, 'Cancelled')
                            "
                            :loading="loadingUpdate"
                            :disabled="loadingUpdate"
                            rounded
                            color="primary"
                          >
                            <span>Decline</span>
                          </v-btn>
                          <v-btn
                            class="white--text mr-3"
                            text
                            rounded
                            color="secondary"
                            @click="selectedEvent = {}"
                          >
                            <span>Cancel</span>
                          </v-btn>
                          <span
                            v-if="appointment.reviewed"
                            class="ml-3"
                            :style="{ color: '#A163C1' }"
                            >Reviewed</span
                          >
                          <span class="success&#45;&#45;text">
                            {{ message }}
                          </span>
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
                    <v-col :lg="1" :md="1" :cols="1" class="pl-0">
                      <v-badge
                        overlap
                        bottom
                        v-if="appointment.psychic.online"
                        color="#2CC05F"
                        class="badgeUser v-badge-list"
                        
                      >
                        <template v-slot:badge></template>
                        <v-avatar size="40">
                          <v-img
                            :alt="appointment.psychic.profile.name"
                            :src="
                              appointment.psychic.profile.profile_headshot_url
                            "
                            @click="windowOpen(appointment.psychic.url)"
                          ></v-img>
                        </v-avatar>
                      </v-badge>

                      <v-badge
                        overlap
                        bottom
                        v-else
                        color="#C7C7C7"
                        class="badgeUser v-badge-list"
                        
                      >
                        <template v-slot:badge></template>
                        <v-avatar size="40">
                          <v-img
                            :alt="appointment.psychic.profile.name"
                            :src="
                              appointment.psychic.profile.profile_headshot_url
                            "
                            @click="windowOpen(appointment.psychic.url)"
                          ></v-img>
                        </v-avatar>
                      </v-badge>
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
                        {{ appointment.psychic.profile.name }}
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
                      class="mt-5"
                    >
                      <v-row class="m-0 py-5 white mt-5" no-gutters>
                        <v-col :lg="6" :md="6" :sm="12" cols="12" class="mb-5">
                          <v-select
                            :items="categories"
                            label="Select service"
                            background-color="#F4F4F4"
                            filled
                            :disabled="appointment.status != 'Pending'"
                            item-text="description"
                            item-value="id"
                            hide-details
                            dense
                            solo
                            v-model="appointment.category.id"
                          ></v-select>
                          <span
                            v-if="errors['name']"
                            class="float-left text-danger small"
                            >{{ errors["name"][0] }}</span
                          >
                        </v-col>
                        <v-col :lg="6" :md="6" :sm="12" cols="12">
                          <v-menu
                            :disabled="appointment.status != 'Pending'"
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
                                :disabled="appointment.status != 'Pending'"
                                background-color="#F4F4F4"
                                filled
                                dense
                                solo
                                v-on="on"
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

                        <v-col :lg="6" :md="6" :sm="12" cols="12" class="mb-5">
                          <v-text-field
                            v-model="start_time"
                            label="00:00 AM/PM"
                            background-color="#F4F4F4"
                            filled
                            :disabled="appointment.status != 'Pending'"
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
                        <v-col :lg="6" :md="6" :sm="12" cols="12" class="mb-5">
                          <v-select
                            v-model="appointment.duration"
                            :items="steppedtime"
                            :disabled="appointment.status != 'Pending'"
                            label="Duration"
                            background-color="#F4F4F4"
                            filled
                            item-text="label"
                            item-value="value"
                            hide-details
                            dense
                            solo
                          ></v-select>

                          <span
                            v-if="errors.duration"
                            class="text-danger small"
                          >
                            {{ appointment.name }}
                            {{ errors.duration[0] }}
                          </span>
                        </v-col>

                        <v-col cols="12" class="mt-3">
                          <div
                            v-if="errors.date_and_time"
                            class="form-group text-danger small"
                          >
                            {{ errors.date_and_time[0] }}
                          </div>
                          <v-btn
                            v-if="
                              appointment.status == 'Completed' &&
                              !appointment.reviewed
                            "
                            class="white--text"
                            @click="newReview(appointment)"
                            :loading="loadingUpdate"
                            :disabled="loadingUpdate"
                            rounded
                            color="primary"
                          >
                            <span>Write a Review</span>
                          </v-btn>
                          <v-btn
                            v-if="appointment.status == 'Pending'"
                            :disabled="loadingUpdate"
                            :loading="loadingUpdate"
                            @click="editAppointment(appointment)"
                            class="white--text mr-3"
                            rounded
                            color="primary"
                          >
                            <span>Save</span>
                          </v-btn>
                          <v-btn
                            v-if="appointment.status == 'Pending'"
                            class="white--text mr-3"
                            @click="
                              updateAppointmentStatus(appointment, 'Cancelled')
                            "
                            :loading="loadingUpdate"
                            :disabled="loadingUpdate"
                            rounded
                            color="primary"
                          >
                            <span>Decline</span>
                          </v-btn>
                          <v-btn
                            class="white--text mr-3"
                            text
                            rounded
                            color="secondary"
                            @click="selectedEvent = {}"
                          >
                            <span>Cancel</span>
                          </v-btn>
                          <span
                            v-if="appointment.reviewed"
                            class="ml-3"
                            :style="{ color: '#A163C1' }"
                            >Reviewed</span
                          >
                          <span class="success&#45;&#45;text">
                            {{ message }}
                          </span>
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
                    <v-col :lg="1" :md="1" :cols="1" class="pl-0">
                      <v-badge
                        overlap
                        bottom
                        v-if="appointment.psychic.online"
                        color="#2CC05F"
                        class="badgeUser v-badge-list"
                        
                      >
                        <template v-slot:badge></template>
                        <v-avatar size="40">
                          <v-img
                            :alt="appointment.psychic.profile.name"
                            :src="
                              appointment.psychic.profile.profile_headshot_url
                            "
                            @click="windowOpen(appointment.psychic.url)"
                          ></v-img>
                        </v-avatar>
                      </v-badge>

                      <v-badge
                        overlap
                        bottom
                        v-else
                        color="#C7C7C7"
                        class="badgeUser v-badge-list"
                        
                      >
                        <template v-slot:badge></template>
                        <v-avatar size="40">
                          <v-img
                            :alt="appointment.psychic.profile.name"
                            :src="
                              appointment.psychic.profile.profile_headshot_url
                            "
                            @click="windowOpen(appointment.psychic.url)"
                          ></v-img>
                        </v-avatar>
                      </v-badge>
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
                        {{ appointment.psychic.profile.name }}
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
                      class="mt-5"
                    >
                      <v-row class="m-0 py-5 white mt-5" no-gutters>
                        <v-col :lg="6" :md="6" :sm="12" cols="12" class="mb-5">
                          <v-select
                            :items="categories"
                            label="Select service"
                            background-color="#F4F4F4"
                            filled
                            :disabled="appointment.status != 'Pending'"
                            item-text="description"
                            item-value="id"
                            hide-details
                            dense
                            solo
                            v-model="appointment.category.id"
                          ></v-select>
                          <span
                            v-if="errors['name']"
                            class="float-left text-danger small"
                            >{{ errors["name"][0] }}</span
                          >
                        </v-col>
                        <v-col :lg="6" :md="6" :sm="12" cols="12">
                          <v-menu
                            :disabled="appointment.status != 'Pending'"
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
                                :disabled="appointment.status != 'Pending'"
                                background-color="#F4F4F4"
                                filled
                                dense
                                solo
                                v-on="on"
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

                        <v-col :lg="6" :md="6" :sm="12" cols="12" class="mb-5">
                          <v-text-field
                            v-model="start_time"
                            label="00:00 AM/PM"
                            background-color="#F4F4F4"
                            filled
                            :disabled="appointment.status != 'Pending'"
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
                        <v-col :lg="6" :md="6" :sm="12" cols="12" class="mb-5">
                          <v-select
                            v-model="appointment.duration"
                            :items="steppedtime"
                            :disabled="appointment.status != 'Pending'"
                            label="Duration"
                            background-color="#F4F4F4"
                            filled
                            item-text="label"
                            item-value="value"
                            hide-details
                            dense
                            solo
                          ></v-select>

                          <span
                            v-if="errors.duration"
                            class="text-danger small"
                          >
                            {{ appointment.name }}
                            {{ errors.duration[0] }}
                          </span>
                        </v-col>

                        <v-col cols="12" class="mt-3">
                          <div
                            v-if="errors.date_and_time"
                            class="form-group text-danger small"
                          >
                            {{ errors.date_and_time[0] }}
                          </div>
                          <v-btn
                            v-if="
                              appointment.status == 'Completed' &&
                              !appointment.reviewed
                            "
                            class="white--text"
                            @click="newReview(appointment)"
                            :loading="loadingUpdate"
                            :disabled="loadingUpdate"
                            rounded
                            color="primary"
                          >
                            <span>Write a Review</span>
                          </v-btn>
                          <v-btn
                            v-if="appointment.status == 'Pending'"
                            :disabled="loadingUpdate"
                            :loading="loadingUpdate"
                            @click="editAppointment(appointment)"
                            class="white--text mr-3"
                            rounded
                            color="primary"
                          >
                            <span>Save</span>
                          </v-btn>
                          <v-btn
                            v-if="appointment.status == 'Pending'"
                            class="white--text mr-3"
                            @click="
                              updateAppointmentStatus(appointment, 'Cancelled')
                            "
                            :loading="loadingUpdate"
                            :disabled="loadingUpdate"
                            rounded
                            color="primary"
                          >
                            <span>Decline</span>
                          </v-btn>
                          <v-btn
                            class="white--text mr-3"
                            text
                            rounded
                            color="secondary"
                            @click="selectedEvent = {}"
                          >
                            <span>Cancel</span>
                          </v-btn>
                          <span
                            v-if="appointment.reviewed"
                            class="ml-3"
                            :style="{ color: '#A163C1' }"
                            >Reviewed</span
                          >
                          <span class="success&#45;&#45;text">
                            {{ message }}
                          </span>
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
              style="background-color: #ebf4fd; width: 290px; top: 223px;"
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

    <!-- TODO DIALOGS TO CHECK !!!! -->
    <v-dialog v-model="review_dialog" width="500">
      <v-card v-if="Object.keys(selectedEvent).length > 0">
        <!-- <v-card-title style="background-color: #eeeeee">Review</v-card-title> -->
        <v-subheader class style="position: absolute; right: 0">
          <v-icon
            class="d-block text-right"
            style="position: absolute; right: 15px; z-index: 9"
            @click="review_dialog = false"
            >mdi-close</v-icon
          >
        </v-subheader>
        <v-card-text class="pt-10">
          <v-row no-gutters>
            <v-col :lg="2" :md="2" :sm="12" cols="12">
              <div
                :aria-label="selectedEvent.psychic.profile.display_name"
                class="user_avatar mr-3"
                :style="{
                  'background-image':
                    'url(' +
                    selectedEvent.psychic.profile.profile_headshot_url +
                    ')',
                }"
              ></div>
            </v-col>
            <v-col cols="10">
              <div class="primary--text h4 pt-5 pl-4">
                <b>{{ selectedEvent.psychic.profile.display_name }}</b>
              </div>
            </v-col>
            <v-col class="mt-6" cols="6">
              <div>
                <b>Select your rating</b>
              </div>
              <div>
                <v-rating
                  class="float-left starBtn"
                  v-model="new_review.rating"
                  background-color="#cccccc"
                  color="amber"
                  dense
                ></v-rating>
                <span
                  v-if="errors['rating']"
                  class="float-left text-danger small"
                  >{{ errors["rating"][0] }}</span
                >
              </div>
            </v-col>
            <v-col class="mt-6 text-right" cols="6">
              <div>
                <b>Date</b>
              </div>
              <div>{{ selectedEvent.date | formatDate }}</div>
            </v-col>
            <v-col class="mt-6" cols="6">
              <div>
                <b>Service</b>
              </div>
              <div>{{ selectedEvent.service.name }}</div>
            </v-col>
            <v-col class="mt-6 text-right" cols="6">
              <div>
                <b>Reading</b>
              </div>
              <div>{{ selectedEvent.category.description }}</div>
            </v-col>
            <v-col cols="12" class="mt-5">
              <div class="mb-1">
                <b>Headline</b>
              </div>
              <v-text-field
                v-model="new_review.headline"
                label
                background-color="#F4F4F4"
                filled
                dense
                solo
                hide-details
              ></v-text-field>
              <span
                v-if="errors['headline']"
                class="float-left text-danger small"
                >{{ errors["headline"][0] }}</span
              >
            </v-col>
            <v-col cols="12" class="mt-5">
              <div class="mb-1">
                <b>Write a review</b>
              </div>
              <v-textarea
                v-model="new_review.text"
                solo
                dense
                background-color="#F4F4F4"
                filled
                hide-details
                placeholder
              ></v-textarea>
              <span
                v-if="errors['text']"
                class="float-left text-danger small"
                >{{ errors["text"][0] }}</span
              >
            </v-col>
            <v-col class="mt-5 text-right">
              <v-btn
                color="primary"
                @click="submitReview"
                :loading="updatingReview"
                :disabled="updatingReview"
                >Submit</v-btn
              >
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-dialog>
    <v-dialog v-model="messageDialog" width="750">
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
  props: ["user", "categories", "apid"],
  components: { DatePick },
  data() {
    return {
      new_review: {
        psychic: "",
        service: "",
        category: "",
        rating: 0,
        headline: "",
        text: "",
        appointment: "",
      },
      display: false,
      today_appointments: [],
      tomorrow_appointments: [],
      after_tomorrow_appointments: [],
      after_tomorrow_day: moment().add(2, "d").format("YYYY-MM-DD"),
      messageDialog: false,
      updatingReview: false,
      review_dialog: false,
      tabs: null,
      upcoming_appointments: [],
      pending_appointments: [],
      completed_appointments: [],
      cancelled_appointments: [],
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
    /**
     * Prepare the component.
     */
    windowOpen(link){
      window.open(link, "_self");
    },

    appoimentsCheck(date) {
      if (!this.appoimentsMonth) return;
      let appoiments = [];
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
    getAppointments() {
      axios
        .get("/api/v1/user/appointments?status=&date_filter=")
        .then((response) => {
          this.appointments = response.data.data;
          this.categorizeAppointmentsbyDate();
          this.categorizeAppointments();
          this.loading = false;
          this.loadingUpdate = false;
          this.validateApid();
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
        .post("/api/v1/user/appointment/update/status", input)
        .then((response) => {
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
    editAppointment(appointment) {
      this.loadingUpdate = true;
      var input = {
        id: appointment.id,
        category: appointment.category.id,
        date: appointment.date,
        start: this.start_time,
        end: this.end_time,
        duration: appointment.duration,
        date_and_time: appointment.date + " " + this.start_time,
        notes: appointment.text,
      };

      axios
        .post("/api/v1/user/appointment/edit/data", input)
        .then((response) => {
          this.getAppointments();
          this.loadingUpdate = false;
          this.message = response.data.message;
          setTimeout(() => {
            this.message = "";
          }, 2000);
          this.selectedEvent = {};
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
    submitReview() {
      this.setNewReview();
      this.updatingReview = true;

      axios
        .post("/api/v1/user/review/create", this.new_review)
        .then((response) => {
          this.updatingReview = false;
          this.message = response.data.message;
          this.selectedEvent.reviewed = true;
          this.selectedEvent = {};
          this.review_dialog = false;
          this.messageDialog = true;
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

          this.updatingReview = false;
          this.message = "";
        });
    },
    setNewReview() {
      this.new_review.psychic = this.selectedEvent.psychic.id;
      this.new_review.service = this.selectedEvent.service.id;
      this.new_review.category = this.selectedEvent.category.id;
      this.new_review.appointment = this.selectedEvent.id;
    },
    edit(appointment) {
      this.selectedEvent = appointment;
      this.updateTimes();
    },
    newReview(appointment) {
      this.selectedEvent = appointment;
      this.updateTimes();
      this.review_dialog = true;
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

      return duration.asMinutes() + " min";
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
      // const open = () => {
      //   this.selectedEvent = event;
      //   this.selectedElement = nativeEvent.target;
      //   setTimeout(() => (this.selectedOpen = true), 10);
      // };

      // if (this.selectedOpen) {
      //   this.selectedOpen = false;
      //   setTimeout(open, 10);
      // } else {
      //   open();
      // }
      // this.updateTimes();
      // this.updateTab();
      // nativeEvent.stopPropagation();
      this.focus = date;

      axios
        .get(
          `/api/v1/user/appointments?status=${this.status}&date_filter=${this.focus}`
        )
        .then((response) => {
          this.appointments = response.data.data;
          this.categorizeAppointmentsbyDate();
          this.categorizeAppointments();
          this.loading = false;
          this.loadingUpdate = false;
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
    validateApid() {
      if (this.apid) {
        for (let i = 0; i < this.completed_appointments.length; i++) {
          const element = this.completed_appointments[i];

          if (element.id == this.apid && element.reviewed == 0) {
            this.newReview(element);
          }
        }
      }
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
.badgeUser {
  padding: 0px 16px !important;
  cursor: pointer;
}
.badgeUser.v-badge-list .v-badge__wrapper .v-badge__badge {
  min-width: 15px !important;
  height: 15px !important;
  border: 2px solid #fff !important;
  top: 29px !important;
  left: 43px !important;
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

.paddinStik {
  padding-bottom: 0px !important;
}
.v-dialog__content--active {
  opacity: 1 !important;
  -webkit-backdrop-filter: blur(10px);
  backdrop-filter: blur(10px);

}

</style>
