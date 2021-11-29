<template>
  <div>
    <div class="fixed_header_container">
      <!-- <header v-if="guest && redeem == 'true'" class="credit_header" style="background-color:#fff">
            <div class="container p-0">
                <div class="row m-0 flex">
                    <div class="col-12 text-center">
                        <span class="primary&#45;&#45;text m-0" :class="{'small': $vuetify.breakpoint.smAndDown}">Get $10 Now, Try For Free!</span>
                        <v-btn  color="#FFAB6E" :small="$vuetify.breakpoint.smAndDown"  @click="userSignupDialog=true"  class="ml-2 elevation-0 white&#45;&#45;text">Redeem</v-btn>
                    </div>
                </div>
            </div>
      </header>-->

       <!-- <header v-if="!guest && (user.login_counter == 1 || user.login_counter == 2)" style="background-color:#43435B">
            <div class="container p-0">
                <div class="row m-0 flex">
                    <div class="col-12 text-center info_browser">
                        <span class="text-white m-0" :class="{'small': $vuetify.breakpoint.xsOnly}">For the best video & call experience, we recommend using Safari on a computer</span>
                    </div>
                    <v-icon style="position: absolute;right: 15px;color: white;" @click="signupDialog=false">mdi-close</v-icon>
                </div>
            </div> 
      </header> -->
       <header-info :user="user"></header-info>
      <header
        class="home_header pb-0 pt-0"
        :style="[ $vuetify.breakpoint.smAndDown ? {'height': '50px !important'}:{'height': '118px !important', overflow: 'inherit'}]"
        :class="{'fixed_header': guest }"
        v-if="!$vuetify.breakpoint.smAndDown || !user"
      >
      
        <div class="container-fluid p-0">
          <div class="row m-0">
            <div class="col-3 col-lg-3 col-md-4 pr-md-0 pt-1">
              <a v-if="$vuetify.breakpoint.smAndDown && guest" href="#"  @click.stop="drawer = !drawer"><img src="/images/icons/menu.svg"/></a>
              <SearchInputHeader v-if="!$vuetify.breakpoint.smAndDown && !search" :header="true" />
              <SearchFilterHeader v-if="!$vuetify.breakpoint.smAndDown && !search" :header="true"/>
            </div>
            <div
              class="col-6 col-lg-6 col-md-4 text-center pl-md-0 pt-3 pt-lg-2"
              :class="{'pb-4 pt-0': !$vuetify.breakpoint.smAndDown}"
            >
              <div class="logo" style="margin:auto">
                <a href="/">
                  <img
                    alt="Psychics"
                    src="/images/site-images/psychics_logo_white.svg"
                    class="img-fluid"
                    :style="[ !$vuetify.breakpoint.smAndDown ? {'height': '60px !important'}:{'height': '36px !important'}]"
                  />
                </a>
              </div>
            </div>
            <div
              v-if="guest && !$vuetify.breakpoint.smAndDown"
              class="col-4 col-lg-3 text-center"
              :class="{'pt-6': !$vuetify.breakpoint.smAndDown}"
            >
              <!--<a v-if="$vuetify.breakpoint.smAndUp" href="/apply" class="white&#45;&#45;text">Psychic Application</a>-->

              <a
                @click.prevent="loginDialog=true"
                href="#"
                class="ml-0 white--text mr-10" style="font-size: 14px !important;font-weight: 500 !important;"
                :class="{' mr-5': !$vuetify.breakpoint.smAndDown,' mr-2': $vuetify.breakpoint.smAndDown}"
              >Log In</a>

              <a
                href="/signup" style="font-size: 14px !important;font-weight: 500 !important;"
                class="ml-2 white--text"
              >Sign Up</a>

              <!--<a href="#" @click.prevent="loginDialog=true" class="btn btn-primary btn-mobile ml-2" :class="{'btn-sm': $vuetify.breakpoint.smAndDown}">Login</a>-->
            </div>
            <div v-else-if="user!=null" class="col-3 text-center pt-5">
              <div class="d-inline-flex">
                <div>
                  <credits v-if="user.role_id===2" :user="user" class="mt-2" />
                </div>

                <div class="mr-2">
                  <text-chat-notifications color="white" size="27px" :user="user"></text-chat-notifications>
                </div>

                <toxbox-chat-notifications color="white" size="27px" :user="user"></toxbox-chat-notifications>

                <div v-if="$vuetify.breakpoint.smAndDown">
                  <v-btn v-if="user.role_id===1" text icon color="white" href="/dashboard/menu">
                    <img :src="dash_menu" />
                  </v-btn>

                  <v-btn
                    v-if="user.role_id===2"
                    text
                    icon
                    color="white"
                    href="/dashboard/user/menu"
                  >
                    <img :src="dash_menu" />
                  </v-btn>
                </div>

                <v-menu
                  v-model="menu_opened"
                  v-if="!$vuetify.breakpoint.smAndDown"
                  offset-y
                  left
                  content-class="my-menu"
                >
                  <template v-slot:activator="{ on }">
                    <a v-on="on" class="ml-3">
                      <div
                        class="w-profile"
                        style="width: 40px"
                        :style="[ menu_opened ? {'background-image': 'url(/images/icons/profile-active.svg)' } :{ 'background-image': 'url(/images/icons/profile.svg)' }]"
                      ></div>
                    </a>
                  </template>
                  <v-card
                    style="border-radius:  5px !important;"
                    :min-width="300"
                    :min-height="user.role_id != 3 ? 150 : '100%'"
                  >
                    <v-list dense class v-if="user.role_id == 1">
                      <v-list-item-group color="primary">
                        <v-list-item dense class="px-5" href="/dashboard">
                          <v-list-item-icon>
                            <img src="/images/icons/calendar.svg" />
                          </v-list-item-icon>
                          <v-list-item-content>
                            <v-list-item-title>Appointments</v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>

                        <v-list-item dense class="px-5" href="/dashboard/services">
                          <v-list-item-icon>
                            <img src="/images/icons/services_bar.svg" />
                          </v-list-item-icon>
                          <v-list-item-content>
                            <v-list-item-title>Services</v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>

                        <v-list-item class="px-5" href="/dashboard/reviews">
                          <v-list-item-icon>
                            <img src="/images/icons/review.svg" />
                          </v-list-item-icon>
                          <v-list-item-content>
                            <v-list-item-title>Reviews</v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                        <v-list-item class="px-5" href="/dashboard/payout">
                          <v-list-item-icon>
                            <img src="/images/icons/moneys.svg" />
                          </v-list-item-icon>
                          <v-list-item-content>
                            <v-list-item-title>Money</v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                        <v-list-item class="px-5" href="/dashboard/analytics">
                          <v-list-item-icon>
                            <img src="/images/icons/analytic.svg" />
                          </v-list-item-icon>
                          <v-list-item-content>
                            <v-list-item-title>Analytics</v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>

                      <v-list-item class="px-5" href="https://psychics1on1-psychics.zendesk.com/hc/en-us"  target="_blank">
                          <v-list-item-icon>
                            <img src="/images/icons/help.svg"/>
                          </v-list-item-icon>
                          <v-list-item-content>
                            <v-list-item-title>Help</v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>


                          <v-list-item class="px-5" href="/blog">
                          <v-list-item-icon>
                            <img src="/images/icons/blog.svg"/>
                          </v-list-item-icon>
                          <v-list-item-content>
                            <v-list-item-title>Blog</v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>


                        <v-list-item class="px-5" @click.prevent="logout()" dense>
                          <v-list-item-icon>
                            <img src="/images/icons/logout.svg" />
                          </v-list-item-icon>
                          <v-list-item-content>
                            <v-list-item-title style="color:rgb(162, 162, 162) !important">Log Out</v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                      </v-list-item-group>
                    </v-list>
                    <v-list dense class v-else-if="user.role_id == 2">
                      <v-list-item-group color="primary">
                        <v-list-item
                          dense
                          class="px-5"
                          href="/dashboard/appointments"
                          style="padding-top:10px !important"
                        >
                          <v-list-item-icon>
                            <img src="/images/icons/calendar.svg" />
                          </v-list-item-icon>
                          <v-list-item-content>
                            <v-list-item-title>Appointments</v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>

                        <v-list-item class="px-5" href="/dashboard/user/reviews">
                          <v-list-item-icon>
                            <img src="/images/icons/review.svg" />
                          </v-list-item-icon>
                          <v-list-item-content>
                            <v-list-item-title>Reviews</v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>

                        <v-list-item dense class="px-5" href="/dashboard/favorites">
                          <v-list-item-icon>
                            <img src="/images/icons/favorites.svg" />
                          </v-list-item-icon>
                          <v-list-item-content>
                            <v-list-item-title>Favorites</v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                        <v-list-item class="px-5" href="/dashboard/transaction">
                          <v-list-item-icon>
                            <img src="/images/icons/moneys.svg" />
                          </v-list-item-icon>
                          <v-list-item-content>
                            <v-list-item-title>Transactions</v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                        <v-list-item class="px-5" href="/dashboard/payment">
                          <v-list-item-icon>
                            <img src="/images/icons/payment.svg" />
                          </v-list-item-icon>
                          <v-list-item-content>
                            <v-list-item-title>Payment</v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                        <v-list-item class="px-5" href="https://psychics1on1.zendesk.com/hc/en-us"  target="_blank">
                          <v-list-item-icon>
                            <img src="/images/icons/help.svg" />
                          </v-list-item-icon>
                          <v-list-item-content>
                            <v-list-item-title>Help</v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>

                        <v-list-item
                          class="px-5"
                          @click.prevent="logout()"
                          dense
                          style="padding-bottom:10px !important"
                        >
                          <v-list-item-icon>
                            <img src="/images/icons/logout.svg" />
                          </v-list-item-icon>
                          <v-list-item-content>
                            <v-list-item-title style="color:rgb(162, 162, 162) !important">Log Out</v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                      </v-list-item-group>
                    </v-list>
                    <v-list dense class v-else-if="user.role_id == 3 || user.role_id == 4 || user.role_id == 7">
                      <v-list-item-group color="primary">
                        <v-list-item
                          class="px-5"
                          link
                          href="/admin"
                          dense
                          style="text-decoration: none"
                        >
                          <v-list-item-icon>
                            <!-- <i class="fas fa-power-off mt-1"></i> -->
                          </v-list-item-icon>
                          <v-list-item-content>
                            <v-list-item-title>Admin dashboard</v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>

                        <v-list-item class="px-5" @click.prevent="logout()" dense>
                          <v-list-item-icon>
                            <img src="/images/icons/logout.svg" />
                          </v-list-item-icon>
                          <v-list-item-content>
                            <v-list-item-title style="color:rgb(162, 162, 162) !important">Log Out</v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                      </v-list-item-group>
                    </v-list>
                  </v-card>
                </v-menu>
              </div>
            </div>
            <!--<div v-if="guest && $vuetify.breakpoint.smAndDown" class="col-12 text-center mt-10"> <a href="/apply" class="white&#45;&#45;text">Psychic Application</a></div>-->
          </div>
        <div v-if="!$vuetify.breakpoint.smAndDown" class="container p-0">
        <div class="row  p-0 pb-4 m-0" style="font-size: 14px;font-weight: 500;">
        <div class="col-10  mx-auto">
        <div class="row">
          <div class="col-1"></div>
          <div class="text-center"  :class="user && user.role_id===2 ? 'col-1' : 'col-2'"></div>
          <div class="col-2 text-center"><a href="/#specialties"  class="white--text mr-10">Specialties</a></div>
          <div class="col-2 text-center"><a href="/#abilities"  class="white--text mr-10">Abilities</a></div>
          <div class="col-2 text-center"><a href="/horoscope"  class="white--text">Horoscopes</a></div>
          <div class="col-2 text-center"><a v-if="user && user.role_id===2" href="/blog"  class="white--text mr-10">Blog</a></div>
          <div class="col-1"></div>
          </div>
        </div>
        
      </div>
        </div>  
        
        </div>
      </header>

      <!-- <div v-if="user && $vuetify.breakpoint.smAndDown" style="height:80px !important"></div> -->

      <nav
        class="navbar"
        style="max-height: 60px; height: 60px;"
        v-if="user && $vuetify.breakpoint.smAndDown"
        id="mobile-nav"
      >
        <v-row>
          <v-col v-if="user.role_id===1" :md="4" class="text-center">
            <v-btn text icon color="white" href="/dashboard">
              <img :src="dash_app" width="40px" />
            </v-btn>
          </v-col>
          <v-col v-if="user.role_id===2" :md="4" class="text-center">
            <v-btn text icon color="white" href="/dashboard/appointments">
              <img :src="dash_app" width="40px" />
            </v-btn>
          </v-col>
          <v-col :md="4" class="text-center">
            <text-chat-notifications color="white" :user="user"></text-chat-notifications>
          </v-col>
          <v-col :md="4" class="text-center">
            <toxbox-chat-notifications color="white" :user="user"></toxbox-chat-notifications>
          </v-col>
          <v-col v-if="user.role_id===1" :md="4" class="text-center">
            <v-btn text icon color="white" href="/dashboard/menu">
              <img :src="dash_menu" />
            </v-btn>
          </v-col>
          <v-col v-if="user.role_id===2" :md="4" class="text-center">
            <v-btn text icon color="white" href="/dashboard/user/menu">
              <img :src="dash_menu" />
            </v-btn>
          </v-col>
            <credits style="display:none" v-if="user.role_id===2" :user="user" class="mt-2" />
        </v-row>
      </nav>

      <v-dialog
        v-if="signupDialog"
        v-model="signupDialog"
        width="375"
      >
        <v-card style="background:#F4F4F4;border-radius:30px!important ">
          <v-card-text class="p-0">
            <div class="row m-0">
              <div class="col-12 text-right mt-6 pr-6">
                <v-icon class="text-right" @click="signupDialog=false">mdi-close</v-icon>
              </div>

              <div class="col-12 px-3">
                <div class="card-body px-0 pt-8">
                  <form method="POST" action class="registration_form">
                  <div v-if="step == 1">
                    <div class="form-row mb-4">
                        <div class="col-md-12 col-12 col-sm-12 col-lg-12">
                          <div class="form-row m-0">
                            <div
                            style="font-size:20px;color:#43425D;font-weight: 600;"
                            >Psychic Application Step 1</div>
                          </div>
                        </div>
                      </div>

                      <div class="form-row mb-0">
                        <label
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-4 pr-0" style="font-size:12px!important;color:#A2A2A2!important"
                        >
                          Account Info
                        </label>

                        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                              <v-text-field
                              label=""
                              placeholder="Email"
                              v-model="newuser.email"
                              hide-details
                              flat
                              height="40"
                              solo
                            
                              class="inputClass1"
                            >
                            <template v-slot:prepend-inner>
                                
                                    <img
                                      width="32"
                                      height="32"
                                      src="/images/icons/email.svg"
                                      alt=""
                                    >
                              
                              </template>
                            </v-text-field>
                              <span class="float-right text-danger" style="min-height:25px;font-size:12px">
                          <span  v-if="errors.email">{{ errors.email[0] }}</span>
                          </span>
                        </div>
                      </div>
                      <div class="form-row mb-0">
                      <div class="col-md-12 col-12 col-sm-12 col-lg-12">
                              <v-text-field
                          label=""
                          placeholder="Password"
                          v-model="newuser.password"
                          hide-details
                          flat
                          height="40"
                          solo
                          type="password"
                          
                          class="inputClass1"
                        >
                        
                            <template v-slot:prepend-inner>
                            
                                <img
                                  width="32"
                                  height="32"
                                  src="/images/icons/password.svg"
                                  alt=""
                                >
                          
                          </template>
                          <!--<template v-slot:append>
                              <v-icon @click="show1 = !show1" size="20" color="#ccc">
                                    mdi-help-circle-outline
                              </v-icon>
                          </template>-->
                            
                        </v-text-field>
                        <span v-if="!errors.password" class="float-right pb-2"  style="min-height:25px;color:#43425D;font-size:12px;">
                          <span style="line-height:18pt;">uppercase letter, number & special character required</span>
                        </span>
                        <span class="float-right text-danger"  style="min-height:25px;font-size:12px">
                          <span   v-if="errors.password">{{ errors.password[0] }}</span>
                          </span>
                            </div>
                      </div>
                      <div class="form-row mb-0">
                        <div class="col-6  mb-lg-0 pr-2">
                          <div class="form-row m-0">
                          

                            <div class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0">
                          
                              <v-select
                                v-model="newuser.code"
                                :items="country_all"
                                item-text="country"
                                item-value="id"
                                label="Select"
                                filled
                                background-color="#FFFFFF"
                                class="whiteCheckList"
                                :menu-props="{contentClass: 'checkList-lineGrey'}"
                                dense
                                solo
                                :height="40"
                              >
                                <template
                                  slot="selection"
                                  slot-scope="data"
                                ><span style="font-size:14px!important;color: rgba(0, 0, 0, 0.87)!important;">{{data.item.code2}} (+ {{data.item.prefix}} )</span></template>
                                <template
                                  slot="item"
                                  slot-scope="data"
                                >{{data.item.country}} (+ {{data.item.prefix}} )</template>
                              </v-select>

                              <span
                                v-if="errors.code"
                                class="float-left text-danger" style="font-size:12px"
                              >{{ errors.code[0] }}</span>
                            </div>
                          </div>
                        </div>
                        <div class="col-6  mb-lg-0 pl-2">
                          <div class="form-row m-0">
                            
                            <div class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0">

                            <v-text-field
                              label=""
                              placeholder="Mobile"
                              v-model="newuser.number"
                              hide-details
                              flat
                              height="40"
                              solo
                            
                              class="inputClass1"
                            >
                            <template v-slot:prepend-inner>
                                
                                    <img
                                      width="32"
                                      height="32"
                                      src="/images/icons/mobile.svg"
                                      alt=""
                                    >
                              
                              </template>
                            </v-text-field>
                          
                            </div>
                          </div>
                        </div>
                        
                        <div class="col-md-12 col-12 col-sm-12 col-lg-12">
                        <span v-if="!errors.number" class="float-right pb-2"  style="min-height:25px;color:#43425D;font-size:12px;">
                          <span style="line-height:18pt;">numbers only</span>
                        </span>
                            <span class="float-right text-danger" style="min-height:25px;font-size:12px">
                              <span   v-if="errors.number">{{ errors.number[0] }}</span>
                            </span>
                        </div>

                      </div>
                      <div class="form-row mb-0">
                      <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                              <v-text-field
                              label=""
                              placeholder="First Name"
                              v-model="newuser.name"
                              hide-details
                              flat
                              height="40"
                              solo
                            
                              class="inputClass1"
                            >
                            <template v-slot:prepend-inner>
                                
                                    <img
                                      width="32"
                                      height="32"
                                      src="/images/profile/finger_print.svg"
                                      alt=""
                                    >
                              
                              </template>
                            </v-text-field>
                              <span class="float-right text-danger" style="min-height:25px;font-size:12px">
                          <span  v-if="errors.name">{{ errors.name[0] }}</span>
                          </span>
                        </div>
                        </div>
                      <div class="form-row mb-0">
                      <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                              <v-text-field
                              label=""
                              placeholder="Last Name"
                              v-model="newuser.last_name"
                              hide-details
                              flat
                              height="40"
                              solo
                            
                              class="inputClass1"
                            >
                            <template v-slot:prepend-inner>
                                
                                    <img
                                      width="32"
                                      height="32"
                                      src="/images/profile/finger_print.svg"
                                      alt=""
                                    >
                              
                              </template>
                            </v-text-field>
                              <span class="float-right text-danger" style="min-height:25px;font-size:12px">
                          <span  v-if="errors.last_name">{{ errors.last_name[0] }}</span>
                          </span>
                        </div>
                      </div>
                      <div class="form-row mb-0">
                        

                        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                          <v-text-field
                              label=""
                              placeholder="Display Name"
                              v-model="newuser.display_name"
                              hide-details
                              flat
                              height="40"
                              solo
                            
                              class="inputClass1"
                            >
                            <template v-slot:prepend-inner>
                                
                                    <img
                                      width="32"
                                      height="32"
                                      src="/images/profile/name.svg"
                                      alt=""
                                    >
                              
                              </template>
                            </v-text-field>
                              <span class="float-right text-danger" style="min-height:25px;font-size:12px;">
                          <span  v-if="errors.display_name">{{ errors.display_name[0] }}</span>
                          </span>
                        </div>
                      </div>

                      <div class="form-row mb-3">
                        <div class="col-md-12 col-12 col-sm-12 col-lg-12 mb-0 mt-0">
                          <div class="form-row m-0">
                            <div class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0">
                              <v-checkbox
                                class="float-left age"
                                style="display: inline-block;"
                                v-model="newuser.age"
                                hide-details
                              >
                                <!--<template v-slot:label>
                                                              <label>
                                                                  By signing up, you certify that you are 18 years old or older, and you agree to our
                                                                  <a
                                                                          href="/terms"
                                                                  >Terms & Conditions</a>.
                                                                  <span class="text-danger">*</span>
                                                              </label>
                                </template>-->
                              </v-checkbox>
                              <label style="width: 88%;font-size: 12px !important;color:#43425D!important;font-weight: 400;line-height:18pt;">
                                By signing up, you certify that you are 18 years old or older, and you agree to our
                                <a style="color: #8EbEF8" target="_blank"
                                  href="/terms"
                                >Terms & Conditions</a>.
                              </label>
                            </div>
                            <div class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0">
                              <span v-if="errors.age" class="text-danger float-right" style="font-size:12px">{{ errors.age[0] }}</span>
                            </div>
                            <div
                              v-if="errors.spam"
                              class="mt-3 col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0"
                            >
                              <span class="text-danger float-right" style="font-size:12px">{{ errors.spam[0] }}</span>
                            </div>
                          </div>
                        </div>
                      </div>

                   <div class="form-row mb-0 mt-0">
                      <div class="col-6">
                      <v-btn
                         
                          class="mb-2"
                          
                          color="#8EbEF8"
                          depressed
                          outlined
                          rounded
                          min-width="84"
                          :loading="loading"
                          :disabled="loading"
                          @click.prevent="signupDialog=false;loginDialog=true;"
                        >
                          <span style="color: #8EbEF8">Log In</span>
                        </v-btn>
                        
                     
                      </div>
                      <div class="col-6 text-right">
                        
                      <v-btn
                          class="mb-2"
                          color="#8EbEF8"
                          depressed
                          rounded
                          min-width="74"
                          :loading="loading"
                          :disabled="loading"
                          @click="step1()"
                        >
                          <span style="color: #ffffff">Next</span>
                        </v-btn>
                      </div>
                    </div>
                  </div> 
                    
                    <!-- <div class="form-row mb-3">

                                        <div class="col-md-6 col-12 col-sm-6 col-lg-6 mb-3">
                                            <div class="form-row m-0">
                                                <label  class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-0 pr-0">I Was Referred by<span class="text-danger">*</span></label>

                                                <div class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0">
                                                    <input class="form-control" type="text" v-model="newuser.referral"/>
                                                    <span v-if="errors.referral" class="float-left text-danger">{{ errors.referral[0] }}</span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 col-sm-6 col-lg-6">

                                        </div>


                                    </div>
                    -->
                  <div v-if="step == 2">
                    <div class="form-row mb-4">
                        <div class="col-md-12 col-12 col-sm-12 col-lg-12">
                          <div class="form-row m-0">
                            <div
                            style="font-size:20px;color:#43425D;font-weight: 600;"
                            >Psychic Application Step 2</div>
                          </div>
                        </div>
                     </div>
                    <div class="form-row mb-3">
                         <label class="col-6 control-label mb-0" style="font-size:12px!important;color:#A2A2A2!important">
                         Abilities
                        </label>
                        <label class="col-6 control-label mb-0" style="font-size:10px!important;color:#A2A2A2!important">
                          Select up to 4
                        </label>
                        <div
                          class="col-md-6 col-12 col-lg-6 pr-lg-0 checks"
                          :key="index"
                          v-for="(item, index) in this.categories"
                        >
                          <v-checkbox
                          :disabled="newuser.categories.length >3 && newuser.categories.indexOf(index+1) == -1"
                            v-model="newuser.categories"
                            :label="item"
                            :value="index+1"
                            color="primary"
                            dense
                            hide-details
                          ></v-checkbox>
                        </div>
                        <span
                          v-if="errors.categories"
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 float-left text-danger" style="font-size:12px"
                        >{{ errors.categories[0] }}</span>
                    </div>
                    <div class="form-row mb-3">
                         <label class="col-6 control-label mb-0" style="font-size:12px!important;color:#A2A2A2!important">
                         Tools
                        </label>
                        <label class="col-6 control-label mb-0" style="font-size:10px!important;color:#A2A2A2!important">
                          Select up to 3
                        </label>
                        <div
                          class="col-md-6 col-12 col-lg-6 pr-lg-0 checks"
                          :key="index"
                          v-for="(item, index) in this.tools"
                        >
                          <v-checkbox
                          :disabled="newuser.tools.length >2 && newuser.tools.indexOf(index+1) == -1"
                            v-model="newuser.tools"
                            :label="item.name"
                            :value="item.id"
                            color="primary"
                            dense
                            hide-details
                          ></v-checkbox>
                        </div>
                        <span
                          v-if="errors.tools"
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 float-left text-danger" style="font-size:12px"
                        >{{ errors.tools[0] }}</span>
                    </div>
                    <div class="form-row mb-0 mt-7">
                      <div class="col-6">
                      <v-btn
                         
                          class="mb-2"
                          
                          color="#8EbEF8"
                          depressed
                          outlined
                          rounded
                          min-width="84"
                          :loading="loading"
                          :disabled="loading"
                          @click.prevent="step--"
                        >
                          <span style="color: #8EbEF8">Back</span>
                        </v-btn>
                        
                     
                      </div>
                      <div class="col-6 text-right">
                        
                      <v-btn
                          class="mb-2"
                          color="#8EbEF8"
                          depressed
                          rounded
                          min-width="74"
                         :loading="loading"
                          :disabled="loading"
                          @click="step2()"
                        >
                          <span style="color: #ffffff">Next</span>
                        </v-btn>
                      </div>
                    </div>
                  </div>  
                    
                  <div v-if="step == 3">
                   <div class="form-row mb-4">
                        <div class="col-md-12 col-12 col-sm-12 col-lg-12">
                          <div class="form-row m-0">
                            <div
                            style="font-size:20px;color:#43425D;font-weight: 600;"
                            >Psychic Application Step 3</div>
                          </div>
                        </div>
                     </div>
                     <div class="form-row mb-3">
                        <label class="col-6 control-label mb-0" style="font-size:12px!important;color:#A2A2A2!important">
                         Specialties
                        </label>
                        <label class="col-6 control-label mb-0" style="font-size:10px!important;color:#A2A2A2!important">
                          Select up to 4
                        </label>
                        <div
                          class="col-md-6 col-12 col-lg-6 pr-lg-0 checks"
                          :key="index"
                          v-for="(item, index) in this.specialties"
                        >
                          <v-checkbox
                          :disabled="newuser.specialties.length >3 && newuser.specialties.indexOf(index+1) == -1"
                            v-model="newuser.specialties"
                            :label="item.name"
                            :value="item.id"
                            color="primary"
                            dense
                            hide-details
                          ></v-checkbox>
                        </div>
                        <span
                          v-if="errors.specialties"
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 float-left small text-danger" style="font-size:12px"
                        >{{ errors.specialties[0] }}</span>
                     </div>

                     <div class="form-row mb-3">
                        <label class="col-6 control-label mb-0" style="font-size:12px!important;color:#A2A2A2!important">
                         Style
                        </label>
                        <label class="col-6 control-label mb-0" style="font-size:10px!important;color:#A2A2A2!important">
                          Select one
                        </label>
                        <div
                          class="col-md-6 col-12 col-lg-6 pr-lg-0 checks"
                          :key="index"
                          v-for="(item, index) in this.styles"
                        >
                          <v-checkbox
                          :disabled="newuser.styles.length >0 && newuser.styles.indexOf(index+1) == -1"
                            v-model="newuser.styles"
                            :label="item.name"
                            :value="item.id"
                            color="primary"
                            dense
                            hide-details
                          ></v-checkbox>
                        </div>
                        <span
                          v-if="errors.styles"
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 float-left text-danger" style="font-size:12px"
                        >{{ errors.styles[0] }}</span>
                     </div>
                   
                     <div class="form-row mb-0 mt-7">
                      <div class="col-6">
                      <v-btn
                         
                          class="mb-2"
                          
                          color="#8EbEF8"
                          depressed
                          outlined
                          rounded
                          min-width="84"
                          :loading="loading"
                          :disabled="loading"
                          @click.prevent="step--"
                        >
                          <span style="color: #8EbEF8">Back</span>
                        </v-btn>
                        
                     
                      </div>
                      <div class="col-6 text-right">
                        
                      <v-btn
                          class="mb-2"
                          color="#8EbEF8"
                          depressed
                          rounded
                          min-width="70"
                          :loading="loading"
                          :disabled="loading"
                          @click="step3()"
                        >
                          <span style="color: #ffffff">Finish</span>
                        </v-btn>
                      </div>
                    </div>

                  </div>  
               

                    
                  </form>
                </div>
              </div>
            </div>
          </v-card-text>
        </v-card>
      </v-dialog>

      <v-dialog v-model="userSignupDialog" width="335">
        <v-card style="background:#F4F4F4;border-radius:30px!important ">
          <v-card-text class="p-0">
            <div class="row m-0">
              <div class="col-12 text-right mt-6 pr-6">
                <v-icon class="text-right" @click="userSignupDialog=false">mdi-close</v-icon>
              </div>

              <div class="col-12 px-3">
                <div class="card-body px-0 pt-8">
                  <form method="POST" action class="registration_form">
                    <div class="form-row mb-4">
                      <div class="col-md-12 col-12 col-sm-12 col-lg-12">
                        <div class="form-row m-0">
                          <div
                             style="font-size:20px;color:#43425D;font-weight: 600;"
                          >Join for Free!</div>
                        </div>
                      </div>
                    </div>
                    <div class="form-row mb-0">
                      <div class="col-md-12 col-12 col-sm-12 col-lg-12">
                        <div class="form-row m-0">
                          <label
                            class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-0 pr-0"  style="font-size:12px!important;color:#A2A2A2!important"
                          >
                            Create Account
                          </label>

                        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 pl-0 pr-0">
                            <v-text-field
                            label=""
                            placeholder="Email"
                            v-model="newuser1.email"
                            hide-details
                            flat
                            height="40"
                            solo
                          
                            class="inputClass1"
                          >
                          <template v-slot:prepend-inner>
                              
                                  <img
                                    width="32"
                                    height="32"
                                    src="/images/icons/email.svg"
                                    alt=""
                                  >
                            
                            </template>
                          </v-text-field>
                             <span class="float-right text-danger" style="min-height:25px;font-size:12px">
                        <span  v-if="errors1.email">{{ errors1.email[0] }}</span>
                        </span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-row mb-0">
                      <div class="col-md-12 col-12 col-sm-12 col-lg-12">
                        <div class="form-row m-0">
                          

                          <div class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0">
                             <v-text-field
                        label=""
                        placeholder="Password"
                        v-model="newuser1.password"
                        hide-details
                        flat
                        height="40"
                        solo
                        type="password"
                        
                        class="inputClass1"
                      >
                      
                           <template v-slot:prepend-inner>
                           
                              <img
                                width="32"
                                height="32"
                                src="/images/icons/password.svg"
                                alt=""
                              >
                         
                         </template>
                         <!--<template v-slot:append>
                            <v-icon @click="show = !show" size="20" color="#ccc">
                                  mdi-help-circle-outline
                            </v-icon>
                        </template>-->
                          
                      </v-text-field>
                      <span v-if="!errors1.password" class="float-right pb-2"  style="min-height:25px;color:#43425D;font-size:12px;">
                        <span style="line-height:18pt;">uppercase letter, number & special character required</span>
                      </span>
                      <span class="float-right text-danger"  style="min-height:25px;font-size:12px">
                        <span   v-if="errors1.password">{{ errors1.password[0] }}</span>
                        </span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-row mb-5">
                      <div class="col-6  mb-lg-0 pr-2">
                        <div class="form-row m-0">
                         

                          <div class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0">
                         
                            <v-select
                              v-model="newuser1.code"
                              :items="country_all"
                              item-text="country"
                              item-value="id"
                              label="Select"
                              filled
                              background-color="#FFFFFF"
                              class="whiteCheckList"
                              :menu-props="{contentClass: 'checkList-lineGrey'}"
                              dense
                              solo
                              :height="40"
                            >
                              <template
                                slot="selection"
                                slot-scope="data"
                              ><span style="font-size:14px!important;color: rgba(0, 0, 0, 0.87)!important;">{{data.item.code2}} (+ {{data.item.prefix}} )</span></template>
                              <template
                                slot="item"
                                slot-scope="data"
                              >{{data.item.country}} (+ {{data.item.prefix}} )</template>
                            </v-select>

                            <span
                              v-if="errors1.code"
                              class="float-left text-danger" style="font-size:12px"
                            >{{ errors1.code[0] }}</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-6  mb-lg-0 pl-2">
                        <div class="form-row m-0">
                          
                          <div class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0">

                           <v-text-field
                            label=""
                            placeholder="Mobile"
                            v-model="newuser1.number"
                            hide-details
                            flat
                            height="40"
                            solo
                          
                            class="inputClass1"
                          >
                          <template v-slot:prepend-inner>
                              
                                  <img
                                    width="32"
                                    height="32"
                                    src="/images/icons/mobile.svg"
                                    alt=""
                                  >
                            
                            </template>
                          </v-text-field>
                            
                          </div>
                        </div>
                      </div>
                    
                       <div class="col-md-12 col-12 col-sm-12 col-lg-12">
                         <span v-if="!errors1.number" class="float-right pb-2"  style="min-height:25px;color:#43425D;font-size:12px;">
                          <span style="line-height:18pt;">numbers only</span>
                        </span>
                           <span class="float-right text-danger" style="font-size:12px">
                            <span   v-if="errors1.number">{{ errors1.number[0] }}</span>
                           </span>
                        </div>
                    </div>

                    <div class="form-row mb-0">
                      <div class="col-md-12 col-12 col-sm-12 col-lg-12 mb-3">
                        <div class="form-row m-0">
                          <div class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0">
                            <v-checkbox
                              class="float-left age"
                              style="display: inline-block;"
                              v-model="newuser1.age"
                              hide-details
                            >
                              <!--<template v-slot:label>
                                                            <label>
                                                                By signing up, you certify that you are 18 years old or older, and you agree to our
                                                                <a
                                                                        href="/terms"
                                                                >Terms & Conditions</a>.
                                                                <span class="text-danger">*</span>
                                                            </label>
                              </template>-->
                            </v-checkbox>

                            <label style="width: 88%;color:#43425D!important;font-size:12px!important;font-weight: 400;line-height:18pt;">
                              By signing up, you certify that you are 18 years old or older, and you agree to our
                              <a style="color: #8EbEF8" target="_blank"
                                href="/terms"
                              >Terms & Conditions</a>.                              
                            </label>
                          </div>
                          <div
                            class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0 mt-0"
                          >
                            <span v-if="errors1.age" class="text-danger float-right" style="font-size:12px">{{ errors1.age[0] }}</span>
                          </div>
                          <div
                            style="font-size: 10px;"
                            v-if="errors1.spam"
                            class="mt-3 col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0 mt-0"
                          >
                            <span class="text-danger float-right" style="font-size:12px">{{ errors1.spam[0] }}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-row mb-0 mt-0">
                      <!--<div class="col-6">
                      <v-btn
                         
                          class="mb-2"
                          
                          color="#8EbEF8"
                          depressed
                          outlined
                          rounded
                          min-width="84"
                          :loading="loading"
                          :disabled="loading"
                          @click.prevent="userSignupDialog=false;loginDialog=true;"
                        >
                          <span style="color: #8EbEF8">Log In</span>
                        </v-btn>
                        
                     
                      </div>-->
                      <div class="col-12">
                        
                      <v-btn
                         
                          class="mb-0 btn-block"
                          
                          color="#8EbEF8"
                          depressed
                          rounded
                          min-width="70"
                          :loading="loading"
                          :disabled="loading"
                          @click="getTokenUser()"
                        >
                          <span style="color: #ffffff">Join Now</span>
                        </v-btn>
                        
                      </div>
                      <div class="col-12 text-center" style="margin-top:24px">
                      <label style="width: 88%;color:#43425D!important;font-size:12px!important;font-weight: 400;line-height:18pt;">
                              Already have an account ?
                              <a style="color: #8EbEF8" 
                               @click.prevent="userSignupDialog=false;loginDialog=true;"
                              ><b>Log In</b></a>                             
                            </label>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </v-card-text>
        </v-card>
      </v-dialog>
      <v-dialog v-model="messageDialog" width="600">
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
                    @click="messageDialog=false;loginDialog=true"
                  >Login Now</v-btn>
                </div>
              </div>
            </div>
          </v-card-text>
        </v-card>
      </v-dialog>
      <v-dialog v-model="loginDialog" width="335">
        <v-card style="background:#F4F4F4;border-radius:30px!important ">
          <v-card-text class="p-0">
            <div class="row m-0">
              <div class="col-12 text-right mt-6 pr-6">
                <v-icon class="text-right" @click="loginDialog=false">mdi-close</v-icon>
              </div>
              <div class="col-12 pt-8">
                <div class="px-2" style="font-size:20px;color:#43425D;font-weight: 600;">
                  Log In
                </div>

                <div class="card-body p-0 p-lg-5 pt-4">
                  <form method="POST" action class="registration_form  pt-0 pb-0">
                    <div class="form-row mb-3">
                      <label class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label" style="font-size:12px!important;color:#A2A2A2!important">
                        Welcome Back
                      </label>
                      <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                       <v-text-field
                        label=""
                        placeholder="Email"
                        v-model="email"
                        hide-details
                        flat
                        height="40"
                        solo
                       
                        class="inputClass1"
                      >
                      <template v-slot:prepend-inner>
                           
                              <img
                                width="32"
                                height="32"
                                src="/images/icons/email.svg"
                                alt=""
                              >
                         
                         </template>
                      </v-text-field>
                        
                        <span class="float-right text-danger" style="min-height:25px;font-size:12px">
                        <span  v-if="errors.email">{{ errors.email[0] }}</span>
                        </span>
                      </div>

                      
                      <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                       

                        <v-text-field
                        label=""
                        placeholder="Password"
                        v-model="password"
                        hide-details
                        flat
                        height="40"
                        solo
                        type="password"
                        
                        class="inputClass1"
                      >
                      
                           <template v-slot:prepend-inner>
                           
                              <img
                                width="32"
                                height="32"
                                src="/images/icons/password.svg"
                                alt=""
                              >
                         
                         </template>
                      </v-text-field>
                       <span class="float-right text-danger" style="font-size:12px">
                        <span   v-if="errors.password">{{ errors.password[0] }}</span>
                        </span>
                       
                        <span v-if="error != ''" class="float-right text-danger" style="font-size:12px">{{ error }}</span>
                      </div>
                    </div>

                    <div class="form-row mb-0 mt-1">
                      <div class="col-12 text-right mb-5">
                      <a href="/password/reset" style="font-size:10px;font-weight:600;color:#8EbEF8">Forgot Password?</a>
                      </div>
                       <div class="col-12 text-right">
                        <v-btn
                        class="white--text mb-0  btn-block"
                          rounded
                          min-width="84"
                          color="#8EbEF8"
                          :loading="loadingLogin"
                          :disabled="loadingLogin"
                          @click="login()"
                        >Log In</v-btn>
                        <!--<p class="mt-3 mb-0">
                          Don't have an account yet?
                          <a
                            href="#"
                            @click.prevent="loginDialog = false;userSignupDialog=true"
                            class
                          >Sign Up</a>
                        </p>-->
                        
                      </div>
                      <div class="col-12 text-center" style="margin-top:24px;margin-bottom:24px">
                      <label style="color:#43425D!important;font-size:12px!important;font-weight: 400;line-height:18pt;margin:0px">
                              Dont have an account?
                              <a style="color: #8EbEF8" 
                               href="/signup"
                              ><b>Sign Up</b></a>                             
                            </label>
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

    <v-navigation-drawer
      class="drawer"
      v-model="drawer"
      hide-overlay
      stateless
      fixed
      width="100%"
      style="top:50px;overflow-y:scroll"
    >


      <v-list dense>
      <v-list-item>
      <i
          class="fa fa-times close-button contact-close"
          style="float: right; font-size: 15px; top: 34px; right: 15px; color: #A2A2A2; cursor: pointer;"
          @click="drawer = false"
          aria-hidden="true"
        ></i>
         </v-list-item>
     
        <div class="flex" v-for="item in items">
        <v-list-item v-if="item.items.length == 0"
          
          :key="item.title"
          link
          @click.stop="openLink(item)"
        >
        

          <v-list-item-content>
            <v-list-item-title class="px-4" v-if="item.title != 'Sign Up'">{{ item.title }}</v-list-item-title>
            <v-btn v-else
                         
                          class="mb-0 btn-block" style="justify-content: start;height:50px!important"
                          
                          color="#8EbEF8"
                          depressed
                          rounded
                          min-width="70"
                          :loading="loading"
                          :disabled="loading"
                          href="/signup"
                        >
                          <span style="color: #ffffff">Sign Up</span>
                        </v-btn>
          </v-list-item-content>
        </v-list-item>
        <v-list-group v-else>
        <template v-slot:activator>
          <v-list-item-content >
            <v-list-item-title class="px-4" v-text="item.title" link></v-list-item-title>
          </v-list-item-content>
        </template>

        <v-list-item 
          v-for="child in item.items[0]"
          :key="child.slug"
        >
          <a v-if="item.title == 'Specialties'"  :href="'/search?category='+child.slug">
          <v-list-item-content class="pl-7">
            <v-list-item-title v-text="child.name"></v-list-item-title>
          </v-list-item-content>
        </a>
        <a v-else-if="item.title == 'Abilities'"  :href="'/search?ability='+child.slug">
          <v-list-item-content class="pl-7">
            <v-list-item-title v-text="child.name"></v-list-item-title>
          </v-list-item-content>
        </a>
        </v-list-item>
        
      </v-list-group>
      </div>
       <div class="my-10 pb-10 px-4"
          
          key="search"
          link
        >
        

          <v-list-item-content>
            <v-list-item-title>
              <div style="color:#C7C7C7; font-size: 25px; font-weight: 600">Search</div>
              <v-divider></v-divider>
              <SearchInput menu="true"/>              
            </v-list-item-title>
          </v-list-item-content>
        </div>   
         </v-list>    
    </v-navigation-drawer>


    
  </div>
