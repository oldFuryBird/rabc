<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/8 0008
 * Time: 下午 2:14
 */

namespace Wang\Rabc;
use Wang\Rabc\Contracts\RoleInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Role extends Model implements RoleInterface
{
    protected $table = 'roles';
    protected $fillable=['name','display_name','description'];
    public function users(): BelongsToMany
    {
        // TODO: Implement users() method.
        return $this->belongsToMany(config('rabc.user'), 'role_user', 'user_id', 'role_id');
    }

    public function perms(): BelongsToMany
    {
        // TODO: Implement perms() method.
        return $this->belongsToMany(Permission::class, 'permission_role', 'permission_id', 'role_id');
    }

    public function savePermissions($inputPermission)
    {
        // TODO: Implement savePermissions() method.

    }

    public function attachPermission($permission)
    {
        // TODO: Implement attachPermission() method.
        if (is_object($permission)) {
            $permission = $permission->getKey();
        } elseif (is_array($permission)) {
            throw new \Exception('permission given as array,you should use attachPermissions');
        }
        $this->perms()->attach($permission);
    }

    public function detachPermission($permission)
    {
        // TODO: Implement detachPermission() method.
        if (is_object($permission)) {
            $permission = $permission->getKey();
        } elseif (is_array($permission)) {
            throw new \Exception('permission given as array,you should use detachPermissions');
        }
        $this->perms()->detach($permission);
    }

    public function attachPermissions($permissions)
    {
        // TODO: Implement attachPermissions() method.
        if (is_array($permissions)) {
            foreach ($permissions as $perm) {
                $this->attachPermission($perm);
            }
        } else {
            throw new \Exception('permissions must be an array');
        }

    }

    public function detachPermissions($permissions = null)
    {
        // TODO: Implement detachPermissions() method.
        // null  for detach all
        if (!$permissions) $permissions = $this->perms()->get();
        if (is_array($permissions)) {
            foreach ($permissions as $perm) {
                $this->detachPermission($perm);
            }
        } else {
            throw new \Exception('permissions must be an array');
        }
    }

    /** 当前角色是否有某权限
     * @param $name
     * @param bool $requireAll 是否全部拥有
     * @return bool
     */
    public function hasPermission($name, $requireAll = false):bool
    {
        $perms = $this->perms()->get();
        if (is_array($name)) {
            $names = collect($name);
            if ($requireAll) {
                return $names->every(function ($value) use ($perms) {
                    return $perms->contains('name', $value);
                });
            } else {
                return $names->isNotEmpty() && $names->filter(function ($value) use ($perms) {
                        return $perms->contains('name', $value);
                    })->isNotEmpty();
            }
        }
        return $perms->contains('name', $name);
    }
}