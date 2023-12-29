<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faculty;
use Validator;

class FacultyController extends Controller
{
    public function index()
    {
        return view('faculty.list', ['data' => Faculty::all()]);
    }

    public function validationRequest($request)
    {
        return Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255|regex:/^[a-zA-Z0-9_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽếềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ_(\s)_(\.)_(\,)_(\-)_(\_)]+$/',
            ],
            [
                'name.required' => 'Tên khoa không được để trống',
                'name.max' => 'Tên khoa không được quá :max kí tự',
                'name.regex' => 'Tên khoa không được chứa kí tự đặc biệt',
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
        $data['slug'] = str_slug($data['name']);

        $faculty = Faculty::create($data);
        if (isset($faculty)) {
            return response()->json(['is' => 'success', 'complete' => 'Khoa được thêm thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Khoa chưa được thêm']);
    }

    public function show($id)
    {
        $faculty = Faculty::find($id);
        return $faculty;
    }

    public function update(Request $request)
    {
        $validator = $this->validationRequest($request);
        if ($validator->fails()) {
            return response()->json(['is' => 'failed', 'error' => $validator->errors()->all()]);
        }

        $data = $request->all();
        $faculty = Faculty::find($data['id']);
        unset($data['_token']);
        unset($data['id']);
        $data['slug'] = str_slug($data['name']);

        $flag = $faculty->update($data);
        if ($flag) {
            return response()->json(['is' => 'success', 'complete' => 'Khoa được cập nhật thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Khoa chưa được cập nhật']);
    }

    public function destroy($id)
    {
        $faculty = Faculty::findOrFail($id)->delete();
        if ($faculty) {
            return response()->json(['is' => 'success', 'complete' => 'Khoa được xóa thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Khoa chưa được xóa']);
    }
}