</template>
<script>
export default {
  props: [
    "user",
    "guest",
    "abilities",
    "specialties",
    "categories",
    "country_all",
    "redeem",
    "search",
    "tools",
    "styles",
  ],

  data: function () {
    return {
      step: 1,
      show: false,
      show1: false,
      drawer: false,
      menu_opened: false,
      dash_menu: "/images/icons/profile.svg",
      dash_app: "/images/icons/dashboard.svg",
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
        specialties: [],
        tools: [],
        styles: [],
        password: "",
        c_password: "",
        code: 215,
        token: "",
      },
      newuser1: {
        age: false,
        name: "",
        email: "",
        password: "",
        code: 215,
        number: "",
        token: "",
      },
      items: [
        { title: "Sign Up", url: "signup", items: [] },
        { title: "Log In", url: "login", items: [] },
        { title: "Specialties", url: "specialties", items: [this.specialties] },
        { title: "Abilities", url: "abilities", items: [this.abilities] },
         { title: "Horoscopes", url: "horoscope", items: [] },
        { title: "About", url: "about", items: [] },
        { title: "Blog", url: "blog", items: [] },
        { title: "Press", url: "press", items: [] },
      ],
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
   
    openLink(item) {
      if (item.url == "login") {
        EventBus.$emit("open_login", {});
      } else {
        window.location = "/" + item.url;
      }
    },

    getToken() {
      this.loading = true;
      const self = this;
      grecaptcha.ready(function () {
        grecaptcha
          .execute("6Ld5_t0UAAAAALQUAPjguf3meaiPSGQUAh_GcDuD", {
            action: "register",
          })
          .then(function (token) {
            if (token) {
              self.newuser.token = token;
              self.register();
            }
          });
      });
    },

    getTokenUser() {
      this.loading = true;
      const self = this;
      grecaptcha.ready(function () {
        grecaptcha
          .execute("6Ld5_t0UAAAAALQUAPjguf3meaiPSGQUAh_GcDuD", {
            action: "registerUser",
          })
          .then(function (token) {
            if (token) {
              self.newuser1.token = token;
              self.registerUser();
            }
          });
      });
    },

    step1() {
      var input = this.newuser;
      this.loading = true;
      axios
        .post("/register/validate/step1", input)
        .then((res) => {
          if (res.status == 201) {
           this.loading = false;
          this.errors = [];
          this.step++;
          }
         
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
          this.show1 = false;
          this.loading = false;
          this.message =
            "There is something wrong, please check that all form fields are correct.";
        });
    },

    
    step2() {
      var input = this.newuser;
      this.loading = true;
      axios
        .post("/register/validate/step2", input)
        .then((res) => {
          if (res.status == 201) {
          this.loading = false;
          this.errors = [];
          this.step++;
          }
         
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

    
    step3() {
      var input = this.newuser;
      this.loading = true;
      axios
        .post("/register/validate/step3", input)
        .then((res) => {
          if (res.status == 201) {
            this.getToken();
          }
        
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

    register() {
      var input = this.newuser;
      axios
        .post("/register/psychic", input)
        .then((res) => {
          if (res.status == 201) {
            //Created
            // this.message = res.data.success.message;
            // this.signupDialog = false;
            // this.resetUser();
            // this.messageDialog = true;
            
            location.reload();
          }
          this.loading = false;
          this.errors = [];
        })
        .catch((error) => {
          this.newuser.token = "";
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
      var input = this.newuser1;
      axios
        .post("/register/user", input)
        .then((res) => {
          if (res.status == 201) {
            //Created
            // this.message = "$10 in <button  class='credit_icon btn-sm' color='withe--text'>c</button> credits have been added to your account.";
            // this.userSignupDialog = false;
            // this.resetUser();
            // this.messageDialog = true;
            // console.log(res)
            location.reload();
          }
          this.loading = false;
          this.errors1 = [];
         
        })
        .catch((error) => {
          this.newuser1.token = "";
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
           this.show = false;
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
              if (res.data.success.url) window.location = res.data.success.url;
              else location.reload();
            }
          }
        })
        .catch((error) => {
          this.loadingLogin = false;

          this.errors = [];

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

          this.message = "There is something wrong.";
        });
    },
  },
};
</script>

<style>

/*.inputClass {
    height: 40px !important;
    font-size: 14px !important;
    padding: 10px !important;
    background: #ffffff !important;
    border: none !important;
    box-shadow: none !important;
    font-weight: 500;
    border-radius: 4px;
    color: #1F1E34!important;
}*/

.inputClass1 .v-input__slot {
    font-size: 14px !important;
}

.credit_icon {
  background-color: #8ebef8 !important;
  font-size: 11px !important;

  padding: 0 !important;
  min-width: 16px !important;
  height: 16px !important;
  color: white !important;
  border-radius: 100% !important;
}



.v-card label,
.v-label:hover,
.v-label {
  font-size: 14px !important;
  color: #656b72 !important;
}

.checks label, .checks .v-label:hover{
    font-size: 12px !important;
}
.logo {
  width: 210px;
}
.v-input__control .v-select__selections,
.checkListGray-line
  .theme--light.v-list-item:not(.v-list-item--active):not(.v-list-item--disabled) {
  color: #8e8d99 !important;
}
.v-text-field.v-text-field--enclosed .v-text-field__details {
  margin: 0px !important;
  display: none;
}

.v-input--selection-controls__ripple {
  display: none;
}
.v-dialog__content--active {
  opacity: 1 !important;
  -webkit-backdrop-filter: blur(10px);
  backdrop-filter: blur(10px);
}

.v-dialog {
  box-shadow:none!important;
}

.v-text-field.v-text-field--solo .v-input__control {
    min-height: 40px!important;
   
}


</style>