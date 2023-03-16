<?php 

namespace App\Models;
use DB;
trait UserTrait {


    //es: desde aqui
    //en: from here

    public function roles(){
        
        return $this->belongsToMany('App\Models\Role');

    }

    public function havePermission($permission){
        $roles_usuario =DB::select('exec sp_roles ?,?,?,?,?,?,?', array("",$this->persona_id,"","","","",20));
        foreach ($roles_usuario as $role ) {
            $roles_permisos =DB::select('exec sp_roles ?,?,?,?,?,?,?', array($role->rol_id,"","","","","",21));
            foreach ($roles_permisos as $perm) {
                if ($perm->tar_url == $permission ) {
                    return true;
                }   
            }
        }
        return false;
    }


}