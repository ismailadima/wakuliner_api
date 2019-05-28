<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Categories;

class CategoriesController extends Controller
{
    public function index()
    {
        $data = Categories::orderBy('category_name','asc')->get();
        return response($data);
    }

    public function show($id)
    {
        $data = Categories::where('id',$id)->get();
        return response($data);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'category_name' => 'required'
        ]);
        $input = $request->all();

        $data = new Categories;
        $data->category_name = $input['category_name'];
        $data->save();

        return response(['message'=>'Category created successfully']);
    }

    public function update(Request $request,$id)
    {
        $data = Categories::where('id',$id)->first();
        $data->category_name = $request->input('category_name');
        $data->save();

        return response(['message'=>'Category updated successfully']);
    }

    public function destroy($id)
    {
        $data = Categories::where('id',$id)->first();
        $data->delete();

        return response(['message'=>'Category deleted successfully']);
    }
}
