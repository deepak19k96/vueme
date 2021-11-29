<!DOCTYPE html>
<html style="overflow-y: hidden;" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-70981211-8"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-70981211-8');
</script>

  <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WBT336Q');</script>
<!-- End Google Tag Manager -->

<!-- Start Alexa Certify Javascript -->
<script type="text/javascript">
    _atrk_opts = { atrk_acct:"htC2t1Fx9f207i", domain:"psychics1on1.com",dynamic: true};
    (function() { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://certify-js.alexametrics.com/atrk.js"; var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(as, s); })();
    </script>
    <noscript><img src="https://certify.alexametrics.com/atrk.gif?account=htC2t1Fx9f207i" style="display:none" height="1" width="1" alt="" /></noscript>
    <!-- End Alexa Certify Javascript -->  


    <meta charset="utf-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="theme-color" content="#A163C1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" type="image/png" href="/images/site-images/favicon.png">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ env('APP_URL') }}/images/pwa/logo152.png" />

    <!-- Scripts -->
    <script  src="https://static.opentok.com/v2/js/opentok.min.js"></script>
    <script  src="{{ mix('backend/js/app.js') }}?id=040920211000" defer></script>

    <!-- Web Manifest -->
    <link rel="manifest" href="{{ env('APP_URL') }}/manifest.json">
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{ asset('backend/css/app.css') }}?id=040920211000">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}?id=040920211000">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--Start Service Worker Script-->
    <script type="text/javascript">
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register("{{ asset('/service-worker.js') }}").then(function(registration) {
                    // Registration was successful
                    console.log('ServiceWorker registration successful with scope: ', registration.scope);
                }, function(err) {
                    // registration failed
                    console.log('ServiceWorker registration failed: ', err);
                });
            });
        }
    </script>
    <!--End of Service Worker Script-->
    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window,document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '370350300874337'); 
        fbq('track', 'PageView');
        </script>
        <noscript>
        <img height="1" width="1" 
        src="https://www.facebook.com/tr?id=370350300874337&ev=PageView
        &noscript=1"/>
        </noscript>
        <!-- End Facebook Pixel Code -->
</head>

<body class="body-dashboard">
    <noscript>You need to enable JavaScript to run this app.</noscript>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MJX4LDW" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div id="app">
        <v-app light class="app_dashboard" v-resize="onResize">
            <div class="container--fluid p-0 container_chat">
                <s-header :user="{{json_encode(Auth::user())}}"></s-header>
                <c-message></c-message>
                <header-space></header-space> 
                <!-- Collapsible content -->
                <!-- <nav class="navbar navbar_chat" id="mobile-nav-2">
                    <mobile-navbar :user="{{json_encode(Auth::user())}}"></mobile-navbar>
                </nav> -->
                <!-- Collapsible content -->

                <div class='linear-layout-wrapper'>
                    <div id="dashboard-layout" class="container p-0" style="margin: 0px !important; max-width: 100%;">
                        <div id="sidebar">

                            <div id="sidebar-scroll-away" class="pb-5">
                                <dashboard-sidebar-menu :link="{{json_encode($link)}}" :user="{{json_encode(Auth::user())}}"></dashboard-sidebar-menu>
                            </div>
                        </div>

                        <div class="d-inline-block mw-100 w-100">
                            @if(Auth::user()->role_id ==1)
                            <div class="d-block  p-0">
                                <div>
                                    <slider-banner :route="{{json_encode(Route::currentRouteName())}}" />
                                </div>


                            </div>


                            @endif
                            <div>
                                <div class="d-flex container p-0">
                                    <div id="main" class="" style="min-height: auto !important;">

                                        @yield('content')

                                    </div>
                                    @if($link!=4)
                                    <!-- <div id="feed-sidebar" class="py-3">
                            <div class="col-gray-area col-12">
                                <div class="subtitle-1 mb-3">Recent Activity</div>

                                        <div id="activity">
                                            <div class="message"><strong>Supporter + 8 others</strong> subscribed to your SILVER tier</div>
                                            <div class="message"><strong>Supporter + 8 others</strong> subscribed to your SILVER tier</div>
                                            <div class="message"><strong>Supporter + 8 others</strong> subscribed to your SILVER tier</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                                    @else

                                    @endif

                                </div>

                            </div>

                        </div>
                    </div>

        </v-app>
    </div>

</body>

</html>