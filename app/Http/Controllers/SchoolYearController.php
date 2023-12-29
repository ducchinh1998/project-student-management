<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolYear;
use Validator;

class SchoolYearController extends Controller
{
    public function index()
    {
        return view('school_year.list', ['data' => SchoolYear::all()]);
    }

    public function validationRequest($request)
    {
        return Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255|regex:/^[a-zA-Z0-9_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽếềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ_(\s)_(\.)_(\,)_(\-)_(\_)]+$/',
                'session' => 'required|max:255|regex:/^[a-zA-Z0-9_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽếềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ_(\s)_(\.)_(\,)_(\-)_(\_)]+$/',
                'start_time' => 'required|max:255|date',
                'end_time' => 'required|max:255|date',
            ],
            [
                'name.required' => 'Năm học không được để trống',
                'name.max' => 'Năm học không được quá :max kí tự',
                'name.regex' => 'Năm học không được chứa kí tự đặc biệt',
                'session.required' => 'Năm học không được để trống',
                'session.max' => 'Năm học không được quá :max kí tự',
                'session.regex' => 'Năm học không được chứa kí tự đặc biệt',
                'start_time.required' => 'Năm học không được để trống',
                'start_time.date' => 'Thời điểm bắt đầu phải có định dạng YYYY-MM-DD',
                'start_time.max' => 'Năm học không được quá :max kí tự',
                'end_time.required' => 'Năm học không được để trống',
                'end_time.max' => 'Năm học không được quá :max kí tự',
                'end_time.date' => 'Thời điểm kết thúc phải có định dạng YYYY-MM-DD',
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
        $data['slug'] = str_slug($data['name'].$data['session']);

        $school_year = SchoolYear::create($data);

        if (isset($school_year)) {
            return response()->json(['is' => 'success', 'complete' => 'Năm học - kì học được thêm thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Năm học - kì học chưa được thêm']);
    }

    public function show($id)
    {
        $school_year = SchoolYear::find($id);
        return $school_year;
    }

    public function update(Request $request, $id)
    {
        $validator = $this->validationRequest($request);
        if ($validator->fails()) {
            return response()->json(['is' => 'failed', 'error' => $validator->errors()->all()]);
        }
        $data = $request->all();
        unset($data['_token']);
        unset($data['id']);

        $find_school_year = SchoolYear::find($data['id']);
        if(!$find_school_year){
            return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Năm học - kì học không tồn tại']);
        }

        $data['slug'] = str_slug($data['name'].$data['session']);
        
        $is_updated = $find_school_year->update($data);
        if ($is_updated) {
            return response()->json(['is' => 'success', 'complete' => 'Năm học - kì học được cập nhật thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Năm học - kì học chưa được cập nhật']);
    }

    public function destroy($id)
    {
        $find_school_year = SchoolYear::findOrFail($id)->delete();
        if ($find_school_year) {
            return response()->json(['is' => 'success', 'complete' => 'Năm học - kì học được xóa thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Năm học - kì học chưa được xóa']);
    }
}
