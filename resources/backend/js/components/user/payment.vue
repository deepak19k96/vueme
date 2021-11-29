<template>
  <div>

    <div class="container p-0">
      <div  class="subtitleDiv mt-3 mb-3">Payment Method</div>
    </div>
    <!-------Add Card------->

    <!----------End Add Card----->

    <!-------Cards------->
    <div v-if="cards.length">
      <v-simple-table class="elevation-0 mt-2 mb-5">
        <template v-slot:default>
          <thead>
            <tr>
              <th class="text-left" style=" max-width: 45px"></th>
              <th class="text-left">Account</th>
              <th class="text-left">Expire</th>
              <th class="text-left">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="method in cards" :key="method[3]">
              <td style="font-size:25px;color:#a163c1; max-width: 45px">
                <i class="far fa-credit-card"></i>
              </td>
              <td>{{ method[0] }}</td>
              <td>{{ method[1] | expire }}</td>
              <td>
                <v-btn
                  depressed
                  small
                  color="error"
                  :loading="card === method[3]"
                  @click="f_delete_card(method)"
                >Delete</v-btn>
              </td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>
    </div>
    <!-------End Cards------>

    <div v-show="!cards.length || add_card" class="container elevation-0 white pa-10 mb-5">

<div class="form-row" style="margin-right: -15px; margin-left: -15px;">
      <div class="form-group col-6">
        <label for="first_name" class="text_subtitle_credit" style="  float: left;">First name</label>
        <input
                type="text"
                v-model="card_selected.first_name"
                class="form-control inputClass"
                :class="{invalid:card_error_selected.first_name}"
                @change="this.f_check_field"
                id="first_name"
                
        />
      </div>
      <div class="form-group col-6">
        <label for="last_name" class="text_subtitle_credit" style="  float: left;">Last name</label>
        <input
                type="text"
                v-model="card_selected.last_name"
                class="form-control inputClass"
                :class="{invalid:card_error_selected.last_name}"
                @change="this.f_check_field"
                id="last_name"
                
        />
      </div>
      </div>
      <!-- <div class="form-group">
        <label for="full_name" class="text_subtitle_credit" style="  float: left;">Name On Card</label>
        <input
                type="email"
                v-model="card_selected.full_name"
                class="form-control"
                :class="{invalid:card_error_selected.full_name}"
                @change="this.f_check_field"
                id="full_name"
                placeholder="Name On Card"
        />
      </div> -->
      <div class="form-group">
        <label for="cc_number" class="text_subtitle_credit" style="  float: left;">Card Number</label>
        <input
                type="text"
                v-model="card_selected.cc_number"
                class="form-control inputClass"
                :class="{invalid:card_error_selected.cc_number}"
                @change="this.f_check_field"
                id="cc_number"
                
                v-mask="'#### #### #### #### ####'"
        />
          <span v-if="card_error_selected.cc_number" class="d-flex text-danger h6">{{ card_error_selected.cc_number[0] }}</span> 
      </div>

      <div class="form-row" style="margin-right: -15px; margin-left: -15px;">
        <div class="form-group col-md-6">
          <label for="cc_exp" class="text_subtitle_credit" style="  float: left;">Expiration Date</label>
          <input
                  type="text"
                  v-model="card_selected.cc_exp"
                  class="form-control inputClass"
                  :class="{invalid:card_error_selected.cc_exp}"
                  maxlength="5"
                  @change="this.f_check_field"
                  
                  id="cc_exp"
                  v-mask="'##/##'"
          />
           <span v-if="card_error_selected.cc_exp" class="float-left text-danger h6">{{ card_error_selected.cc_exp[0] }}</span> 
        </div>
        <div class="form-group col-md-6">
          <label for="cc_cvv" class="text_subtitle_credit" style="  float: left;">CVV</label>
          <input
                  type="text"
                  v-model="card_selected.cc_cvv"
                  class="form-control inputClass"
                  :class="{invalid:card_error_selected.cc_cvv}"
                  @change="this.f_check_field"
                  id="cc_cvv"
                  
          />
          <span v-if="card_error_selected.cc_cvv" class="float-left text-danger h6">{{ card_error_selected.cc_cvv[0] }}</span>
        </div>
      </div>

      <div class="form-group">
        <label for="cc_zip" class="text_subtitle_credit" style="  float: left;">ZIP/Postal Code</label>
        <input
                type="text"
                v-model="card_selected.cc_zip"
                class="form-control inputClass"
                id="cc_zip"
                :class="{invalid:card_error_selected.cc_zip}"
                @change="this.f_check_field"
                
        />
        <span v-if="card_error_selected.cc_zip" style="position:absolute" class="float-left text-danger h6">{{ card_error_selected.cc_zip[0] }}</span> 
      </div>

      <v-btn  style="height: auto!important; min-width: auto !important; padding: 10px 20px !important;"
              type="button"
              class="btn btn-primary mt-3"
              color="primary"
              depressed
              @click="f_add_card"
              :disabled="loading"
              :loading="loading"
      >save information</v-btn>
    </div>

    <v-btn
            v-show="cards.length"
            class="mx-2 mb-2"
            small
            fab
            dark
            color="primary"
            @click="f_show_add_card"

    >
      <v-icon v-show="!add_card" dark>mdi-plus</v-icon>
      <v-icon v-show="add_card" dark>mdi-minus</v-icon>
    </v-btn>
  </div>
</template>

