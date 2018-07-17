
@php

    /** @var App\Model\Branch $branch */
    /** @var App\Model\BranchEvent[] $branchEvents */

    $branchEvents = $branch->getBranchEvents->all();

@endphp

@extends('master.master')


@section('content')


        <span id="page-event" class="page-container">

                <div class="segment1">
                        <div class="container">


                            @foreach($branchEvents as $branchEvent)
                                @php

                                    $firstImage = $branchEvent->getPhotos->first();
                                @endphp

                                <div class="row text-center pt-3 pb-3">
                                    <div class="col-12 ">



                                        <h1 class="title">{{$branchEvent->title}}</h1>
                                        <p class=" text-center">{{$branchEvent->description}}</p>
                                        <div class="galleryContainer blockCenter ">

                                            <div class="pictureContainer popup-gallery d-flex aligni">
                                                <a  class='' href='{{asset($firstImage->path . $firstImage->nameLg)}}'><img  src='{{asset($firstImage->path . $firstImage->nameSm)}}'/></a>

                                                @foreach($branchEvent->getPhotos as $currentPhoto)
                                                    <a  style="display:none;visibility: hidden;" class='' href='{{asset($currentPhoto->path . $currentPhoto->nameLg)}}'><img  src='{{asset($currentPhoto->path . $currentPhoto->nameSm)}}'/></a>

                                                @endforeach

                                            </div>
                                             <div class="galleryHolder">
                                                <img  src="{{publicAsset("image/page/event/icon-gallery.png")}}"/>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                            @endforeach





                        </div>
                </div>

        </span>

@endsection
