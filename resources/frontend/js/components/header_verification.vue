<template>
  <div>
    <header v-if="guest" class="credit_header" style="background-color: #fff">
      <div class="container p-0">
        <div class="row m-0 flex">
          <div class="col-12 text-center">
            <span
              class="primary--text m-0"
              :class="{ small: $vuetify.breakpoint.xsOnly }"
              >Get $10 Now, Try For Free!</span
            >
            <v-btn
              color="#FFAB6E"
              :small="$vuetify.breakpoint.xsOnly"
              @click="userSignupDialog = true"
              class="ml-2 elevation-0 white--text"
              >Redeem</v-btn
            >
          </div>
        </div>
      </div>
    </header>
    <header class="home_header" :style="[ $vuetify.breakpoint.xsOnly ? {'height': '50px !important'}:{'height': '80px !important'}]">
      <div class="container p-0">
        <div class="row m-0">
          <div class="col-4">
            <div class="logo">
              <a href="/">
                <img
                  alt="Psychics Logo"
                  src="/images/site-images/logo.png"
                  class="img-fluid"
                  height="60px"
                />
              </a>
            </div>
          </div>
          <div v-if="guest" class="col-8 text-right">
            <!--<a v-if="$vuetify.breakpoint.smAndUp" href="/apply" class="white&#45;&#45;text">Psychic Application</a>-->
            <v-btn
              rounded
              :small="$vuetify.breakpoint.xsOnly"
              @click="userSignupDialog = true"
              class="ml-2 elevation-0 btn-mobile"
              >Sign Up</v-btn
            >

            <v-btn
              rounded
              color="accent"
              :small="$vuetify.breakpoint.xsOnly"
              @click.prevent="loginDialog = true"
              class="ml-2 elevation-0"
              >Login</v-btn
            >
            <!--<a href="#" @click.prevent="loginDialog=true" class="btn btn-primary btn-mobile ml-2" :class="{'btn-sm': $vuetify.breakpoint.xsOnly}">Login</a>-->
          </div>
          <div v-else-if="user != null" class="col-8 text-right pt-lg-4 pt-0">
            <div class="d-inline-flex">
              <v-menu offset-y left>
                <template v-slot:activator="{ on }">
                  <a v-on="on" class="ml-3">
                    <div
                      :aria-label="user.userProfile.display_name"
                      class="user_avatar_sm"
                      :style="{
                        'background-image':
                          'url(' + user.userProfile.haedshot_path + ')',
                      }"
                    ></div>
                  </a>
                </template>
                <v-card :min-width="300">
                  <v-list dense class v-if="user.role_id == 1">
                    <v-list-item-group color="primary">
                      <v-list-item class="px-5" @click.prevent="logout()" dense>
                        <v-list-item-icon>
                          <img src="/images/icons/logout.svg" />
                        </v-list-item-icon>
                        <v-list-item-content>
                          <v-list-item-title
                            style="color: rgb(162, 162, 162) !important"
                            >Log Out</v-list-item-title
                          >
                        </v-list-item-content>
                      </v-list-item>
                    </v-list-item-group>
                  </v-list>
                  <v-list dense class v-else-if="user.role_id == 2">
                    <v-list-item-group color="primary">
                      <v-list-item class="px-5" @click.prevent="logout()" dense>
                        <v-list-item-icon>
                          <img src="/images/icons/logout.svg" />
                        </v-list-item-icon>
                        <v-list-item-content>
                          <v-list-item-title
                            style="color: rgb(162, 162, 162) !important"
                            >Log Out</v-list-item-title
                          >
                        </v-list-item-content>
                      </v-list-item>
                    </v-list-item-group>
                  </v-list>
                </v-card>
              </v-menu>
            </div>
          </div>
          <!--<div v-if="guest && $vuetify.breakpoint.xsOnly" class="col-12 text-center mt-10"> <a href="/apply" class="white&#45;&#45;text">Psychic Application</a></div>-->
        </div>
      </div>
    </header>

    <v-dialog
      v-model="signupDialog"
      width="750"
      :fullscreen="$vuetify.breakpoint.xsOnly"
    >
      <v-card>
        <v-card-text class="p-0">
          <div class="row m-0">
            <div class="col-12 text-right mt-2">
              <v-icon class="text-right" @click="signupDialog = false"
                >mdi-close</v-icon
              >
            </div>
            <div class="col-12">
              <div class="text-center">
                <h2>HAVE WHAT IT TAKES?</h2>
              </div>
              <div class="text-center">
                <h2>JOIN US TODAY</h2>
              </div>

              <div class="card-body px-0 pa-lg-5 pt-3">
                <form method="POST" action class="registration_form">
                  <div class="form-row mb-3">
                    <label
                      class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label"
                    >
                      Name
                      <span class="text-danger">*</span>
                    </label>

                    <div class="col-md-6 col-12 col-sm-6 col-lg-6 mb-5 mb-lg-0">
                      <input
                        class="form-control"
                        type="text"
                        v-model="newuser.name"
                        placeholder="First"
                      />
                      <span v-if="errors.name" class="float-left text-danger">{{
                        errors.name[0]
                      }}</span>
                    </div>

                    <div class="col-md-6 col-12 col-sm-6 col-lg-6">
                      <input
                        class="form-control"
                        type="text"
                        v-model="newuser.last_name"
                        placeholder="Last"
                      />
                      <span
                        v-if="errors.last_name"
                        class="float-left text-danger"
                        >{{ errors.last_name[0] }}</span
                      >
                    </div>
                  </div>

                  <div class="form-row mb-3">
                    <div class="col-md-3 col-6 col-sm-3 col-lg-3 mb-lg-0 mb-3">
                      <div class="form-row m-0">
                        <label
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-0 pr-0"
                        >
                          Country Code
                          <span class="text-danger">*</span>
                        </label>

                        <div
                          class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0"
                        >
                          <select
                            class="form-control"
                            style="-webkit-appearance: button"
                            v-model="newuser.code"
                          >
                            <option value disabled selected="selected">
                              Select
                            </option>
                            <option
                              v-for="country in country_all"
                              :key="country.id"
                              :value="country.code2"
                            >
                              {{ country.country }}({{ country.prefix }})
                            </option>
                          </select>
                          <span
                            v-if="errors.code"
                            class="float-left text-danger"
                            >{{ errors.code[0] }}</span
                          >
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 col-6 col-sm-3 col-lg-3 mb-lg-0 mb-3">
                      <div class="form-row m-0">
                        <label
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-0 pr-0"
                        >
                          Mobile
                          <span class="text-danger">*</span>
                        </label>

                        <div
                          class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0"
                        >
                          <input
                            class="form-control"
                            type="text"
                            v-model="newuser.number"
                            placeholder="(555) 555 5555"
                          />
                          <span
                            v-if="errors.number"
                            class="float-left text-danger"
                            >{{ errors.number[0] }}</span
                          >
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-12 col-sm-6 col-lg-6">
                      <div class="form-row m-0">
                        <label
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-0 pr-0"
                        >
                          Email
                          <span class="text-danger">*</span>
                        </label>

                        <div
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 pl-0 pr-0"
                        >
                          <input
                            class="form-control"
                            type="text"
                            v-model="newuser.email"
                            placeholder="gifted@psychics1on1.com"
                          />
                          <span
                            v-if="errors.email"
                            class="float-left text-danger"
                            >{{ errors.email[0] }}</span
                          >
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-row mb-3">
                    <label
                      class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label mb-0"
                    >
                      Display Name
                      <span class="text-danger">*</span>
                    </label>

                    <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                      <!--<input class="form-control" type="text" v-model="newuser.display_name" placeholder="Must only contain letters, numbers or dashes."/>-->

                      <input
                        class="form-control"
                        type="text"
                        v-model="newuser.display_name"
                      />
                      <span
                        v-if="errors.display_name"
                        class="float-left text-danger"
                        >{{ errors.display_name[0] }}</span
                      >
                    </div>
                  </div>

                  <div class="form-row mb-3">
                    <div class="col-md-6 col-12 col-sm-6 col-lg-6 mb-3">
                      <div class="form-row m-0">
                        <label
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-0 pr-0"
                        >
                          Password
                          <span class="text-danger">*</span>
                        </label>

                        <div
                          class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0"
                        >
                          <input
                            class="form-control"
                            type="password"
                            v-model="newuser.password"
                          />
                          <span
                            v-if="errors.password"
                            class="float-left text-danger"
                            >{{ errors.password[0] }}</span
                          >
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-12 col-sm-6 col-lg-6">
                      <div class="form-row m-0">
                        <label
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-0 pr-0"
                        >
                          Confirm Password
                          <span class="text-danger">*</span>
                        </label>

                        <div
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 pl-0 pr-0"
                        >
                          <input
                            class="form-control"
                            type="password"
                            v-model="newuser.c_password"
                            placeholder
                          />
                          <span
                            v-if="errors.c_password"
                            class="float-left text-danger"
                            >{{ errors.c_password[0] }}</span
                          >
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-row mb-3">
                    <div class="col-md-6 col-12 col-sm-6 col-lg-6 mb-3">
                      <div class="form-row m-0">
                        <label
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-0 pr-0"
                        >
                          I Was Referred by
                          <span class="text-danger">*</span>
                        </label>

                        <div
                          class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0"
                        >
                          <input
                            class="form-control"
                            type="text"
                            v-model="newuser.referral"
                          />
                          <span
                            v-if="errors.referral"
                            class="float-left text-danger"
                            >{{ errors.referral[0] }}</span
                          >
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-12 col-sm-6 col-lg-6"></div>
                  </div>

                  <div class="form-row mb-3">
                    <label
                      class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label"
                    >
                      Select All That Apply
                      <span class="text-danger">*</span>
                    </label>

                    <div
                      class="col-md-3 col-12 col-sm-3 col-lg-3 pr-lg-0"
                      :key="index"
                      v-for="(item, index) in this.categories"
                    >
                      <v-checkbox
                        v-model="newuser.categories"
                        :label="item"
                        :value="index + 1"
                        color="primary"
                        dense
                        hide-details
                      ></v-checkbox>
                    </div>
                    <span
                      v-if="errors.categories"
                      class="col-md-12 col-xs-12 col-sm-12 col-lg-12 float-left text-danger"
                      >{{ errors.categories[0] }}</span
                    >
                  </div>

                  <div class="form-row mb-3">
                    <div class="col-md-12 col-12 col-sm-12 col-lg-12 mb-0 mt-7">
                      <div class="form-row m-0">
                        <div
                          class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0"
                        >
                          <v-checkbox
                            class="float-left"
                            style="display: inline-block"
                            v-model="newuser.age"
                            hide-details
                            label="I am 13+ years old"
                          ></v-checkbox>
                          <span class="text-danger float-left">*</span>
                        </div>
                        <div
                          class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0"
                        >
                          <span v-if="errors.age" class="text-danger">{{
                            errors.age[0]
                          }}</span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-row mb-0 mt-5">
                    <div class="col-12">
                      <v-btn
                        rounded
                        large
                        min-width="150"
                        color="primary"
                        :loading="loading"
                        :disabled="loading"
                        @click="register()"
                        >Sign Up</v-btn
                      >
                      <p class="mt-3 mb-1">
                        Already registered?
                        <a
                          href="#"
                          @click.prevent="
                            signupDialog = false;
                            loginDialog = true;
                          "
                          >Login</a
                        >
                      </p>
                      <p class="m-0 small">
                        By signing up, you agree to our
                        <a href="/terms">Terms & Conditions</a>
                      </p>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
    <v-dialog
      v-model="userSignupDialog"
      width="500"
      :fullscreen="$vuetify.breakpoint.xsOnly"
    >
      <v-card>
        <v-card-text class="p-0">
          <div class="row m-0">
            <div class="col-12 text-right">
              <v-icon class="text-right" @click="userSignupDialog = false"
                >mdi-close</v-icon
              >
            </div>
            <div class="col-12">
              <div class="text-center">
                <h2>Sign Up</h2>
              </div>

              <div class="card-body px-0 pa-lg-5 pt-3">
                <form method="POST" action class="registration_form">
                  <div class="form-row mb-3">
                    <div class="col-md-12 col-12 col-sm-12 col-lg-12 mb-3">
                      <label class="control-label">
                        First Name
                        <span class="text-danger">*</span>
                      </label>
                      <input
                        class="form-control"
                        type="text"
                        v-model="newuser1.name"
                        placeholder="First"
                      />
                      <span
                        v-if="errors1.name"
                        class="float-left text-danger"
                        >{{ errors1.name[0] }}</span
                      >
                    </div>

                    <div class="col-md-12 col-12 col-sm-12 col-lg-12">
                      <label class="control-label">
                        Last Name
                        <span class="text-danger">*</span>
                      </label>
                      <input
                        class="form-control"
                        type="text"
                        v-model="newuser1.last_name"
                        placeholder="Last"
                      />
                      <span
                        v-if="errors1.last_name"
                        class="float-left text-danger"
                        >{{ errors1.last_name[0] }}</span
                      >
                    </div>
                  </div>

                  <div class="form-row mb-3">
                    <div class="col-md-12 col-12 col-sm-12 col-lg-12">
                      <div class="form-row m-0">
                        <label
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-0 pr-0"
                        >
                          Email
                          <span class="text-danger">*</span>
                        </label>

                        <div
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 pl-0 pr-0"
                        >
                          <input
                            class="form-control"
                            type="text"
                            v-model="newuser1.email"
                            placeholder="gifted@psychics1on1.com"
                          />
                          <span
                            v-if="errors1.email"
                            class="float-left text-danger"
                            >{{ errors1.email[0] }}</span
                          >
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-row mb-3">
                    <div class="col-md-5 col-6 col-sm-6 col-lg-5 mb-lg-0 mb-3">
                      <div class="form-row m-0">
                        <label
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-0 pr-0"
                        >
                          Country Code
                          <span class="text-danger">*</span>
                        </label>

                        <div
                          class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0"
                        >
                          <select
                            class="form-control"
                            style="-webkit-appearance: button"
                            v-model="newuser1.code"
                          >
                            <option value disabled selected="selected">
                              Select
                            </option>
                            <option
                              v-for="country in country_all"
                              :key="country.id"
                              :value="country.code2"
                            >
                              {{ country.country }}({{ country.prefix }})
                            </option>
                          </select>
                          <span
                            v-if="errors1.code"
                            class="float-left text-danger"
                            >{{ errors1.code[0] }}</span
                          >
                        </div>
                      </div>
                    </div>
                    <div class="col-md-7 col-6 col-sm-6 col-lg-7 mb-lg-0 mb-3">
                      <div class="form-row m-0">
                        <label
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-0 pr-0"
                        >
                          Mobile
                          <span class="text-danger">*</span>
                        </label>

                        <div
                          class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0"
                        >
                          <input
                            class="form-control"
                            type="text"
                            v-model="newuser1.number"
                            placeholder="(555) 555 5555"
                          />
                          <span
                            v-if="errors1.number"
                            class="float-left text-danger"
                            >{{ errors1.number[0] }}</span
                          >
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-row mb-3">
                    <div class="col-md-12 col-12 col-sm-12 col-lg-12 mb-3">
                      <div class="form-row m-0">
                        <label
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-0 pr-0"
                        >
                          Password
                          <span class="text-danger">*</span>
                        </label>

                        <div
                          class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0"
                        >
                          <input
                            class="form-control"
                            type="password"
                            v-model="newuser1.password"
                          />
                          <span
                            v-if="errors1.password"
                            class="float-left text-danger"
                            >{{ errors1.password[0] }}</span
                          >
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 col-12 col-sm-12 col-lg-12">
                      <div class="form-row m-0">
                        <label
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-0 pr-0"
                        >
                          Confirm Password
                          <span class="text-danger">*</span>
                        </label>

                        <div
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 pl-0 pr-0"
                        >
                          <input
                            class="form-control"
                            type="password"
                            v-model="newuser1.c_password"
                            placeholder
                          />
                          <span
                            v-if="errors1.c_password"
                            class="float-left text-danger"
                            >{{ errors1.c_password[0] }}</span
                          >
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-row mb-3">
                    <div class="col-md-12 col-12 col-sm-12 col-lg-12">
                      <div class="form-row m-0">
                        <label
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-0 pr-0"
                          >Promo Code</label
                        >

                        <div
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 pl-0 pr-0"
                        >
                          <input
                            class="form-control"
                            type="text"
                            v-model="newuser1.promo_code"
                            placeholder
                          />
                          <span
                            v-if="errors1.promo_code"
                            class="float-left text-danger"
                            >{{ errors1.promo_code[0] }}</span
                          >
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-row mb-3">
                    <div class="col-md-12 col-12 col-sm-12 col-lg-12 mb-3">
                      <div class="form-row m-0">
                        <div
                          class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0"
                        >
                          <v-checkbox
                            class="float-left"
                            style="display: inline-block"
                            v-model="newuser1.age"
                            hide-details
                            label="I am 13+ years old"
                          ></v-checkbox>
                          <span class="text-danger float-left">*</span>
                        </div>
                        <div
                          class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0"
                        >
                          <span v-if="errors1.age" class="text-danger">{{
                            errors1.age[0]
                          }}</span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-row mb-3 mt-8">
                    <div class="col-12 text-center">
                      <v-btn
                        class
                        large
                        color="primary"
                        rounded
                        min-width="150"
                        :loading="loading"
                        :disabled="loading"
                        @click="registerUser()"
                        >Sign Up</v-btn
                      >
                      <p class="mt-3 mb-1">
                        Already registered?
                        <a
                          href="#"
                          @click.prevent="
                            userSignupDialog = false;
                            loginDialog = true;
                          "
                          >Login</a
                        >
                      </p>
                      <p class="mt-0">
                        Are you a Psychic?
                        <a href="/psychic/redirect">Apply Now</a>
                      </p>
                      <p class="mt-8 small mb-0">
                        By signing up, you agree to our
                        <a href="/terms">Terms & Conditions</a>
                      </p>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
    <v-dialog
      v-model="messageDialog"
      width="600"
      :fullscreen="$vuetify.breakpoint.xsOnly"
    >
      <v-card>
        <v-card-text class="p-0">
          <div class="row m-0">
            <div class="col-12 text-right">
              <v-btn icon light @click="messageDialog = false" class="right">
                <i class="far fa-times-circle fa-2x primary--text"></i>
              </v-btn>
            </div>
            <div class="col-12">
              <div class="text-center p-5">
                <h1 class="mb-5">
                  THANK YOU
                  <br />FOR SIGNING UP!
                </h1>
                <p class="p-4 pt-0 mb-8" v-html="message"></p>
                <v-btn
                  class
                  rounded
                  color="primary"
                  @click="
                    messageDialog = false;
                    loginDialog = true;
                  "
                  >Login Now</v-btn
                >
              </div>
            </div>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
    <v-dialog
      v-model="loginDialog"
      width="500"
      :fullscreen="$vuetify.breakpoint.xsOnly"
    >
      <v-card>
        <v-card-text class="p-0">
          <div class="row m-0">
            <div class="col-12 text-right mt-2">
              <v-icon class="text-right" @click="loginDialog = false"
                >mdi-close</v-icon
              >
            </div>
            <div class="col-12">
              <div class="text-center">
                <h2>LOGIN</h2>
              </div>

              <div class="card-body p-0 p-lg-5 pt-3">
                <form
                  method="POST"
                  action
                  class="registration_form p-lg-5 pt-0 pb-0"
                >
                  <div class="form-row mb-3">
                    <label
                      class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label"
                    >
                      Email
                      <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 mb-3">
                      <input
                        class="form-control"
                        type="text"
                        v-model="email"
                        placeholder
                      />
                      <span
                        v-if="errors.email"
                        class="float-left text-danger"
                        >{{ errors.email[0] }}</span
                      >
                    </div>

                    <label
                      class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label"
                    >
                      Password
                      <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                      <input
                        class="form-control"
                        type="password"
                        v-model="password"
                        placeholder
                      />
                      <span
                        v-if="errors.password"
                        class="float-left text-danger"
                        >{{ errors.password[0] }}</span
                      >

                      <span v-if="error != ''" class="float-left text-danger">{{
                        error
                      }}</span>
                    </div>
                  </div>

                  <div class="form-row mb-3 mt-8">
                    <div class="col-12 text-center">
                      <v-btn
                        rounded
                        large
                        min-width="150"
                        color="primary"
                        :loading="loadingLogin"
                        :disabled="loadingLogin"
                        @click="login()"
                        >Login</v-btn
                      >
                      <p class="mt-3 mb-0">Don't have an account yet?</p>
                      <p>
                        <a
                          href="#"
                          @click.prevent="
                            loginDialog = false;
                            userSignupDialog = true;
                          "
                          class
                          >Sign Up</a
                        >
                        |
                        <a href="/psychic/redirect" class
                          >Psychic Application</a
                        >
                      </p>
                      <a href="/password/reset" class="btn btn-link mb-8"
                        >Forgot Your Password?</a
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
    <c-message></c-message>
  </div>
