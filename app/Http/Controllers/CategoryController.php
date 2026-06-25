<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function addcategory(Request $request){
        Category::create([
            'CategoryName'=>$request->category
        ]);
        return redirect()->back()->with('success', 'Category Added!');
    }
    public function categorylist()
    {
        $categories=Category::all();//get all data
        return view('category',compact('categories'));
    }
    public function getCategory($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }
    public function addsubcategory(Request $request){
        $category = Category::findOrFail($request->category_id);
        $category->subcategories()->create([
            'SubCategoryName' => $request->subcategory
        ]);
        return redirect()->back()->with('success', 'Subcategory Added!');
    }
   public function getSubCategory($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category->subcategories);
    }
}
