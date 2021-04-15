<div class="card ">
  <div class="card-body">
    <a href="/questions/create" class="btn btn-primary btn-block" aria-label="Left Align">
      <i class="fas fa-pencil-alt mr-2"></i> 提个问题？
    </a>
  </div>
</div>

@if (count($activeUsers))
<div class="card mt-4">
  <div class="card-body active-users pt-2">
    <div class="text-center mt-1 mb-0 text-muted">活跃用户</div>
    <hr class="mt-2">
    @foreach ($activeUsers as $activeUser)
    <a class="media mt-2" href="{{ route('users.show', $activeUser->id) }}">
      <div class="media-left media-middle mr-2 ml-1">
        <img src="{{ $activeUser->userAvatar }}" width="24px" height="24px" class="media-object">
      </div>
      <div class="media-body">
        <small class="media-heading text-secondary">{{ $activeUser->name }}</small>
      </div>
    </a>
    @endforeach
  </div>
</div>
@endif
