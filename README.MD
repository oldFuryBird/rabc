# rabc
## 基于角色管理权限扩展
  require laravel:~5.6
### 安装
` composer require oldfurybird/rabc`

或

`git clone git@github.com:oldFuryBird/rabc.git vendor/oldfurybird/rabc/`

### 使用
1. 注册服务，在 config\app 中

```php        
      'providers'=>[
          ...
        /*
         * Package Service Providers...
         */
         Rabc\RabcServiceProvider::class,
        ...
      ],
```

2. 默认使用 App\User 模型作为用户模型 可以在config/rabc.php 中修改
3. 当用户表migrate成功之后

` php artisan rabc:install `

允许mirgrate

### User 需要implements UserInterface接口
  - hasRole()
  - roles($role_name)
  - can($permission[s]) 能否通过权限测试
  - attachRole[s]/detachRole[s] 添加删除角色
  通过 use Rabc\RabcUserTrait  trait 具体实现

### middleware
    在Kernel.php 添加中间件  Rabc\Middleware\TrustRole,Rabc\Middleware\TrustPermission
    控制路由访问权限等功能
    $this->middleware('role:test|test_2'); // test或test_2角色可以访问
    $this->middleware('perm:test1');// test1 权限通过的用户可以访问

### 实例
```php
 $role = Role::create(['name'=>'test','display_name'=>'测试','description'=>'能否通过?']);
 $user->attachRole($role);
 $user->hasRole('test');//true;
 $user->can('test_perm');//false;

 $permission = Permission::create(['name'=>'test_perm','display_name'=>'测试权限','description'=>'能否通过?']);
 $role->attachPermission($permission);
 $user->can('test_perm');//true;
```

## 反馈
  如果您有任何建议和意见可以给我issue或者反馈[ccwc3@163.com](ccwc3@163.com)
