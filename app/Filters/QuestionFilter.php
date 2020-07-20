<?php

namespace App\Filters;

use App\Models\User;
use Illuminate\Http\Request;

class QuestionFilter
{
    protected $request;
    protected $queryBuilder;
    protected $filters = ['by', 'popularity', 'unanswered'];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->queryBuilder = $builder;

        // 得到 $this->>filters 属性中存在且在请求中传入的过滤条件
        $filters = array_filter($this->request->only($this->filters));

        foreach ($filters as $filter => $value) {
            // 在此处，$filter 即为方法名
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->queryBuilder;
    }

    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrfail();

        $this->queryBuilder->where('user_id', $user->id);
    }

    public function popularity()
    {
        $this->queryBuilder->orderBy('answers_count', 'desc');
    }

    public function unanswered()
    {
        $this->queryBuilder->where('answers_count', '=', 0);
    }
}
