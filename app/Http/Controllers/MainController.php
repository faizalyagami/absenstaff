<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class MainController extends Controller
{
    public function home() {
        return response()->json(
            [
                'msg' => 'We should retrun any json'
            ]
        );
    }
    
    public function createTag(Request $request) {
        // validate
        $this->validate($request, [
            'tagName' => 'required'
        ], [
            'tagName.required' => 'Tag name is required'
        ]);
        
        $result = null;
        $errorcode = 200;

        try {
            $message = new Tag();
            $message->tag_name = $request->tagName;
            $message->save();

            $result = $message;
            $errorcode = 201;

        } catch (\Throwable $th) {
            $result = ['message' => 'some error accured'];
            $errorcode = 422;
        }

        return response()->json($result, $errorcode);
    }
    
    public function editTag(Request $request) {
        // validate
        $this->validate($request, [
            'id' => 'required', 
            'tagName' => 'required', 
        ], [
            'id.required' => 'Id is required', 
            'tagName.required' => 'Tag name is required', 
        ]);
        
        $result = null;
        $errorcode = 200;

        try {
            $message = Tag::where('id', $request->id)->first();
            if($message !== null) {
                $message->tag_name = $request->tagName;
                $message->save();
            }

            $result = $message;
            $errorcode = 201;

        } catch (\Throwable $th) {
            $result = ['errors' => [
                'swr' => 'some error accured'
                ]
            ];
            $errorcode = 422;
        }

        return response()->json($result, $errorcode);
    }

    public function deleteTag(Request $request) {
        // validate
        $this->validate($request, [
            'id' => 'required', 
        ], [
            'id.required' => 'Id is required', 
        ]);
        
        $result = null;
        $errorcode = 200;

        try {
            $message = Tag::where('id', $request->id)->delete();

            $result = $message;
            $errorcode = 201;

        } catch (\Throwable $th) {
            $result = ['errors' => [
                'swr' => 'some error accured'
                ]
            ];
            $errorcode = 422;
        }

        return response()->json($result, $errorcode);
    }

    public function getTags() {
        $tags = Tag::orderBy('id', 'desc')->get();

        return $tags;
    }

    public function upload(Request $request) {
        // validate 
        $this->validate($request, [
            'file' => 'required|mimes:jpeg,jpg,png'
        ], [
            'file.required' => 'File is required.', 
            'file.mimes' => 'The file must be a file of type: jpeg, jpg, png.', 
        ]);
        
        $file_name = date('YmdHis') .'.'. $request->file->getClientOriginalExtension();
        $folder_path = public_path('uploads');

        $request->file->move($folder_path, $file_name);
        
        return $file_name;
    }

    public function deleteImage(Request $request) {
        $filename = $request->image_name;
        $this->deleteFileFromServer($filename);
        return 'done'. $filename;
    }

    public function deleteFileFromServer($fileName) {
        $filePath = public_path() . $fileName;
        if(file_exists($filePath)) {
            @unlink($filePath);
        }

        return;
    }

    public function createCategory(Request $request) {
        // validate
        $this->validate($request, [
            'category_name' => 'required',
            'icon_image' => 'required'
        ], [
            'category_name.required' => 'Category name is required', 
            'icon_image.required' => 'Icon image is required', 
        ]);
        
        $result = null;
        $errorcode = 200;

        try {
            $message = new Category();
            $message->category_name = $request->category_name;
            $message->icon_image = $request->icon_image;
            $message->save();

            $result = $message;
            $errorcode = 201;

        } catch (\Throwable $th) {
            $result = ['message' => 'some error accured'];
            $errorcode = 422;
        }

        return response()->json($result, $errorcode);
    }

    public function getCategories() {
        $categories = Category::orderBy('id', 'desc')->get();

        return $categories;
    }

    public function editCategory(Request $request) {
        // validate
        $this->validate($request, [
            'id' => 'required', 
            'category_name' => 'required',
            'icon_image' => 'required'
        ], [
            'id.required' => 'Id is required', 
            'category_name.required' => 'Category name is required', 
            'icon_image.required' => 'Icon image is required', 
        ]);
        
        $result = null;
        $errorcode = 200;

        try {
            $message = Category::where('id', $request->id)->first();
            if($message !== null) {
                $message->category_name = $request->category_name;
                $message->icon_image = $request->icon_image;
                $message->save();
            }

            $result = $message;
            $errorcode = 201;

        } catch (\Throwable $th) {
            $result = ['errors' => [
                'swr' => 'some error accured'
                ]
            ];
            $errorcode = 422;
        }

        return response()->json($result, $errorcode);
    }

    public function deleteCategory(Request $request) {
        // validate
        $this->validate($request, [
            'id' => 'required', 
        ], [
            'id.required' => 'Id is required', 
        ]);
        
        $result = null;
        $errorcode = 200;

        try {
            $message = Category::where('id', $request->id)->delete();

            $filename = $request->icon_image;
            $this->deleteFileFromServer($filename);

            $result = $message;
            $errorcode = 201;

        } catch (\Throwable $th) {
            $result = ['errors' => [
                'swr' => 'some error accured'
                ]
            ];
            $errorcode = 422;
        }

        return response()->json($result, $errorcode);
    }

}
