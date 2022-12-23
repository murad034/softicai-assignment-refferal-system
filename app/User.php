<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'email', 'password', 'name', 'refer_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public static function getpermissionGroups()
    {
       
        $permission_groups=DB::table('permissions')
        ->select('group_name as name')
        ->groupBy('group_name')
        ->get();

        

        return $permission_groups;
    }


    public static function getPermissionsByGroupName($group_name)
    {
        $permissions = DB::table('permissions')
            ->select('id', 'name')
            ->where('guard_name', 'web')
            ->where('group_name', $group_name)
            ->get();
        return $permissions;
    }
    public static function roleHasPermissions($role,$permissions)
    {
        $hasPermission=true;
        foreach ($permissions as $permission){
            if(!$role->hasPermissionTo($permission->name)){
                $hasPermission=false;
                return $hasPermission;
            }
        }
        return $hasPermission;
    }

    public function referrerFunc(){
        return $this->belongsTo(Refer::class, 'id', 'user_id');
    }

    public function totalRefer(){
        return $this->hasMany(Refer::class,'referrer','id');
    }

}
