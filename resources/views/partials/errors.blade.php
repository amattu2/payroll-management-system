@if ($errors->any())
  @if (count($errors->all()) > 4)
    <div class="alert alert-danger" role="alert">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{$error}}</li>
        @endforeach
      </ul>
    </div>
  @else
    @foreach ($errors->all() as $error)
      <div class="alert alert-danger" role="alert">
        {{$error}}
      </div>
    @endforeach
  @endif
@endif
