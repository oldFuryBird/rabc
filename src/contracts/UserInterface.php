<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/8 0008
 * Time: 下午 12:30
 */

namespace Rabc\Contracts;


use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface UserInterface
{
    /** 用户拥有的角色
     * @return BelongsToMany
     */
    public function roles():BelongsToMany;

    /** 检查用户时候有名称为$name的角色,
     * @param $name
     * @param bool $requireAll $requireAll $name 如果时数组，那么所有的角色都必须有
     * @return bool
     */

    public function hasRole($name,$requireAll=false):bool;

    /** 是否有某个或多个权限
     * @param $permission
     * @param bool $requireAll 如果permission是数组，那么，必须满足全部的条件
     * @return bool
     */
    public function can($permission,$requireAll=false):bool;

    /** 检查角色和权限
     * @param $roles
     * @param $permission
     * @param array $options
     * @return mixed
     */
    public function ability($roles,$permission,$options=[]);

    /** 添加角色
     * @param $role
     * @return mixed
     */
    public function attachRole($role);

    /** 解除角色
     * @param $role
     * @return mixed
     */
    public function detachRole($role);

    /** 添加多个角色
     * @param $roles
     * @return mixed
     */
    public function attachRoles($roles);

    /** detach multiple roles
     * @param $roles
     * @return mixed
     */
    public function detachRoles($roles);
}