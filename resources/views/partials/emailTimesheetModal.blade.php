<div class="modal fade" id="emailTimesheetModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
  <div class="modal-dialog modal-lg modal-fullscreen-lg-down">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Send Timesheet Email</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3" action="{{ Route('timesheet.email', ['id' => $employee->id, 'year' => $timesheet->year, 'month' => $timesheet->month]) }}"
          method="POST" id="emailTimesheetForm">
          @csrf
          <div class="col-md-12">
            <div class="alert alert-warning mb-0">
              <strong>Warning!</strong> Sending emails outside of your organization is not recommended.
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="email">Recipient(s)</label>
              <input type="email" class="form-control mb-2 @error('recipient.0') is-invalid @enderror" id="email" name="recipient[]" placeholder="Email"
                value="{{ $employee->email ?? '' }}">
            </div>
            <a class="btn btn-primary btn-sm" role="button" data-cs-role="clone" data-cs-target="#email">Add Email</a>
          </div>
          <div class="col-md-12">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" id="subject" placeholder="Email Subject"
              value="{{ old('subject') ?? '' }}" />
          </div>
          <div class="col-md-12">
            <label for="message" class="form-label">Message</label>
            <textarea name="message" class="form-control @error('message') is-invalid @enderror" id="message" rows="4">{{ old('message') ?? __('messages.timesheet.email.default', ['period' => $timesheet->period->format('F, Y')]) }}</textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary me-auto" form="emailTimesheetForm" value="submit">Send</button>
        <a class="text-danger" role="button" data-bs-dismiss="modal">Cancel</a>
      </div>
    </div>
  </div>
</div>
