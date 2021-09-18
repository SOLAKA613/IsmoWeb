@extends('master')

@section('title', 'table of data')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/TableData/style.css')}}">
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

        <div class="container px-4 alert alert-primary" role="alert">
            <div class="row gx-5">
                <div class="col">
                    <label for="division-id" class="col-form-label">Division:</label>
                    <span  id="level-id" >{{ session('division') }}</span>
                </div>
                <div class="col">
                    <label for="level-id" class="col-form-label">Level:</label>
                    <span  id="level-id" >{{ session('level') }}</span>
                </div>
                <div class="col">
                    <label for="group-id" class="col-form-label">Group:</label>
                    <span  id="group-id" >{{ session('group') }}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-offset-1">
                <div class="panel table_center">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-sm-3 col-xs-12">
                                <h4 class="title">List of <span>trainees</span></h4>
                            </div>
                            <div class="col-sm-9 col-xs-12 text-right d-flex flex-row-reverse bd-highlight">
                                <div class="btn_group">
                                    <button id="delTrainee" type="button" class="btn_delete btn btn-default delete"  title="Delete trainees"><i class="fas fa-user-slash font1  fa-lg"></i></button>
                                </div>
                                <form action="{{ url('/choiceUpload') }}" method="GET">
                                    <div class="btn_group">
                                       <button type="submit" class="btn_add btn btn-default" title="Add trainee"><i class="fas fa-user-plus font fa-lg" ></i></button>
                                    </div>
                               </form>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body table-responsive" >
                        <table class="table" id="myTableId">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="master"></th>
                                    <th>#</th>
                                    <th>{{setting('titlecolumne.firstName')}}</th>
                                    <th>{{setting('titlecolumne.lastName')}}</th>
                                    <th>{{setting('titlecolumne.age')}}</th>
                                    <th>{{setting('timeabsence.timeAbsence')}}</th>
                                    <th>{{setting('titlecolumne.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $id = 0 @endphp
                                @foreach ($listTrainees as $trainee)
                                    <tr id="tr_{{$trainee->id}}">
                                        <td><input type="checkbox" class="sub_chk" data-id="{{$trainee->id}}"></td>
                                        <td>{{$id++}}</td>
                                        <td>{{$trainee->first_name}}</td>
                                        <td>{{$trainee->last_name}}</td>
                                        <td>{{$trainee->age}}</td>
                                        <td><form method="POST" action="/listAbsences_delays" style="text-align: center;">@csrf <input type="hidden" name="id" value="{{$trainee->id}}" /> <button type="submit" class="btn btn-success " id="btnAbsence{{$id}}" role="button" data-tip="absence"><i class="fas fa-user-times"></i></button></form>
                                        <td>
                                            <ul class="action-list">
                                                <li><a  data-bs-toggle="modal" data-bs-target="#exampleModal" data-tip="view" data-bs-whatever="@if(!empty($trainee)) {{ json_encode($trainee,TRUE) }}  @endif"><i class="far fa-eye"></i></a></li>
                                                <li><a href="{{ url('/add/'  . $trainee->id) }}" data-tip="edit"><i class="fa fa-edit"></i></a></li>
                                                <li><a data-bs-toggle="modal" data-bs-target="#deleteTrainee" data-tip="delete" data-bs-whatever="@if(!empty($trainee)) {{ json_encode($trainee,TRUE) }} @endif"><i class="fa fa-trash"></i></a></li>
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


    @include('ismo.TableData.Trainee.ComponentTrainee.viewTrainee')
    @include('ismo.TableData.Trainee.ComponentTrainee.deleteTrainee')


@endsection


@push('scripts')
    <script>
        $(document).ready( function () {
            $('#myTableId').DataTable();
        } );
    </script>
    <script type="text/javascript" src="{{ asset('DataTables/js/datatables.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/modal/modal.js')}}"></script>
    <script type="text/javascript" src="{{ asset('message/toastr.min.js')}}"></script>
@endpush
