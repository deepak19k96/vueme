<template>
  <v-container class="px-0">
    <div class="mb-4">
      <form style="max-width: 770px" class="form-dashboard sfFormProfile">
          <v-row class="mb-3">
            <v-col class="subtitle-1">Money</v-col>
          </v-row>
        <div class="row sfHeaderProfile m-0">
          <v-col class="col-4 col-sm-4 pr-0">
            <v-card
              class="mb-3 text-center pt-5 sfHeadersPayout"
              style="margin-inline-start: auto"
            >
              <div>
                <div
                  :style="[
                    payout_details.current_balance < 0
                      ? { color: '#ff5a7f' }
                      : {},
                  ]"
                  class="sfHeaderBalance"
                >
                  ${{ payout_details.current_balance | numFormat("0,0.00") }}
                </div>
                <div class="sfHeaderTitle">Current Net Balance</div>
                <div class="sfHeaderPeriod">
                  {{ payout_details.pay_period_short }}
                </div>
                <div class="sfHeaderIco">
                  <img src="/images/icons/money_ico.svg" />
                </div>
              </div>
            </v-card>
          </v-col>

          <v-col class="col-4 col-sm-4 pr-0 pl-0">
            <v-card
              class="mb-3 text-center pt-5 sfHeadersPayout"
              style="margin: auto"
            >
              <div>
                <div class="sfHeaderBalance">
                  ${{
                    payout_details.upcoming_payment_amount | numFormat("0,0.00")
                  }}
                </div>
                <div class="sfHeaderTitle">Upcoming Net Payout</div>
                <div class="sfHeaderPeriod">
                  {{ payout_details.upcoming_payment_day_short }}
                </div>
                <div class="sfHeaderIco">
                  <img src="/images/icons/calendar_ico.svg" />
                </div>
              </div>
            </v-card>
          </v-col>

          <v-col class="col-4 col-sm-4 pl-0">
            <v-card
              class="mb-3 text-center pt-5 sfHeadersPayout"
              style="margin-inline-end: auto"
            >
              <div>
                <div class="sfHeaderBalance">
                  ${{ payout_details.all_payment | numFormat("0,0.00") }}
                </div>
                <div class="sfHeaderTitle">All-Time Net Earnings</div>
                <div class="sfHeaderPeriod">
                  Since {{ payout_details.since_short }}
                </div>
                <div class="sfHeaderIco">
                  <img src="/images/icons/bag_ico.svg" />
                </div>
              </div>
            </v-card>
          </v-col>
        </div>
        <v-tabs
          slider-size="0"
          align-with-title
          centered
          grow
          v-model="active_tab"
        >
          <v-tabs-slider></v-tabs-slider>
          
          
          <v-tab tabindex="0" style="margin-left: 0px">Payouts</v-tab>
          <v-tab-item class="mt-5 mb-5">

            <payout-method 
              :user="user"
              :countries="countries"
              :cards="cards"></payout-method>


          </v-tab-item>
          <v-tab tabindex="1">Tax Forms</v-tab>
          <v-tab-item class="mt-5 mb-5">

              <p-tax :user="user" :countries="countries" :states="states" :country_all="country_all"></p-tax>

            </v-tab-item>
          <v-tab tabindex="2" style="margin-right: 0px; padding-right: 0px">History</v-tab>
          <v-tab-item class="mt-5 mb-5">
            <p-credit_logs class="mt-5" :transactions="transactions" :name="name"></p-credit_logs>
            <p-payout-history :transactions="payout_logs"></p-payout-history>
        </v-tab-item>
          
        </v-tabs>
      </form>
    </div>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      reviews: 0,
      total_earning: 0,
      profile_views: 0,
      reviews_rating: 0.0,
      active_tab: null,
    };
  },
  props: ["payout_details", "user",'countries', 'cards','name','transactions','payout_logs',"states","country_all"],
  mounted() {
    if (
      this.$vuetify.breakpoint.name === "xs" ||
      this.$vuetify.breakpoint.name === "sm"
    ) {
      this.f_data_header();
    }
  },

  methods: {
    f_data_header() {
      axios
        .get("/api/v1/user/hdata")
        .then((response) => {
          if (response.status === 200) {
            this.total_earning = response.data.success.t_earning;
            this.reviews = response.data.success.reviews;
            this.profile_views = response.data.success.p_views;
            this.reviews_rating = response.data.success.reviews_rating;
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
    },
  },
};
</script>

<style>
.sfHeaderProfile {
  background: #f4f4f4;
  box-shadow: 0px 3px 6px #0000000d;
  opacity: 1;
  padding: 20px;
}
.sfHeadersPayout {
  max-width: 135px;
  max-height: 97px;
  box-shadow: 0px 3px 6px #0000000d !important;
  border-radius: 10px !important;
}
.sfHeadersPayout.v-card {
  padding: 10px 5px 5px 10px !important;
}

.sfHeaderBalance {
  font-size: 14px;
  text-align: left;
  font-weight: 600 !important;
  color: #43425d;
  opacity: 1;
  letter-spacing: 0.28px;
  line-height: 17px;
}

.sfHeaderTitle {
  font-size: 10px;
  line-height: 13px;
  letter-spacing: 0px;
  opacity: 0.5;
  font-weight: 600;
  color: #43425d;
  text-align: left;
  margin-bottom: 5px;
  margin-top: 5px;
}
.sfHeaderPeriod {
  font-size: 10px;
  text-align: left;
  opacity: 0.5;
  line-height: 13px;
  letter-spacing: 0px;
  font-weight: 500;
  color: #43425d;
}
.sfHeaderIco {
  text-align: right;
}
</style>