<script>
function getData() {
  return {
    loading: false,
    add_card: false,

    card_error_selected: {
      last_four: null,
      type: null,
      first_name: null,
      last_name:null,
      cc_number: null,
      cc_exp: null,
      cc_cvv: null,
      cc_zip: null
    },
    card_selected: {
      last_four: null,
      type: null,
      first_name: null,
      last_name:null,
      cc_number: null,
      cc_exp: null,
      cc_cvv: null,
      cc_zip: null
    },
    card: ""
  };
}
import { mask } from "vue-the-mask";
export default {
  directives: { mask },
  name: "payment",
  props: ["cards"],
  data: getData,
  filters: {
    expire: function(value) {
      return value.toString().slice(0, 2) + "/" + value.toString().slice(2, 4);
    }
  },
  methods: {
    f_show_add_card() {
      this.add_card = !this.add_card;
    },
    f_check_field(e) {
      switch (e.currentTarget.id) {
        case "first_name":
          this.card_error_selected.first_name = !this.card_selected.first_name;
          break;
        case "last_name":
          this.card_error_selected.last_name = !this.card_selected.last_name;
          break;  
        case "cc_number":
          this.card_error_selected.cc_number = !this.card_selected.cc_number;
          break;
        case "cc_exp":
          this.card_error_selected.cc_exp = !this.card_selected.cc_exp;
          break;
        case "cc_cvv":
          this.card_error_selected.cc_cvv = !this.card_selected.cc_cvv;
          break;
        case "cc_zip":
          this.card_error_selected.cc_zip = !this.card_selected.cc_zip;
          break;

        default:
      }
    },
    f_reset_data() {
      Object.assign(this.$data, this.$options.data.call(this));
    },

    f_validate_form_card() {
      this.card_error_selected.cc_number = !this.card_selected.cc_number;
      this.card_error_selected.cc_exp = !this.card_selected.cc_exp;
      this.card_error_selected.cc_zip = !this.card_selected.cc_zip;
      this.card_error_selected.cc_cvv = !this.card_selected.cc_cvv;
      this.card_error_selected.first_name = !this.card_selected.first_name;
       this.card_error_selected.last_name = !this.card_selected.last_name;

      if (
        !this.card_error_selected.cc_number &&
        !this.card_error_selected.cc_exp &&
        !this.card_error_selected.cc_zip &&
        !this.card_error_selected.cc_cvv &&
        !this.card_error_selected.first_name &&
        !this.card_error_selected.last_name
      ) {
        return true;
      }
      return false;
    },
    f_add_card() {
      if (this.f_validate_form_card()) {
        this.loading = true;
        axios
          .post("/api/v1/user/account/card", {
            cc_number: this.card_selected.cc_number.replace(/\s+/g, ''),
            cc_exp: this.card_selected.cc_exp,
            cc_zip: this.card_selected.cc_zip,
            cc_cvv:this.card_selected.cc_cvv,
            first_name: this.card_selected.first_name,
            last_name: this.card_selected.last_name
          })
          .then(response => {            
            this.message = response.data;
            this.$root.$emit("open_dialog_message", {
              message: this.message.success,
              message_title: "SUCCESS"
            });
            this.f_reset_data();
            this.f_get_cards();
          })
          .catch(error => {           
            let message = "";
            this.loading = false;
             if(error.response.status === 422){                              
                this.card_error_selected = error.response.data.errors;
              
            }else{  
                this.show_message_decline_transaction(error)
               }
           
          });
      }
    },
    show_message_decline_transaction(error){
                let message = error.response.status === 400 ? error.response.data.error : "";
                message = message == "" ? 'Your payment method could not be added.' : message;
                this.$root.$emit("open_dialog_message", {message: message,message_title: "ERROR"});
    },
    f_array_remove(card) {
      this.cards.splice(this.cards.findIndex(v => v[3] === card[3]), 1);
      if (this.cards.length === 0) {
        this.cards = [];
      }
    },
    f_get_cards() {
      axios
        .get("/api/v1/user/account/cards", {})
        .then(response => {
          this.cards = response.data;
        })
        .catch(error => {
          this.message = error;
        });
    },
    f_delete_card(card) {
      this.card = card[3];

      axios
        .delete("/api/v1/user/account/card", {
          params: {
            biller: card[3]
          }
        })
        .then(response => {
          this.f_array_remove(card);
          this.card = "";
          this.$root.$emit("open_dialog_message", {
            message: response.data.success,
            message_title: "SUCCESS"
          });
        })
        .catch(error => {
          this.card = "";

          if (error.response.status === 400) {
            this.show_message_decline_transaction(error)
          } else {
            this.message =
              "Your payment method could not be removed. ";
          }
          this.$root.$emit("open_dialog_message", {
            message: this.message,
            message_title: "ERROR"
          });
        });
    }
  }
};
</script>

<style type="text/css" scoped>
.text_subtitle_credit {
  font-size: 14px;
  font-weight: 500;
  color: #8d8fa4 !important;
  margin-bottom: 3px;
}

.form-control {
  display: block;
  width: 100%;
  padding: 0.375rem 0.75rem;
  font-size: 1rem;
  line-height: 1.5;
  color: #495057;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
.invalid {
  border-color: #e3342f !important;
  box-shadow: 0 0 0 0.2rem rgba(227, 52, 47, 0.25);
}
.v-dialog__content--active {
    opacity: 1 !important;
    -webkit-backdrop-filter: blur(10px);
    backdrop-filter: blur(10px);
}
</style>