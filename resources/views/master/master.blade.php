<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>{{$title ?? "Sekolah Minggu Bukit Zaitun"}}</title>
    <link rel="icon" type="image/png" href="{{publicAsset('image/global/logo-dark.png')}}">
    <meta name="description" content="{{$description ?? "Salsa Beauty Centre sekolah kecantikan, service kecantikan, salon, perawatan di Surabaya"}}">
    <link rel="alternate" hreflang="id" href="https://salsabeautycentre.com/" />

    <meta name="google-site-verification" content="IytWGWwk0avyfl1j0KONSlS6DTiYAeLDBwAtVOTl3F4" />

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    @php($version = time())
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css" >
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">--}}
    <link rel="stylesheet" href="{{publicAsset("plugin/magnific/magnific-popup.css")}}" >
    <link rel="stylesheet" href="{{publicAsset("css/main.css")}}" >



    <!-- Global site tag (gtag.js) - Google Analytics -->
    {{--<script async src="https://www.googletagmanager.com/gtag/js?id=UA-91360635-3"></script>--}}
    {{--<script>--}}
        {{--window.dataLayer = window.dataLayer || [];--}}
        {{--function gtag(){dataLayer.push(arguments);}--}}
        {{--gtag('js', new Date());--}}

        {{--gtag('config', 'UA-91360635-3');--}}
    {{--</script>--}}

    <!-- Global site tag (gtag.js) - Google Analytics -->
    {{--<script async src="https://www.googletagmanager.com/gtag/js?id=UA-97639484-1"></script>--}}
    {{--<script>--}}
        {{--window.dataLayer = window.dataLayer || [];--}}
        {{--function gtag(){dataLayer.push(arguments);}--}}
        {{--gtag('js', new Date());--}}

        {{--gtag('config', 'UA-97639484-1');--}}
    {{--</script>--}}
</head>
<body >

<div style="display:none; height: 100%;" id="wrapperAfterLoad">
    <!--[if lt IE 7]>
    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a
            href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->


    @include('master.navbar')

    @if(!IS_LIVE)
        <div style="position: fixed; overflow:visible;left:0; top: 0; z-index: 99999;">
            <p class="d-block d-sm-none ">xs 0-575</p>
            <p class="d-none d-sm-block d-md-none">sm 576-767</p>
            <p class="d-none d-md-block d-lg-none">md 768-991</p>
            <p class="d-none d-lg-block d-xl-none">lg 992-1999</p>
            <p class="d-none d-xl-block">xl 1200--z</p>
        </div>
    @endif
    @yield('content')





    @include('master.footer')

</div>


{{----}}

<div id='wrapperBeforeLoad' class="d-flex h-100 align-items-center justify-content-center">
    <h3 class="textColor1">GBZ<span class="loadingDot"> ....</span></h3>
</div>



<script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/TweenMax.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/plugins/TextPlugin.min.js"></script>

<script src="{{publicAsset("plugin/magnific/jquery.magnific-popup.min.js")}}"></script>


@yield('pageAnimationConfig')

<script src="{{publicAsset("js/main.js")}}?v={{$version}}"></script>

@yield('javascript')


</body>
</html>


{{--view--}}
{{--image/page--}}