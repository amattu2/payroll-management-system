<div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Hours</th>
        <th scope="col">Salary</th>
        <th scope="col">Status</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($employees as $employee)
        <tr>
          <td>{{str_pad($employee->id, 4, "0", STR_PAD_LEFT)}}</td>
          <td>{{$employee->firstname}} {{$employee->lastname}}</td>
          <td>{{$employee->email}}</td>
          <td>0</td>
          <td>0</td>
          <td>Terminated</td>
        </tr>
      @empty
        <tr>
          <td class="text-center" colspan="6"></td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
