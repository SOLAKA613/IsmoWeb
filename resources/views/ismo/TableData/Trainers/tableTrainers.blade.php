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

        <div class="row">
            <div class="col-md-offset-1">
                <div class="panel table_center">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-sm-3 col-xs-12">
                                <h4 class="title">List of <span>trainers</span></h4>
                            </div>
                            <div class="col-sm-9 col-xs-12 text-right d-flex flex-row-reverse bd-highlight">
                                <div class="btn_group">
                                    <button id="delTrainer" type="button" class="btn_delete btn btn-default delete"  title="Delete trainers"><i class="fas fa-user-slash font1  fa-lg"></i></button>
                                </div>
                                <form action="{{ url('/choiceAddUploadTrainer') }}" method="GET">
                                    <div class="btn_group">
                                       <button type="submit" class="btn_add btn btn-default" title="Add trainer"><i class="fas fa-user-plus font fa-lg" ></i></button>
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
                                    <th>{{setting('titlecolumne.email')}}</th>
                                    <th>{{setting('titlecolumne.timePlanning')}}</th>
                                    <th>{{setting('titlecolumne.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $id=0 @endphp
                                @foreach ($trainers as $trainer)
                                    <tr id="tr_{{$trainer->id}}">
                                        <td><input type="checkbox" class="sub_chk" data-id="{{$trainer->id}}"></td>
                                        <td>{{$id++}}</td>
                                        <td>{{$trainer->first_name}}</td>
                                        <td>{{$trainer->last_name}}</td>
                                        <td>{{$trainer->email}}</td>
                                        <td><ul class="action-list" style="margin-left:50px;"><li><a href="{{url('/selectFile',$trainer->time_planning_id)}}"  data-tip="time planning"><i class="far fa-calendar-alt"></i></a></li></ul></td>
                                        <td>
                                            <ul class="action-list">
                                                <li><a  data-bs-toggle="modal" data-bs-target="#exampleModal" data-tip="view" data-bs-whatever="{{$trainer}}"><i class="far fa-eye"></i></a></li>
                                                <li><a href="{{ url('/formTrainer/'  . $trainer->id) }}" data-tip="edit"><i class="fa fa-edit"></i></a></li>
                                                <li><a data-bs-toggle="modal" data-bs-target="#deleteTrainer" data-tip="delete" data-bs-whatever="{{$trainer}}"><i class="fa fa-trash"></i></a></li>
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
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            @php   if(session('user') == 'Supervisor'){  @endphp
                <?php $trainer = App\Models\Trainer::first(); ?>
                @can('read', $trainer)
                <div class="mb-3">
                    <label for="recipient-id" class="col-form-label">Code Trainer:</label>
                    <span  id="recipient-id"></span>
                </div>
                <div class="mb-3">
                    <label for="recipient-firstname" class="col-form-label">First Name:</label>
                    <span  id="recipient-firstname"></span>
                </div>
                <div class="mb-3">
                    <label for="recipient-lastname" class="col-form-label">Last Name:</label>
                    <span id="recipient-lastname"></span>
                </div>
                <div class="mb-3">
                    <label for="recipient-age" class="col-form-label">Age:</label>
                    <span id="recipient-age"></span>
                </div>
                <div class="mb-3">
                    <label for="recipient-gender" class="col-form-label">Gender:</label>
                    <span id="recipient-gender"></span>
                </div>
                <div class="mb-3">
                    <label for="recipient-email" class="col-form-label">Email:</label>
                    <span id="recipient-email"></span>
                </div>
                <span id="demo"></span>
                <div class="mb-3">
                    <table id="myTableJS" class="table table-primary table-hover">
                        <!-- here goes our data! -->
                    </table>
                </div>
                @else
                Permission denied!
                @endcan
            @php } @endphp
            </div>
            <div class="modal-footer">
                <button  type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
    <!--End Modal -->

    <!-- Static Modal -->
    <div class="modal fade" id="deleteTrainer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('trainersController.delete') }}" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Delete Trainer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="@if(!empty($trainer)){{$trainer->id}} @endif" />
                        Are you sure you want to delete this trainer?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Static Modal2 -->

    <div class="modal fade" id="deleteAllTrainer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Delete Trainer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                @php   if(session('user') == 'Supervisor'){  @endphp
                    <?php $trainer = App\Models\Trainer::first(); ?>
                    @can('delete', $trainer)
                        <div class="modal-body">
                            Are you sure you want to delete this trainers?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger delete_all" data-url="{{ url('deleteLotTrainers') }}" >Delete</button>
                        </div>
                    @else
                        <div class="modal-body">
                            Permission denied!
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    @endcan
                @php } @endphp
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
    <script type="text/javascript" src="{{ asset('js/modalTrainer/modalTrainer.js')}}"></script>
    <script type="text/javascript" src="{{ asset('message/toastr.min.js')}}"></script>
@endpush
