<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegisterClass;
use Validator;

class RegisterClassController extends Controller
{
    public function index()
    {
        return view('register_class.list', ['data' => RegisterClass::all()]);
    }

    public function validationRequest($request)
    {
        return Validator::make(
            $request->all(),
            [
                'student_id' => 'required',
                'credit_class_id' => 'required',
                'registered_at' => 'required',
            ],
            [
                'student_id.required' => 'Thông tin sinh viên đăng ký là bắt buộc',
                'credit_class_id.required' => 'Thông tin lớp học là bắt buộc',
                'registered_at.required' => 'Thời điểm đăng ký là bắt buộc',
            ]
        );
    }

    public function store(Request $request)
    {
        $validator = $this->validationRequest($request);
        if ($validator->fails()) {
            return response()->json(['is' => 'failed', 'error' => $validator->errors()->all()]);
        }

        $data = $request->all();
        unset($data['_token']);

        $class = RegisterClass::where('student_id', $data['student_id'])->where('credit_class_id', $data['credit_class_id'])->first();
        if ($class) {
            return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Sinh viên đã đăng ký lớp học']);
        }

        $class = RegisterClass::create($data);
        if (isset($class)) {
            return response()->json(['is' => 'success', 'complete' => 'Đăng ký lớp học thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Đăng ký lớp học thất bại']);
    }

    public function show($id)
    {
        $class = RegisterClass::find($id);
        return $class;
    }

    public function destroyRegister(Request $request)
    {
        $data = $request->all();
        $class = RegisterClass::where('student_id', $data['student_id'])->where('credit_class_id', $data['credit_class_id'])->delete();
        if ($class) {
            return response()->json(['is' => 'success', 'complete' => 'Xóa đăng ký lớp học thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Xóa đăng ký lớp học thất bại']);
    }
}
