<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function appendVotedAttribute($item)
    {
        $item->isVotedUp = $item->isVotedUp(Auth::user());
        $item->isVotedDown = $item->isVotedDown(Auth::user());

        return $item;
    }
}
