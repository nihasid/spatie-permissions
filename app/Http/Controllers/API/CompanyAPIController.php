<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Company;
use Validator;

class CompanyAPIController extends BaseController
{
    //
    public function index(Request $request)
    {
        
        // get all Companies list with company, duties, positions and certificates
        $data = Company::whereNotNull('status')
            ->orderBy('created_at', 'desc')
            ->paginate($request->limit);
        return response()->json(['data'=> $data], 200);
    }

    public function store(request $request)
    {
        // save employee w.r.t ompany, duties, positions and certificates
        $validator = Validator::make($request->all(), [
            'company_type_id' => 'required',
            'company_name' => 'required',
            'company_department' => 'required',
            'company_started_at' => 'date|date_format:Y-m-d|required',
            'company_ended_at' => 'date|date_format:Y-m-d|nullable'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $input = $request->all();
        try{
            $result = Company::create($input);
            if($result) {
                return response()->json(['message' => 'company added succesfully.', 'data' => $result], 200);
            }
            
        } catch(Exception $e) {
            dd($e->getMessage());
        }
        

    }

    public function show($id)
    {
        $data = Company::find($id);
        return response()->json([
            'data' => $data
        ], 200);

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}
