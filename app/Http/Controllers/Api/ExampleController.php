<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Controller;
use DB;

class ExampleController extends Controller
{
    public function index(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:posts|max:255',
            'content' => 'required'
        ]);

        $title = $request->input("title");
        $content = $request->input("content");
        $tag = $request->input("tag");

        $results = DB::select("select * from users");
        return json_encode($results);
    }
}