<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $param = $request->all();
        $page = $param['page'];
        $limit = $param['limit'];
        $search = $param['q'];
        if(!$page){
            $page = 1;
        } 

        if(!$limit){
            $limit = 5;
        }

        if($page==1){
            $skip = 0;
        }else {
            $skip = ($page-1)*$limit;
        }

        if($search){
            $data = Product::select('product.*','categories.category_name')
                ->where('product_name','like','%'.$search.'%')
                ->leftJoin('categories','product.categories_id','=','categories.id')
                ->orderBy('product.id','desc')->skip($skip)->take($limit)->get();
            $total = count($data);
            return response([
                'total'=> $total,
                'page' => $page,
                'items' => $data
            ]);            
        }

        $data = Product::select('product.*','categories.category_name')
            ->leftJoin('categories','product.categories_id','=','categories.id')
            ->orderBy('product.id','desc')->skip($skip)->take($limit)->get();
        $total = count($data);
        return response([
            'total'=> $total,
            'page' => $page,
            'items' => $data
        ]);
    }

    public function categoryFilter(Request $request,$id)
    {
        $param = $request->all();
        $page = $param['page'];
        $limit = $param['limit'];
        $search = $param['q'];
        if(!$page){
            $page = 1;
        } 

        if(!$limit){
            $limit = 5;
        }

        if($page==1){
            $skip = 0;
        }else {
            $skip = ($page-1)*$limit;
        }

        if($search){
            $data = Product::select('product.*','categories.category_name')
                ->where([
                    ['product.categories_id',$id],
                    ['product_name','like','%'.$search.'%']
                ])
                ->leftJoin('categories','product.categories_id','=','categories.id')
                ->orderBy('product.id','desc')->skip($skip)->take($limit)->get();
            $total = count($data);
            return response([
                'total'=> $total,
                'page' => $page,
                'items' => $data
            ]);            
        }

        $data = Product::select('product.*','categories.category_name')
            ->where('product.categories_id',$id)
            ->leftJoin('categories','product.categories_id','=','categories.id')
            ->orderBy('product.id','desc')->skip($skip)->take($limit)->get();
        $total = count($data);
        return response([
            'total'=> $total,
            'page' => $page,
            'items' => $data
        ]);
    }

    public function show($id)
    {
        $data = Product::select('product.*','categories.category_name')
            ->where('product.id',$id)
            ->leftJoin('categories','product.categories_id','=','categories.id')
            ->first();
        return response($data);
    }


    public function store(Request $request)
    {
        $this->validate($request,[
            'product_name' => 'required',
            'image' => 'required',
            'price' => 'required',
            'weight' => 'required',
            'category' => 'required'
        ]);
        $image = $request->file('image');
        $imageName = time().'-'.$image->getClientOriginalName();
        $destinationPath = storage_path('/upload/product');
        $image->move($destinationPath,$imageName);

        $input = $request->all();

        $data = new Product;
        $data->product_name = $input['product_name'];
        $data->description = $input['description'];
        $data->image = $imageName;
        $data->price = $input['price'];
        $data->weight = $input['weight'];
        $data->categories_id = $input['category'];
        $data->save();

        return response(['message'=>'Product created successfully']);
    }

    public function update(Request $request,$id)
    {
        $data = Product::where('id',$id)->first();
        $imageName = $data['image'];
        $input = $request->all();
        if($input['image']){
            $image = $request->file('image');
            $imageName = time().'-'.$image->getClientOriginalName();
            $destinationPath = storage_path('/upload/product');
            $image->move($destinationPath,$imageName);
            
        }

        $data->product_name = $input['product_name'];
        $data->description = $input['description'];
        $data->image = $imageName;
        $data->price = $input['price'];
        $data->weight = $input['weight'];
        $data->categories_id = $input['category'];
        $data->save();

        return response(['message'=>'Banner updated successfully']);
    }

    public function destroy($id)
    {
        $data = Product::where('id',$id)->first();
        $data->delete();

        return response(['message'=>'Banner deleted successfully']);
    }
}
