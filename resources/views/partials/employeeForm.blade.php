@csrf
<div class="row mb-3">
  <div class="col-md-4">
    <label for="firstname" class="form-label">First Name</label>
    <input type="text" placeholder="First Name" value="{{ isset($employee) ? $employee->firstname : '' }}"
      class="form-control @error('title') is-invalid @enderror" name="firstname">
  </div>
  <div class="col-md-4">
    <label for="middlename" class="form-label">Middle Name</label>
    <input type="text" placeholder="Middle Name" value="{{ isset($employee) ? $employee->middlename : '' }}"
      class="form-control @error('title') is-invalid @enderror" name="middlename">
  </div>
  <div class="col-md-4">
    <label for="lastname" class="form-label">Last Name</label>
    <input type="text" placeholder="Last Name" value="{{ isset($employee) ? $employee->lastname : '' }}"
      class="form-control @error('title') is-invalid @enderror" name="lastname">
  </div>
</div>
<div class="mb-3">
  <label for="email" class="form-label">Email Address</label>
  <input type="email" placeholder="example@example.com" value="{{ isset($employee) ? $employee->email : '' }}"
    class="form-control @error('title') is-invalid @enderror" name="email">
  <div class="form-text">
    This employee will not be granted access to this application. In order to grant access, you must create a separate
    user account for this employee.
  </div>
</div>
<div class="mb-3">
  <label for="telephone" class="form-label">Telephone</label>
  <input type="text" placeholder="000-000-000" value="{{ isset($employee) ? $employee->telephone : '' }}"
    class="form-control @error('title') is-invalid @enderror" name="telephone">
</div>
<div class="row g-3 mb-3">
  <div class="col-md-6">
    <label for="street1" class="form-label">Street #1</label>
    <input type="text" value="{{ isset($employee) ? $employee->street1 : '' }}"
      class="form-control @error('title') is-invalid @enderror" name="street1" placeholder="1234 Main St">
  </div>
  <div class="col-md-6">
    <label for="street2" class="form-label">Street #2</label>
    <input type="text" value="{{ isset($employee) ? $employee->street2 : '' }}"
      class="form-control @error('title') is-invalid @enderror" name="street2"
      placeholder="Apartment, studio, or floor">
  </div>
  <div class="col-md-6">
    <label for="city" class="form-label">City</label>
    <input type="text" value="{{ isset($employee) ? $employee->city : '' }}"
      class="form-control @error('title') is-invalid @enderror" name="city">
  </div>
  <div class="col-md-4">
    <label for="state" class="form-label">State</label>
    <select name="state" class="form-select @error('title') is-invalid @enderror">
      <option value="MD" selected>Maryland</option>
    </select>
  </div>
  <div class="col-md-2">
    <label for="zip" class="form-label">Zip</label>
    <input type="text" value="{{ isset($employee) ? $employee->zip : '' }}"
      class="form-control @error('title') is-invalid @enderror" name="zip">
  </div>
</div>
<div class="mb-3">
  <label for="birthdate" class="form-label">Date of Birth</label>
  <input type="date" value="{{ isset($employee) ? $employee->birthdate : '' }}"
    class="form-control @error('title') is-invalid @enderror" name="birthdate">
</div>
<div class="mb-3">
  <label for="hired_at" class="form-label">Date Hired</label>
  <input type="date" value="{{ isset($employee) ? $employee->hired_at->format('Y-m-d') : '' }}"
    class="form-control @error('title') is-invalid @enderror" name="hired_at">
</div>
<div class="row mb-3">
  <div class="col-md-4">
    <label for="pay_type" class="form-label">Pay Type</label>
    <select class="form-control @error('title') is-invalid @enderror" name="pay_type">
      <option value="hourly" @selected(($employee->pay_type ?? '') === 'hourly')>Hourly</option>
      <option value="salary" @selected(($employee->pay_type ?? '') === 'salary')>Salary</option>
    </select>
  </div>
  <div class="col-md-4">
    <label for="pay_period" class="form-label">Pay Period</label>
    <select class="form-control @error('title') is-invalid @enderror" name="pay_period">
      <option value="daily" @selected(($employee->pay_period ?? '') === 'daily')>Daily</option>
      <option value="weekly" @selected(($employee->pay_period ?? '') === 'weekly')>Weekly</option>
      <option value="biweekly" @selected(($employee->pay_period ?? '') === 'biweekly')>Bi-Weekly</option>
      <option value="monthly" @selected(($employee->pay_period ?? '') === 'monthly')>Monthly</option>
    </select>
  </div>
  <div class="col-md-4">
    <label for="pay_rate" class="form-label">Salary</label>
    <input type="number" min="0" step="1" value="{{ isset($employee) ? $employee->pay_rate : '' }}"
      class="form-control @error('title') is-invalid @enderror" name="pay_rate">
  </div>
</div>
<div class="mb-3">
  <label for="title" class="form-label">Job Title</label>
  <input type="text" value="{{ isset($employee) ? $employee->title : '' }}"
    class="form-control @error('title') is-invalid @enderror" name="title">
</div>
