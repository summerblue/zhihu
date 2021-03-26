<ul class="list-unstyled">
  @foreach ($answers as $index => $answer)
    @include('questions._answer')
    @if ( ! $loop->last)
      <hr>
    @endif
  @endforeach
</ul>
