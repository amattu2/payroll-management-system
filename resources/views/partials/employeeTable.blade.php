<div class="table-responsive">
  <table class="table table-striped table-bordered mb-0 table-sm">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Hire Date</th>
        <th scope="col">Pay Rate</th>
        <th scope="col">Status</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @forelse ($employees as $employee)
        @if (isset($employment_status) && $employee->employment_status !== $employment_status)
          @continue
        @endif
        <tr>
          <td>{{ str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}</td>
          <td>{{ $employee->firstname }} {{ $employee->lastname }}</td>
          <td>{{ $employee->email }}</td>
          <td>{{ $employee->hired_at }}</td>
          <td>${{ number_format($employee->pay_rate) }}</td>
          <td>{{ ucfirst($employee->employment_status) }}</td>
          <td>
            <a href="{{ Route('employees.employee', $employee->id) }}" class="text-primary" role="button">View</a>
          </td>
        </tr>
      @empty
        <tr>
          <td class="text-center" colspan="7">No employees</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
