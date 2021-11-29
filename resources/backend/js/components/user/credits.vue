<template>
  <div>
    <div v-if="$vuetify.breakpoint.smAndDown" class="row" style="position: absolute;right: 24px;box-shadow: 2px 1px 15px -9px rgb(162, 162, 162) !important;">
      <v-card color="white" style="width:90px; height: 95px;box-shadow: none !important;" @click="dialog_select_credit=true">
            <div primary-title class="text-center">
              <img style="margin-top:19px;margin-bottom:10px" src="/images/icons/Wallet.svg" />
              <div style="color: #656B72 !important;font-weight: 500;font-size: 14px !important;">Reload</div>
            </div>           
       </v-card>


      <v-card color="white" style="width:115px; height: 95px;box-shadow: none !important;" @click="dialog_select_credit=true">
            <div style="color: #43425D;font-size: 12px;font-weight: 500;padding: 15px 20px;" primary-title class="text-center">
              <div style="background-color:#F4F4F4;padding: 6px 5px;">
              <div style="opacity: 0.5;">Current</div>
              <div style="opacity: 0.5;">Balance</div>
              <div  style="color: color: #656B72; !important; font-weight: 600; font-size: 12px !important ">{{currency}}{{ parseFloat(user_credits).toFixed(2) }}</div>
            </div>  
            </div>         
       </v-card>      
    </div>

    <div v-else style="display: inline-flex;">
      <!-- <v-btn style="margin-right: 5px;margin-top: 2px;"
             x-small class="credit_icon" color="withe--text" 
      @click="dialog_select_credit = true">{{currency}}</v-btn>-->
      <span
        class="credits"
        @click="dialog_select_credit = true"
      >{{currency}}{{ parseFloat(user_credits).toFixed(2) }}</span>
      <!-- <v-btn text small class="credits" color="white&#45;&#45;text"
                   @click="dialog_select_credit = true">
                {{ user.credits }}
      </v-btn>-->
    </div>

    <v-dialog v-model="g_modal" width="320px">
      <v-card color="#fff">
        <v-card-text style="padding: 15px 20px;">
          <div
            class="text-left mb-2"
            style=" font-family: Montserrat;font-size: 18px;font-weight: 600;color: #1f1e34;"
          >
            Guarantee Terms
            <v-icon
              class="float-right"
              style="position: absolute;right: 15px;"
              @click="g_modal=false"
            >mdi-close</v-icon>
          </div>
          <div
            class="text-left mb-2 small"
          >If your chat message is not responded to within 24hrs, the funds for those messages will automatically be credited back to your account.</div>
        </v-card-text>
      </v-card>
    </v-dialog>

    <v-dialog v-model="dialog_select_credit" max-width="335px" content-class="credit_dialog">
      <v-card height="100%" style="border-radius: 30px !important;">
        <v-list-item style="background-color: #F4F4F4">
          <v-list-item-title>
            <div class="row">
              
               <v-icon
              class="d-block text-right mt-3 mr-1"
              style="position: absolute;right: 15px;"
              @click="dialog_select_credit=false"
            >mdi-close</v-icon>
             </div>
            <div class="container py-0">
          
             
              
            <div class="row text-left" v-if="!show_check_out">
              <div class="col-12 mt-15 px-0 text_title">Add Funds to Wallet</div>
              <div class="container bg-white mt-5" style="padding: 10px;">
                   <div class="row">
                   
                    <div class="col-4" style="padding: 0 10px !important;">
                      <div primary-title class="text-center" style="padding: 10px 0px;background-color:#F4F4F4;">
                      <img src="/images/icons/Wallet_opacity.svg" />
                      <div class="text_subtitle_credit" style="opacity:0.5">{{currency}}{{ parseFloat(user_credits).toFixed(2) }}</div>
                      </div>   
                    </div>
                    <div class="col-8 pr-12">
                      
                            <div class="text_subtitle_credit" style="color:#C7C7C7 !important">Risk-Free Guarantee</div>
                            <div class="sub_text_subtitle_credit mt-1" style="line-height: 15px;">Exceptional experience and response guaranteed, or we’ll issue a refund.</div>
                            
                            <img class="icon_certified" src="/images/icons/Certified_30x30.svg" />
                          </div>
                   </div>
              </div>

              <div class="container py-5">
                <div class="row">
                   <div class="col-12 px-0 select_credits">Select Amount</div>
                   <div class="col-12 px-0 mb-2">


                   <div class="row">
                      <div class="col-3 mt-5 px-3" v-for="(item, index) in credits_amount" :key="index">
                        <div class="btn_prices" @click="credits = item" :style="[ credits.value == item.value ? {'background-color': '#C1DBFB'}:{}]">
                          <div style="opacity:0.5">{{item.title}}</div>
                        </div>
                      </div>                  
                                      
                   </div>
                    </div>

                    
                    <div v-if="promo"  class="col-12 px-0 mt-3">                    
                    <input
                      type="text"
                      v-model="promoCode"
                      class="form-control form-payment"
                      :style="[promoCode?{'text-transform': 'uppercase'}:{}]"
                      placeholder="Promo Code"                     
                    />
                    <div v-if="promoError" style="color: red; text-align: left; font-size: 12px; padding: 5px;">{{promoError}}</div>
                    </div>
                    <div class="col-12 px-0">
                        <div class="row">
                      <div class="col-6 mt-3">
                        
                        <div class="btn_prices" style="display: inline-flex;font-weight: 600;padding: 10px 15px !important;">
                          <div class="mr-9" style="font-weight: 600;color: #C7C7C7;">Total</div><div style="opacity:0.5">
                             {{currency}}{{ parseFloat(credits.value).toFixed(2) }}</div></div>
                      </div>   

                      <div class="col-6 pl-0" style="display: inline-flex;" v-if="user.buyCredits.times == 0">
                         <img class="" src="/images/icons/Gift_B35x35.svg" />
                         <div class="pt-5" style="color: rgb(142, 190, 248);
    font-size: 12px;
    font-weight: 600;">You get ${{user.buyCredits.promo}} credit</div>
                         
                        </div> 
                         <div class="col-12 mt-5"> 
                         <v-btn style="float: right;"
                          rounded
                          height="38"
                          width="74"
                          @click="validate_promo"
                          color="#8EBEF8"
                          dark
                        >Next</v-btn> 
                         </div>            
                                      
                   </div>
                    </div>
                </div>
              </div>
                
              </div>




              <!-------------Check Out------>
                   

                   <div class="row text-left" v-if="show_check_out">
              <div class="col-12 mt-15 px-0 text_title">Checkout</div>
               <div class="form-group pt-2 text-left mb-0">
                      <img src="/images/icons/Card_Apple_PayLeft_40x40.svg"  />
                      <img src="/images/icons/Card_Visa_40x40.svg"  />
                      <img src="/images/icons/Card_Discover_40x40.svg"  />
                      <img src="/images/icons/Card_Mastercard_40x40.svg" />
                      <img src="/images/icons/Card_DinersClub_40x40.svg"  />
                      <img src="/images/icons/Card_JCB_40x40.svg" />
                  </div>             

              <div class="container pt-3">
                <div class="row">
                   <div class="col-12 px-0 select_credits mb-5">Payment Method</div>
                   <div class="form-group mb-2" style="overflow-y: scroll;">

                        <v-sheet
                    class="mx-auto"
                    max-width="500"
                   
                  >
                    <v-slide-group
                      v-model="option_selected"                      
                      style="background-color:#f4f4f4"
                      
                      
                    >
                      <v-slide-item
                        v-for="(card , index) in cards"
                        :key="'card_'+index"
                        v-slot:default="{ active, toggle }"
                      > 
                        <div :class="index !=0 ? 'pl-3 pr-7':'pr-7'">
                              <img  :input-value="active" 
                              style="cursor: pointer;"
                        @click="toggle" 
                        :src="!active || apple_pay ?  card.image_unselected: card.image_selected" />
                         <div v-if="index!==0" :style="[active ? {'color': '#8ebef8','opacity':1}:{}]" class="last_four">**** **** **** {{card.last_four}}</div>
                         <div v-if="index==0" style="margin-left: 6px;" :style="[active ? {'color': '#8ebef8','opacity':1}:{}]" class="last_four">Add New Card</div>
                        </div>
                           
                        
                        </v-slide-item>
                      </v-slide-group>
                    </v-sheet>
                    
                   </div>
                    <div class="col-12 px-0 mb-2 mt-3" v-if="apple_allowed"> 
                          <v-btn
                           
                          
                           rounded
                           height="31" 
                           @click="apple_pay = true"
                           :style="[apple_pay ? {'background-color': '#8EBEF8','border-color': '#8EBEF8','opacity':1}:{}]" 
                           color="#43425D"
                           style="opacity: 0.5;color: white;"
                         
                        >
                         <i class="fab fa-apple"></i>
                        Pay</v-btn>   
                        
                    </div> 



                    <!---Form new card----->


                <div style="padding: 0px 3px;" class="mt-3" v-show="option_selected == 0">
                 

                   <div class="form-group">
                   
                    <input
                      type="text"
                      v-model="card_selected.cc_number"
                      class="form-control form-payment"
                      :class="{invalid:card_error_selected.cc_number}"
                      @change="this.f_check_field"
                      @keyup="validateAMEX()"
                      id="cc_number"
                      placeholder="Card Number"
                      v-mask="'#### #### #### #### ####'"
                    />
                    <span
                      v-if="card_error_selected.cc_number"
                      class="d-flex text-danger h6"
                    >{{ card_error_selected.cc_number[0] }}</span>
                  </div>

                  <div class="form-row" style="margin-right: -15px; margin-left: -15px;">
                    <div class="form-group col-md-6 pr-md-2">                     
                      <input
                        type="text"
                        v-model="card_selected.first_name"
                        class="form-control form-payment"
                        :class="{invalid:card_error_selected.first_name}"
                        @change="this.f_check_field"
                        id="first_name"
                        placeholder="First Name"
                      />
                    </div>
                    <div class="form-group col-md-6 pl-md-2">                    
                      <input
                        type="text"
                        v-model="card_selected.last_name"
                        class="form-control form-payment"
                        :class="{invalid:card_error_selected.last_name}"
                        @change="this.f_check_field"
                        id="last_name"
                        placeholder="Last Name"
                      />
                    </div>
                  </div>

                 

                  <div class="form-row" style="margin-right: -15px; margin-left: -15px;">
                    <div class="form-group col-4 pr-0 mb-2">
                     
                      <input
                        type="text"
                        v-model="card_selected.cc_exp"
                        class="form-control form-payment"
                        :class="{invalid:card_error_selected.cc_exp}"
                        @change="this.f_check_field"
                        maxlength="5"
                        placeholder="Expires"
                        id="cc_exp"
                        v-mask="'##/##'"
                      />
                      <span
                        v-if="card_error_selected.cc_exp"
                        class="float-left text-danger h6"
                      >{{ card_error_selected.cc_exp[0] }}</span>
                    </div>
                    <div class="form-group col-4 px-2 mb-2">
                     
                      <input
                        type="text"
                        v-model="card_selected.cc_cvv"
                        class="form-control form-payment"
                        :class="{invalid:card_error_selected.cc_cvv}"
                        @change="this.f_check_field"
                        id="cc_cvv"
                        placeholder="CSV"
                      />
                      <span
                        v-if="card_error_selected.cc_cvv"
                        class="float-left text-danger h6"
                      >{{ card_error_selected.cc_cvv[0] }}</span>
                    </div>

                   <div class="form-group col-4 pl-0 mb-2">
                  
                    <input
                      type="text"
                      v-model="card_selected.cc_zip"
                      class="form-control form-payment"
                      id="cc_zip"
                      :class="{invalid:card_error_selected.cc_zip}"
                      @change="this.f_check_field"
                      placeholder="Zip Code"
                    />
                    <span
                      v-if="card_error_selected.cc_zip"
                      class="float-left text-danger h6"
                    >{{ card_error_selected.cc_zip[0] }}</span>
                  </div>

                  </div>

                 
                </div>

                    <!---end form new Card------>



                
                    <div class="col-12 px-0 mb-3">
                        <div class="row">
                     <div class="col-6 mt-3">
                        
                        <div class="btn_prices" style="display: inline-flex;font-weight: 600;padding: 10px 15px !important;">
                          <div class="mr-9" style="font-weight: 600;color: #C7C7C7;">Total</div>
                          <div style="opacity:0.5"> {{currency}}{{ parseFloat(credits.value).toFixed(2) }}</div></div>
                      </div>   

                      <div class="col-6 pl-0" style="display: inline-flex;" v-if="user.buyCredits.times == 0 || promoCodeAmount > 0">
                         <img class="" src="/images/icons/Gift_B35x35.svg" />
                         <div class="pt-5" style="color: rgb(142, 190, 248);
    font-size: 12px;
    font-weight: 600;">You get ${{show_total_gift()}} credit!</div>
                         
                        </div> 
                          <div class="col-md-12 text-left mt-2" style="white-space: break-spaces;">
                    <a target="_blank" href="/payment-terms">
                      <span
                        class="sub_text_subtitle_credit"
                        style="font-size: 10px"
                      >By tapping ‘Pay Now’ you agree to all Terms & Conditions. Charges will appear as 1on1.com on your statement.</span>
                    </a>
                    <!-- <p
                      class="text-muted"
                      style="font-size: 10px"
                    >Charges will appear on your credit card statement as 1on1.com</p> -->
                  </div>
                         <div class="col-12 mt-5"> 
                          <v-btn
                          rounded
                          @click="show_check_out = false"
                          outlined
                          height="38"
                          color="#8EBEF8"
                         
                        >Back</v-btn>   
                         <v-btn style="float: right;"
                          rounded                          
                          color="#8EBEF8"
                          dark
                          height="38"
                          v-bind:class="option_selected == undefined && !apple_pay ? 'color_inactive':''"
                          @click="f_pay_credits"
                          :disabled="loading || (option_selected == undefined && !apple_pay)"
                          :loading="loading"
                         
                        >Pay Now</v-btn> 
                         </div>            
                                      
                   </div>
                    </div>
                </div>
              </div>
                
              </div>
              <!------- End Check Out----->

            </div>
          
           
        
          </v-list-item-title>
        </v-list-item>
      </v-card>
    </v-dialog>
  </div>
