@extends('master')
<style>
    .footer{
        bottom:0px;
        position:fixed;
    }

</style>

@section('head')

    <title>table of data</title>
    <link rel="stylesheet" href="{{asset('css/choiceUpload/upload.css')}}">

@endsection

@section('content')
  <br />

    <div class="container">
        <h3 align="center" style="margin-top: 100px">Import Excel File</h3>
            <br />

        @if(count($errors) > 0 || $message = Session::get('erreur'))
                <div id="er_message" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Upload Validation Error</strong><br/>
                    {{ $message }}
                    <br>
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
        @endif

        @if(Session::has('failures'))
                <div id="er_message" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Upload Validation Error</strong><br>
                    <table class="table table-danger">
                            <tr>
                                <th>Row</th>
                                <th>Attribute</th>
                                <th>Errors</th>
                                <th>Value</th>
                            </tr>

                            @foreach (session()->get('failures') as $validation)
                                <tr>
                                    <td>{{ $validation->row() }}</td>
                                    <td>{{ $validation->attribute() }}</td>
                                    <td>
                                        <ul>
                                            @foreach ($validation->errors() as $e)
                                                <li>{{ $e }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        {{ $validation->values()[$validation->attribute()] }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
        @endif

        <form method="post" enctype="multipart/form-data" onsubmit="return myFunction()" action="{{ url('/import_excelTrainer/import') }}" style="margin-bottom: 300px">
                {{ csrf_field() }}
                <div class="form-group">
                    <table class="table table-primary table-striped">
                        <tr>
                            <td width="10%" align="right"></td>
                            <td width="60%" >
                                <div class="mb-3">
                                    <input class="form-control inputFile" type="file" name="select_file"  id="FormControlFile" onchange="return ValidationFile()" lang="en"  >
                                    <div class="error_file" id="file_error"></div>
                                </div>
                            </td>
                            <td class="formFile" width="30%" align="left">
                                <input type="submit" value="Upload"  class="btn btn-primary btnFile" id="submit" name="upload"  >
                            </td>
                        </tr>
                        <tr>
                        <td width="40%" align="right">Allowed file extensions:</td>
                        <td width="30"><span class="text-muted">.xls, .xslx</span></td>
                        <td width="30%" align="left"></td>
                        </tr>
                    </table>
                </div>
        </form>
@endsection

@push('scripts')
    <script type="text/javascript" src="js/uploadFile/upload.js"></script>
@endpush

