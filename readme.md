# 微商城

> laravel5.4

> 后台模板adminlet

### Demo

前台: [http://123.207.65.111/](http://123.207.65.111/)

后台: [http://123.207.65.111/admin](http://123.207.65.111/admin)   账号 admin@admin.com 密码 admin

### 安装步骤
1. cp .env.example .env 配置 .env
2. composer install
3. php artisan migrate --seed 
    - 在AdminsTableSeeder中可以配置 用户名密码
    - 默认账号 admin@mail.com 密码 admin
4. php artisan storage:link

5. php artisan serve 启动服务器
    - 前后台分表 前台为users表,后台为admins表
    - 后台地址为 /admin

### .env配置

6.  `WECHAT_ENABLE_MOCK=true` 表示是否开启模拟登陆,若没有设置WECHAT_ENABLE_MOCK 则会读取`APP_DEBUG`的值来判断是否开启模拟登陆
7. `WECHAT_APPID` ,`WECHAT_SECRET` 为公众号appid和secret



