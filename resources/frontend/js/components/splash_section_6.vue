<template>
    <section class="fourColSection">
        <div class="container text-center">
            <div class="row">
                <div class="col">
                    <h3 class="m-5">EARNINGS & FEES</h3>
                    <div class="fourthSecItemContainer">

                        <div class="fItemContainer">

                            <div class="py-5">
                                <img src="images/icons/971.png" alt="Sign up" class="img-fluid">
                            </div>
                            <p>You keep 80% of what you make. International Psychics incur a 2% surcharge. (Yes – it’s that easy).</p>
                        </div>
                        <div class="fItemContainer">

                            <div class="py-5">
                                <img src="images/icons/974.png" alt="Browse" class="img-fluid">
                            </div>
                            <p>Know exactly when you’re getting paid with consistent, weekly payments.</p>
                        </div>
                        <div class="fItemContainer">

                            <div class="py-5">
                                <img src="images/icons/975.png" alt="Discover" class="img-fluid">
                            </div>
                            <p>Our fees are clear and all inclusive – that means no surprises later on. Plus, we’ve got your back with fraud and default protection.</p>
                        </div>


                    </div>
                </div>
            </div>
            <div class="row"><div class="col-12 text-center"><a @click="openSignUpPopUp()" class="btn btn-primary btn-lg my-5">Apply Now</a></div> </div>
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