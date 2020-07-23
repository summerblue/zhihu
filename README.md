## 说明

本项目作为 https://learnku.com/courses/laravel-testing 课程的示例项目，为您演示如何在 Laravel 中编写测试。

---

## 安装步骤

基于 Homestead，请见请参考文档进行配置 https://learnku.com/docs/laravel-development-environment。


## 1. 拉取代码

```
git clone https://gitee.com/nofirst/larazhihu.git
```

## 2. 新增站点

在 `Homestead.yaml` 文件中新增 `larazhihu` 应用的 `sites` 和 `databases` 的相关设置

```
ip: "192.168.10.10"
memory: 2048
cpus: 1
provider: virtualbox

authorize: ~/.ssh/id_rsa.pub

keys:
    - ~/.ssh/id_rsa

folders:
    - map: ~/Code
      to: /home/vagrant/Code

sites:
    - map: homestead.test
      to: /home/vagrant/Code/Laravel/public
    - map: zhihu.test # <--- 这里
      to: /home/vagrant/Code/larazhihu/public # <--- 这里

databases:
    - homestead
    - zhihu # <--- 这里
    - zhihu-dusk # <--- 这里，dusk 测试需要的

variables:
    - key: APP_ENV
      value: local

# blackfire:
#     - id: foo
#       token: bar
#       client-id: foo
#       client-token: bar

# ports:
#     - send: 93000
#       to: 9300
#     - send: 7777
#       to: 777
#       protocol: udp
```

## 3. 添加 `host`

```
192.168.10.10  zhihu.test
```

## 4. 安装依赖

```
composer install
```

## 5. 安装前端依赖并编译

```
npm install && npm run dev
```

## 6. 环境变量

环境变量：

```
cp .env.example .env
```


## 7. 生成应用 `secret`

```
php artisan key:generate
```

## 8. 运行数据库迁移和数据填充

```
php artisan migrate --seed
```

## 9. 运行测试

```
phpunit --exclude-group online
```

>注：`online` 组包含实时调用百度翻译`API`的测试，需要先配置`BAIDU_TRANSLATE_APPID`与`BAIDU_TRANSLATE_KEY`

## 10. 运行`dusk`测试

### 10.1 安装扩展

```
php artisan dusk:install
```

### 10.2 命令行运行测试

```
php artisan dusk
```

### 10.3 或者浏览器界面运行

```
php artisan dusk:dashboard
```

>注1：`dusk` 测试需要依托 `Chrome` 。
>注2：`dusk` 测试读取单独的配置文件 `env.dusk.local` 的内容，需要按照文件上面的配置提供数据库。



## 11. 其他注意事项：

### 11.1 图片显示 404 问题

如果用户头像图片显示 404，且为 `storage/**.jpg` 获取资源失败，参照如下处理：

首先进入 `/public` 文件夹，然后执行：

```
rm storage
```

接着切换到项目根目录，并执行：

```
php artisan storage:link
```

### 11.2 `pre-push` git 钩子

设置单元测试的 Git 钩子，确保 Push 到主仓库前代码能通过测试。

钩子文件请见 `resources/scripts/git-hooks/pre-push`。

修改文件为可执行：

```
chmod 755 resources/scripts/git-hooks/pre-push
```

执行以下命令即可：

```
cp resources/scripts/git-hooks/pre-push .git/hooks/pre-push
```
