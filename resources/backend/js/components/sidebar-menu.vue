<template>
  <div v-if="!$vuetify.breakpoint.smAndDown">
    <div id="profile" v-if="user.role_id == 1" class="text-center">
      <v-badge overlap bottom v-if="status" color="#2CC05F">
        <template v-slot:badge>{{ status.color }}</template>
        <v-avatar size="150">
          <v-img
            :alt="user.userProfile.display_name"
            :src="user.userProfile.haedshot_path"
          ></v-img>
        </v-avatar>
      </v-badge>

      <v-badge overlap bottom v-if="!status" color="#C7C7C7">
        <template v-slot:badge>{{ status.color }}</template>
        <v-avatar size="150">
          <v-img
            :alt="user.userProfile.display_name"
            :src="user.userProfile.haedshot_path"
          ></v-img>
        </v-avatar>
      </v-badge>

      <p class="text-center titleUser">
        {{ user.userProfile.display_name }}
      </p>
    </div>

    <div
      id="profile"
      v-if="user.role_id == 2"
      class="text-center"
      style="height: 287px"
    >
      <v-avatar size="150">
        <v-img :src="user.userProfile.haedshot_path"></v-img>
      </v-avatar>
      <p class="text-center titleUser">
        {{ user.userProfile.name + " " + user.userProfile.last_name }}
      </p>

      <div
        id="under-profile"
        class="text-center"
        v-if="user.role_id == 2"
        style="margin-top: 16px"
      >
        <a href="/dashboard/user/profile">
          <!-- <i class="far ico-edit"></i> Edit -->
          <img
            src="/images/site-images/pencil.svg"
            width="30"
            height="30"
            style="margin-left: -7px"
          />
          <span style="margin-left: 15px" class="mMontserrat">Edit</span>
        </a>
      </div>
    </div>

    <div>
      <div
        id="under-profile"
        class="text-center row m-0"
        v-if="user.role_id == 1"
      >
        <div class="boxProfile" style="margin-right: 4px">
          <a href="/dashboard/profile" class="mMontserrat">
            <i class="far ico-edit"></i> Edit
          </a>
        </div>
        <div class="boxProfile" style="margin-left: 4px">
          <a
            id="view_profile"
            :href="'/' + user.userProfile.profile_link"
            class="mMontserrat"
          >
            <i class="far ico-view"></i> View
          </a>
        </div>
      </div>
      <!-- <div id="under-profile" class="text-center" v-else-if="user.role_id == 2">
        <a href="/dashboard/user/profile">
          <i class="far ico-edit"></i> Edit
        </a>
      </div>-->
    </div>

    <v-container class="pt-2 pb-2 mb-0">
      <v-row v-if="user.role_id == 1" justify="center" align-content="center">
        <p class="pt-2">
          <span
            style="color: #2cc05f; font-weight: 500; font-size: 14px"
            v-if="status"
            >Online</span
          >
          <span
            style="color: #999999; font-weight: 500; font-size: 14px"
            v-if="!status"
            >Offline</span
          >
        </p>
        <v-switch
          class="mt-1 ml-8 service_switch"
          color="#49C874"
          flat
          inset
          :dense="true"
          :ripple="false"
          v-model="status"
          @change="postUserOnlineStatus(status)"
        ></v-switch>
      </v-row>
    </v-container>

    <div
      id="sidebar-schedule"
      class="d-none d-md-block"
      v-if="concated_user_schedule.length > 0 && user.role_id == 1"
    >
      <span
        style="
          font-family: Montserrat, sans-serif;
          font-size: 14.4px;
          font-weight: 500;
          color: #1f1e34;
        "
        >Schedule</span
      >

      <div class="row" v-for="cs in concated_user_schedule">
        <div class="col-auto mr-auto" style="padding-left: 12px !important">
          {{ cs.days }}
        </div>
        <div class="col-auto" style="padding-right: 0px !important">
          {{ cs.from | ampmtime }}-{{ cs.till | ampmtime }}
        </div>
      </div>
    </div>

    <v-list dense class="mt-0" v-if="user.role_id == 1">
      <v-list-item-group
        v-model="link"
        color="primary"
        active-class="primary--text"
      >
        <v-list-item
          v-for="(item, i) in items"
          :key="i"
          class="px-5"
          :href="item.href"
          :target="item.target"
        >
          <v-list-item-icon>
            <img :src="item.icon" />
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title
              v-text="item.text"
              class="mMontserrat"
            ></v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list-item-group>
    </v-list>

    <v-list dense class="mt-3 menu-items" v-else-if="user.role_id == 2">
      <v-list-item-group
        v-model="link"
        color="primary"
        active-class="primary--text"
      >
        <v-list-item
          v-for="(item, i) in items_user"
          :key="i"
          class="px-5"
          :href="item.href"
          :target="item.target"
        >
          <v-list-item-icon>
            <img :src="item.icon" />
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title v-text="item.text"></v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list-item-group>
    </v-list>
  </div>
