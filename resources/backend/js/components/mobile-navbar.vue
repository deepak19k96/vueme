<template>
  <v-container class="m-0 p-0" v-if="$vuetify.breakpoint.smAndDown">
    <!-- Links -->
    <ul class="navbar-nav m-0 p-0">
      <li class="nav-item white mr-0">
        <!-- <div class="col-6 ">
            <div class=" d-flex align-center">
              <a
                href="/dashboard/profile"
                class="mt-2 mr-3"
                v-if="user.role_id == 1"
              >
                <div
                  class="user_avatar"
                  :style="{
                    'background-image':
                      'url(' + user.userProfile.haedshot_path + ')',
                  }"
                ></div>
              </a>

              <a
                href="/dashboard/user/profile"
                class="mt-2 mr-3"
                v-else-if="user.role_id == 2"
              >
                <div
                  class="user_avatar"
                  :style="{
                    'background-image':
                      'url(' + user.userProfile.haedshot_path + ')',
                  }"
                ></div>
              </a>

              <span style="font-weight: 600; font-size: 18px; ">{{
                user.userProfile.name
              }}</span>
            </div>
        </div>-->
        <div class="col-12 white">
          <div
            id="profile"
            v-if="user.role_id == 1"
            :key="user.online"
            class="text-center p-3 pb-1"
          >
            <v-badge overlap bottom v-if="status" color="#2CC05F">
              <template v-slot:badge>{{ status.color }}</template>
              <v-avatar size="150" style="background-color: rgb(142, 190, 248); border-color: rgb(142, 190, 248);">
                <v-img :alt="user.userProfile.display_name" :src="user.userProfile.haedshot_path"></v-img>
              </v-avatar>
            </v-badge>
            <v-badge overlap bottom v-if="!status" color="#C7C7C7">
              <template v-slot:badge>{{ status.color }}</template>
              <v-avatar size="150"  style="background-color: rgb(142, 190, 248); border-color: rgb(142, 190, 248);">
                <v-img :alt="user.userProfile.display_name" :src="user.userProfile.haedshot_path"></v-img>
              </v-avatar>
            </v-badge>

            <p class="text-center p-2 pb-1 titleUser ">
              
              {{ user.userProfile.display_name  }}
              
              </p>
          </div>
          <div id="profile" v-if="user.role_id == 2" class="text-center">
            <v-avatar size="150" style="background-color: rgb(142, 190, 248); border-color: rgb(142, 190, 248);">
              <v-img :src="user.userProfile.haedshot_path"></v-img>
            </v-avatar>
            <p
              class="text-center titleUser "
            >
            
            {{ user.userProfile.name + ' ' + user.userProfile.last_name}}
            
            
            </p>
          </div>
        </div>

        <div
          id="under-profile"
          class="text-center pb-5 pr-0 pl-0 mr-0 ml-0 row m-0"
          v-if="user.role_id == 1"
        >
          <div class="col-6 col-md-6">
            <a href="/dashboard/profile" class="mMontserrat">
              <i class="far ico-edit"></i> Edit
            </a>
          </div>
          <div class="col-6 col-md-6">
            <a id="view_profile" :href="'/' + user.userProfile.profile_link" class="mMontserrat">
              <i class="far ico-view"></i> View
            </a>
          </div>

          <div id="under-profile" class="text-center pb-5 col-12" v-if="user.role_id == 2">
            <a href="/dashboard/user/profile" class="mMontserrat">
              <i class="far ico-edit"></i> Edit
            </a>
          </div>
        </div>
        <div id="under-profile" class="text-center pb-5 col-" v-else-if="user.role_id == 2">
          <a href="/dashboard/user/profile" class="mMontserrat" style="font-size:14px">
            <i class="far ico-edit"></i> Edit
          </a>
        </div>
      </li>

      <li class="nav-item pl-0 pt-0"  color="#EBF4FD" style="background:#EBF4FD " >
        <v-list dense v-if="user.role_id == 1" color="#EBF4FD" class="mobileMcon" style="    height: 100% !important;">
          <v-list-item-group class="mobileSa">
            <v-list-item dense href="/dashboard/services">
              <v-list-item-icon>
                <img src="/images/icons/services_bar.svg" width="30px" height="30px" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">Services</v-list-item-title>
              </v-list-item-content>
            </v-list-item>

            <v-list-item href="/dashboard/reviews">
              <v-list-item-icon>
                <img src="/images/icons/review.svg" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">Reviews</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-list-item href="/dashboard/payout">
              <v-list-item-icon>
                <img src="/images/icons/moneys.svg" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">Money</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-list-item href="/dashboard/analytics">
              <v-list-item-icon>
                <img src="/images/icons/analytic.svg" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">Analytics</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <!-- <v-list-item href="/about">
              <v-list-item-icon>
                <img src="/images/icons/about.svg" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">About</v-list-item-title>
              </v-list-item-content>
            </v-list-item> -->
            <v-list-item href="https://psychics1on1-psychics.zendesk.com/hc/en-us"  target="_blank">
              <v-list-item-icon>
                <img src="/images/icons/help.svg"/>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">Help</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-list-item href="/blog">
              <v-list-item-icon>
                <img src="/images/icons/blog.svg"/>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">Blog</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-list-item
              class="logout"
              @click.prevent="logout()"
              dense
              style="padding-bottom:10px;"
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

        <v-list dense class="mobileMcon pt-1 pb-0" v-if="user.role_id == 2" color="#EBF4FD"  style="height: 100% !important;" >
          <v-list-item-group class="mobileSa" style="height: 100%;">

            <v-list-item href="/dashboard/user/reviews" :ripple="false" class="mb-0 pt-2" >
              <v-list-item-icon>
                <img src="/images/icons/review.svg" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">Reviews</v-list-item-title>
              </v-list-item-content>
            </v-list-item>

            <v-list-item dense href="/dashboard/favorites" class="mb-0" >
              <v-list-item-icon>
                <img src="/images/icons/favorites.svg" width="30px" height="30px" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">Favorites</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-list-item href="/dashboard/transaction" class="mb-0" >
              <v-list-item-icon>
                <img src="/images/icons/moneys.svg" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">Transactions</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-list-item href="/dashboard/payment" class="mb-0" >
              <v-list-item-icon>
                <img src="/images/icons/payment.svg" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">Payment</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
