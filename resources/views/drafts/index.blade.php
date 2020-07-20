@extends('layouts.app')

@section('title', '草稿列表')

@section('content')
    <div class="row mb-5">
        <div class="col-lg-9 col-md-9 topic-list">
            <div class="card ">

                <div class="card-body">
                    @if (count($drafts))
                        <ul class="list-unstyled">
                            @foreach ($drafts as $draft)
                                <li class="media">
                                    <div class="media-body">
                                        <div class="media-heading mt-1 mb-1">
                                            {{ $draft->title }}

                                            <a class="text-muted" >
                                                <i class="far fa-clock"></i>
                                                <span class="timeago">创建于：{{ $draft->created_at->diffForHumans() }}</span>
                                            </a>
                                            <a class="float-right" >
                                                <form action="/questions/{{ $draft->id }}/published-questions" method="POST" accept-charset="UTF-8">
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-primary btn-sm">发布</button>
                                                </form>
                                            </a>
                                        </div>

                                    </div>
                                </li>

                                @if ( ! $loop->last)
                                    <hr>
                                @endif

                            @endforeach
                        </ul>

                    @else
                        <div class="empty-block">暂无数据 ~_~ </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