</template>

<script>
export default {
  props: ["link", "user"],
  data: () => ({
    loading: true,
    status: false,
    switchcall: true,
    switchtxt: false,
    switchvideo: false,
    items: [
      {
        text: "Appointments",
        icon: "/images/icons/calendar.svg",
        href: "/dashboard/",
        target: "_self",
      },
      {
        text: "Services",
        icon: "/images/icons/services_bar.svg",
        href: "/dashboard/services",
        target: "_self",
      },
      {
        text: "Reviews",
        icon: "/images/icons/review.svg",
        href: "/dashboard/reviews",
        target: "_self",
      },
      {
        text: "Cosmic Rewards",
        icon: "/images/icons/cosmic_rewards_ico.svg",
        href: "/dashboard/cosmic-rewards",
        target: "_self",
      },
      {
        text: "Money",
        icon: "/images/icons/moneys.svg",
        href: "/dashboard/payout",
        target: "_self",
      },
      {
        text: "Analytics",
        icon: "/images/icons/analytic.svg",
        href: "/dashboard/analytics",
        target: "_self",
      },
      {
        text: "Help",
        icon: "/images/icons/help.svg",
        href: "https://psychics1on1-psychics.zendesk.com/hc/en-us",
        target: "_blank",
      },
      {
        text: "Blog",
        icon: "/images/icons/blog.svg",
        href: "/blog",
        target: "_self",
      },
    ],
    items_user: [
      {
        text: "Appointments",
        icon: "/images/icons/calendar.svg",
        href: "/dashboard/appointments",
        target: "_self",
      },
      {
        text: "Reviews",
        icon: "/images/icons/review.svg",
        href: "/dashboard/user/reviews",
        target: "_self",
      },
      {
        text: "Favorites",
        icon: "/images/icons/favorites.svg",
        href: "/dashboard/favorites",
        target: "_self",
      },
      {
        text: "Transactions",
        icon: "/images/icons/moneys.svg",
        href: "/dashboard/transaction",
        target: "_self",
      },
      {
        text: "Payment",
        icon: "/images/icons/payment.svg",
        href: "/dashboard/payment",
        target: "_self",
      },
      {
        text: "Help",
        icon: "/images/icons/help.svg",
        href: "https://psychics1on1.zendesk.com/hc/en-us",
        target: "_blank",
      },
    ],
    concated_user_schedule: [],
  }),

  created() {
    this.status = this.user.online;
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

  computed: {},
  methods: {
    getUserSchedule() {
      axios
        .get("/api/v1/user/schedule")
        .then((response) => {
          this.concated_user_schedule = response.data.success.concated;
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

    updateUserServices() {
      //console.log('oka!');

      this.savingUserServices = true;

      axios
        .post("/api/v1/user/services/save", {
          user_id: this.user.id,
          user_services: this.user.userService,
        })
        .then((response) => {
          setTimeout(() => {
            this.savingUserServices = false;
            this.usSaved = true;

            setTimeout(() => {
              this.usSaved = false;
            }, 2000);
          }, 1000);

          this.status = response.data.success.user_online;
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

    postUserOnlineStatus(status) {
      axios
        .post("/api/v1/user/set_contact_status", { online: status })
        .then((response) => {
          console.log(
            `this is status from DB: ${response.data.success.data.online}`
          );
          this.user.online = response.data.success.data.online;
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
  },
};
</script>
<style>
.menu-items .v-list-item.v-list-item--link.v-list-item--active {
  background-color: #c2a5dd !important;
}
.boxProfile {
  width: 130px !important;
  min-height: 50px !important;
  vertical-align: middle;
  padding: 0px !important;
  padding-top: 13px !important ;
  margin-bottom: 10px !important;
}

.theme--light.v-list-item--active {
  background: #c3a6dd !important;
}
.v-list-item__title {
  color: #1f1e34 !important;
}

.theme--light.v-list-item--active:hover::before,
.theme--light.v-list-item--active::before {
  opacity: 0;
}
/* .v-badge__wrapper .v-badge__badge {
  top: 118px !important;
  left: 118px !important;
} */

#profile {
  padding: 20px 59px !important;
}
.titleUser {
  padding-top: 20px !important;
  margin-bottom: 0px !important;
}

.theme--light.v-list-item:not(.v-list-item--active):not(.v-list-item--disabled) {
  color: transparent !important;
}
</style>