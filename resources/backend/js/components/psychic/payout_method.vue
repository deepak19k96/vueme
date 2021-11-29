<template>
  <div>
    
    <div
      v-if="!Object.entries(card).length || edit"
      class="container container-gray-area elevation-0"
      style="padding-top: 0px; padding-bottom: 20px;"
    >
      <div class="mt-2 pt-8 pb-4 subtitle-1">Banking Information</div>

      <div class="tab-content" id="nav-tabContent" style>
        <div
          class="tab-pane fade show active"
          id="nav-posts"
          role="tabpanel"
          aria-labelledby="nav-posts-tab"
        >
          <v-form class="form-dashboard">
            <div class="mb-0" v-show="obj_account.method==='DEPOSIT' || obj_account.method==='PAYPAL' && !edit">
              <div class="form-group mb-0">
                <label
                  for="address_country"
                  class="mb-4 label_text"
                >Select the country of your bank.</label>

                <!-- <select
                  id="address_country"
                  :class="{invalid:obj_error.address_country}"
                  @change="checkField($event)"
                  name="address_country"
                  v-model="obj_account.address_country"
                  class="custom-select"
                >
                  <option value>Select</option>
                  <option v-for="item in countries" :key="item.id" :value="item.name">{{item.name}}</option>
                </select> -->

                <v-select
                  v-model="obj_account.address_country"
                  :items="countries"
                  item-text="name"
                  item-value="id"
                  label="Select"
                  filled
                  background-color="#ebf4fd"
                  class="blueCheckList"
                  :menu-props="{contentClass: 'checkList-lineBlue'}"
                  :class="{invalid:obj_error.address_country}"
                  dense
                  hide-details
                  solo
                  :height="32"
                  @change="checkField($event)"
                ></v-select>
              </div>
            </div>

            <div class="form-group mt-0" v-if="!edit">
              <label style="width: 100%" class="my-4 label_text">Select Method of Payment</label>
              <div class="custom-control custom-radio custom-control-inline">
                <input
                  type="radio"
                  id="paypal"
                  name="method"
                  value="PAYPAL"
                  v-model="obj_account.method"
                  class="custom-control-input"
                  :menu-props="{contentClass: 'checkListGray-line'}"
                />
                <label
                  :class="{  rselected: obj_account.method === 'PAYPAL',runselected: obj_account.method !== 'PAYPAL'}"
                  class="custom-control-label"
                  for="paypal"
                >Paypal</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input
                  type="radio"
                  id="deposit"
                  checked
                  
                  @change="f_reset_data"
                  v-model="obj_account.method"
                  name="method"
                  value="DEPOSIT"
                  class="custom-control-input"
                />
                <label
                  :class="{ rselected: obj_account.method === 'DEPOSIT',runselected: obj_account.method !== 'DEPOSIT'}"
                  class="custom-control-label"
                  for="deposit"
                >Direct Deposit</label>
              </div>
            </div>

            <div class="form-group mt-3" v-if="edit && obj_account.method==='DEPOSIT'">
              <label style="width: 100%" class="my-4 label_text">Method of Payment</label>

              <div class="custom-control custom-radio custom-control-inline">
                <input
                  type="radio"
                  id="deposit"
                  checked
                  @change="f_reset_data"
                  v-model="obj_account.method"
                  name="method"
                  value="DEPOSIT"
                  class="custom-control-input"
                />
                <label
                  :class="{ rselected: obj_account.method === 'DEPOSIT',runselected: obj_account.method !== 'DEPOSIT'}"
                  class="custom-control-label"
                  for="deposit"
                >Direct Deposit</label>
              </div>
            </div>

            <div v-show="obj_account.method==='DEPOSIT'">
              <div class="form-group">
                <label for="checkname" class="my-4 label_text">Account Holder's Name</label>
                <input
                  type="text"
                  :class="{invalid:obj_error.checkname}"
                  @change="checkField($event)"
                  required
                  class="form-control inputClass"
                  value
                  id="checkname"
                  name="checkname"
                  v-model="obj_account.checkname"
                  placeholder="First and Last Name"
                />
              </div>

              <div class="form-group">
                <label style="width: 100%" class="mt-4 mb-3 label_text">Bank Information</label>
                <div class="custom-control custom-radio custom-control-inline">
                  <input
                    v-model="obj_account.account_type"
                    value="checking"
                    checked
                    type="radio"
                    id="checking"
                    name="account_type"
                    class="custom-control-input "
                  />
                  <label
                    :class="{  rselected: obj_account.account_type === 'checking',runselected: obj_account.account_type !== 'checking'}"
                    class="custom-control-label"
                    for="checking"
                  >Checking</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input
                    v-model="obj_account.account_type"
                    value="savings"
                    type="radio"
                    id="savings"
                    name="account_type"
                    class="custom-control-input"
                  />
                  <label
                    :class="{  rselected: obj_account.account_type === 'savings',runselected: obj_account.account_type !== 'savings'}"
                    class="custom-control-label"
                    for="savings"
                  >Savings</label>
                </div>
              </div>

              <div class="form-group row">
                <div class="form-group col-6">
                  <input
                    type
                    v-model="obj_account.routing_number"
                    :class="{invalid:obj_error.routing_number}"
                    class="form-control inputClass"
                    id="routing_number"
                    placeholder="Routing Number"
                  />
                </div>
                <div class="form-group col-6">
                  <input
                    type="text"
                    v-model="obj_account.account_number"
                    :class="{invalid:obj_error.account_number}"
                    @change="checkField($event)"
                    class="form-control inputClass"
                    id="account_number"
                    placeholder="Account Number"
                  />
                </div>
              </div>
            </div>

            <div v-show="obj_account.method==='PAYPAL'">
              <div class="form-group">
                <label for="paypal_account" class="my-4 label_text">PayPal account</label>
                <input
                  type="text"
                  :class="{invalid:obj_error.paypal_account}"
                  @change="checkField($event)"
                  required
                  class="form-control inputClass"
                  value
                  id="paypal_account"
                  name="paypal_account"
                  v-model="obj_account.paypal_account"
                  placeholder="Email address"
                />
              </div>
            </div>

            <v-btn  style="height: auto!important; min-width: auto !important; padding: 10px 20px !important;"
              depressed
              @click.native.stop="add_deposit_account()"
              :loading="loading"
              :disabled="loading"
              rounded
              color="primary"
            >Save Information</v-btn>

            <v-btn v-if="edit" depressed @click="edit=false" rounded>Cancel</v-btn>
          </v-form>
        </div>
      </div>
    </div>
    <div v-if="Object.entries(card).length && !edit">
      <v-simple-table class="elevation-0 mt-3">
        <template v-slot:default>
          <thead>
            <tr>
              <th class="text-left">Account</th>
              <th class="text-center">Type</th>
              <th class="text-right">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr :key="card.id">
              <td>{{ card.account }}</td>
              <td class="text-center">{{ card.account_type }}</td>
              <td class="text-right">
                <!-- <v-btn depressed small 
                            @click="f_edit_deposit_account(card)">
                <v-icon left small>mdi-pencil</v-icon> Edit</v-btn>-->

                <v-btn depressed small :loading="loading" @click="f_delete_deposit_account(card)">
                  <v-icon left small color="red">mdi-delete</v-icon>Delete
                </v-btn>
              </td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>
    </div>
  </div>
