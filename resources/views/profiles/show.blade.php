@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-offset-2">
      <div class="page-header">
        <h1>
          {{ $profileUser->name }}
          <small>注册于{{ $profileUser->created_at->diffForHumans() }}</small>
        </h1>
      </div>

      @can('update', $profileUser)
      <form method="POST" action="{{ route('user-avatars.store', $profileUser) }}" enctype="multipart/form-data">
        {{ csrf_field() }}

        <input type="file" name="avatar">

        <button type="submit" class="btn btn-primary">上传头像</button>
      </form>

      <img src="{{ $profileUser->userAvatar }}" width="200" height="200">
      @endcan

      @foreach($activities as $activity)
      <li class=" media">
        <div class="media-body">
          <div class="media-heading mt-0 mb-1 text-secondary">
            <a class="float-right">

              <span class="meta text-secondary" title="{{ $activity->created_at }}">{{ $activity->created_at->diffForHumans() }}</span>
            </a>

          </div>
          <div class="comment-content text-secondary">
            @include("profiles.activities.{$activity->type}")
          </div>
        </div>

      </li>
      <hr>
      @endforeach

    </div>
  </div>
</div>
@endsection
