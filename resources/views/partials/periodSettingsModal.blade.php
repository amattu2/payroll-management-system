<div class="modal fade" id="periodSettingsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
  <div class="modal-dialog modal-lg modal-fullscreen-lg-down">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Period Settings</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3"
          action="{{ Route('timesheet.settings', ['id' => $timesheet->employee_id, 'year' => $timesheet->period->format('Y'), 'month' => $timesheet->period->format('m')]) }}"
          method="POST" id="periodSettingsForm">
          @csrf
          <div class="col-md-12">
            <div class="alert alert-danger mb-0">
              <strong>Warning!</strong> Changing these settings during an active pay period is not recommended.
            </div>
          </div>
          <div class="col-md-12">
            <label for="period" class="form-label">Pay Period</label>
            <input type="month" name="period" class="form-control" id="period"
              value="{{ $timesheet->period->format('Y-m') }}">
          </div>
          <div class="col-md-12">
            <label for="pay_type" class="form-label">Pay Type</label>
            <select id="pay_type" name="pay_type" class="form-select">
              <option value="hourly" @selected($timesheet->pay_type === "hourly")>Hourly</option>
              <option value="salary" @selected($timesheet->pay_type === "salary")>Salary</option>
            </select>
          </div>
          <div class="col-md-12">
            <div class="form-check">
              <input id="completed_at" name="completed_at" type="checkbox" class="form-check-input" value="1" @checked($timesheet->completed_at)>
              <label class="form-check-label" for="completed_at">
                Finalized {{ $timesheet->completed_at ? "on " . $timesheet->completed_at->format('m/d/Y g:i A') : "" }}
              </label>
            </div>
            @if ($timesheet->completed_at)
              <div class="form-text">
                Uncheck to re-enable editing of this period.
              </div>
            @endif
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary me-auto" form="periodSettingsForm" value="submit">Save</button>
        <a class="text-danger" role="button" data-bs-dismiss="modal">Cancel</a>
      </div>
    </div>
  </div>
</div>