<!-- 
            <v-list-item href="/about">
              <v-list-item-icon>
                <img src="/images/icons/about.svg" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">About</v-list-item-title>
              </v-list-item-content>
            </v-list-item> -->


            <v-list-item href="/horoscope" class="mb-0" >
              <v-list-item-icon>
                <img src="/images/icons/horoscope.svg" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">Horoscopes</v-list-item-title>
              </v-list-item-content>
            </v-list-item>



            <v-list-item href="https://psychics1on1.zendesk.com/hc/en-us"  target="_blank" class="mb-0" >
              <v-list-item-icon>
                <img src="/images/icons/help.svg" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">Help</v-list-item-title>
              </v-list-item-content>
            </v-list-item>



            <v-list-item href="/blog" class="mb-0" >
              <v-list-item-icon>
                <img src="/images/icons/blog.svg" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">Blog</v-list-item-title>
              </v-list-item-content>
            </v-list-item>



            <v-list-item class="logout" @click.prevent="logout()" >
              <v-list-item-icon>
                <img src="/images/icons/logout.svg" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title style="color:rgb(162, 162, 162) !important">Log Out</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list-item-group>
        </v-list>
      </li>
    </ul>
    <!-- Links -->
  </v-container>
  <!-- <v-container class="m-0 p-0" v-else @="this.window.location.href = '/dashboard/menu'"></v-container> -->
</template>

<script>
// import { EventBus } from "../event-bus.js";
import { mapGetters } from "vuex";
export default {
  props: ["user"],
  // watch: {
  //   user(newUser) {
  //     this.status = newUser.online;
  //   },
  // },
  data() {
    return {
      status: this.user.online,
    };
  },
  filters: {
    ampmtime: function (time) {
      if (typeof time == "string") {
        time = time.split(":"); // convert to array

        // fetch
        var hours = Number(time[0]);
        var minutes = Number(time[1]);

        if (typeof time[2] != "undefined") {
          var seconds = Number(time[2]);
        } else {
          var seconds = 0;
        }

        // calculate
        var timeValue;

        if (hours > 0 && hours <= 12) {
          timeValue = "" + hours;
        } else if (hours > 12) {
          timeValue = "" + (hours - 12);
        } else if (hours == 0) {
          timeValue = "12";
        }

        timeValue += minutes < 10 ? ":0" + minutes : ":" + minutes; // get minutes
        //timeValue += (seconds < 10) ? ":0" + seconds : ":" + seconds;  // get seconds
        timeValue += hours >= 12 ? " P.M." : " A.M."; // get AM/PM

        return timeValue;
      }
    },
  },
  computed: {
    ...mapGetters({
      mobile: "util/mobile",
    }),
  },
  created() {
    // EventBus.$on("changed-event", (status) => {
    //   this.status = status;
    // });

    if (!this.mobile) {
      window.location.href = "/dashboard";
    }
  },
  methods: {
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
  },
};
</script>
<style>
#navbarSupportedContent1 {
  background: #ebf4fd;
}
#navbarSupportedContent1 .navbar-nav {
  display: block;
  padding-left: 0px !important;
  padding-right: 0px !important;
}
.v-application a {
  color: rgba(0, 0, 0, 0.87) !important;
}


.mobileMcon .v-list-item{
  /* height: 12.5% !important; */
}
</style>