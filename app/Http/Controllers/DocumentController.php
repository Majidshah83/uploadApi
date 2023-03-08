<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Document;
use PhpParser\Comment\Doc;

class DocumentController extends Controller
{
   public function store(Request $request)
    {
        // dd($request->all());
       $validator = Validator::make($request->all(),
              [
              'title' =>'required',
              'description' =>'required',
              'image' => 'required|mimes:doc,jpg,png,docx,pdf,txt|max:2048',
             ]);

    if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
         }

           if ($request->file('image')) {
            $images = $request->image->store('public/files');
            //store your file into database
            $document=new Document();
            $document->image =$images;
            $document->title =$request->title;
            $document->description =$request->description;
            $document->save();
            return response()->json([
                "success" => true,
                "message" => "File successfully uploaded",
                "images" => $images
            ]);


        }

    }






}