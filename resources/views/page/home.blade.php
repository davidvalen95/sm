
@php

/** @var App\Model\Branch $branch */

@endphp


@extends('master.master')



@section('content')



    <span id="page-home" class="page-container">

        <div class="segment1">


            <div class="container-fluid h-100">
                <div class="row h-100">
                    <div class="col-12 d-flex align-items-center ">
                        <div>

                            @if(!$branch->isMaster())
                                <h1  style="color:white">{{$branch->name}}</h1>
                                <a class="nav-link " href="{{route('get.yearPlanning',["branch"=>$branch->id])}}"><h3>YEAR PLANNING</h3></a>

                                <a class="nav-link " href="{{route('get.event',["branch"=>$branch->id])}}"><h3>EVENT</h3></a>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            {{--segment1--}}
        </div>

        <div class="segment2">

            <div class="container  ">
                <div class="row">
                    <div class="col-md-5">
                        <div class="flag">
                                                    <img class="imgFluidWidthHeight"
                                                         src="{{publicAsset("image/page/home/segment2-model.png")}}"/>

                        </div>
                    </div>
                    <div class="col-md-7 d-flex justify-content-center align-items-center">
                        <div>
                            <p class="text-justify verse">
                                Tetapi Yesus berkata:
                                "Biarkanlah anak-anak itu, janganlah menghalang-halangi mereka datang kepada-Ku;
                                sebab orang-orang yang seperti itulah yang empunya kerajaan sorga
                            </p>
                        </div>

                    </div>
                </div>
            </div>
            {{--segment2--}}



            {{--segment2--}}
        </div>


        <div class="segment3">
              <div class="shapeTop">
                <img src="{{publicAsset("image/page/home/segment3-shape-top.png")}}"/>
                </div>

            <div class="container  ">
                <div class="row mb-5">
                    <div class="col-12 text-center">
                        <h1>SM CABANG</h1>

                    </div>




                </div>
                <div class="row">

                    @php

                        $branches = \App\Model\Branch::allNotMaster()->toArray();
                        $chunks = getPartition($branches, 3);

                    @endphp
                    @foreach($chunks as $chunk)

                        <div class="col-4  text-center">


                        @foreach($chunk as $currentBranch)
                                <a style="display:block;" href="{{ route('get.home',["branch"=>$currentBranch['id']]) }}">{{$currentBranch['name']}}</a>
                            @endforeach

                    </div>
                    @endforeach




                </div>
            </div>

            {{--segmetm3--}}
        </div>



        <div class="segment4">



            <div class="container">
                    <div class="row">

                        <div class="col-md-6 d-flex justify-content-center align-items-center">

                            <div>
                                <img class="imgFluidWidthHeight"
                                     src="{{publicAsset("image/page/home/segment4-model.png")}}">
                            </div>


                        </div>

                        <div class="col-md-6 contactUsForm">

                            <h2 class="text-center textColor2">Contact Us</h2>
                            <p class="text-center textColor2">Let us know what we can serve you</p>

                            <form>

                                @component('component.formInput',['baseForms'=>$contactUsForms])

                                @endcomponent

                                <button type="submit" class="btn btn-primary mb-2 submit">Submit</button>
                            </form>

                        </div>



                    </div>
            </div>






            <div class="shapeBottom">
                <img src="{{publicAsset("image/page/home/segment4-shape-bottom.png")}}"/>
            </div>
            {{--segmetm4--}}
        </div>



        <div class="segment5">



            <iframe
                    src="https://maps.google.com/maps?q=-7.260936,112.741560&hl=es;z=14&amp;output=embed"
                    frameborder="0"
                    style="border:0"
                    class="map"
                    allowfullscreen>

            </iframe>



            {{--segmetm4--}}
        </div>


    </span>

@endsection