@extends('layouts.app_splash')

@section('content')
<splash-top></splash-top>
<section class="thirdSectionHeading">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="thirdSectionHeadingContainer">
                    <h2>At home, on your mobile or anywhere in the world – Psychics1on1™ works wherever you do. Use your spiritual gift to generate game-changing income.</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="fourColSection">
    <div class="container text-center">
        <div class="row">
            <div class="col">
                <h3 class="m-5">HOW IT WORKS</h3>
                <div class="fourColContainer">

                    <div class="fourColItem">
                        <p><b>Step 1</b></p>
                        <div class="iconContainer">
                            <img src="{{ env('APP_URL') }}/images/icons/4258.png" alt="Sign up" class="img-fluid">
                        </div>
                        <p>Apply Now</p>
                    </div>
                    <div class="fourColItem">
                        <p><b>Step 2</b></p>
                        <div class="iconContainer">
                            <img src="{{ env('APP_URL') }}/images/icons/4261.png" alt="Browse" class="img-fluid">
                        </div>
                        <p>Build your profile</p>
                    </div>
                    <div class="fourColItem">
                        <p><b>Step 3</b></p>
                        <div class="iconContainer">
                            <img src="{{ env('APP_URL') }}/images/icons/4268.png" alt="Discover" class="img-fluid">
                        </div>
                        <p>Provide spiritual services safely and securely via in-app Chat, Calling and Video Chat</p>
                    </div>
                    <div class="fourColItem">
                        <p><b>Step 4</b></p>
                        <div class="iconContainer">
                            <img src="{{ env('APP_URL') }}/images/icons/4282.png" alt="Advice" class="img-fluid">
                        </div>
                        <p>Get Paid</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="thirdSection">
    <div class="container-fluid why_join p-0">
        <div class="container  pt-5 pb-5">
            <div class="row mt-lg-5 py-lg-5">
                <div class="col-12 mb-5 mt-5 text-center">
                    <h3 class="">WHY JOIN</h3>

                </div>

                <div class="col-12 mb-5 mt-5">
                    <v-card>
                        <v-list-item>
                            <div class="p-3 m-0 head text-center"
                                 size="auto"
                                 tile
                                 two-line
                            >
                                <v-list-item-title
                                        class="headline mb-2"

                                ><img src="{{ env('APP_URL') }}/images/icons/1092.png"/></v-list-item-title>

                                <v-list-item-title v-if="$vuetify.breakpoint.mdAndUp"> <p>Monetize<br>Interactions</p></v-list-item-title>


                            </div>
                            <v-card-text class="pl-lg-5 p-3">Clients pay to interact via in-app Chat, Calling and Video Chat.</v-card-text>


                        </v-list-item>

                    </v-card>
                </div>
                <div class="col-12 mb-5 mt-5">
                    <v-card>
                        <v-list-item>
                            <div class="p-3 m-0 head text-center"
                                 size="auto"
                                 tile
                                 two-line
                            >
                                <v-list-item-title
                                        class="headline mb-2"

                                ><img src="{{ env('APP_URL') }}/images/icons/931.png"/></v-list-item-title>

                                <v-list-item-title v-if="$vuetify.breakpoint.mdAndUp"> <p>Clientbase<br>Growth</p></v-list-item-title>


                            </div>
                            <v-card-text class="pl-lg-5 p-3">Get discovered organically with category search and filter functions.</v-card-text>


                        </v-list-item>

                    </v-card>
                </div>
                <div class="col-12 mb-5 mt-5">
                    <v-card>
                        <v-list-item>
                            <div class="p-3 m-0 head text-center"
                                 size="auto"
                                 tile
                                 two-line
                            >
                                <v-list-item-title
                                        class="headline mb-2"

                                ><img src="{{ env('APP_URL') }}/images/icons/settings.png"/></v-list-item-title>

                                <v-list-item-title v-if="$vuetify.breakpoint.mdAndUp"> <p>Completely<br>Customizable</p></v-list-item-title>


                            </div>
                            <v-card-text class="pl-lg-5 p-3">Set your pricing and availability, then adjust at any time.</v-card-text>


                        </v-list-item>

                    </v-card>
                </div>
                <div class="col-12 mb-5 mt-5">
                    <v-card>
                        <v-list-item>
                            <div class="p-3 m-0 head text-center"
                                 size="auto"
                                 tile
                                 two-line
                            >
                                <v-list-item-title
                                        class="headline mb-2"

                                ><img src="{{ env('APP_URL') }}/images/icons/hand-shake.png"/></v-list-item-title>

                                <v-list-item-title v-if="$vuetify.breakpoint.mdAndUp"> <p>Business<br>Mobilized</p></v-list-item-title>


                            </div>
                            <v-card-text class="pl-lg-5 p-3">Amplify your influence by mobilizing your business.</v-card-text>


                        </v-list-item>

                    </v-card>
                </div>
                <div class="col-12 mb-5 mt-5">
                    <v-card>
                        <v-list-item>
                            <div class="p-3 m-0 head text-center"
                                 size="auto"
                                 tile
                                 two-line
                            >
                                <v-list-item-title
                                        class="headline mb-2"

                                ><img src="{{ env('APP_URL') }}/images/icons/4230.png"/></v-list-item-title>

                                <v-list-item-title v-if="$vuetify.breakpoint.mdAndUp"> <p>Marketing<br>Managed</p></v-list-item-title>


                            </div>
                            <v-card-text class="pl-lg-5 p-3">We handle the advertising to drive potential new clients to your page.</v-card-text>


                        </v-list-item>

                    </v-card>
                </div>
                <div class="col-12 mb-5 mt-5">
                    <v-card>
                        <v-list-item>
                            <div class="p-3 m-0 head text-center"
                                 size="auto"
                                 tile
                                 two-line
                            >
                                <v-list-item-title
                                        class="headline mb-2"

                                ><img src="{{ env('APP_URL') }}/images/icons/954.png"/></v-list-item-title>

                                <v-list-item-title v-if="$vuetify.breakpoint.mdAndUp"> <p>Logistics<br>Handled</p></v-list-item-title>


                            </div>
                            <v-card-text class="pl-lg-5 p-3">We manage payment processing, customer support and website maintenance.</v-card-text>


                        </v-list-item>

                    </v-card>
                </div>
            </div>
        </div>
    </div>
</section>




<div class="container-fluid the_platform text-center">
    <div class="container  pt-5">
        <div class="row mt-5 pt-5">
            <div class="col-12 mb-5 mt-5">
                <h3 class="">THE PLATFORM</h3>
                <p>Simple and Easy-To-Use</p>
                <p><img src="{{ env('APP_URL') }}/images/icons/4283.png" class="img-fluid" /></p>
            </div>


        </div>
    </div>
</div>

<splash-section-6></splash-section-6>


@endsection
