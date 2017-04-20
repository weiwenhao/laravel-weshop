# RABC权限控制后台模板

> laravel5.4

> 后台模板adminlet

> entrust

### 示例图片
![](http://omjq5ny0e.bkt.clouddn.com/17-3-24/20717489-file_1490327092851_3541.png)

![](http://omjq5ny0e.bkt.clouddn.com/17-3-24/13942523-file_1490327120859_1cf4.png)

![](http://omjq5ny0e.bkt.clouddn.com/17-3-24/38781140-file_1490327154306_bb3.png)

### 安装步骤
1. 配置 .env
2. composer install
3. php artisan migrate --seed 
    - 在AdminsTableSeeder中可以配置 用户名密码

4. php artisan serve 启动服务器
    - 前后台分表 前台为users表,后台为admins表
    - 后台地址为 /admin

