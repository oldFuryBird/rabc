<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/8 0008
 * Time: 下午 2:14
 */

namespace Rabc;


use Rabc\Contracts\PermissionInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model implements PermissionInterface
{
    protected $table='permissions';
    protected $fillable=['name','display_name','description'];
    public function roles(): BelongsToMany
    {
        // TODO: Implement roles() method.
        return $this->belongsToMany(Role::class,'permission_role','permission_id','role_id');
    }


}