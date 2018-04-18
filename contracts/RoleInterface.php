<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/8 0008
 * Time: 下午 12:30
 */

namespace Wang\Rabc\Contracts;


use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface RoleInterface
{
    /**
     *  角色下面的用户
     * @return BelongsToMany
     */
    public function users(): BelongsToMany;

    /**
     *  角色拥有的权限
     * @return BelongsToMany
     */
    public function perms():BelongsToMany;

    /**
     * 保存相关的权限
     * @param $inputPermission
     * @return mixed
     */
    public function savePermissions($inputPermission);

    /** 添加权限
     * @param $permissions
     * @return mixed
     */
    public function attachPermission($permission);

    /** detach permission from current role
     * @param $permission
     * @return mixed
     */
    public function detachPermission($permission);

    /** 给角色添加多个权限
     * @param $permissions
     * @return mixed
     */
    public function attachPermissions($permissions);

    /** 解除多个权限
     * @param $permissions
     * @return mixed
     */
    public function detachPermissions($permissions);

}
