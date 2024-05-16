@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Drop Downs') }}</div>

                <div class="card-body">
                    <form id="drop-down-form" method="POST" action="javascript:void(0);" onsubmit="PrintData()">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Drop Downs') }}</label>

                            <div class="col-md-6">
                                <select id="name" onchange="getOptions($(this));" class="form-control @error('name') is-invalid @enderror" id="options" name="name">
                                    <option value="">Select</option>
                                    @foreach($drop_downs as $drop_down)
                                        <option value="{{$drop_down->id ?? '0'}}">{{$drop_down->name ?? ''}}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback name-error" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="options" class="col-md-4 col-form-label text-md-end">{{ __('Options') }}</label>

                            <div class="col-md-6">
                                <select class="form-control @error('options') is-invalid @enderror" id="options" multiple name="options[]">
                                  <option value="">Select</option>
                                    @foreach($options as $option)
                                        <option value="{{$option->id ?? '0'}}">{{$option->option ?? ''}}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback option-error" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>

                            </div>
                        </div>
                    </form>
                </div>

                <hr>
                <table class="table d-none">
                    <thead>
                    <th>Drop Down</th>
                    <th>Options</th>
                    </thead>
                    <tbody>
                    <tr>
                        <td id="option-name"></td>
                        <td id="drop-down-options"></td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
       function getOptions($that) {
           $.ajax({
               type: 'get',
               dataType: 'json',
               url: "{{route('options.get')}}",
               data: {drop_down: $that.val()},
               success: function (response) {
                   let options = response.options;
                   let dropDownOptions = '';
                   Object.values(options).forEach( function (option) {
                       dropDownOptions += `<option value="${option.id}">${option.option}</option>`;
                   });
                   $("#options").html(dropDownOptions);
               }, error: function (error) {
                   alert("Something went wrong")
               }
           });
       }

       function PrintData() {
           $.ajax({
               headers: {
                   'X-CSRF-Token': "{{csrf_token()}}"
               },
               type: 'post',
               dataType: 'json',
               url: "{{route('dropdown_store')}}",
               data: $("#drop-down-form").serialize(),
               success: function (response) {
                   $(".name-error, .option-error").hide();
                   $("#option-name").text(response.dropDown)
                   let dropDownOptionsName = '';
                   Object.values(response.dropDownOptions).forEach( function (option) {
                       dropDownOptionsName += `${option.option},`;
                   });
                   dropDownOptionsName = dropDownOptionsName.replace(/,\s*$/, "");
                   $("#drop-down-options").text(dropDownOptionsName);
                   $(".table").removeClass("d-none")
               }, error: function (error) {
                   if (typeof error.responseJSON.message !== "undefined") {
                       $(".name-error").text(error.responseJSON.errors.name).show();
                       $(".option-error").text(error.responseJSON.errors.options).show();
                       alert(error.responseJSON.message)
                   } else {
                       alert("Something went wrong")
                   }
               }
           });
       }
    </script>
@endsection
