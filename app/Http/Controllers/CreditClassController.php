<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CreditClass;
use Validator;

class CreditClassController extends Controller
{
    public function index()
    {
        return view('credit_class.list', ['data' => CreditClass::all()]);
    }

    public function validationRequest($request)
    {
        return Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255|regex:/^[a-zA-Z0-9_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽếềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ_(\s)_(\.)_(\,)_(\-)_(\_)]+$/',
                'school_year_id' => 'required',
                'faculty_id' => 'required',
                'subject_id' => 'required',
                'lecturer_id' => 'required',
                'code' => 'required',
                'revise_weight' => 'required',
                'practice_weight' => 'required',
                'attendance_weight' => 'required',
                'finish_test_weight' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
            ],
            [
                'name.required' => 'Tên lớp không được để trống',
                'name.max' => 'Tên lớp không được quá :max kí tự',
                'name.regex' => 'Tên lớp không được chứa kí tự đặc biệt',
                'school_year_id.required' => 'Năm học không được để trống',
                'faculty_id.required' => 'Khoa không được để trống',
                'subject_id.required' => 'Môn học không được để trống',
                'lecturer_id.required' => 'Giảng viên không được để trống',
                'code.required' => 'Mã lớp không được để trống',
                'revise_weight.required' => 'Trọng số điểm bài tập không được để trống',
                'middle_test_weight.required' => 'Trọng số điểm kiểm tra không được để trống',
                'practice_weight.required' => 'Trọng số điểm thực hành không được để trống',
                'attendance_weight.required' => 'Trọng số điểm chuyên cần không được để trống',
                'finish_test_weight.required' => 'Trọng số điểm thi không được để trống',
                'start_time.required' => 'Thời gian vào học không được để trống',
                'end_time.required' => 'Thời gian kết thúc không được để trống',
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

        $class = CreditClass::create($data);
        if (isset($class)) {
            return response()->json(['is' => 'success', 'complete' => 'Lớp học tín chỉ được thêm thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Lớp học tín chỉ chưa được thêm']);
    }

    public function show($id)
    {
        $class = CreditClass::find($id);
        return $class;
    }

    public function update(Request $request)
    {
        $validator = $this->validationRequest($request);
        if ($validator->fails()) {
            return response()->json(['is' => 'failed', 'error' => $validator->errors()->all()]);
        }

        $data = $request->all();
        $class = CreditClass::find($data['id']);
        unset($data['_token']);
        unset($data['id']);
        $data['slug'] = str_slug($data['name']);

        $flag = $class->update($data);
        if ($flag) {
            return response()->json(['is' => 'success', 'complete' => 'Lớp học tín chỉ được cập nhật thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Lớp học tín chỉ chưa được cập nhật']);
    }

    public function destroy($id)
    {
        $class = CreditClass::findOrFail($id)->delete();
        if ($class) {
            return response()->json(['is' => 'success', 'complete' => 'Lớp học tín chỉ được xóa thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Lớp học tín chỉ chưa được xóa']);
    }
}
