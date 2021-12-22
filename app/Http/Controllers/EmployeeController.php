<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function create(Request $request) {
        // validate
        $this->validate($request, [
            'nik' => 'required', 
            'first_name' => 'required', 
            'gender' => 'required', 
            'religion' => 'required', 
            'departement_id' => 'required', 
            'position_id' => 'required', 
            'status' => 'required', 
            'in_date' => 'required', 
            'phone' => 'required', 
            'email' => 'required', 
        ]);
        
        $result = null;
        $errorcode = 200;

        try {
            $message = new Employee();
            $message->nik = $request->nik;
            $message->first_name = $request->first_name;
            $message->last_name = $request->last_name;
            $message->born_place = $request->born_place;
            $message->born_date = $request->born_date;
            $message->gender = $request->gender;
            $message->religion = $request->religion;
            $message->phone = $request->phone;
            $message->email = $request->email;
            $message->in_date = $request->in_date;
            $message->out_date = $request->out_date;
            $message->departement_id = $request->departement_id;
            $message->position_id = $request->position_id;
            $message->status = $request->status;
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
            'id' => 'required', 
            'nik' => 'required', 
            'first_name' => 'required', 
            'gender' => 'required', 
            'religion' => 'required', 
            'departement_id' => 'required', 
            'position_id' => 'required', 
            'status' => 'required', 
            'in_date' => 'required', 
            'phone' => 'required', 
            'email' => 'required', 
        ]);
        
        $result = null;
        $errorcode = 200;

        try {
            $message = Employee::where('id', $request->id)->first();
            if($message !== null) {
                $message->nik = $request->nik;
                $message->first_name = $request->first_name;
                $message->last_name = $request->last_name;
                $message->born_place = $request->born_place;
                $message->born_date = $request->born_date;
                $message->gender = $request->gender;
                $message->religion = $request->religion;
                $message->phone = $request->phone;
                $message->email = $request->email;
                $message->in_date = $request->in_date;
                $message->out_date = $request->out_date;
                $message->departement_id = $request->departement_id;
                $message->position_id = $request->position_id;
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
            $message = Employee::where('id', $request->id)->delete();

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
        $result = Employee::with(['departement', 'position'])->orderBy('id', 'desc')->get();

        return $result;
    }
}
