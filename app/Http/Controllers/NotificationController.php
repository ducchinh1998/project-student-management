<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\CreditClass;
use App\Models\RegisterClass;
use App\Models\Lecturer;
use Validator;
use Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::groupBy('credit_class_id', 'content')->get();
        return view('notification.list', ['data' => $notifications]);
    }

    public function viewNotify()
    {
        $lecturer_id = Auth::guard('admin')->user()->id;
        $creditClasses = CreditClass::where('lecturer_id', $lecturer_id)->get();
        return view('notification.new', ['data' => $creditClasses]);
    }

    public function validationRequest($request)
    {
        return Validator::make(
            $request->all(),
            [
                'title' => 'required|max:255|regex:/^[a-zA-Z0-9_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽếềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ_(\s)_(\.)_(\,)_(\-)_(\_)]+$/',
            ],
            [
                'title.required' => 'Tiêu đề không được để trống',
                'title.max' => 'Tiêu đề không được quá :max kí tự',
                'title.regex' => 'Tiêu đề không được chứa kí tự đặc biệt',
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
        $account_id = Auth::guard('admin')->user()->id;
        $lecturer = Lecturer::where('account_id', $account_id)->first();
        $data['lecturer_id'] = $lecturer->id;

        $students = RegisterClass::where('credit_class_id', $data['credit_class_id'])->get();
        foreach ($students as $value) {
            $data['student_id'] = $value->student_id;
            $notification = Notification::create($data);
        }
        if (isset($notification)) {
            return response()->json(['is' => 'success', 'complete' => 'Gửi thông báo thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Gửi thông báo không thành công']);
    }

    public function show($id)
    {
        $class = Notification::find($id);
        return $class;
    }

    public function update(Request $request)
    {
        $validator = $this->validationRequest($request);
        if ($validator->fails()) {
            return response()->json(['is' => 'failed', 'error' => $validator->errors()->all()]);
        }

        $data = $request->all();
        $class = Notification::find($data['id']);
        unset($data['_token']);
        unset($data['id']);
        $data['slug'] = str_slug($data['name']);

        $flag = $class->update($data);
        if ($flag) {
            return response()->json(['is' => 'success', 'complete' => 'Thông báo được cập nhật thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Thông báo chưa được cập nhật']);
    }

    public function destroy($id)
    {
        $notification = Notification::findOrFail($id)->delete();
        if ($notification) {
            return response()->json(['is' => 'success', 'complete' => 'Thông báo được xóa thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Thông báo chưa được xóa']);
    }
}
