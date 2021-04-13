<question :attributes="{{ $question }}" inline-template>
  <li class="media">
    <div class="media-body">
      <div class="media-heading mt-1 mb-1">
        <a class="text-dark" href="{{ route('questions.show', [$question->category, $question->id, $question->slug]) }}" title="{{ $question->title }}">
          {{ $question->title }}
        </a>
        <a class="float-right text-muted">
          <i class="far fa-clock"></i>
          <span class="timeago">{{ $question->updated_at->diffForHumans() }}</span>
        </a>
      </div>

      <small class="media-body meta text-muted mt-2">
        <question-affect :question="{{ $question }}" :display="false"></question-affect>
      </small>
    </div>
  </li>
</question>
