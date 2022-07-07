<div class="align-items-center bg-dark d-flex justify-content-center p-2 rounded-circle text-white {{ $classes ?? '' }}"
  style="height: {{ $size ?? 32 }}px; width: {{ $size ?? 32 }}px;">
  @if (isset($e) && $e instanceof \App\Models\Employee)
    {{ $e?->firstname[0] }}{{ $e?->lastname[0] }}
  @elseif (isset($name))
    {{ $name[0] }}{{ explode(' ', $name)[1][0] ?? '' }}
  @else
    ??
  @endif
</div>
