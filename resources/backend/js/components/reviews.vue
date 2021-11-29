<template>
  <div>
    <v-container class="row-gray-area p-0 ml-0">
      <v-row no-gutters>
        <v-col class="m-0 p-0">
          <div class="mb-1 mt-4 ml-4 subtitleDiv">Reviews</div>
        </v-col>
      </v-row>
    </v-container>
    <v-container v-if="!loading">
      <v-row class="pt-0 mb-0 justify-space-between" no-gutters>
        <v-col :lg="4" :md="4" :sm="6" cols="6" class="text-lg-left text-center pb-0 pl-0">
          <v-select
            v-model="date_filter"
            :items="date_filter_list"
            item-text="name"
            item-value="key"
            label="All Time"
            filled
            background-color="white"
            dense
            solo
            v-on:change="filterReviews"
            class="widthSelect"
            :menu-props="{contentClass: 'checkList-line'}"
            :style="[ !$vuetify.breakpoint.smAndDown ? {'width': '135px !important'}:{'width': '135px !important','float':'left'}]"
          ></v-select>
        </v-col>
        <v-col :lg="4" :md="4" :sm="6" cols="6" class="text-lg-right text-center pb-0 pr-0">
          <v-select
            class="widthSelect float-right"
            v-model="status"
            :items="status_list"
            label="All Reviews"
            item-text="name"
            item-value="key"
            background-color="white"
            multiple
            filled
            dense
            solo
            v-on:change="filterReviews"
            :menu-props="{contentClass: 'checkList'}"
            :style="[ !$vuetify.breakpoint.smAndDown ? {'width': '135px !important'}:{'width': '135px !important','float':'right'}]"
          >
            <template v-slot:selection="{ item, index }">
              <div v-if="status.length <= 1" class>{{ item.name }}</div>
              <span v-if="index === 1">Show Filtered</span>
            </template>
          </v-select>
        </v-col>
      </v-row>

      <v-row
        v-if="reviews.length > 0"
        class="pt-2"
        v-for="review in reviews"
        :key="review.id"
        no-gutters
      >
        <v-card class="mb-2 pt-0 pb-3" width="100%">
          <v-col class="pl-0 listReviews">
            <v-badge
              overlap
              bottom
              v-if="review.psychic.online"
              color="#2CC05F"
              class="badgeUsers v-badge-list"
            >
              <template v-slot:badge>{{ }}</template>
              <v-avatar size="50">
                <v-img
                  :alt="review.psychic.profile.name"
                  :src="review.psychic.profile.profile_headshot_url"
                ></v-img>
              </v-avatar>
            </v-badge>

            <v-badge overlap bottom v-else color="#C7C7C7" class="badgeUsers v-badge-list">
              <template v-slot:badge>{{ }}</template>
              <v-avatar size="50">
                <v-img
                  :alt="review.psychic.profile.name"
                  :src="review.psychic.profile.profile_headshot_url"
                ></v-img>
              </v-avatar>
            </v-badge>

            <div class="reviews_info pb-0 pt-0">
              <div class="h2Title pt-0 pb-0 pb-reviews">{{ review.psychic.profile.name }}</div>
              <div
                v-if="review.category"
                class="textList subList pt-0 pb-0 pb-reviews"
              >{{ review.category.name }}</div>
              <div v-else class="textList subList pt-0 pb-0 pb-reviews">Other</div>
              <div class="textList servList pt-0 pb-0 pb-date">{{ review.created_at | formatDate }}</div>
            </div>

            <div class="reviews_msn pb-2">
              <div class="textList mb-1 d-flex">
                <div class="float-left pr-3 pt-0 pb-0 pb-date">
                  <b>{{ review.title }}</b>
                </div>

                <v-rating
                  class="float-left textRating"
                  v-model="review.rating"
                  background-color="#bcbec9"
                  color="amber"
                  readonly
                  dense
                ></v-rating>
              </div>
              <div class="textList subList text-muted pb-lg-0 pb-3">"{{ review.text }}"</div>
            </div>

            <div
              class="statusMsn textList"
              v-bind:style="{ color: status_color(review.status)+' !important' }"
            >{{ review.status }}</div>

            <!-- <v-chip :text-color="status_color(review.status)" color="white">{{
              review.status
            }}</v-chip>-->
          </v-col>

          <v-col
            v-if="review.replies.length > 0"
            cols="12"
            v-for="(reply, index) in review.replies"
            :key="index"
            justify="end"
            class="m-0 mt-5"
          >
            <v-row>
              <v-col
                class="small text-muted pb-lg-0 pb-3 ml-auto"
                :lg="8"
                :md="8"
                :sm="12"
                cols="12"
              >{{ reply.text }}</v-col>
              <v-col :lg="2" :md="2" :sm="12" cols="12" class="pt-2">
                <div
                  :aria-label="reply.user.profile.display_name"
                  class="user_avatar mr-3"
                  :style="{
                    'background-image':
                      'url(' + reply.user.profile.profile_headshot_url + ')',
                  }"
                ></div>
              </v-col>
            </v-row>
          </v-col>
        </v-card>
      </v-row>
    </v-container>
    <v-container class="white" v-if="!loading && reviews.length == 0">
      <v-row no-gutters>
        <v-col class="pt-2">There are no reviews</v-col>
      </v-row>
    </v-container>

    <v-dialog v-model="dialog" width="500">
      <v-card v-if="Object.keys(selectedReview).length > 0">
        <v-card-text class="pt-4">
          <v-row no-gutters>
            <v-col :lg="2" :md="2" :sm="12" cols="12">
              <div
                :aria-label="selectedReview.psychic.profile.display_name"
                class="user_avatar mr-3"
                :style="{
                  'background-image':
                    'url(' +
                    selectedReview.psychic.profile.profile_headshot_url +
                    ')',
                }"
              ></div>
            </v-col>
            <v-col>
              <div>
                <b>{{ selectedReview.title }}</b>
              </div>
              <div>
                <v-rating
                  class="float-left starBtn"
                  v-model="selectedReview.rating"
                  background-color="#bcbec9"
                  color="amber"
                  readonly
                  dense
                ></v-rating>
              </div>
            </v-col>
            <v-col cols="12" class="mt-5">
              <v-textarea
                v-model="reply_text"
                solo
                background-color="#F4F4F4"
                filled
                hide-details
                placeholder="Enter you reply"
              ></v-textarea>
            </v-col>
            <v-col class="mt-5 text-right">
              <v-btn
                color="primary"
                @click="submitReply"
                :loading="updating"
                :disabled="updating"
              >Submit</v-btn>
              <v-btn color="secondary" text @click="dialog = false" :disabled="updating">Close</v-btn>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import moment from "moment";