</template>

<script>
function getData() {
  return {
    dialog_message: false,
    message: "",
    message_title: "",
    loading: false,
    tab_in_use: "payout_method",
    edit: false,

    obj_account: {
      method:
        Object.keys(this.cards).length > 0 ? this.cards.payment : "DEPOSIT",
      checkname: null,
      account_type: "checking",
      routing_number: null,
      account_number: null,
      address_country: 232,
      paypal_account: "",
    },

    sending_method: false,
    successfully_method_added: false,

    obj_error: {
      method: "DEPOSIT",
      checkname: null,
      account_type: "checking",
      routing_number: null,
      account_number: null,
      address_country: "",
      paypal_account: null,
    },
    errors: [],
    card: this.cards,
  };
}
export default {
  name: "payou_method",
  props: ["user", "countries", "cards"],
  data: getData,

  methods: {
    f_edit_deposit_account() {
      if (this.card.payment === "DEPOSIT") {
        this.obj_account.address_country = this.card.country;
        this.obj_account.checkname = this.card.account_name;
        this.obj_account.account_type = this.card.account_type;
        this.obj_account.routing_number = this.card.routing;
        this.obj_account.account_number = this.card.account;
        this.obj_account.method = this.card.payment;
      } else {
        this.obj_account.paypal_account = this.card.account;
        this.account_type = "";
        this.obj_account.account = this.card.account;
        this.obj_account.method = "PAYPAL";
      }
      this.edit = true;
    },
    f_delete_deposit_account(card) {
      if (this.obj_account.method.toUpperCase() === "PAYPAL") {
        this.f_delete_paypal_account();
        this.f_reset_data();
        this.card = [];
      } else {
        let type = "DEPOSIT";
        this.loading = true;
        axios
          .delete("/api/v1/user/account/card", {
            params: {
              card_type: type,
              biller: card.id,
            },
          })
          .then((response) => {
            this.f_reset_data();
            this.card = [];
            this.$root.$emit("open_dialog_message", {
              message: response.data.success,
              message_title: "SUCCESS",
            });
          })
          .catch((error) => {
            this.loading = false;

            if (error.response.status === 400) {
              this.message = error.response.data.error;
            } else {
              this.message = error.response.data.message;
            }
            this.$root.$emit("open_dialog_message", {
              message: this.message,
              message_title: "ERROR",
            });
          });
      }
    },
    f_reset_data() {
      Object.assign(this.$data, this.$options.data.call(this));
    },
    getDepositAccount(type) {
      axios
        .get("/api/v1/user/account/cards", {
          params: {
            card_type: type,
          },
        })
        .then((response) => {
          this.card = response.data;
        })
        .catch((error) => {
          this.message = error;
        });
    },
    send_edit_deposit_account() {
      axios
        .put("/api/v1/user/account/payout", {
          checkname: this.obj_account.checkname,
          account_type: this.obj_account.account_type,
          routing_number: this.obj_account.routing_number,
          account_number: this.obj_account.account_number,
          address_country: this.obj_account.address_country,
          billing_id: this.card.id,
        })
        .then((response) => {
          this.loading = false;
          this.$root.$emit("open_dialog_message", {
            message: response.data.success,
            message_title: "SUCCESS",
          });
          this.f_reset_data();
          this.card = [];
          this.getDepositAccount("DEPOSIT");
        })
        .catch((error) => {
          this.loading = false;
          if (error.response.status === 400) {
            this.message = error.response.data.error;
          } else {
            this.message = "Please update your account details and try again";
          }
          this.$root.$emit("open_dialog_message", {
            message: this.message,
            message_title: "ERROR",
          });
        });
    },
    send_new_depossit_account() {
      this.loading = true;

      if (this.edit) {
        if (this.obj_account.method === "PAYPAL") {
          this.f_save_paypal_account();
        } else {
          this.send_edit_deposit_account();
        }
      } else {
        axios
          .post("/api/v1/user/account/depositAccount", {
            checkname: this.obj_account.checkname,
            account_type: this.obj_account.account_type,
            routing_number: this.obj_account.routing_number,
            account_number: this.obj_account.account_number,
            address_country: this.obj_account.address_country,
          })
          .then((response) => {
            this.loading = false;
            this.$root.$emit("open_dialog_message", {
              message: response.data.success,
              message_title: "SUCCESS",
            });
            this.f_reset_data();
            this.card = [];
            this.getDepositAccount("DEPOSIT");
          })
          .catch((error) => {
            this.loading = false;
            if (error.response.status === 400) {
              this.message = error.response.data.error;
            } else {
              this.message = error.response.data.message;
            }
            this.$root.$emit("open_dialog_message", {
              message: this.message,
              message_title: "ERROR",
            });
          });
      }
    },
    add_deposit_account(e) {
      if (this.obj_account.method === "DEPOSIT") {
        if (this.check_form(e)) {
          this.send_new_depossit_account();
        }
      } else {
        this.obj_error.paypal_account = !this.obj_account.paypal_account;

        if (this.obj_error.paypal_account) {
          return;
        }
        this.f_save_paypal_account();
      }
    },
    f_save_paypal_account() {
      this.loading = true;
      axios
        .post("/api/v1/user/account/paypal", {
          email: this.obj_account.paypal_account,
        })
        .then((response) => {
          if (this.edit) {
            this.$root.$emit("open_dialog_message", {
              message: "Your PayPal account was updated",
              message_title: "SUCCESS",
            });
            this.card.account = this.obj_account.paypal_account;
            this.edit = false;
          } else {
            this.card.account = this.obj_account.paypal_account;
            this.card.account_type = "PAYPAL";
            this.$root.$emit("open_dialog_message", {
              message: response.data.success,
              message_title: "SUCCESS",
            });
          }

          this.loading = false;

          //EventBus.$emit('open_dialog_message',{});
        })
        .catch((error) => {
          this.loading = false;
          //this.edit =false;
          if (error.response.status === 400) {
            this.message = error.response.data.error;
          } else {
            this.message =
              "Your PayPal account could not be added. " +
              error.response.data.message;
          }
          this.$root.$emit("open_dialog_message", {
            message: this.message,
            message_title: "ERROR",
          });
          //EventBus.$emit('open_dialog_message',{});
        });
    },
    f_delete_paypal_account() {
      this.loading = true;
      axios
        .delete("/api/v1/user/account/paypal", {
          email: this.obj_account.paypal_account,
        })
        .then((response) => {
          this.loading = false;
          this.card = [];
          this.obj_account.method = "DEPOSIT";
          this.$root.$emit("open_dialog_message", {
            message: response.data.success,
            message_title: "SUCCESS",
          });
        })
        .catch((error) => {
          if (error.response.status === 400) {
            this.message = error.response.data.error;
          } else {
            this.message =
              "Your payment method could not be removed. ";
          }
          this.$root.$emit("open_dialog_message", {
            message: this.message,
            message_title: "ERROR",
          });
        });
    },
    checkField(e) {

      if(typeof(e.currentTarget) != "undefined"){
     
      
      switch (e.currentTarget.id) {
        case "address_country":
          if (e.currentTarget.value !== "United States") {
            this.obj_account.method = "PAYPAL";
          }
          
          this.obj_error.address_country = !this.obj_account.address_country;
          break;
        case "checkname":
          this.obj_error.checkname = !this.obj_account.checkname;
          break;
        case "routing_number":
          this.obj_error.routing_number = !this.obj_account.routing_number;
          break;
        case "account_number":
          this.obj_error.account_number = !this.obj_account.account_number;
          break;
        case "paypal_account":
          this.obj_error.paypal_account = !this.obj_account.paypal_account;
          break;

        default:
      }

      }else{

              console.log(e)
                if (e !== 232)
                this.obj_account.method = "PAYPAL";

                this.obj_error.address_country = !this.obj_account.address_country;
          
      }
    
    },
    check_form(e) {
      this.obj_error.address_country = !this.obj_account.address_country;
      this.obj_error.checkname = !this.obj_account.checkname;
      this.obj_error.routing_number = !this.obj_account.routing_number;
      this.obj_error.account_number = !this.obj_account.account_number;
      this.obj_error.method = !this.obj_account.method;
      this.obj_error.account_type = !this.obj_account.account_type;

      if (
        this.obj_error.address_country ||
        this.obj_error.method ||
        this.obj_error.checkname ||
        this.obj_error.account_type ||
        this.obj_error.routing_number ||
        this.obj_error.account_number
      ) {
        return false;
      }
      return true;
    },
  },

  created() {
    // this.getDepositAccount('DEPOSIT');
    //  this.finished = true;
  },
  mounted() {},
};
</script>

