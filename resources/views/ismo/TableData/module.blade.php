@extends('master')

@section('title', 'table of data')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/tableData/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('DataTables/css/datatables.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('message/toastr.min.css')}}">
@endsection

@section('content')

        @if(count($errors) > 0 || Session::has('erreur'))
            <div  class="alert alert-danger alert-dismissible fade show top" id="messageErreur" role="alert">
                    <strong>{{ session('titleErreur') }}</strong><br/>
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
           <div  class="alert alert-success alert-dismissible fade show top" role="alert">
                    <strong>Success!</strong><br/>
                    {{$message}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif



    <div class="tabl container">

        <div class="alert alert-secondary" role="alert">
            <nav class="navGroup" aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="listDivision" class="link-primary">Divisions</a></li>
                  <li class="breadcrumb-item"><form action="/listLevel">@csrf <input type="hidden" name="id" value="{{$idDiv}}" /><button style="MARGIN-BOTTOM: 7px;" type="submit" class="btn btn-link btnLevel">Levels</button> </form></li>
                  <li class="breadcrumb-item " class="link-secondary" aria-current="page">Modules</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-offset-1">
                <div class="panel table_center">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-sm-3 col-xs-12">
                                <h4 class="title">List of <span>Modules</span></h4>
                            </div>
                            <div class="col-sm-9 col-xs-12 text-right d-flex flex-row-reverse bd-highlight">
                                <div class="btn_module">
                                    <button id="delModule" type="button" class="btn_delete btn btn-default delete"  title="Delete Modules"><i class="fas font1 fa-trash fa-lg"></i></button>
                                </div>

                                <div class="btn_module">
                                    <button id="addModule" style="width: 85px;" type="button" class="btn_add btn btn-default" title="Add Module"><i class="fas font fa-plus fa-lg" ></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body table-responsive" >
                        <table class="table" id="myTableId">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="master"></th>
                                    <th>#</th>
                                    <th>{{setting('module.code')}}</th>
                                    <th>{{setting('module.name')}}</th>
                                    <th>{{setting('titlecolumne.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $id=0 @endphp
                                @foreach ($modules as $module)
                                    <tr id="tr_{{$module->id}}">
                                        <td><input type="checkbox" class="sub_chk" data-id="{{$module->id}}"></td>
                                        <td>{{$id++}}</td>
                                        <td>{{$module->id}}</td>
                                        <td>{{$module->name}}</td>
                                        <td>
                                            <ul class="action-list">
                                                <li><a  data-bs-toggle="modal" data-bs-target="#editModule" data-tip="edit" data-bs-whatever="{{$module}}"><i class="fa fa-edit"></i></a></li>
                                                <li><a data-bs-toggle="modal" data-bs-target="#deleteModule" data-tip="delete" data-bs-whatever="{{$module}}"><i class="fa fa-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="editModule" tabindex="-1" aria-labelledby="editModuleLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="updateModule">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModuleLabel">update Module</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="recipient-id" class="col-form-label">Code Module:</label>
                            <input type="text" class="form-control" id="recipient-id"></span>
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" id="recipient-name"></span>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success"><span id="btnAction"></span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Modal -->

    <!-- Static Modal -->
    <div class="modal fade" id="deleteModule" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Delete Module</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this Module?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger deleteMo" data-url="{{ url('deleteModule') }}">Delete</button>
                    </div>
                </div>
        </div>
    </div>

    <!-- Static Modal2 -->
    <div class="modal fade" id="deleteAllModules" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Delete Module</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this modules?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger delete_all" data-url="{{ url('deleteLotModules') }}" >Delete</button>
                    </div>
                </div>
        </div>
    </div>

@endsection


@push('scripts')
    <script>
        $(document).ready( function () {
            $('#myTableId').DataTable();
        } );
    </script>
    <script type="text/javascript" src="{{ asset('DataTables/js/datatables.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/modal/modalModule.js')}}"></script>
    <script type="text/javascript" src="{{ asset('message/toastr.min.js')}}"></script>
@endpush
