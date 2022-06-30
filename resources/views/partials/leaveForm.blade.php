@csrf
<div class="col-md-6">
  <label for="start_date" class="form-label">Start</label>
  <input type="datetime-local" name="start_date" class="form-control" id="start_date"
    value="{{ isset($leave) ? $leave->start_date->toDateTimeLocalString() : '' }}">
</div>
<div class="col-md-6">
  <label for="end_date" class="form-label">End</label>
  <input type="datetime-local" name="end_date" class="form-control" id="end_date"
    value="{{ isset($leave) ? $leave->end_date->toDateTimeLocalString() : '' }}">
</div>
<div class="col-md-12">
  <label for="comments" class="form-label">Comments</label>
  <textarea name="comments" class="form-control" id="comments">{{ isset($leave) ? $leave->comments : '' }}</textarea>
</div>
<div class="col-md-12">
  <label for="type" class="form-label">Type</label>
  <select id="type" name="type" class="form-select">
    <option value="paid" @selected(isset($leave) ? $leave->type === 'paid' : '')>Paid</option>
    <option value="unpaid" @selected(isset($leave) ? $leave->type === 'unpaid' : '')>Unpaid</option>
    <option value="sick" @selected(isset($leave) ? $leave->type === 'sick' : '')>Sick</option>
    <option value="vacation" @selected(isset($leave) ? $leave->type === 'vacation' : '')>Vacation</option>
    <option value="vacation" @selected(isset($leave) ? $leave->type === 'parental' : '')>Parental</option>
  </select>
</div>
<div class="col-md-12">
  <label for="status" class="form-label">Request Status</label>
  <div class="form-check">
    <input class="form-check-input" type="radio" name="status" value="pending" id="status1"
      @checked(isset($leave) && $leave->status === 'pending')>
    <label class="form-check-label" for="status1">
      Pending
    </label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="radio" name="status" value="approved" id="status2"
      @checked(isset($leave) && $leave->status === 'approved')>
    <label class="form-check-label" for="status2">
      Approved {{ isset($leave) && $leave->approved_at ? 'on ' . $leave->approved_at->format('m/d/Y g:i A') : '' }}
    </label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="radio" name="status" value="declined" id="status3"
      @checked(isset($leave) && $leave->status === 'declined')>
    <label class="form-check-label" for="status3">
      Declined {{ isset($leave) && $leave->declined_at ? 'on ' . $leave->declined_at->format('m/d/Y g:i A') : '' }}
    </label>
  </div>
</div>
<div class="col-md-12">
  <label for="timesheet_id" class="form-label">Period</label>
  <select id="timesheet_id" name="timesheet_id" class="form-select">
    <option value="" @selected(!isset($leave) || !$leave->timesheet_id)>None</option>
    @foreach ($employee->timesheets as $t)
      <option value="{{ $t->id }}" @selected(isset($leave) && $leave->timesheet_id === $t->id)>{{ $t->period->format('F, Y') }}</option>
    @endforeach
  </select>
</div>
<div class="col-md-12">
  <label for="notify" class="form-label">Notify Employee</label>
  <div class="form-check">
    <input class="form-check-input" name="notify" type="checkbox" value="1" id="notify" checked>
    <label class="form-check-label" for="notify">Notify of request status</label>
  </div>
  @if (isset($leave))
    <div class="form-text">
      If the status is pending, or no change to the status is detected, an alert will not be sent.
    </div>
  @endif
</div>
