@extends('master')

@section('title', 'table of data')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/tableData/style.css')}}">
    <link rel="stylesheet" href="{{ asset('css/Absence_delay/style.css')}}">
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
            <nav class="navAbsence" aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><form  action="/listTrainee">@csrf<button type="submit" class="btn btn-link">Trainees</button></form></li>
                  <li class="breadcrumb-item">Absence and delay</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-offset-1">
                <div class="panel table_center">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-sm-3 col-xs-12">
                                <h6 class="title" style="width: 700px;">Absence and delay of the trainee @php echo $nameTrainee->first_name . " " . $nameTrainee->last_name @endphp </h6>
                            </div>
                            <div class="col-sm-9 col-xs-12 text-right d-flex flex-row-reverse bd-highlight">
                                <div class="btn_group">
                                    <button id="delAbsence" type="button" class="btn_delete btn btn-default delete"  title="Delete absences and delays"><i class="fas font1 fa-trash fa-lg"></i></button>
                                </div>

                                <div class="btn_group">
                                    <button id="addAbsence" style="width: 85px;" type="button" class="btn_add btn btn-default add" data-bs-whatever="" title="Add absences and delays"><i class="fas font fa-calendar-day fa-lg"></i></button>
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
                                    <th>{{setting('titlecolumne.id')}}</th>
                                    <th>{{setting('timeabsence.type')}}</th>
                                    <th>{{setting('timeabsence.firstTimeAbsence')}}</th>
                                    <th>{{setting('timeabsence.lastTimeAbsence')}}</th>
                                    <th>{{setting('titlecolumne.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $id=0 @endphp
                                @foreach ($absences_delays as $absences_delay)
                                    <tr id="tr_{{$absences_delay->id}}">
                                        <td><input type="checkbox" class="sub_chk" data-id="{{$absences_delay->id}}"></td>
                                        <td>{{$id++}}</td>
                                        <td>{{$absences_delay->id}}</td>
                                        <td>{{$absences_delay->type}}</td>
                                        <td>{{$absences_delay->first_date_time}}</td>
                                        <td>{{$absences_delay->last_date_time}}</td>
                                        <td>
                                            <ul class="action-list">
                                                <li><a  data-bs-toggle="modal" data-bs-target="#viewAbsence" data-tip="view" data-bs-whatever="{{$absences_delay}}"><i class="far fa-eye"></i></a></li>
                                                <li><a  data-bs-toggle="modal" data-bs-target="#editAbsence" data-tip="edit" data-bs-whatever="{{$absences_delay}}"><i class="fa fa-edit"></i></a></li>
                                                <li><a data-bs-toggle="modal" data-bs-target="#deleteAbsence" data-tip="delete" data-bs-whatever="{{$absences_delay}}"><i class="fa fa-trash"></i></a></li>
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


    @include('ismo.TableData.Trainee.ComponentAbsences.editAbsences')
    @include('ismo.TableData.Trainee.ComponentAbsences.viewAbsences')
    @include('ismo.TableData.Trainee.ComponentAbsences.deleteAbsences')



@endsection


@push('scripts')
    <script>
        $(document).ready( function () {
            $('#myTableId').DataTable();
        } );
    </script>
    <script type="text/javascript" src="{{ asset('DataTables/js/datatables.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('message/toastr.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/moment/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/modal/modalAbsence.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/selectChoice/selectChoice.js')}}"></script>
@endpush
