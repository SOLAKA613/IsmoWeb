@extends('master')

@section('title', 'table of data')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/TableDataTrainer/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/addTrainer/style.css')}}">
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

    @if($message = Session::get('success'))
        <div id="su_message" class="alert alert-success alert-dismissible fade show top" role="alert">
            <strong>Success!</strong><br>
            {{ $message }}
        </div>
    @endif

    <div  class="card border-secondary mb-3 formAdd">
        <div class="card-header">
            <h5 class="card-title">Add Trainer</h5>
        </div>
        <form action = "/addUpdateTrainer" method="POST" onsubmit="return myFunction()" enctype="multipart/form-data" style = "margin-top:150px" id = "DataTrainer" class="row g-3 needs-validation" novalidate>
            @csrf
            <div class="container col-md-8 order-md-1 cont">
                <div class="row">

                        <input type="hidden" name="index" value="@if(!empty($trainer)){{$trainer->id}} @endif" />

                        <div class="mb-3">
                            <label for="id" class="form-label">{{ setting('titlecolumne.id') }}</label>
                            <input type="text" name="id"  value="@if(!empty($trainer)){{$trainer->id}} @else{{ old('id') }}@endif" class="form-control" id="id" required>
                            <div class="valid-feedback">
                                Good!
                            </div>
                            <div class="invalid-feedback">
                                Code trainer cannot be blank.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="first_name" class="form-label">{{setting('titlecolumne.firstName')}}</label>
                            <input type="text" name="first_name" value="@if(!empty($trainer)){{$trainer->first_name}} @else{{ old('first_name') }}@endif" class="form-control" id="first_name" required>
                            <div class="valid-feedback">
                                Good!
                            </div>
                            <div class="invalid-feedback">
                                First name cannot be blank.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">{{setting('titlecolumne.lastName')}}</label>
                            <input type="text" name="last_name" value="@if(!empty($trainer)){{$trainer->last_name}} @else{{ old('last_name') }}@endif" class="form-control" id="last_name" required>
                            <div class="valid-feedback">
                                Good!
                            </div>
                            <div class="invalid-feedback">
                                Last name cannot be blank.
                            </div>
                        </div>

                        @if(!empty($division) && !empty($level) && !empty($module))
                            <script type="text/javascript">
                                var divs = @json($division);
                                var levs = @json($level);
                                var mods = @json($module);
                            </script>
                        @else
                            <script type="text/javascript">
                                var divs = [];
                                var levs = [];
                                var mods = [];
                            </script>
                        @endif

                        <i id="addSelect" onclick="cloneSelect()" class="fas fa-plus-circle fa-2x "></i>
                        @if(!empty($division))
                            <input type="hidden" name = "contSelect" value = "{{count($division)}}" id = "contSelect" />
                        @else
                            <input type="hidden" name = "contSelect" value = "0" id = "contSelect" />
                        @endif

                        <div class="row gr-select" >
                            <div id="Div" class="col-md">
                                <div class="form-floating">
                                    <select  class="form-select input-lg dynamic"  name="division" id="Division" data-dependent="Level" required>

                                        @if(!empty($division))
                                            <option  value="">Select Division</option>
                                            @foreach($divisions as $div)
                                                @if($division[0] == $div->name)
                                                    <option value="{{$div->name}}" selected>{{$div->name}}</option>
                                                @else
                                                    <option value="{{$div->name}}" >{{$div->name}}</option>
                                                @endif
                                            @endforeach
                                        @else
                                            <option  value="" selected>Select Division</option>
                                            @foreach($divisions as $division)
                                                <option value="{{$division->name}}">{{$division->name}}</option>
                                            @endforeach
                                        @endif
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
                            <div id="Lev" class="col-md">
                                <div class="form-floating">
                                    <select class="form-select input-lg dynamic"  name="level" id="Level" data-dependent="Module" required>
                                        @if(!empty($level))
                                            <option value="" >Select Level</option>
                                            <option value="{{$level[0]}}" selected >{{$level[0]}}</option>
                                        @else
                                            <option value="" >Select Level</option>
                                        @endif
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
                            <div id="Mod" class="col-md">
                                <div class="form-floating">
                                    <select class="form-select input-lg dynamic"   name="module" id="Module" required>
                                        @if(!empty($module))
                                            <option value="" selected >Select Module</option>
                                            <option value="{{$module[0]}}" selected >{{$module[0]}}</option>
                                        @else
                                            <option value="" selected >Select Module</option>
                                        @endif
                                    </select>
                                    <label for="Module">Modules</label>
                                    <div class="valid-feedback">
                                        Good Choice!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please select a valid module.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="float-select">
                        </div>

                        <div class=" mb-3 gender" role="group" aria-label="Basic radio toggle button group">
                            <label for="gender" class="form-label">{{setting('titlecolumne.gender')}}</label>
                            <input type="radio" class="btn-check " name="gender" id="gender1" value="Male"  @if(!empty($trainer)) @if($trainer->gender == "male") checked @endif @elseif(!empty(old('gender'))) @if(old('gender') == "Male") checked @endif @else checked @endif required>
                            <label class="btn btn-outline-primary" style="margin-left:15px" for="gender1">Male</label>

                            <input type="radio" class="btn-check"  name="gender" id="gender2" value="Female"  @if(!empty($trainer)) @if($trainer->gender == "female") checked @endif @elseif(!empty(old('gender'))) @if(old('gender') == "Female") checked @endif @endif required>
                            <label class="btn btn-outline-primary" for="gender2">Female</label>
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">{{setting('titlecolumne.age')}}</label>
                            <input type="text" name="age" value="@if(!empty($trainer)){{$trainer->age}} @else{{ old('age') }}@endif" class="form-control" id="age" required>
                            <div class="valid-feedback">
                                Good!
                            </div>
                            <div class="invalid-feedback">
                                Age cannot be blank.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">{{setting('titlecolumne.email')}}</label>
                            <input type="text" name="email" value="@if(!empty($trainer)){{$trainer->email}} @else{{ old('email') }}@endif" class="form-control" id="email" required>
                            <div class="valid-feedback">
                                Good!
                            </div>
                            <div class="invalid-feedback">
                                Email cannot be blank.
                            </div>
                        </div>
                        <div class="mb-3">
                            <button id="buttonUpdate" type="button" class="btn btn-success" onclick="HideShow()">Update File</button>
                        </div>

                        <div id="idFile" class="form-group form-file">
                            <table id="idTable" class="table table-primary table-striped">
                                <tr>
                                    <td width="10%" align="right"></td>
                                    <td width="60%" >
                                        <div class="mb-3">
                                            <input type="hidden" id="indexFile" value="@if(!empty($fileName)){{$fileName}}@endif" />
                                            <input class="form-control inputFile" type="file" name="file" id="FormControlFile" onchange="return ValidationFile()" lang="en"  required>
                                            <div class="error_file" id="file_error"></div>
                                        </div>
                                    </td>
                                    <td class="formFile" width="30%" align="left">
                                    </td>
                                </tr>
                                <tr>
                                <td width="40%" align="right">Allowed file extensions:</td>
                                <td width="30"><span class="text-muted">.pdf</span></td>
                                <td width="30%" align="left"></td>
                                </tr>
                            </table>
                        </div>

                    <div class="d-flex justify-content-end btn_submit">
                        <button id="submit" type="submit" type="button" class="btn btn-primary d-flex justify-content-end" >Validate</button>
                    </div>

                </div>
            </div>
        </form>
    </div>


@endsection
@push('scripts')
<script src="{{asset('js/modalTrainer/addSelect.js')}}"></script>
<script>
    window.onload = crateSelects(divs,levs,mods);
$(document).ready(function(){

    var division = "";
    var level = "";
    var module1 = "";

     $('.dynamic').change(function(){
            var select = $(this).attr("id");
            var value = $(this).val();
            var dependent = $(this).data('dependent');
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{ route('moduleTrainerController.fetch') }}",
                method:"POST",
                data:{select:select, value:value, _token:_token, dependent:dependent},
                success:function(result)
                {
                $('#'+dependent).html(result);
                console.log( dependent + " " + select + " " + value );
                },
                error: function(data){
                    alert("Internal Server Error");
                }
            })
     });



});
</script>

    <script src="{{asset('js/selectChoice/selectChoice.js')}}"></script>
    <script src="{{asset('js/modalTrainer/validationUploadFile.js')}}"></script>
@endpush

