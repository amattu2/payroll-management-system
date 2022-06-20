<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
  <h1 class="h2">Overview</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
    <button type="button" class="btn btn-sm btn-outline-secondary me-2">Export</button>
    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
      <span data-feather="calendar" class="align-text-bottom"></span>
      This week
    </button>
  </div>
</div>

<canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>

<h2>Employees</h2>
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
          <td></td>
        </tr>
      @empty
        <tr>
          <td class="text-center" colspan="6"></td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
