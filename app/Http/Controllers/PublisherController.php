<?php

namespace App\Http\Controllers;
use App\Models\Publisher;

use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function publisherlist(){
        //$publishers=Publisher::all();
        $publishers=Publisher::orderBy('Name','asc')->get();
        return view('publisher',compact('publishers'));
    }
    public function addpublisher(Request $request){
        Publisher::create([
            'Name'=>$request->publisher,
            'Address'=>$request->address
        ]);
        return redirect()->back()->with('success', 'Publisher Added Successfully!');
    }
}
