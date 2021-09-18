<!-- Static Modal -->
<div class="modal fade" id="deleteTrainee" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('dataController.delete') }}" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Delete Trainee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="@if(!empty($trainee)){{$trainee->id}} @endif" />
                    Are you sure you want to delete this trainee?
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

        <div class="modal fade" id="deleteAllTrainee" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Delete Trainee</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    @php   if(session('user') == 'Supervisor'){  @endphp
                        <?php $trainee = App\Models\Trainee::first(); ?>
                        @can('delete', $trainee)
                            <div class="modal-body">
                                Are you sure you want to delete this trainees?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger delete_all" data-url="{{ url('deleteLotTrainees') }}" >Delete</button>
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
