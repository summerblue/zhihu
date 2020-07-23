@extends('layouts.app')

@section('title', '问题列表')

@section('content')

    <div class="row mb-5">
        <div class="col-lg-9 col-md-9 topic-list">
            <div class="card ">

                <div class="card-body">
                    {{-- 问题列表 --}}
                    @if (count($questions))
                        <ul class="list-unstyled">
                            @foreach ($questions as $question)
                                @include('questions._question')

                                @if ( ! $loop->last)
                                    <hr>
                                @endif

                            @endforeach
                        </ul>
                    @else
                        <div class="empty-block">暂无数据 ~_~ </div>
                    @endif
                    {{-- 分页 --}}
                    <div class="mt-5">
                        {!! $questions->appends(Request::except('page'))->render() !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 sidebar">
            @include('questions._sidebar')
        </div>
    </div>

@endsection
