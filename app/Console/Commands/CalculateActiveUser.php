<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CalculateActiveUser extends Command
{
    protected $signature = 'zhihu:calculate-active-user';

    protected $description = '计算活跃用户';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(User $user)
    {
        // 在命令行打印一行信息
        $this->info("开始计算...");

        $user->calculateAndCacheActiveUsers();

        $this->info("成功生成！");
    }
}
