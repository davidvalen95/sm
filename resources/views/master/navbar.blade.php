
{{--<navbar>--}}
{{--<div class="container-fluid clearfix align-items-center d-flex">--}}
{{--<span class="logo ">--}}
{{--Salsa--}}
{{--</span>--}}
{{--<div style='margin-left:auto;' class=" menu">--}}
{{--<a>HOME</a>--}}
{{--<a>ABOUT US</a>--}}
{{--<a>OUR SERVICES</a>--}}
{{--<a>BEAUTY</a>--}}
{{--<a>YOGA CLASS</a>--}}
{{--</div>--}}
{{--<div class=""></div>--}}
{{--</div>--}}
{{--</navbar>--}}



<nav style="z-index: 9999;" class="navbar navbar-expand-md position-absolute">
    <a class="navbar-brand" id="logo" href="{{route('get.home')}}"><img class="logo" src="{{publicAsset("image/global/logo-yellow.png")}}"/></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse " id="navbarSupportedContent">
        <ul class="navbar-nav ml-md-5">

            @if(!$branch->isMaster())

                <li class="nav-item float-right">
                    <a class="nav-link textColor1" style="color: #F18022 !important"  href="{{route('get.home',["branch"=>$branch->id])}}">{{$branch->name}}</a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link " href="{{route('get.home')}}">HOME</a>
                </li>
            @endif

            <li class="nav-item">
                <a class="nav-link " href="{{route('get.visiMisi')}}">VISI MISI</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{route('get.yearPlanning',["branch"=>$branch->id])}}">YEAR PLANNING</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{route('get.event',["branch"=>$branch->id])}}">EVENT</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{route('get.contact',["branch"=>$branch->id])}}">CONTACT US</a>
            </li>



            {{--<li class="nav-item dropdown" class="navbarOurService">--}}
                {{--<a class="nav-link dropdown-toggle navbarOurService" href="#" id="navbarOurService" role="button" data-toggle="dropdown"--}}
                   {{--aria-haspopup="true" aria-expanded="false">--}}
                    {{--OUR SERVICE--}}
                {{--</a>--}}
                {{--<div class="dropdown-menu" aria-labelledby="navbarOurService">--}}
                    {{--<a class="dropdown-item" href="">Salon</a>--}}

                    {{--<div class="dropdown-divider"></div>--}}
                    {{--<a class="dropdown-item" href="#">Something else here</a>--}}
                {{--</div>--}}
            {{--</li>--}}
            {{--<li class="nav-item dropdown">--}}
                {{--<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"--}}
                   {{--aria-haspopup="true" aria-expanded="false">--}}
                    {{--BEAUTY SCHOOL--}}
                {{--</a>--}}
                {{--<div class="dropdown-menu" aria-labelledby="navbarDropdown">--}}
                    {{--<a class="dropdown-item" href="{{route('get.classSummary')}}">Our Classes</a>--}}
                    {{--<a class="dropdown-item" href="{{route('get.embroideryClass')}}">Embroidery Class</a>--}}
                    {{--<a class="dropdown-item" href="{{route('get.makeUpSchool')}}">Makeup Class</a>--}}
                    {{--<a class="dropdown-item" href="{{route('get.hairCutSchool')}}">Hair-Cut-Style Class</a>--}}
                    {{--<a class="dropdown-item" href="{{route('get.beauticianSchool')}}">Beautician Class</a>--}}


                {{--</div>--}}
            {{--</li>--}}
            {{----}}
            {{--<li class="nav-item active">--}}
                {{--<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>--}}
            {{--</li>--}}
            {{--<li class="nav-item">--}}
                {{--<a class="nav-link" href="#">Link</a>--}}
            {{--</li>--}}
            {{--<li class="nav-item dropdown">--}}
                {{--<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"--}}
                   {{--aria-haspopup="true" aria-expanded="false">--}}
                    {{--Dropdown--}}
                {{--</a>--}}
                {{--<div class="dropdown-menu" aria-labelledby="navbarDropdown">--}}
                    {{--<a class="dropdown-item" href="#">Action</a>--}}
                    {{--<a class="dropdown-item" href="#">Another action</a>--}}
                    {{--<div class="dropdown-divider"></div>--}}
                    {{--<a class="dropdown-item" href="#">Something else here</a>--}}
                {{--</div>--}}
            {{--</li>--}}
            {{--<li class="nav-item">--}}
                {{--<a class="nav-link disabled" href="#">Disabled</a>--}}
            {{--</li>--}}
        </ul>
    </div>
</nav>


@if ($errors->any() || Session::has('dangerNotification'))

<div class="alert alert-danger text-center" style="padding-top: 100px; margin-bottom: 0;">
    <ul>
        @if ($errors->any())

            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        @endif
        {{--{{json_encode(Session::get("dangerNotification"))}}--}}

        @if(Session::has('dangerNotification'))
            <li>{{Session::get('dangerNotification')}}</li>
        @endif
    </ul>

</div>

@endif

@if(Session::has('successNotification'))
<div class="alert alert-success text-center " style="padding-top: 100px; margin-bottom: 0;">
    <ul>
        {{--{{json_encode(Session::get("dangerNotification"))}}--}}
            <li>{{Session::get('successNotification')}}</li>
    </ul>
</div>
@endif