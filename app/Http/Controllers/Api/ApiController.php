<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;

class ApiController extends Controller
{
    //Create an employee API
    public function createEmployee(Request $request){


   //validation

   $request->validate([
        "name"=>"required",
        "email"=>"required|email|unique:employees",
        "phone_no"=>"required",
        "gender"=>"required",
        "age"=>"required",
   ]);
   //create
            $employee=new Employee();
            $employee->name=$request->name;
            $employee->email=$request->email;
            $employee->phone_no=$request->phone_no;
            $employee->gender=$request->gender;
            $employee->age=$request->age;

            $employee->save();

    //response
            return response()->json([
                "status"=>1,
                "mesage"=>"Employee has been created"
            ]);

    }

    //List all employees API
    public function listEmployees(){
        $employees=Employee::get();
        return response()->json([
            "data"=>$employees
        ]);


    }

    //Get single employee API
    public function listSingleEmployee($id){
        if(Employee::where("id",$id)->exists()){
                    $employee_data=Employee::where("id",$id)->first();
                    return response()->json([
                        "data"=>$employee_data
                    ]);
        }

        else{
            return response()->json([
                "status"=>0,
                "message"=>"Employee not found",
            ]);
        }
    }

    //Update employee API
    public function updateEmployee(Request $request,$id){
        if(Employee::where("id",$id)->exists()){
                 //update
                 $employee=Employee::find($id);

                    $employee->name=!empty($request->name)?$request->name:$request->name;
                    $employee->email=!empty($request->email)?$request->email:$request->email;
                    $employee->phone_no=!empty($request->phone_no)?$request->phone_no:$request->phone_no;
                    $employee->gender=!empty($request->gender)?$request->gender:$request->gender;
                    $employee->age=!empty($request->age)?$request->age:$request->age;

                    $employee->save();

                    return response()->json([
                        "status"=>1,
                        "message"=>"Employee updated",
                    ]);



        }
        else{
            return response()->json([
                "status"=>0,
                "message"=>"Employee not found",
            ]);

        }

    }

    //Delete employee API
    public function deleteEmployee($id){
        if(Employee::where("id",$id)->exists()){
                    $employee=Employee::find($id);
                    $employee->delete();

                    return response()->json([
                        "status"=>1,
                        "message"=>"Employee has been deleted!",
                    ]);
        }
        else{
            return response()->json([
                "status"=>0,
                "message"=>"Employee not found",
            ]);
        }
                }
}
