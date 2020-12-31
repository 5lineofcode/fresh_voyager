<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Controller;
use DB;
use Illuminate\Support\Str;

class CrudGeneratorController extends Controller
{
    public function index($endpoint)
    {
        return DB::table($endpoint)->paginate(10);
    }

    public function single_item($endpoint, $id)
    {
        return DB::table($endpoint)
                    ->where("id",$id)
                    ->paginate(10);
    }

    public function create($endpoint, $postdata) {
        $id = DB::table($endpoint)->insertGetId($postdata);
        return response()->json([
            "id" => $id,
            "success" => true
        ]);
    }

    public function update($endpoint,$id, $postdata){
        $is_success = DB::table($endpoint)
                ->where("id", $id)
                ->update($postdata);

        return response()->json([
            "id" => $id,
            "success" => $is_success
        ]);
    }

    public function delete($endpoint,$id){
        $is_success = DB::table($endpoint)
            ->where("id", $id)
            ->delete();

        return response()->json([
            "id" => $id,
            "success" => $is_success
        ]);
    }

    public function definition(){

        $database_name = env("DB_DATABASE");
        $tables =  DB::select("
            SELECT table_name FROM information_schema.tables
            WHERE table_schema = '$database_name';
        ");


        $queryResponse = [];
        $menu_definition = [];

        for($n=0; $n<count($tables); $n++) {

            $table = $tables[$n];
            $endpoint = $table->table_name;
            
            $form_definition = [];
            $table_definition = [];
    
            $items =  DB::select("SHOW COLUMNS FROM $endpoint");
            
            for($i=0; $i<count($items) ;$i++){
                $item = $items[$i];
    
                $field = $item->Field;
                $type = $item->Type;
                $nullable = $item->Null;
                $key = $item->Key;
                $extra = $item->Extra;
    
                array_push($form_definition,[
                    "field" => $field,
                    "type" => $type,
                    "nullable" => $nullable,
                    "key" => $key,
                    "extra" => $extra,
                    "title_name" => Str::title(Str::of($field)->replace("_"," "))
                ]);
    
                
                array_push($table_definition,[
                    "field" => $field,
                    "type" => $type,
                    "nullable" => $nullable,
                    "key" => $key,
                    "extra" => $extra,
                    "title_name" => Str::title(Str::of($field)->replace("_"," "))
                ]);
    
            }
    
            $form_view_name = Str::title(Str::of($endpoint)->replace("_"," "));
            $list_view_name = Str::title(Str::of($endpoint)->replace("_"," "));
    
            array_push($menu_definition, [
                "icon" => null,
                "label" => Str::title(Str::of($endpoint)->replace("_"," ")),
                "route" => "/$endpoint",
                "endpoint" => "$endpoint",
                "color" => null
            ]);

            array_push($queryResponse, [
                "endpoint" => $endpoint,
                "form_view_name" => $form_view_name,
                "list_view_name" => $list_view_name,
                "form_definition" => $form_definition,
                "table_definition" => $table_definition,
            ]);
        }

        return response()->json([
            "data" => [
                "module_definition" => $queryResponse,
                "menu_definition" => $menu_definition
            ]
        ]);
    }

    public function databaseIndex(){

        $database_name = env("DB_DATABASE");
        $tables =  DB::select("
            SELECT table_name FROM information_schema.tables
            WHERE table_schema = '$database_name';
        ");
        
        return response()->json([
            "data" => $tables
        ]);
    }
}