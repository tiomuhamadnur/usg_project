<!-- Delete Modal -->
<div class="modal modal-blur fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <i class="fa fa-trash-can fa-5x text-danger"></i>
                <h3>Are you sure?</h3>
                <div class="text-secondary">Do you really want to delete this data? What you've done cannot
                    be undone.</div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col">
                            <a href="#" class="btn w-100" data-bs-dismiss="modal">
                                Cancel
                            </a>
                        </div>
                        <div class="col">
                            <form id="deleteForm" action="#" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Delete Modal -->


<!-- Export Modal -->
<div class="modal modal-blur fade" id="exportModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <i class="fa fa-file-export fa-5x text-success"></i>
                <h3>Are you sure?</h3>
                <div class="text-secondary">Do you really want to export this data to Excel File?</div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col">
                            <a href="#" class="btn w-100" data-bs-dismiss="modal">
                                Cancel
                            </a>
                        </div>
                        <div class="col">
                            <form id="exportForm" action="#" method="POST">
                                @csrf
                                @method('post')
                            </form>
                            <button form="exportForm" type="submit" class="btn btn-success w-100">
                                Export
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Export Modal -->
