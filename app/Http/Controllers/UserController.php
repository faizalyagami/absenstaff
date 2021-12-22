<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create(Request $request) {
        // validate
        $this->validate($request, [
            'username' => 'required', 
            'password' => 'required', 
            'level' => 'required', 
            'employee_id' => 'required', 
        ]);
        
        $result = null;
        $errorcode = 200;

        try {
            $message = new User();
            $message->username = $request->username;
            $message->password = $request->password;
            $message->level = $request->level;
            $message->employee_id = $request->employee_id;
            $message->creator = 'admin';
            $message->editor = 'admin';
            $message->save();

            $result = $message;
            $errorcode = 201;

        } catch (\Throwable $th) {
            $result = ['message' => $th];
            $errorcode = 422;
        }

        return response()->json($result, $errorcode);
    }
    
    public function edit(Request $request) {
        // validate
        $this->validate($request, [
            'username' => 'required', 
            'level' => 'required', 
            'employee_id' => 'required', 
        ]);
        
        $result = null;
        $errorcode = 200;

        try {
            $message = User::where('id', $request->id)->first();
            if($message !== null) {
                $message->username = $request->username;
                if($request->password) {
                    $message->password = $request->password;
                }
                $message->level = $request->level;
                $message->employee_id = $request->employee_id;
                $message->editor = 'admin';
                $message->save();
            }

            $result = $message;
            $errorcode = 201;

        } catch (\Throwable $th) {
            $result = ['errors' => [
                'swr' => $th
                ]
            ];
            $errorcode = 422;
        }

        return response()->json($result, $errorcode);
    }

    public function delete(Request $request) {
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

    public function gets() {
        $result = User::orderBy('id', 'desc')->get();

        return $result;
    }
}