</template>
<script>
export default {
  props: ["user", "guest", "categories", "country_all"],

  data: function () {
    return {
      same_page_login: false,
      loadingLogin: false,
      loading: false,
      loginDialog: false,
      email: "",
      password: "",
      message: "",
      header: "",
      error: "",
      errors: [],
      errors1: [],
      signupDialog: false,
      userSignupDialog: false,
      message: "",
      messageDialog: "",
      newuser: {
        age: false,
        name: "",
        last_name: "",
        number: "",
        email: "",
        display_name: "",
        referral: "",
        categories: [],
        password: "",
        c_password: "",
        code: "",
      },
      newuser1: {
        age: false,
        name: "",
        last_name: "",
        email: "",
        password: "",
        c_password: "",
        code: "",
        number: "",
        promo_code: "",
      },
    };
  },
  mounted() {
    EventBus.$on("open_sign_up", () => (this.signupDialog = true));
    EventBus.$on("open_sign_up_user", () => (this.userSignupDialog = true));
    EventBus.$on("open_login", (data) => {
      this.loginDialog = true;
      this.same_page_login = data.same_page_login;
    });
  },
  ready() {
    EventBus.$on("open_sign_up", () => (this.signupDialog = true));
    EventBus.$on("open_sign_up_user", () => (this.userSignupDialog = true));
    EventBus.$on("open_login", () => (this.loginDialog = true));
  },

  methods: {
    register() {
      this.loading = true;
      var input = this.newuser;
      axios
        .post("/api/v1/register", input)
        .then((res) => {
          if (res.status == 201) {
            //Created
            this.message = res.data.success.message;
            this.signupDialog = false;
            this.resetUser();
            this.messageDialog = true;
          }
          this.loading = false;
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

          this.loading = false;
          this.message =
            "There is something wrong, please check that all form fields are correct.";
        });
    },
    registerUser() {
      this.loading = true;
      var input = this.newuser1;
      axios
        .post("/api/v1/register/user", input)
        .then((res) => {
          if (res.status == 201) {
            //Created
            this.message =
              "$10 in <button  class='credit_icon btn-sm' color='withe--text'>c</button> credits have been added to your account.";
            this.userSignupDialog = false;
            this.resetUser();
            this.messageDialog = true;
          }
          this.loading = false;
          this.errors1 = [];
        })
        .catch((error) => {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
          if (typeof error.response.data === "object") {
            this.errors1 = error.response.data.errors;
          } else {
            this.errors1 = ["Something went wrong. Please try again."];
          }

          this.loading = false;
          this.message =
            "There is something wrong, please check that all form fields are correct.";
        });
    },
    resetUser() {
      this.newuser = {
        name: "",
        last_name: "",
        number: "",
        email: "",
        display_name: "",
        referral: "",
        categories: [],
        password: "",
        c_password: "",
        age: false,
      };

      this.newuser1 = {
        name: "",
        last_name: "",
        email: "",
        password: "",
        c_password: "",
        age: false,
        promo_code: "",
      };
    },
    logout() {
      axios
        .post("/logout")
        .then((response) => {
          if (response.status === 200) {
            window.location = "/";
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
      // this.$refs.logoutform.submit()
    },
    login() {
      this.loadingLogin = true;
      this.error = "";
      var input = { email: this.email, password: this.password };
      axios
        .post("/ajax/login", input)
        .then((res) => {
          if (res.status == 200) {
            //Created

            if (this.same_page_login) {
              location.reload();
            } else {
              window.location = res.data.success.url;
            }
          }
        })
        .catch((error) => {
          this.errors = [];
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
          if (typeof error.response.data === "object") {
            if (error.response.data.error) {
              this.error = error.response.data.error;
            }

            if (error.response.data.errors) {
              this.errors = error.response.data.errors;
            }
          } else {
            this.errors = ["Something went wrong. Please try again."];
          }

          this.loadingLogin = false;
          this.message = "There is something wrong.";
        });
    },
  },
};
</script>

<style>
.credit_icon {
  background-color: #8ebef8 !important;
  font-size: 11px !important;

  padding: 0 !important;
  min-width: 16px !important;
  height: 16px !important;
  color: white !important;
  border-radius: 100% !important;
}

.v-label {
  font-size: 14px;
}
</style>