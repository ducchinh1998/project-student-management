<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\Faculty;
use Validator;

class ClassesController extends Controller
{
    public function index()
    {
        return view('class.list', ['data' => Classes::all()]);
    }

    public function validationRequest($request)
    {
        return Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255|regex:/^[a-zA-Z0-9_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽếềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ_(\s)_(\.)_(\,)_(\-)_(\_)]+$/',
            ],
            [
                'name.required' => 'Tên lớp không được để trống',
                'name.max' => 'Tên lớp không được quá :max kí tự',
                'name.regex' => 'Tên lớp không được chứa kí tự đặc biệt',
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

        $class = Classes::create($data);
        if (isset($class)) {
            return response()->json(['is' => 'success', 'complete' => 'Lớp chuyên ngành được thêm thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Lớp chuyên ngành chưa được thêm']);
    }

    public function show($id)
    {
        $class = Classes::find($id);
        return $class;
    }

    public function update(Request $request)
    {
        $validator = $this->validationRequest($request);
        if ($validator->fails()) {
            return response()->json(['is' => 'failed', 'error' => $validator->errors()->all()]);
        }

        $data = $request->all();
        $class = Classes::find($data['id']);
        unset($data['_token']);
        unset($data['id']);
        $data['slug'] = str_slug($data['name']);

        $flag = $class->update($data);
        if ($flag) {
            return response()->json(['is' => 'success', 'complete' => 'Lớp chuyên ngành được cập nhật thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Lớp chuyên ngành chưa được cập nhật']);
    }

    public function destroy($id)
    {
        $class = Classes::findOrFail($id)->delete();
        if ($class) {
            return response()->json(['is' => 'success', 'complete' => 'Lớp chuyên ngành được xóa thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Lớp chuyên ngành chưa được xóa']);
    }
}
