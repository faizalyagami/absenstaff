<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\TryCatch;

class MainController extends Controller
{

    public function index(Request $request) {
        // first check if you are loggidin adn admin user...
        if(!Auth::check() && $request->path() != 'login') {
            return redirect('/login');
        }

        // you are already loggedin... so check for it you are an admin user...
        if(Auth::check()) {
            $user = Auth::user();
            if($user->role->is_admin  == 0) {
                return redirect('/login');
            }

            if($request->path() == 'login') {
                return redirect('/');
            }
        }

        return view('welcome');
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }
    
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

    public function createUser(Request $request) {
        // validate
        $this->validate($request, [
            'full_name' => 'required',
            'email' => 'bail|required|email|unique:users',
            'password' => 'bail|required|min:6',
            'role_id' => 'required',
        ], [
            'category_name.required' => 'Category name is required', 
            'email.required' => 'Email is required', 
            'password.required' => 'Password is required', 
            'role_id.required' => 'User Type is required', 
        ]);
        
        $result = null;
        $errorcode = 200;

        try {
            $password = bcrypt($request->password);
            $message = new User();
            $message->full_name = $request->full_name;
            $message->email = $request->email;
            $message->password = $password;
            $message->role_id = $request->role_id;
            $message->save();

            $users = User::with(['role'])->orderBy('id', 'desc')->where('id', $message->id)->first();

            $result = $users;
            $errorcode = 201;

        } catch (\Throwable $th) {
            $result = ['message' => $th];
            $errorcode = 422;
        }

        return response()->json($result, $errorcode);
    }

    public function getUsers() {
        $users = User::with(['role'])->orderBy('id', 'desc')->get();

        return $users;
    }

    public function editUser(Request $request) {
        // validate
        $this->validate($request, [
            'full_name' => 'required',
            'email' => 'bail|required|email|unique:users,email,'. $request->id,
            'password' => 'min:6',
            'role_id' => 'required',
        ]);
        
        $result = null;
        $errorcode = 200;

        try {
            $message = User::where('id', $request->id)->first();
            $message->full_name = $request->full_name;
            $message->email = $request->email;
            if(isset($request->password)) {
                $password = bcrypt($request->password);
                $message->password = $password;
            }
            $message->role_id = $request->role_id;
            $message->save();

            $users = User::with(['role'])->orderBy('id', 'desc')->where('id', $request->id)->first();

            $result = $users;
            $errorcode = 201;

        } catch (\Throwable $th) {
            $result = ['message' => $th];
            $errorcode = 422;
        }

        return response()->json($result, $errorcode);
    }

    public function deleteUser(Request $request) {
        // validate
        $this->validate($request, [
            'id' => 'required', 
        ], [
            'id.required' => 'Id is required', 
        ]);
        
        $result = null;
        $errorcode = 200;

        try {
            $message = User::where('id', $request->id)->delete();

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

    public function adminLogin(Request $request) {
        $this->validate($request, [
            'email' => 'bail|required|email',
            'password' => 'bail|required|min:6',
        ]);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            if($user->role->is_admin  == 0) {
                Auth::logout();
                return response()->json([
                    'message' => 'Incorrect Login detail (user)'
                ], 401);
            } 

            return response()->json([
                'message' => 'You are logged in', 
                'user' => $user
            ]);
        } else {
            return response()->json([
                'message' => 'Incorrect Login detail'
            ], 401);
        }
    }

    public function createRole(Request $request) {
        // validate
        $this->validate($request, [
            'role_name' => 'required'
        ], [
            'role_name.required' => 'Tag name is required'
        ]);
        
        $result = null;
        $errorcode = 200;

        try {
            $message = new Role();
            $message->role_name = $request->role_name;
            $message->save();

            $result = $message;
            $errorcode = 201;

        } catch (\Throwable $th) {
            $result = ['message' => 'some error accured'];
            $errorcode = 422;
        }

        return response()->json($result, $errorcode);
    }
    
    public function editRole(Request $request) {
        // validate
        $this->validate($request, [
            'id' => 'required', 
            'role_name' => 'required', 
        ], [
            'id.required' => 'Id is required', 
            'role_name.required' => 'Role name is required', 
        ]);
        
        $result = null;
        $errorcode = 200;

        try {
            $message = Role::where('id', $request->id)->first();
            if($message !== null) {
                $message->role_name = $request->role_name;
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

    public function deleteRole(Request $request) {
        // validate
        $this->validate($request, [
            'id' => 'required', 
        ], [
            'id.required' => 'Id is required', 
        ]);
        
        $result = null;
        $errorcode = 200;

        try {
            $message = Role::where('id', $request->id)->delete();

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

    public function getRoles() {
        $roles = Role::orderBy('id', 'desc')->get();

        return $roles;
    }

}
