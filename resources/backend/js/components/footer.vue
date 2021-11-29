<template>
    <div class="footer blue white--text container-fluid mt-0">
      <v-container>
        <v-row>
          <v-col cols="12" md="4" class="pt-2 pb-4">
            <v-divider color="white" style="border: 1px solid; width: 70%"></v-divider>
            <p
              class="white--text pb d-none d-md-inline-block ma-0"
              style="font-weight: 600;"
            >Get Resources</p>
            <p
              class="white--text pb d-md-none ma-0"
              style="font-weight: 600; font-size: 14px"
            >Get Resources</p>
            <div style="margin-top: 23px">
              <p class="mb-0" style="margin-top: 10px">
                <a
                  href="/about"
                  class="white--text"
                  style="font-weight: 600; font-size: 14px;"
                >About</a>
              </p>
              <p class="mb-0" style="margin-top: 10px">
                <a href="/blog" class="white--text" style="font-weight: 600; font-size: 14px">Blog</a>
              </p>
              <p class="mb-0" style="margin-top: 10px" v-if="guest">
                <a
                  href="#"
                  @click.prevent="f_sign_up"
                  class="white--text"
                  style="font-weight: 600; font-size: 14px"
                >Psychic Application</a>
              </p>
              <p class="mb-0" style="margin-top: 10px">
                <a href="/press" class="white--text" style="font-weight: 600; font-size: 14px">Press</a>
              </p>
              <p class="mb-0" style="margin-top: 10px">
                <a
                  class="white--text"
                  href="/privacy-policy"
                  style="font-weight: 600; font-size: 14px"
                >Privacy</a>
              </p>

              <p class="mb-0" style="margin-top: 10px">
                <a
                  class="white--text"
                  href="/dmca-policy"
                  style="font-weight: 600; font-size: 14px"
                >DMCA</a>
              </p>
              <p class="mb-0" style="margin-top: 10px">
                <a
                  class="white--text"
                  href="/payment-terms"
                  style="font-weight: 600; font-size: 14px"
                >Payment Terms</a>
              </p>
              <p class="mb-0" style="margin-top: 10px">
                <a
                  class="white--text"
                  href="/terms"
                  style="font-weight: 600; font-size: 14px"
                >Terms of Service</a>
              </p>
                 <!-- <p class="mb-0" style="margin-top: 10px">
                <a
                  class="white--text"
                  href="#"
                  style="font-weight: 600; font-size: 14px"
                >Annual Report</a>
              </p> -->
            </div>
          </v-col>
          <v-col cols="12" md="4" class="pt-2 pb-4">
            <v-divider color="white" style="border: 1px solid; width: 70%"></v-divider>
            <p
              class="white--text pb d-none d-md-inline-block ma-0"
              style="font-weight: 600;"
            >Get Social</p>
            <p
              class="white--text pb d-md-none ma-0"
              style="font-weight: 600; font-size: 14px"
            >Get Social</p>

            <div style="margin-top: 23px">
              <a href="https://www.instagram.com/psychics1on1/">
                <!-- <v-icon class="mr-3" color="white">mdi-instagram</v-icon> -->
                <img src="/images/icons/instagram-square-brands-footer.svg" />
              </a>

              <a href="https://www.facebook.com/Psychics1on1/" class="mx-3">
                <!-- <v-icon class="mr-3" color="white">mdi-facebook-box</v-icon> -->
                <img src="/images/icons/facebook-square-brands-footer.svg" />
              </a>

              <a href="https://twitter.com/psychics1on1/" class="mr-3">
                <!-- <v-icon color="white">mdi-twitter</v-icon> -->
                <img src="/images/icons/twitter-square-brands-footer.svg" />
              </a>

              <a href="https://www.linkedin.com/company/psychics1on1/about/">
                <!-- <v-icon class="mr-3" color="white">mdi-linkedin-box</v-icon> -->
                <img src="/images/icons/linkedin-brands-footer.svg" />
              </a>
            </div>
          </v-col>
          <v-col cols="12" md="4" class="pt-2 pb-4">
            <v-divider color="white" style="border: 1px solid; width: 70%"></v-divider>
            <p
              class="white--text pb d-none d-md-inline-block ma-0"
              style="font-weight: 600;"
            >Get Help</p>
            <p
              class="white--text pb d-md-none ma-0"
              style="font-weight: 600; font-size: 14px"
            >Get Help</p>

            <div style="margin-top: 23px">
              <a href="https://psychics1on1.zendesk.com/hc/en-us" class="mr-3">
                <!-- <v-icon class="mr-3" color="white">mdi-help</v-icon> -->
                <img src="/images/icons/interrogation-footer.svg" />
              </a>

              <a href=" https://psychics1on1.zendesk.com/hc/en-us/requests/new">
                <!-- <v-icon color="white">mdi-email</v-icon> -->
                <img src="/images/icons/mail-footer.svg" />
              </a>
            </div>
          </v-col>
        </v-row>

        <!-- <v-row class="text-center white--text d-block h6">
                © Copyright {{ year }} Psychics1on1, LLC
                </v-row>
                <v-row class="text-center white--text d-block h6 small">
                    This site is protected by reCAPTCHA and the Google
                    <a href="https://policies.google.com/privacy" class="white--text">Privacy Policy</a> and
                    <a href="https://policies.google.com/terms" class="white--text">Terms of Service</a> apply.
        </v-row>-->
      </v-container>
    </div>
</template>

<script>
export default {
  data: () => ({
    signupDialog: false,
    year: 2020,
  }),
  props: ["guest", "home"],
  methods: {
    f_open_login() {
      EventBus.$emit("open_login", {});
    },
    f_sign_up() {
      EventBus.$emit("open_sign_up", {});
    },
    f_sign_up_user() {
      EventBus.$emit("open_sign_up_user", {});
    },
  },
  mounted() {
    var now_date = new Date();

    this.year = now_date.getFullYear();
  },
};
</script>


