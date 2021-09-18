<!-- Modal -->
<div class="modal fade" id="editAbsence" tabindex="-1" aria-labelledby="editAbsenceLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form  id="updateAbsence" class="row g-3 needs-validation" novalidate>
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editAbsenceLabel">update Absence</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="recipient-id" class="col-form-label">{{setting('site.code')}}:</label>
                        <input type="text" class="form-control" id="recipient-id" required></span>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label"> {{setting('timeabsence.type')}}:</label>
                        <input type="text" class="form-control" id="recipient-type" required></span>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label"> {{setting('timeabsence.remark')}}:</label>
                        <input type="text" class="form-control" id="recipient-remark" required></span>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label"> {{setting('timeabsence.firstTimeAbsence')}}:</label>
                        <input type="datetime-local" class="form-control" id="recipient-firstTimeAbsence" required>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label"> {{setting('timeabsence.lastTimeAbsence')}}:</label>
                        <input type="datetime-local" class="form-control" id="recipient-lastTimeAbsence" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="btn" type="submit" class="btn btn-success" ><span id="btnAction"></span></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Modal -->
