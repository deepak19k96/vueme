<template>
    <section class="pageBanner">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="bannerOverContainer row">
                        <div class="leftCol col-lg-6 col-12 text-center text-lg-left">
                            <h1>Psychics1on1™</h1>
                            <p>Welcome to a brand new platform that connects paying clients to the world’s most gifted Psychics, Mediums, Healers and Astrologers.</p>
                            <v-list-item class="col-lg-10 pl-lg-0 top_list_item">
                                <v-list-item-avatar class="m-0"
                                                    size="auto"
                                                    tile
                                >
                                    <img src="images/icons/4252.png" class="mr-3"/>
                                </v-list-item-avatar>
                                <v-card-text class="py-1"><p>Get discovered by a global client base.</p></v-card-text>


                            </v-list-item>
                            <v-list-item class="col-lg-10 pl-lg-0 top_list_item">
                                <v-list-item-avatar class="m-0"
                                                    size="auto"
                                                    tile
                                >
                                    <img src="images/icons/4250.png" class="mr-3"/>
                                </v-list-item-avatar>
                                <v-card-text class="py-1"><p>Connect on your terms and get paid for every session through in-app Chat, Calling and Video Chat.</p></v-card-text>


                            </v-list-item>
                            <v-list-item class="col-lg-10 pl-lg-0 top_list_item">
                                <v-list-item-avatar class="m-0"
                                                    size="auto"
                                                    tile
                                >
                                    <img src="images/icons/1114.png" class="mr-3"/>
                                </v-list-item-avatar>
                                <v-card-text class="py-1"><p>Earn easier, with simple fees and no surprises.</p></v-card-text>


                            </v-list-item>

                            <a @click="openSignUpPopUp()" class="btn btn-primary btn-lg">Apply Now</a>
                        </div>
                        <div class="rightCol col-lg-6 col-12 text-center">
                            <img src="images/Banner-imgs/banner-phone.png" alt="Psychics" style="max-width: 100%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</template>
<script>
    export default {
        props: ['user', 'guest'],
        data: function () {
            return {
                loading: true,
                errors: [],
                signupDialog: false,
            }
        },
        mounted() {
            this.loadUser();
        },
        ready() {
            this.loadUser();
        },

        methods: {
            openSignUpPopUp(){
                EventBus.$emit('open_sign_up',  {});
            },
            loadUser(){

            }
        }
    }
</script>