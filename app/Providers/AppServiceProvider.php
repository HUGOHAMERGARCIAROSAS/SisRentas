<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use View;
use App\Models\Grupo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        
            view()->composer('*', function ($view) 
            {
                if(Auth::check()) {
                    $grupos =DB::select('exec sp_roles ?,?,?,?,?,?,?', array("",Auth::user()->persona_id,"","","","",32));

                    $tareas =DB::select('exec sp_roles ?,?,?,?,?,?,?', array("",Auth::user()->persona_id,"","","","",33));

                    foreach($grupos as $post)
                    {
                        $post->tareas = array_filter($tareas, function($comment) use ($post) {
                            return $comment->grupo_id === $post->grupo_id;
                        });
                    }

                    View::share(['grupos' => $grupos]);
                }
            });  
        

        // $Headercategory = Grupo::whereHas('orderTareas', function($q) { 
        //     $q->where('gru_activo','=','1'); 
        // })->with(['orderTareas' => function($q) { 
        //     $q->where('tar_activo','=','1')->where('menu','=','1'); 
        // }])->get();

        // View::share(['Headercategory' => $Headercategory]);
    }
}
