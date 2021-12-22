<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    public function create(Request $request) {
        // validate
        $this->validate($request, [
            'name' => 'required', 
            'status' => 'required', 
        ]);
        
        $result = null;
        $errorcode = 200;

        try {
            $message = new Departement();
            $message->name = $request->name;
            $message->status = $request->status;
            $message->creator = 'admin';
            $message->editor = 'admin';
            $message->save();

            $result = $message;
            $errorcode = 201;

        } catch (\Throwable $th) {
            $result = ['message' => 'some error accured'];
            $errorcode = 422;
        }

        return response()->json($result, $errorcode);
    }
    
    public function edit(Request $request) {
        // validate
        $this->validate($request, [
            'id' => 'required', 
            'name' => 'required', 
            'status' => 'required', 
        ]);
        
        $result = null;
        $errorcode = 200;

        try {
            $message = Departement::where('id', $request->id)->first();
            if($message !== null) {
                $message->name = $request->name;
                $message->status = $request->status;
                $message->editor = 'admin';
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
            $message = Departement::where('id', $request->id)->delete();

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
        $result = Departement::orderBy('id', 'desc')->get();

        return $result;
    }
}
