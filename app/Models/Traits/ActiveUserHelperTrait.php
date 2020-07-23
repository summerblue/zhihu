<?php

namespace App\Models\Traits;

use App\Models\Answer;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

trait ActiveUserHelperTrait
{
    // 用于存放临时用户数据
    protected $users = [];

    // 配置信息
    protected $question_weight = 4;
    protected $answer_weight = 1;
    protected $pass_days = 7;    // 多少天内发表过内容
    protected $user_number = 6; // 取出来多少用户

    // 缓存相关配置
    protected $cache_key = 'zhihu_active_users';
    protected $cache_expire_in_seconds = 60 * 60;

    public function getActiveUsers()
    {
        // 先尝试获取缓存，获取不到则重新获取活跃用户，并存入缓存
        return Cache::remember($this->cache_key, $this->cache_expire_in_seconds, function () {
            return $this->calculateActiveUsers();
        });
    }

    public function calculateAndCacheActiveUsers()
    {
        // 取得活跃用户列表
        $activeUsers = $this->calculateActiveUsers();
        // 加以缓存
        $this->cacheActiveUsers($activeUsers);
    }

    private function calculateActiveUsers()
    {
        $this->calculateQuestionScore();
        $this->calculateAnswerScore();

        // 数组按照得分排序
        $users = Arr::sort($this->users, function ($user) {
            return $user['score'];
        });

        // 我们需要的是倒序，高分靠前，第二个参数为保持数组的 KEY 不变
        $users = array_reverse($users, true);

        // 只获取我们想要的数量
        $users = array_slice($users, 0, $this->user_number, true);

        // 新建一个空集合
        $activeUsers = collect();

        foreach ($users as $userId => $user) {
            // 数据库里是否有该用户的话
            $user = $this->find($userId);

            // 如果数据库里有的话
            if ($user) {
                // 将此用户实体放入集合的末尾
                $activeUsers->push($user);
            }
        }

        // 返回数据
        return $activeUsers;
    }

    private function calculateQuestionScore()
    {
        $questionUsers = Question::query()->select(DB::raw('user_id, count(*) as question_count'))
            ->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))
            ->groupBy('user_id')
            ->get();
        // 根据 Question 数量计算得分
        foreach ($questionUsers as $value) {
            // question_count 大于 0 才计算
            if ($value->question_count > 0) {
                $this->users[$value->user_id]['score'] = $value->question_count * $this->question_weight;
            }
        }
    }

    private function calculateAnswerScore()
    {
        $answerUsers = Answer::query()->select(DB::raw('user_id, count(*) as answer_count'))
            ->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))
            ->groupBy('user_id')
            ->get();
        // 根据 Answer 数量计算得分
        foreach ($answerUsers as $value) {
            // answer_count 大于 0 才计算
            if ($value->answer_count > 0) {
                $answer_score = $value->answer_count * $this->answer_weight;
                if (isset($this->users[$value->user_id])) {
                    $this->users[$value->user_id]['score'] += $answer_score;
                } else {
                    $this->users[$value->user_id]['score'] = $answer_score;
                }
            }
        }
    }

    private function cacheActiveUsers($activeUsers)
    {
        // 将数据放入缓存中
        Cache::put($this->cache_key, $activeUsers, $this->cache_expire_in_seconds);
    }
}
