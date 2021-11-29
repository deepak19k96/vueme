



<template>
  <div>
    <v-row>
      <v-col cols="12" class="px-0">
        <v-container class="mx-0">
       

          <v-card class="mx-auto">
            <v-card-text class="pa-0" style="height: 50%">
              <v-container>
                   <v-row class="mb-3">
            <v-col class="subtitle-1">Payout History</v-col>
          </v-row>

          <v-row class="mb-3">
            <v-col
              style="    color: #0000008a;
    font-size: 12px;"
            >Payouts are process seven days after the pay period ends, and processed on a weekly basis.</v-col>
          </v-row>

          <v-row class="mb-3">
            <v-col style="    color: #0000008a;
    font-size: 12px;">
              Your weekly earnings must reach the minimum payout balance of $75 in order to be processed.
              Payout earnings under the required balance will carry over to the next pay period.
              <a
                href="https://psychics1on1.zendesk.com/hc/en-us/articles/360037770171-When-can-I-expect-my-payout-"
              >(view pay schedule)</a>
            </v-col>
          </v-row>
                <v-row>
                  <v-col class="col-6 col-sm-6">
                    <v-text-field
                      style="background-color: white;"
                      filled
                      solo
                      dense
                      flat
                      prepend-inner-icon="mdi-magnify"
                      label="Search"
                      v-model="search"
                      clearable
                      background-color="#F4F4F4"
                      class="magnifyInput"
                    ></v-text-field>
                  </v-col>
                  <v-col class="col-6 col-md-6">
                    <v-row>
                      <v-col>
                        <template>
                          <div class="text-right btOnly" >
                            <v-menu offset-y :close-on-content-click="false" v-model="close">
                              <template v-slot:activator="{ on }">
                                <v-btn
                                  style="width: initial !important;height: 35px !important;min-width: 135px;padding: 0px;padding-left: 5px;font-size: 12px !important;"
                                  v-show="!show_data_range"
                                  
                                  
                                  v-on="on"
                                  text
                                  hint="MM/DD/YYYY format"
                                >
                                 <label class="mb-0" style="opacity:0.5">{{range_data}}</label>
                                  <v-icon
                                    small
                                     style="margin-left: 35px;"
                                    v-show="range_data ==='Filter by'"
                                  >ico-sort-arrows</v-icon>
                                  <v-icon
                                    small
                                   
                                    v-show="range_data !=='Filter by'"
                                    @click="f_remove_data"
                                  >mdi-close</v-icon>
                                </v-btn>
                              </template>
                              <v-date-picker v-model="dates" range></v-date-picker>
                            </v-menu>
                          </div>
                        </template>
                      </v-col>
                    </v-row>
                  </v-col>
                </v-row>

                <v-data-table
                  id="information"
                  class="col-12"
                  :search="search"
                  :items="obj_transactions"
                  :headers="headers"
                  :hide-default-header="mobile"
                >
                  <template v-slot:item="{item}">
                    <tr :key="item.id" style="height:60px">
                      <td class="px-2">${{item.payout | numFormat('0,0.00')}}</td>

                      <td
                        v-if="item.payout_to_pay > 0"
                        class="px-2 text-center"
                      >${{ item.payout_to_pay | numFormat('0,0.00')}}</td>
                      <td v-else class="px-2 text-center">$--</td>

                      <td class="px-2 text-center">{{item.period}}</td>
                      <td
                        class="px-2 text-right"
                        :class="[item.status === 'Processed' ?'text-success':'']"
                      >
                        <v-tooltip top v-if="item.status === 'Processed'">
                          <template v-slot:activator="{ on }">
                            <div style="cursor:pointer" v-on="on">{{item.status}}</div>
                          </template>
                          <span>{{item.paid_day}}</span>
                        </v-tooltip>
                        <div v-else>{{item.status}}</div>
                      </td>
                    </tr>
                  </template>
                </v-data-table>
              </v-container>
            </v-card-text>
          </v-card>
        </v-container>
      </v-col>
    </v-row>
  </div>
</template>
                              



<script>
import { mapGetters } from "vuex";
import jsPDF from "jspdf";
import autoTable from "jspdf-autotable";
export default {
  data: function () {
    return {
      loading: false,
      search: "",
      flag: true,
      selected_service: "",
      pdf_data: [],
      pdf_data_temp: [],

      headers: [
        { text: "Earnings", value: "earnings" },
        { text: "Payout", value: "payout", align: "center" },
        { text: "Pay Period", value: "period", align: "center" },
        { text: "Status", value: "status", align: "right" },
      ],
      dates: [],
      close: false,
      range_data: "Filter by",
      show_data_range: false,
    };
  },
  watch: {
    dates: function (newVal, oldVal) {
      if (newVal.length !== 0) {
        if (newVal.length === 2) {
          this.range_data =
            newVal[0].replace("-", "/") + " - " + newVal[1].replace("-", "/");
          this.close = false;
        }
      }
    },
  },
  computed: {
    obj_transactions() {
      return this.transactions.filter((transaction) => {
        let str =
          transaction.payout +
          " " +
          transaction.payout_to_pay +
          " " +
          transaction.period +
          " " +
          transaction.status;

        if (
          !this.search ||
          str.toLowerCase().indexOf(this.search.toLowerCase()) !== -1
        ) {
          if (this.range_data !== "Filter by") {
            let start = new Date(this.dates[0]);
            let end = new Date(this.dates[1]);
            let startDB = new Date(transaction.start_period);
            let endDB = new Date(transaction.end_period);
            if (
              (start <= startDB || start <= endDB) &&
              (end >= endDB || end >= startDB)
            ) {
              return true;
            }
          } else {
            return true;
          }
        }
      });
    },
    ...mapGetters({
      mobile: "util/mobile",
    }),
  },
  props: ["transactions"],

  methods: {
    f_remove_data() {
      this.close = false;
      this.range_data = "Filter by";
      this.dates = [];
    },
    f_fdate(date) {
      var created = new Date(date);
      return (
        (created.getMonth() > 8
          ? created.getMonth() + 1
          : "0" + (created.getMonth() + 1)) +
        "/" +
        (created.getDate() > 9 ? created.getDate() : "0" + created.getDate()) +
        "/" +
        created.getFullYear()
      );
    },
  },
};
</script>

<style>
.icon-close {
  position: absolute;
  top: 0;
  right: 0;
  margin-right: 5px;
  margin-top: 5px;
}

.v-data-footer__pagination {
  margin: 0px 10px 0px 10px;
}
td {
  font-weight: 500;
  font-size: 12px;
}
.v-card label {
  color: #3f3e3f !important;
  font-weight: 500 !important;
}

.btOnly .v-btn:not(.v-btn--round).v-size--default {
width: 135px !important;
}
.btOnly  .v-btn{
        background-color: #F0F0F7 !important;
            
}

.v-text-field--filled.v-input--dense.v-text-field--single-line .v-label div,
.theme--light.v-select .v-select__selection--comma div,
.v-select .v-label,
.v-select__selections div{
  font-weight: 500;
  color: #1f1e34 !important; 
  opacity: .5;
}
.btOnly .v-btn .v-btn__content{
    color: #1f1e34 !important;
    /*opacity: .5;*/
    font-size: 12px !important;

}
.btOnly .v-btn.theme--light.v-btn:focus::before,
.btOnly .theme--light.v-btn:hover::before {
    opacity: 0 !important;
}
.btOnly button:focus {
 outline: none !important;
}


</style>
