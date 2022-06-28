@csrf
<div class="col-md-6">
  <label for="start_date" class="form-label">Start</label>
  <input type="datetime-local" name="start_date" class="form-control" id="start_date" value="{{ $leave->start_date->toDateTimeLocalString() }}">
</div>
<div class="col-md-6">
  <label for="end_date" class="form-label">End</label>
  <input type="datetime-local" name="end_date" class="form-control" id="end_date" value="{{ $leave->end_date->toDateTimeLocalString() }}">
</div>
<div class="col-md-12">
  <label for="comments" class="form-label">Comments</label>
  <textarea name="comments" class="form-control" id="comments">{{ $leave->comments }}</textarea>
</div>
<div class="col-md-12">
  <label for="type" class="form-label">Type</label>
  <select id="type" name="type" class="form-select">
    <option value="paid" @selected($leave->type === 'paid')>Paid</option>
    <option value="unpaid" @selected($leave->type === 'unpaid')>Unpaid</option>
    <option value="sick" @selected($leave->type === 'sick')>Sick</option>
    <option value="vacation" @selected($leave->type === 'vacation')>Vacation</option>
    <option value="vacation" @selected($leave->type === 'parental')>Parental</option>
  </select>
</div>
<div class="col-md-12">
  <label for="status" class="form-label">Request Status</label>
  <div class="form-check">
    <input class="form-check-input" type="radio" name="status" value="pending" id="status1" @checked(!$leave->declined && !$leave->approved)>
    <label class="form-check-label" for="status1">
      Pending
    </label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="radio" name="status" value="approved" id="status2" @checked($leave->approved)>
    <label class="form-check-label" for="status2">
      Approved {{ $leave->approved ? 'on ' . $leave->approved->format('m/d/Y g:i A') : '' }}
    </label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="radio" name="status" value="declined" id="status3" @checked($leave->declined)>
    <label class="form-check-label" for="status3">
      Declined {{ $leave->declined ? 'on ' . $leave->declined->format('m/d/Y g:i A') : '' }}
    </label>
  </div>
</div>
<div class="col-md-12">
  <label for="timesheet_id" class="form-label">Period</label>
  <select id="timesheet_id" name="timesheet_id" class="form-select">
    <option value="" @selected(!$leave->timesheet_id)>None</option>
    @foreach ($employee->timesheets as $t)
      <option value="{{ $t->id }}" @selected($leave->timesheet_id === $t->id)>{{ $t->period->format('F, Y') }}</option>
    @endforeach
  </select>
</div>
