<answer :attributes="{{ $answer }}" inline-template>
    <li class="media" name="answer{{ $answer->id }}" id="answer{{ $answer->id }}">
        <div class="media-left">
            <a href="#">
                <img class="media-object img-thumbnail mr-3" alt="{{ $answer->owner->name }}" src="{{ $answer->owner->userAvatar }}" style="width:48px;height:48px;" />
            </a>
        </div>

        <div class="media-body">
            <div class="media-heading mt-0 mb-1 text-secondary">
                <a href="#" title="{{ $answer->owner->name }}">
                    {{ $answer->owner->name }}
                </a>
                <span class="text-secondary"> • </span>
                <span class="meta text-secondary" title="{{ $answer->created_at }}">{{ $answer->created_at->diffForHumans() }}</span>

                <a class="float-right" >
                    @if($answer->isBest())
                        <button class="btn btn-warning btn-sm"><i class="fa fa-check"></i> 最佳答案</button>
                    @else
                        @can('update', $question)
                            <form action="/answers/{{ $answer->id }}/best" method="POST" accept-charset="UTF-8">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-primary btn-sm">设为最佳</button>
                            </form>
                        @endcan

                        @can('delete', $answer)
                            <form action="/answers/{{ $answer->id }}" method="POST" accept-charset="UTF-8">
                                {{ method_field("DELETE") }}
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-primary btn-sm">删除</button>
                            </form>
                        @endcan
                    @endif
                </a>

            </div>

            <div class="answer-content text-secondary">
                <p v-html="content"></p>
            </div>

            <small class="media-body meta text-secondary">
                <a class="text-secondary" role="button" href="#" data-toggle="modal" data-target="#modal{{$answer->id}}">
                    <i class="fa fa-comments"></i>
                    {{ $answer->comments_count }} 个评论
                </a>

                <div class="modal fade" id="modal{{$answer->id}}" tabindex="-1" role="dialog" aria-labelledby="modal{{$answer->id}}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" >
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="modal{{$answer->id}}">
                                    评论列表
                                </h4>
                            </div>
                            <div class="modal-body">
                                <comments :data="{{ $answer->comments }}" :subject="{{ $answer }}"></comments>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
                <span> • </span>

                <answer-affect :answer="{{ $answer }}" v-if="signedIn"></answer-affect>
            </small>
        </div>
    </li>
</answer>
