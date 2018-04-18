<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/18 0018
 * Time: 下午 4:01
 */
namespace Wang\Rabc\Traits;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
Use Wang\Rabc\Role;

trait RabcUserTrait
{
    /**
     * @param string $permission
     * @param bool $requireAll false 用户只要通过一个权限就可以放行，true,用户必须通过全部权限
     * @return bool
     */
    public function can($permission, $requireAll = false): bool
    {
        $perms = $this->permissions();
        if (is_array($permission)) {
            $input_perms = collect($permission);
            if ($requireAll) {
                return $input_perms->every(function ($perm) use ($perms) {
                    return $perms->contains($perm);
                });
            } else {
                return $input_perms->isNotEmpty() && $input_perms->filter(function ($perm) use ($perms) {
                        return $perms->contains($perm);
                    })->isNotEmpty();
            }
        }
        return $perms->contains($permission);
    }

    public function permissions()
    {
        $perms = collect();
        $this->roles()->get()->each(function ($role) use ($perms) {
            $perms->push($role->perms()->get()->pluck('name'));
        });
        return $perms->flatten()->unique();
    }

    public function roles(): BelongsToMany
    {
        // TODO: Implement roles() method.
        return $this->belongsToMany(Role::class, 'role_user', 'role_id', 'user_id');
    }

    /**
     *
     * @param $name
     * @param bool $requireAll 如果true,该用户是否拥有全部角色，false，是否有这些角色之一
     * @return bool
     */
    public function hasRole($name, $requireAll = false): bool
    {
        // TODO: Implement hasRole() method.
        $roles = $this->roles()->get();
        if (is_array($name)) {
            $names = collect($name);
            if ($requireAll) {
                return $names->every(function ($value) use ($roles) {
                    return $roles->contains('name', $value);
                });
            } else {
                return $names->isNotEmpty() && $names->filter(function ($value) use ($roles) {
                        return $roles->contains('name', $value);
                    })->isNotEmpty();
            }
        }
        return $roles->contains('name', $name);
    }

    public function ability($roles, $permission, $options = [])
    {
        // TODO: Implement ability() method.
    }

    public function attachRole($role)
    {
        // TODO: Implement attachRole() method.
        if (is_object($role)) {
            $role = $role->getKey();
        } elseif (is_array($role)) {
            throw new \InvalidArgumentException();
        }
        $this->roles()->attach($role);
    }

    public function detachRole($role)
    {
        // TODO: Implement detachRole() method.
        if (is_object($role)) {
            $role = $role->getKey();
        } elseif (is_array($role)) {
            throw new \InvalidArgumentException();
        }
        $this->roles()->detach($role);
    }

    public function attachRoles($roles)
    {
        // TODO: Implement attachRoles() method.
        if (!is_array($roles)) throw new \InvalidArgumentException();
        foreach ($roles as $role) {
            $this->attachRole($role);
        }
    }

    public function detachRoles($roles)
    {
        // TODO: Implement detachRoles() method.
        if (!is_array($roles)) throw new \InvalidArgumentException();
        foreach ($roles as $role) {
            $this->detachRole($role);
        }
    }
}