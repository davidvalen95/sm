@php

    /** @var App\Model\Branch $branch */
    /** @var App\Model\Planning[] $plannings */

    $plannings = $branch->getPlannings->all();

@endphp

@extends('master.master')


@section('content')


    <span id="page-yearPlanning" class="page-container">

                <div class="segment1">
                        <div class="container">
                                <div class="row d-flex justify-content-center">
                                        @foreach($plannings as $planning)

                                        <div class="col-4 text-center p-5" data-toggle="modal" data-target="#exampleModal{{$planning->id}}">
                                                <div class="calendar">
                                                        <div class="month">{{getDefaultDatetime($planning->dueDate,"M Y")}}</div>
                                                        <div class="date">{{getDefaultDatetime($planning->dueDate,"d")}}</div>
                                                </div>

                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" style="margin-top: 90px;" id="exampleModal{{$planning->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title d-block">{{$planning->title}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                  <p class="d-block">{{getDefaultDatetime($planning->dueDate,"D M Y")}}</p>

                                                <p>{{$planning->description}}</p>
                                              </div>
                                              <div class="modal-footer">

                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                    @endforeach

                                </div>

                        </div>
                </div>

        </span>

@endsection
