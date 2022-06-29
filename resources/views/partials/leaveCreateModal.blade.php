<div class="modal fade" id="createLeaveModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
  <div class="modal-dialog modal-lg modal-fullscreen-lg-down">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create Leave</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3" action="{{ Route('leaves.create', $employee->id) }}" method="POST" id="newLeaveForm">
          @include('partials.leaveForm')
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary me-auto" form="newLeaveForm" value="submit">Create</button>
        <a class="text-danger" role="button" data-bs-dismiss="modal">Cancel</a>
      </div>
    </div>
  </div>
</div>