<style type="text/css" scoped>
.custom-select:focus {
  /*   border-color: #9390DE; */
  outline: 0;
  box-shadow: none;
}
#address_country {
  text-align-last: left;
  text-align: left !important;
    min-height: 32px !important;
    color: #8e8d99 !important;
    font-size: 12px !important;
    background: #F0F0F7  url("/images/icons/sort.svg") no-repeat right;
    border: none !important;
    
}
#address_country option{

  padding: 10px !important;
  border-bottom: 1px solid #fff;

}

.rselected {
  filter: blur(0.5);
}
.runselected {
  color: #cfd5db !important;
}
.custom-control-input:checked ~ .custom-control-label::before {
  border-color: #a163c1;
  background-color: #a163c1;
}
.label_text {
  color: #1f1e34 !important;
}
.rselected:hover,
.runselected:hover,
input[type="radio"]:hover {
  cursor: pointer;
}
.btnSave {
  padding: 0.6rem 25px !important;
  border-radius: 22px !important;
  color: #1f1e34 !important;
}
.v-tabs .v-tab {
  font-size: 20px;
}



.tabs_xs {
  font-size: 18px !important;
}
.v-dialog__content--active {
    opacity: 1 !important;
    -webkit-backdrop-filter: blur(10px);
    backdrop-filter: blur(10px);
}

</style>