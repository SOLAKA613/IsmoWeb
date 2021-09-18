<!-- Modal -->
<div class="modal fade" id="viewAbsence" tabindex="-1" aria-labelledby="viewAbsenceLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form  id="updateAbsence" class="row g-3 needs-validation" novalidate>
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="viewAbsenceLabel">Absence information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="idAbsence" class="col-form-label">{{setting('site.code')}}:</label>
                        <span id="idAbsence"></span>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="col-form-label"> {{setting('timeabsence.type')}}:</label>
                        <span id="type"></span>
                    </div>
                    <div class="mb-3">
                        <label for="remark" class="col-form-label"> {{setting('timeabsence.remark')}}:</label>
                        <span id="remark"></span>
                    </div>
                    <div class="mb-3">
                        <label for="first_time" class="col-form-label"> {{setting('timeabsence.firstTimeAbsence')}}:</label>
                        <span id="first_time"></span>
                    </div>
                    <div class="mb-3">
                        <label for="last_time" class="col-form-label"> {{setting('timeabsence.lastTimeAbsence')}}:</label>
                        <span id="last_time"></span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Modal -->
