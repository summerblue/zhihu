<div class="panel panel-default">
    <div class="panel-heading">
        <div class="level">
            <span class="flex">
                {{ $profileUser->name }} 发布了问题
            </span>
        </div>
    </div>

    <div class="panel-body">
        {!!   $activity->subject->content !!}
    </div>
</div>
