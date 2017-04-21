# 微商城

> laravel5.4

> 后台模板adminlet

### 安装步骤
1. 配置 .env
2. composer install
3. php artisan migrate --seed 
    - 在AdminsTableSeeder中可以配置 用户名密码

4. php artisan serve 启动服务器
    - 前后台分表 前台为users表,后台为admins表
    - 后台地址为 /admin

