<div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Hire Date</th>
        <th scope="col">Pay Rate</th>
        <th scope="col">Status</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($employees as $employee)
        <tr>
          <td>{{str_pad($employee->id, 4, "0", STR_PAD_LEFT)}}</td>
          <td>{{$employee->firstname}} {{$employee->lastname}}</td>
          <td>{{$employee->email}}</td>
          <td>{{$employee->hired_at}}</td>
          <td>${{number_format($employee->pay_rate)}}</td>
          <td>{{ucfirst($employee->employment_status)}}</td>
        </tr>
      @empty
        <tr>
          <td class="text-center" colspan="6">No employees</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
