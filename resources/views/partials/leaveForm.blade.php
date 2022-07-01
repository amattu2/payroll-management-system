@csrf
<div class="col-md-6">
  <label for="start_date" class="form-label">Start</label>
  <input type="datetime-local" name="start_date" class="form-control @error('start_date') is-invalid @enderror"
    id="start_date"
    value="{{ old('start_date') ?? (isset($leave) ? $leave->start_date->toDateTimeLocalString() : '') }}">
</div>
<div class="col-md-6">
  <label for="end_date" class="form-label">End</label>
  <input type="datetime-local" name="end_date" class="form-control @error('end_date') is-invalid @enderror"
    id="end_date" value="{{ old('end_date') ?? (isset($leave) ? $leave->end_date->toDateTimeLocalString() : '') }}">
</div>
<div class="col-md-12">
  <label for="comments" class="form-label">Comments</label>
  <textarea name="comments" class="form-control @error('comments') is-invalid @enderror" id="comments">{{ old('comments') ?? (isset($leave) ? $leave->comments : '') }}</textarea>
</div>
<div class="col-md-12">
  <label for="type" class="form-label">Type</label>
  <select id="type" name="type" class="form-select @error('type') is-invalid @enderror">
    <option value="paid" @selected((old('type') ?? ($leave->type ?? '')) === 'paid')>Paid</option>
    <option value="unpaid" @selected((old('type') ?? ($leave->type ?? '')) === 'unpaid')>Unpaid</option>
    <option value="sick" @selected((old('type') ?? ($leave->type ?? '')) === 'sick')>Sick</option>
    <option value="vacation" @selected((old('type') ?? ($leave->type ?? '')) === 'vacation')>Vacation</option>
    <option value="vacation" @selected((old('type') ?? ($leave->type ?? '')) === 'parental')>Parental</option>
  </select>
</div>
<div class="col-md-12">
  <label for="status" class="form-label">Request Status</label>
  <div class="form-check">
    <input class="form-check-input" type="radio" name="status" value="pending" id="status1"
      @checked((old('status') ?? ($leave->status ?? '')) === 'pending')>
    <label class="form-check-label" for="status1">
      Pending
    </label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="radio" name="status" value="approved" id="status2"
      @checked((old('status') ?? ($leave->status ?? '')) === 'approved')>
    <label class="form-check-label" for="status2">
      Approved {{ isset($leave) && $leave->approved_at ? 'on ' . $leave->approved_at->format('m/d/Y g:i A') : '' }}
    </label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="radio" name="status" value="declined" id="status3"
      @checked((old('status') ?? ($leave->status ?? '')) === 'declined')>
    <label class="form-check-label" for="status3">
      Declined {{ isset($leave) && $leave->declined_at ? 'on ' . $leave->declined_at->format('m/d/Y g:i A') : '' }}
    </label>
  </div>
</div>
<div class="col-md-12">
  <label for="timesheet_id" class="form-label">Period</label>
  <select id="timesheet_id" name="timesheet_id" class="form-select @error('timesheet_id') is-invalid @enderror">
    <option value="" @selected(!old('timesheet_id') && (!isset($leave) || !$leave->timesheet_id))>None</option>
    @foreach ($employee->timesheets as $t)
      <option value="{{ $t->id }}" @selected((old('timesheet_id') ?? ($leave->timesheet_id ?? '')) === $t->id)>{{ $t->period->format('F, Y') }}</option>
    @endforeach
  </select>
</div>
<div class="col-md-12">
  <label for="notify" class="form-label">Notify Employee</label>
  <div class="form-check">
    <input class="form-check-input" name="notify" type="checkbox" value="1" id="notify"
      @checked(old('notify') ?? true)>
    <label class="form-check-label" for="notify">Notify of request status</label>
  </div>
  @if (isset($leave))
    <div class="form-text">
      If the status is pending, or no change to the status is detected, an alert will not be sent.
    </div>
  @endif
</div>
