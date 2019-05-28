<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Banner;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $param = $request->all();
        if($param['activated']=='1'){
            $data = Banner::where('status','1')->orderBy('id','desc')->get();
            return response($data);
        }
        
        $data = Banner::orderBy('id','desc')->get();
        return response($data);
    }

    public function show($id)
    {
        $data = Banner::where('id',$id)->get();
        return response($data);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'banner_name' => 'required',
            'image' => 'required',
            'link' => 'required'
        ]);
        $image = $request->file('image');
        $imageName = time().'-'.$image->getClientOriginalName();
        $destinationPath = storage_path('/upload/banner');
        $image->move($destinationPath,$imageName);

        $input = $request->all();

        $data = new Banner;
        $data->banner_name = $input['banner_name'];
        $data->image = $imageName;
        $data->link = $input['link'];
        $data->status = '1';
        $data->save();

        return response(['message'=>'Banner created successfully']);
    }

    public function update(Request $request,$id)
    {
        $data = Banner::where('id',$id)->first();
        $imageName = $data['image'];
        $input = $request->all();
        if($input['image']){
            $image = $request->file('image');
            $imageName = time().'-'.$image->getClientOriginalName();
            $destinationPath = storage_path('/upload/banner');
            $image->move($destinationPath,$imageName);
            
        }

        $data->banner_name = $input['banner_name'];
        $data->image = $imageName;
        $data->link = $input['link'];
        $data->status = $input['status'];
        $data->save();

        return response(['message'=>'Banner updated successfully']);
    }

    public function destroy($id)
    {
        $data = Banner::where('id',$id)->first();
        $data->delete();

        return response(['message'=>'Banner deleted successfully']);
    }
}
