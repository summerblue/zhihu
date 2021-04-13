<?php

namespace App\Filters;

use App\Models\User;
use Illuminate\Http\Request;

class QuestionFilter
{
    protected $request;
    protected $queryBuilder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->queryBuilder = $builder;

        if ($username = $this->request->by) {
            $this->by($username);
        }

        return $this->queryBuilder;
    }

    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrfail();

        return $this->queryBuilder->where('user_id', $user->id);
    }
}