export default {
  data() {
    return {
      menu: false,
      updating: false,
      reply_text: "",
      savingUserServices: false,
      usSaved: false,
      loading: true,
      reviews: [],
      dialog: false,
      selectedReview: {},
      errors: {
        user_services: [],
      },
      date_filter_list: [
        { name: "Last 6 months", key: 6 },
        { name: "Last 3 months", key: 3 },
        { name: "Last 2 months", key: 2 },
        { name: "All Time", key: "All" },
      ],
      status_list: [
        { name: "All Reviews", key: "All" },
        { name: "Posted", key: "Posted" },
        { name: "Pending", key: "Pending" },
        { name: "Unapproved", key: "Removed" },
      ],
      status: ["All"],
      date_filter: "All",
      message: "",
    };
  },
  filters: {
    formatDate(date) {
      return moment(date).format("MM/DD/YYYY");
    },
  },
  computed: {
    ...mapGetters({
      mobile: "util/mobile",
    }),
  },
  methods: {
    getReviews() {
      axios
        .get(
          "/api/v1/user/reviews?status=" +
            this.status +
            "&date_filter=" +
            this.date_filter
        )
        .then((response) => {
          this.reviews = response.data.data;
          this.reviews.forEach((review) => {
            if (review.status === "Removed") {
              review.status = "Unapproved";
            }
          });
          console.log(this.reviews);
          this.loading = false;
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
    status_color(status) {
      var color = "";
      if (status == "Pending") {
        color = "#ffac3b";
      } else if (status == "Posted") {
        color = "#2cc05f";
      } else if (status == "Unapproved") {
        color = "#E85D4ECC";
      }
      return color;
    },
    filterReviews() {
      if (
        (this.status.length > 1) &
        this.status.includes("All") &
        (this.status[0] != "All")
      ) {
        this.status = ["All"];
        this.getReviews();
      } else if ((this.status.length > 1) & (this.status[0] == "All")) {
        this.status.shift();
        this.getReviews();
      } else if (this.status.length === 3) {
        this.status = ["All"];
        this.getReviews();
      } else {
        this.getReviews();
      }
    },
    openDialog(review) {
      this.selectedReview = review;
      this.dialog = true;
    },

    updateReview() {
      this.updating = true;
      var input = {
        id: this.selectedReview.id,
        text: this.selectedReview.text,
        rating: this.selectedReview.rating,
        title: this.selectedReview.title,
      };
      axios
        .post("/api/v1/user/review/update/data", input)
        .then((response) => {
          this.updating = false;
          this.selectedReview = {};
          this.dialog = false;
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

          this.updating = false;
        });
    },
  },
  mounted() {
    this.getReviews();
  },
};
</script>

<style>
.v-list.v-select-list {
  overflow: hidden !important;
}

.icon-close {
  position: absolute;
  top: 0;
  right: 0;
  margin-right: 5px;
  margin-top: 5px;
}

.badgeUsers {
  padding: 0px 14px !important;
}
.pb-reviews {
  margin-bottom: 4px !important;
}
.pb-date {
  margin-bottom: 10px !important;
}
.badgeUsers.v-badge-list .v-badge__wrapper .v-badge__badge {
  min-width: 15px !important;
  height: 15px !important;
  border: 2px solid #fff !important;
  top: 34px !important;
  left: 51px !important;
}
</style>
