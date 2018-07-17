

@php

/** @var BaseForm[] $baseForms */
@endphp


@if($baseForms)


    <div class="row">

        @foreach($baseForms as $baseForm)
            <div class="{{$baseForm->containerClass}} form-group">
                <label for="idInput_{{$baseForm->name}}">{{ucwords($baseForm->label)}}</label>
                @if($baseForm->type == "text")
                    <input
                            id="idInput_{{$baseForm->name}}"
                            value="{{$baseForm->value}}"
                            type="{{$baseForm->type}}"
                            class="form-control {{$baseForm->inputClass}}"
                            placeholder="{{$baseForm->placeholder}}"
                    />

                @endif

                @if($baseForm->type == "textarea")
                    <textarea
                            id="idInput_{{$baseForm->name}}"

                            type="{{$baseForm->type}}"
                            class="form-control {{$baseForm->inputClass}}"
                            rows="5"
                            placeholder="{{$baseForm->placeholder}}"

                    >{{$baseForm->value}}</textarea>

                @endif



                <small id="idHelp_{{$baseForm->name}}" class="form-text text-muted">{{$baseForm->bottomDescription}}</small>
            </div>


        @endforeach

    </div>





@endif