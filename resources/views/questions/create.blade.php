@extends('layouts.app')

@section('content')

<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">

      <div class="card-body">
        <h2 class="">
          <i class="far fa-edit"></i>
          提个问题
        </h2>

        <hr>

        <form action="/questions" method="POST" accept-charset="UTF-8">

          {{ csrf_field() }}

          @include('shared._error')

          <div class="form-group">
            <input class="form-control" type="text" name="title" value="{{ old('title', $question->title ) }}" placeholder="请填写标题" required dusk="question-title" />
          </div>

          <div class="form-group">
            <select class="form-control" name="category_id" required dusk="question-category">
              <option value="" hidden disabled selected>请选择分类</option>
              @foreach ($categories as $value)
              <option value="{{ $value->id }}">{{ $value->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <textarea name="content" class="form-control" id="editor" rows="6" placeholder="请填入至少三个字符的内容。" required dusk="question-content">{{ old('content', $question->content ) }}</textarea>
          </div>

          <div class="well well-sm">
            <button type="submit" class="btn btn-primary" dusk="question-submit"><i class="far fa-save mr-2" aria-hidden="true"></i> 保存</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
