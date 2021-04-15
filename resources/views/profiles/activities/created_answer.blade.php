<div class="panel panel-default">
  <div class="panel-heading">
    <div class="level">
      <span class="flex">
        {{ $profileUser->name }} 发表了回答
      </span>
    </div>
  </div>

  <div class="panel-body">
    {!! $activity->subject->content !!}
  </div>
</div>
