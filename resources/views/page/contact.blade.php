


@extends('master.master')


@section('content')


        <div id="page-contact" class="page-container">

                <div class="segment1">
                        <div class="container">
                                <div class="row text-center pt-3 pb-3">
                                    <div class="col-12 ">
                                        <div class="galleryContainer blockCenter">
                                             <div class="galleryHolder">
                                                <img  src="{{publicAsset("image/page/event/icon-gallery.png")}}"/>
                                            </div>
                                            <div class="mapContainer">
                                                   <iframe
                                                           src="https://maps.google.com/maps?q=-7.260936,112.741560&hl=es;z=14&amp;output=embed"
                                                           frameborder="0"
                                                           style="border:0"
                                                           class="map"
                                                           allowfullscreen>

                                                    </iframe>


                                            </div>
                                        </div>
                                    </div>
                                </div>




                        </div>
                </div>


            <div class="segment2">
                <div class="container">
                    <div class="row">
                        <div class="col-4 text-center address">
                            <img class="icon" src="{{publicAsset("image/page/contact/icon-marker.png")}}" />
                            <p class="title">Alamat {{$branch->name}}</p>
                            <p class="content">
                                {{$branch->address}}
                            </p>
                        </div>

                        <div class="col-4 text-center address">
                            <img class="icon" src="{{publicAsset("image/page/contact/icon-phone.png")}}" />
                            <p class="title">No Telephone</p>
                            <p class="content">
                                031-5312222
                            </p>
                        </div>

                        <div class="col-4 text-center address">
                            <img class="icon" src="{{publicAsset("image/page/contact/icon-message.png")}}" />
                            <p class="title">Email</p>
                            <p class="content">
                                info@gerejabukitzaitun.org
                            </p>
                        </div>

                    </div>
                </div>
            {{--segment--}}
            </div>

            <div class="segment3">
                <div class="container">
                    <div class="row">
                        <div class="col-12">

                            <form class="contactUsForm">


                                @component('component.formInput',["baseForms"=>$contactUsForms])

                                @endcomponent

                                    <button type="submit" class="btn btn-primary mb-2 submit">Submit</button>


                            </form>

                        </div>

                    </div>
                </div>
            {{--segment--}}
            </div>





        </div>

@endsection