</template>


<script>
function getData() {
  return {
    message: "",
    message_title: "",
    loading: false,        
    dialog_select_credit: false,
    g_modal: false,

    credits: {
      title: "$100",
      value: 100
    },

    credits_amount: [
      { value: 20, title: "$20" },
      { value: 35, title: "$35" },
      { value: 50, title: "$50" },
      { value: 75, title: "$75" },
      { value: 100, title: "$100" },
      { value: 250, title: "$250" },
      { value: 500, title: "$500" },
      { value: 750, title: "$750" }
     
    ],
    cards:[],
    card_selected: {
      last_four: null,
      type: null,
      first_name: null,
      last_name: null,
      cc_number: null,
      cc_exp: null,
      cc_cvv: null,
      cc_zip: null
    },
    card_error_selected: {
      last_four: null,
      type: null,
      first_name: null,
      last_name: null,
      cc_number: null,
      cc_exp: null,
      cc_cvv: null,
      cc_zip: null
    },   
    user_credits: this.user.credits, 
    currency: "$",

    promo: null,
    promoCode: null,
    promoError: null,
    promoCodeAmount:0,
    show_check_out:false,
    apple_pay:false,
    option_selected:undefined,
    newCard:{
          id:0, 
          last_four: null,          
          cc_exp: null,
          image_selected:'/images/icons/Card_added_selected.svg',
          image_unselected: '/images/icons/Card_added.svg',
          priority:0
    },
    debug:false,
    version: 10,
    apple_allowed: false
  };
}
import Vue from "vue";
import { mask } from "vue-the-mask";
export default {
  directives: { mask },
  name: "credits",
  props: ["user"],
  data: getData,
  watch: {
    dialog_select_credit: function(newVal, oldVal) {
      if (newVal) {
        
        this.f_reset_data();
        this.f_get_cards();
        this.is_apple_pay_allowed();
        this.dialog_select_credit = true;
        

      }
    },
    apple_pay: function(newVal,oldVal){
       if(newVal){
         this.option_selected = undefined;
       }
    },
    option_selected: function(newVal, oldVal){
      if(newVal !== undefined){
         this.apple_pay =false;
      }
    },
    show_check_out: function(newVal, oldVal){
      if(!newVal){       
        this.promoError = null;
      }
    }
  }, 
  mounted() {
   
    this.$root.$on("open_credits_too", () => {      
      this.dialog_select_credit = true;
    });
    this.$root.$on("chat_subtract_credits-" + this.user.id, data => {
      this.f_remove_credits_user_text_message(data.user.credits);
    });

    EventBus.$on("open-credits", (payload) => {
      
      this.dialog_select_credit = true;
    });

    EventBus.$on("update_credits", () => {
      this.updateCredits();
    });
  },
  methods: {
     show_total_gift(){
           return this.user.buyCredits.times > 0 ? this.promoCodeAmount : this.promoCodeAmount + this.user.buyCredits.promo ; 
           
     },
     pay_by_apple(){
                  self = this;
                      var request = {
                            countryCode: 'US',
                            currencyCode: 'USD',
                            supportedNetworks: ['visa', 'masterCard', 'amex', 'discover'],
                            merchantCapabilities: ['supports3DS'],
                            requiredBillingContactFields: [
                              'postalAddress',
                              'name',
                            ],               
                            total: { label: 'Psychics1on1', amount: this.credits.value, type: 'final' },
                          }
                          this.logit(this.version)
                  var session = new ApplePaySession(this.version, request);
                      //Merchant Validation        
                  session.onvalidatemerchant = function (event) {
                      
                        self.performValidation(event.validationURL, function(merchantSession){
                        self.logit('callback')
                          if(merchantSession){
                            self.logit('inside')
                              session.completeMerchantValidation(merchantSession);
                          }else{
                            self.logit('abort')
                            session.abort();
                          }           
                            
                        });
                      }; 
                      
                  
                  session.onpaymentauthorized = function (event) {
                          self.sendPaymentToken(event.payment, function (outcome) {
                            if (outcome) {                                       
                                  session.completePayment(ApplePaySession.STATUS_SUCCESS)                      
                            } 
                            else {                                 
                                    session.completePayment(ApplePaySession.STATUS_FAILURE)
                                  }
                            });
                      }
                     session.oncancel = function(event) {
                        self.logit('starting session.cancel');
                        self.logit(event);
                      }
                    session.begin(); 
                  },
      sendPaymentToken(values, callback) { 
    
      var valuesPaymentData = values.token.paymentData; 
       axios
          .post('/api/v1/user/account/apple/pay', {
           paymentData:   { 
            
             data : valuesPaymentData.data,
             header:{
               ephemeralPublicKey: valuesPaymentData.header.ephemeralPublicKey,
               publicKeyHash: valuesPaymentData.header.publicKeyHash,              
               transactionId: valuesPaymentData.header.transactionId
             },
             signature: valuesPaymentData.signature,
             version: valuesPaymentData.version,
             
          },
          billingDetails : values.billingContact,
          paymentMethod: {
             displayName: values.token.paymentMethod.displayName,
             network: values.token.paymentMethod.network,
             type: values.token.paymentMethod.type
          },
          transactionId : values.token.transactionIdentifier,
          promoCode: this.promoCode,
          credits: this.credits.value,
          })
          .then(response => {   
            this.loading = false;
            this.f_add_credits_to_user(response.data.success.credits);
            this.dialog_select_credit = false;
            this.message = response.data.success.msg;
            this.$root.$emit("open_dialog_message", {
              message: this.message,
              message_title: "PURCHASE",
              purchase: response.data.success.purchase
             });         
			      	callback(response.data);
          })
            .catch(error => {   
              callback(false); 
              this.logit(error)
               this.loading = false;
            if(error.response.data.error && error.response.data.error.promo) {
               this.promoError = error.response.data.error.message;
               return;
             }
            this.dialog_select_credit = false;
            this.show_message_decline_transaction(error)
          });
    	},
      performValidation(valURL, callback) {     
       this.promoError ='';
       axios
          .post('/api/v1/user/account/validate', {
           appleUrl: valURL,
           promoCode: this.promoCode,
          })
          .then(response => {  
               this.logit(response)           
			      	callback(response.data);
          })
          .catch(responseerror => { 
             
              this.logit(responseerror) 
              if(responseerror.response.data.error && responseerror.response.data.error.promo) {
               this.promoError = responseerror.response.data.error.message;               
             }            
            callback(false); 
            });
  },
     logit( data ){	
      if( this.debug == true ){
        console.log(data);
      }	
    }, 
    is_apple_pay_allowed(){
       
         var self = this;       
         if (window.ApplePaySession) {
           while(!ApplePaySession.supportsVersion(this.version)){
             this.logit(ApplePaySession.supportsVersion(this.version))
             this.logit(this.version);
             this.version--;
           }
          
           
              var merchantIdentifier = 'merchant.com.psychics1on1';
            
              var promise = ApplePaySession.canMakePaymentsWithActiveCard(merchantIdentifier);
              promise.then(function (canMakePayments) {
                if (canMakePayments) {
                  self.apple_allowed = true;
                   
                } else {
                    
                    //document.getElementById("got_notactive").style.display = "block";
                    //self.logit('ApplePay is possible on this browser, but not currently activated.');
                      } }); 
            } 
            else {
                //self.logit('ApplePay is not available on this browser');
                //document.getElementById("notgot").style.display = "block";
            }     
    },
    validate_promo(){

      if(this.promoCode){
        this.loading = true;  
        axios
          .post("/api/v1/user/validate/promo", {           
            promoCode: this.promoCode,
            credits: this.credits.value,
          })
          .then(response => {
           this.promoCodeAmount = response.data; 
           this.loading = false;   
           this.show_check_out = true
          })
          .catch(error => {
            this.loading = false;
            if(error.response.data.error && error.response.data.error.promo) {
               this.promoError = error.response.data.error.message;
               return;
             }          
        
          });
      }else{
          this.promoCodeAmount = 0;
         this.show_check_out = true;
      }
       
 
   
     
    },
    validateAMEX() {
      const text = this.card_selected.cc_number.trim().substring(0, 2);
      if (text == 37 || text == 34) {
        //this.card_selected.cc_number = "";
        this.card_error_selected.cc_number = ["American Express not accepted"];
      } else {
        this.card_error_selected.cc_number = null;
      }
    },
    updateCredits() {
      this.loading = true;
      axios
        .get("/api/v1/user/get/credits", {
          id: this.user.id
        })
        .then(response => {
          this.f_remove_credits_user_text_message(
            response.data.success.credits
          );
        })
        .catch(error => {
          this.loading = false;
          if (error.response.status == 422) {
            this.card_error_selected = error.response.data.errors;
          } else {
            if (error.response.status === 400) {
              this.message = error.response.data.message;
            } else {
              this.message =
                "Your payment method could not be added. " +
                error.response.data.message;
            }
            this.$root.$emit("open_dialog_message", {
              message: this.message,
              message_title: "ERROR"
            });
          }
        });
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

    f_pay_credits() {
      if(this.apple_pay){
        this.pay_by_apple();
      }else{
        if (this.option_selected == 0) {
        this.f_add_card_and_buy_credits();
        } else {
          this.f_buy_credits();
        }
      }
      
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
    f_add_card_and_buy_credits() {
      if (this.f_validate_form_card()) {
        this.loading = true;
        axios
          .post("/api/v1/user/account/cardPayment", {
            cc_number: this.card_selected.cc_number.replace(/\s+/g, ""),
            credits: this.credits.value,
            cc_exp: this.card_selected.cc_exp,
            cc_zip: this.card_selected.cc_zip,
            cc_cvv: this.card_selected.cc_cvv,
            first_name: this.card_selected.first_name,
            last_name: this.card_selected.last_name,
            promoCode: this.promoCode
          })
          .then(response => {
            this.loading = false;
            this.f_add_credits_to_user(response.data.success.credits);            
            this.dialog_select_credit = false;
            this.message = response.data.success.msg;
            

              this.$root.$emit("open_dialog_message", {
              message: this.message,
              message_title: "PURCHASE",
              purchase: response.data.success.purchase
            });
          })
          .catch(error => {
            this.loading = false;
            if(error.response.data.error && error.response.data.error.promo) {
               this.promoError = error.response.data.error.message;
               return;
             }
            if (error.response.status == 422) {
              this.card_error_selected = error.response.data.errors;
            } else {
              this.show_message_decline_transaction(error);
            }
          });
      }
    },
    f_add_credits_to_user(credits) {

      // const promo = this.user.buyCredits.times < 1 ? this.user.buyCredits.promo : 0; 
      // this.user_credits = parseFloat(this.user.credits) + parseFloat(credits) + promo + this.promoCodeAmount;
      const buyCreditsCount = parseInt(this.user.buyCredits.times) + 1;
      this.user_credits = credits;
      Vue.set(this.user.buyCredits, 'times', buyCreditsCount);
      Vue.set(this.user, "credits", credits);
    },
    f_remove_credits_user_text_message(credits) {
      this.user_credits = credits;
      Vue.set(this.user, "credits", credits);
    },
    f_buy_credits() {
      
      if(this.option_selected != undefined){
          this.loading = true;
        axios
          .post("/api/v1/user/account/credits", {
            credits: this.credits.value,
            biller: this.cards[this.option_selected].id,
            promoCode: this.promoCode
          })
          .then(response => {           
            this.loading = false;
            this.f_add_credits_to_user(response.data.success.credits);
            this.dialog_select_credit = false;

            this.message = response.data.success.msg;
            this.$root.$emit("open_dialog_message", {
              message: this.message,
              message_title: "PURCHASE",
              purchase: response.data.success.purchase
            });
          })
          .catch(error => {
            this.loading = false;
            if(error.response.data.error && error.response.data.error.promo) {
               this.promoError = error.response.data.error.message;
               return;
             }
            this.dialog_select_credit = false;
            this.show_message_decline_transaction(error);
          });
 
      }
       
     
    },
     show_message_decline_transaction(error){
                let message = error.response.status === 400 ? error.response.data.error : "";
                message = message == "" ? 'Your payment method could not be added.' : message;
                this.$root.$emit("open_dialog_message", {message: message,message_title: "ERROR"});
    },
    f_get_cards() {
     
        axios
          .get("/api/v1/user/account/cards?checkPromo=true&card_type=BUY_CREDIT", {})
          .then(response => {           
            this.cards = response.data.cards;
            this.cards.unshift(this.newCard);
            this.promo = response.data.promo;
            this.option_selected = this.cards.length > 1 ? 1:0;           
          })
          .catch(error => {          
          });
     
    },    
  }
};
</script>

<style scoped>


.credit_icon {
  background-color: #8ebef8 !important;
  font-size: 10px !important;
  font-weight: 700;
  padding: initial !important;
  min-width: 18px !important;
  height: 18px !important;
  color: white;
  border-radius: 100%;
}
.form-payment::placeholder {
  color: #C7C7C7 !important;
  font-size: 14px;
  font-weight: 500;
  opacity: 1;
}
.credits {
  color: white;
  margin-right: 15px;
  font-size: 15px;
  font-weight: 800;
  cursor: pointer;
}

.text_title {
  font-size: 16px;
  font-weight: 600;
  color: #43425D;
}


.text_subtitle_credit {
  font-size: 12px;
  font-weight: 600;
  color: #43425D !important;

}
.sub_text_subtitle_credit {
  font-size: 10px;
  font-weight: 500;
  color: #C7C7C7 !important;
  white-space: pre-wrap;
}
.icon_certified{
      position: absolute;
    right: 10px;
    bottom: 0px;
}
.select_credits {
  letter-spacing: 0px;
  font-size: 12px;
  font-weight: 600;  
  color: #A2A2A2;  
}
.btn_prices{
  
    text-align: center;
    padding: 8px 10px !important;
    background-color: white;
    border-radius: 30px;
    color: #1F1E34;
    font-size: 12px;
    font-weight: 500;
    /* opacity: 0.5; */
    cursor: pointer;
}
.total_amount { 
  font-weight: 600 !important;
  color: #1f1e34 !important;
}
>>>.credit_dialog {
  border-radius: 30px !important;
}
.last_four{
  position: absolute;
    top: 18px;
    font-size: 10px;
    font-weight: 600;
    color: #43425D;
    opacity: 0.5;
}
.theme--dark.v-btn.v-btn--disabled:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined) {
    background-color: #a1a1ae !important;
}

.form-control div{
  opacity: 0.5;
}
.form-control { 
  height: 40px;
  background-color: #fff;
  background-clip: padding-box;
  font-size: 14px;
  height: 40px;
  color: #989494;
  padding: 10px;
  font-weight: 500;
  border-radius: 0.25rem;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
.form-control:focus {  
  color: #1F1E34;
}






.text_add_card {
  font-size: 10px;
  font-weight: 500;
  text-transform: uppercase;
  padding-left: 0px;
  /* height: 60px;*/
  color: #80818b;
}

.v-list-item {
  text-align: center;
  border: 1px solid #e7e7f0;
  padding: 0 20px;
}

.btn_select_payment_method {
  font-size: 16px;
  font-weight: 600;
  text-transform: capitalize;
  width: 100%;
  color: #F0F0F7;
  border-radius: 5px !important;
  background-color:#F0F0F7!important;
}

.color_inactive {
  background-color: #A1A1AE  !important;
  pointer-events: none;
}

.invalid {
  border-color: #e3342f !important;
  box-shadow: 0 0 0 0.2rem rgba(227, 52, 47, 0.25);
}
.v-card label {
  font-size: 12px !important;
  color: #6b7d7d !important;
}
.v-input--selection-controls.v-input .v-label {
  font-size: 12px !important;
  color: #6b7d7d !important;
}

.btn_select_payment_method >>> span {
  font-size: 13px;
  color: #1f1e34;
}

.select_credits >>> span {
  font-size: 13px;
  color: #1f1e34;

  
}
>>> .v-slide-group__next {
   display: none;
}
>>> .v-slide-group__prev {
   display: none;
}


</style>
<style>
/* .promo .v-text-field > .v-input__control > .v-input__slot:after, .promo .v-text-field > .v-input__control > .v-input__slot:before{
  border: none !important;
  content: none !important;
} */
.promo input{
  font-size: 13px !important;
  text-align: center;
}
@media only screen and (max-width: 450px){
  
  .v-dialog__content--active {
    opacity: 1 !important;
    backdrop-filter: blur(10px);
  }
  
}



</style>