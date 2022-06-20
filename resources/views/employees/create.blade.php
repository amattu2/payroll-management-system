<!DOCTYPE html>
<html class="h-100" lang="EN">
  <head>
    <title>{{config('app.name')}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
 </head>

  <body class="h-100 w-100">
    @include("partials.navbar")

    <div class="container-fluid">
      @include("partials.sidebar")
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3 bg-light">
        @include("partials.errors")

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Create Employee</h5>
            <p class="card-text">Create a new employee below to begin tracking payroll, disembursements, & more!</p>
            <form method="POST" action="{{route("employees")}}">
              @csrf
              <div class="mb-3">
                <label for="firstname" class="form-label">First Name</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="firstname">
              </div>
              <div class="mb-3">
                <label for="middlename" class="form-label">Middle Name</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="middlename">
              </div>
              <div class="mb-3">
                <label for="lastname" class="form-label">Last Name</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="lastname">
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control @error('title') is-invalid @enderror" name="email">
                <div class="form-text">
                  This employee will not be granted access to this application. In order to grant access, you must create a separate user account for this employee.
                </div>
              </div>
              <div class="mb-3">
                <label for="telephone" class="form-label">Telephone</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="telephone">
              </div>
              <div class="row g-3 mb-3">
                <div class="col-12">
                  <label for="street1" class="form-label">Street #1</label>
                  <input type="text" class="form-control @error('title') is-invalid @enderror" name="street1" placeholder="1234 Main St">
                </div>
                <div class="col-12">
                  <label for="street2" class="form-label">Street #2</label>
                  <input type="text" class="form-control @error('title') is-invalid @enderror" name="street2" placeholder="Apartment, studio, or floor">
                </div>
                <div class="col-md-6">
                  <label for="city" class="form-label">City</label>
                  <input type="text" class="form-control @error('title') is-invalid @enderror" name="city">
                </div>
                <div class="col-md-4">
                  <label for="state" class="form-label">State</label>
                  <select name="state" class="form-select @error('title') is-invalid @enderror">
                    <option value="MD" selected>Maryland</option>
                  </select>
                </div>
                <div class="col-md-2">
                  <label for="zip" class="form-label">Zip</label>
                  <input type="text" class="form-control @error('title') is-invalid @enderror" name="zip">
                </div>
              </div>
              <div class="mb-3">
                <label for="birthdate" class="form-label">Date of Birth</label>
                <input type="date" class="form-control @error('title') is-invalid @enderror" name="birthdate">
              </div>
              <div class="mb-3">
                <label for="datehired" class="form-label">Date Hired</label>
                <input type="date" class="form-control @error('title') is-invalid @enderror" name="datehired">
              </div>
              <div class="mb-3">
                <label for="paytype" class="form-label">Pay Type</label>
                <select class="form-control @error('title') is-invalid @enderror" name="paytype">
                  <option value="hourly" selected>Hourly</option>
                  <option value="salary">Salary</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="payperiod" class="form-label">Pay Period</label>
                <select class="form-control @error('title') is-invalid @enderror" name="payperiod">
                  <option value="daily">Daily</option>
                  <option value="weekly">Weekly</option>
                  <option value="biweekly">Bi-Weekly</option>
                  <option value="monthly" selected>Monthly</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="salary" class="form-label">Salary</label>
                <input type="number" class="form-control @error('title') is-invalid @enderror" name="salary">
              </div>
              <div class="mb-3">
                <label for="title" class="form-label">Job Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title">
              </div>
              <button type="submit" class="btn btn-primary">Create</button>
              <a class="btn text-danger" href="{{route("employees")}}">Cancel</button>
            </form>
          </div>
        </div>
      </main>
    </div>

    <!-- Scripts -->
    <script src="{{asset('js/app.js')}}" defer></script>
  </body>
</html>
