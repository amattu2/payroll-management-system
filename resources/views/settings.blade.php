<!DOCTYPE html>
<html lang="EN">
  <head>
    <title>{{ config('app.name') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  </head>
  <body>
    @include('partials.navbar')
    @include('partials.errors')

    <div class="container-fluid">
      @include('partials.sidebar')

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
          <h1 class="h2">Settings</h1>
        </div>
        <div class="card shadow-sm mb-3">
          <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
              <li class="nav-item">
                <a class="nav-link active" href="#">Application</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Notifications</a>
              </li>
            </ul>
          </div>
          <div class="card-body">
            <h5 class="mb-0">Notifications Settings</h5>
            <p>Select notification you want to receive</p>
            <hr class="my-4" />
            <strong class="mb-0">Security</strong>
            <p>Control security alert you will be notified.</p>
            <div class="list-group mb-5">
              <div class="list-group-item">
                <div class="row align-items-center">
                  <div class="col">
                    <strong class="mb-0">Unusual activity notifications</strong>
                    <p class="text-muted mb-0">Donec in quam sed urna bibendum tincidunt quis mollis
                      mauris.</p>
                  </div>
                  <div class="col-auto">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" id="alert1" checked="" />
                      <span class="custom-control-label"></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="list-group-item">
                <div class="row align-items-center">
                  <div class="col">
                    <strong class="mb-0">Unauthorized financial activity</strong>
                    <p class="text-muted mb-0">Fusce lacinia elementum eros, sed vulputate urna eleifend
                      nec.</p>
                  </div>
                  <div class="col-auto">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" id="alert2" />
                      <span class="custom-control-label"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr class="my-4" />
            <strong class="mb-0">System</strong>
            <p>Please enable system alert you will get.</p>
            <div class="list-group">
              <div class="list-group-item">
                <div class="row align-items-center">
                  <div class="col">
                    <strong class="mb-0">Notify me about new features and updates</strong>
                    <p class="text-muted mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    </p>
                  </div>
                  <div class="col-auto">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" id="alert3" checked="" />
                      <span class="custom-control-label"></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="list-group-item">
                <div class="row align-items-center">
                  <div class="col">
                    <strong class="mb-0">Notify me by email for latest news</strong>
                    <p class="text-muted mb-0">Nulla et tincidunt sapien. Sed eleifend volutpat
                      elementum.</p>
                  </div>
                  <div class="col-auto">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" id="alert4" checked="" />
                      <span class="custom-control-label"></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="list-group-item">
                <div class="row align-items-center">
                  <div class="col">
                    <strong class="mb-0">Notify me about tips on using account</strong>
                    <p class="text-muted mb-0">Donec in quam sed urna bibendum tincidunt quis mollis
                      mauris.</p>
                  </div>
                  <div class="col-auto">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" id="alert5" />
                      <span class="custom-control-label"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
      new Chart(document.getElementById('overviewChart'), {
        type: 'bar',
        data: {
          labels: [
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday'
          ],
          datasets: [{
              label: "John Doe",
              data: [
                3,
                4,
                8,
                4,
                11,
                9,
                12
              ],
              lineTension: 0,
              backgroundColor: '#0d6efd'
            },
            {
              label: "Bob Smith",
              data: [
                8,
                9,
                6,
                0,
                9,
                8,
                5
              ],
              lineTension: 0,
              backgroundColor: '#6610f2'
            }
          ],
          options: {
            scales: {
              x: {
                stacked: true
              },
              y: {
                stacked: true
              }
            }
          }
        }
      });
    </script>
  </body>
</html>
