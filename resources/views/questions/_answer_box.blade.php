@include('shared._error')

<div class="answer-box pt-4 pl-4 pr-4">
  <form action="/questions/{{ $question->id }}/answers" method="POST" accept-charset="UTF-8">
    {{ csrf_field() }}
    <div class="form-group">
      <textarea class="form-control" rows="3" placeholder="让我来回答~" name="content"></textarea>
    </div>
    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-share mr-1"></i> 发布回答</button>
  </form>
</div>
<hr>
