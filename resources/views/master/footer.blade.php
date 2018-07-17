



<div id="footer">


    @if(!request()->is('home'))
        <div class="segment1">
            {{--halo--}}
        </div>
    @endif


    <div class="segment2">
        <div class="container">
            <div class="row">
                <div class="  text-center col-md-4">
                    <img class="imgFluidWidthHeight" style="height: 125px;" src="{{publicAsset("image/global/logo-white.png")}}" />
                </div>

                <div class=" text-center col-md-4">
                    @if(!$branch->isMaster())

                        <a class="" href="{{route('get.home',["branch"=>$branch->id])}}"><h3>{{$branch->name}}</h3></a>

                    @else
                        <a class=""  href="{{route('get.home')}}">Home</a>

                    @endif
                    <a href="{{route('get.visiMisi')}}">Visi Misi</a>
                </div>
                <div class=" text-center col-md-4">
                    <a href="{{route('get.yearPlanning',["branch"=>$branch->id])}}">Year Planning</a>
                    <a href="{{route('get.event',["branch"=>$branch->id])}}">Event SM</a>
                    <a href="{{route('get.contact',["branch"=>$branch->id])}}">Contact</a>

                </div>

            </div>
        </div>
    </div>

    <div class="segment3">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">

                    &copy; BUKIT ZAITUN {{getDefaultDatetime(null,"Y")}}
                </div>
             

            </div>
    </div>

</div>



{{--@yield('js')--}}