@extends('master')

@section('title', 'table of data')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/TableData/style.css')}}">
    <link rel="stylesheet" type="text/css" href="DataTables/css/datatables.min.css"/>
@endsection

@section('content')
    @if(count($errors) > 0 || Session::has('erreur'))
        <div id="er_message" class="alert alert-danger alert-dismissible fade show top" role="alert">
            @if(Session::has('titleErreur'))
                <strong>{{ session('titleErreur') }}</strong><br/>
            @else
                <strong>Selection error</strong><br>
            @endif

            {{ Session::get('erreur')  }}
            <br>
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form style = "margin-top:150px" class="row g-3 needs-validation"  action="{{ route('divisionController.show') }}" method="POST" novalidate>
        @csrf
                    <div class="col-md ">
                        <div class="form-floating">
                            <select class="form-select input-lg dynamic" name="division" id="Division" data-dependent="Level" required>
                                <option  value="" selected>Select Division</option>
                                @foreach($divisions as $division)
                                    <option value="{{$division->name}}">{{$division->name}}</option>
                                @endforeach
                            </select>
                            <label for="Division">Divisions</label>
                            <div class="valid-feedback">
                                Good Choice!
                            </div>
                            <div class="invalid-feedback">
                                Please select a valid division.
                            </div>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating">
                            <select class="form-select input-lg dynamic" name="level" id="Level" data-dependent="Group" required>
                                <option value="" selected >Select Level</option>
                            </select>
                            <label for="Level">Levels</label>
                            <div class="valid-feedback">
                                Good Choice!
                            </div>
                            <div class="invalid-feedback">
                                Please select a valid level.
                            </div>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating">
                            <select class="form-select input-lg" name="group" id="Group" required>
                                <option value="" selected >Select Group</option>
                            </select>
                            <label for="Group">Groups</label>
                            <div class="valid-feedback">
                                Good Choice!
                            </div>
                            <div class="invalid-feedback">
                                Please select a valid group.
                            </div>
                        </div>
                    </div>

        <div class="d-flex justify-content-end">
            <button type="submit" type="button" class="btn btn-primary d-flex justify-content-end" style="margin-top:250px">Validate</button>
        </div>

    </form>


@endsection
@push('scripts')
<script>

    $(document).ready(function(){

     $('.dynamic').change(function(){
     /* if($(this).val() != '')
        {*/
            var select = $(this).attr("id");
            var value = $(this).val();
            var dependent = $(this).data('dependent');
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{ route('divisionController.fetch') }}",
                method:"POST",
                data:{select:select, value:value, _token:_token, dependent:dependent},
                success:function(result)
                {
                $('#'+dependent).html(result);
                console.log( dependent + " " + select + " " + value + "" + result);
                },
                error: function(data){
                    alert("Internal Server Error");
                }
            })
    //    }
     });

    $('#Division').change(function(){
      $('#Level').val('');
      $('#Group').val('');
    });

    $('#Level').change(function(){
        $('#Group').val('');
    });

    });
    </script>
    <script src="{{asset('js/selectChoice/selectChoice.js')}}"></script>
@endpush

