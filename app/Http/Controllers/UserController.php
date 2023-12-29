<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  
use App\Models\Account;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Classes;
use App\Models\Faculty;
use Validator;

class UserController extends Controller
{
    public function studentsIndex()
    {
        $users = DB::table('accounts')
        ->select('accounts.*', 'classes.name as class_name', 'faculties.name as faculty_name')
        ->join('students', 'students.account_id', '=', 'accounts.id')
        ->join('classes', 'classes.id', '=', 'students.class_id')
        ->join('faculties', 'faculties.id', '=', 'students.faculty_id')
        ->where('accounts.position', 'Student')
        ->orderBy('created_at', 'desc')->get();
        return view('user.students_list', ['users' => $users]);
    }

    public function lecturersIndex()
    {
        $users = DB::table('accounts')
        ->select('accounts.*', 'classes.name as class_name', 'faculties.name as faculty_name')
        ->join('lecturers', 'lecturers.account_id', '=', 'accounts.id')
        ->join('classes', 'classes.id', '=', 'lecturers.class_id')
        ->join('faculties', 'faculties.id', '=', 'lecturers.faculty_id')
        ->where('accounts.position', 'Lecturer')
        ->orderBy('created_at', 'desc')->get();
        return view('user.lecturers_list', ['users' => $users]);
    }

    public function administratorsIndex()
    {
        $users = DB::table('accounts')
        ->select()
        ->where('accounts.position', 'Administrators')
        ->orderBy('created_at', 'desc')->get();
        return view('user.administrators_list', ['users' => $users]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|min:8|max:32',
            'code' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'birthday' => 'required',
            'gender' => 'required',
            'phone' => 'required|max:10',
            'email' => 'required|email',
            'address' => 'required',
        ],
        [
            'username.required' => 'Tên đăng nhập không được để trống',
            'code.required' => 'Mã không được để trống',
            'first_name.required' => 'Họ & tên đệm không được để trống',
            'last_name.required' => 'Tên không được để trống',
            'avatar.required' => 'Ảnh không được để trống',
            'birthday.required' => 'Ngày sinh không được để trống',
            'gender.required' => 'Giới tính không được để trống',
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.max' => 'Số điện thoại không quá 10 số',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email chưa đúng định dạng',
            'address.required' => 'Địa chỉ không được để trống',
            'password.required' => 'Yêu cầu nhập mật khẩu',
            'password.min' => 'Mật khẩu tối thiểu 8 kí tự',
            'password.max' => 'Mật khẩu tối đa 32 kí tự',
            'avatar.image' => 'Yêu cầu phải là ảnh có đuôi jpeg,png,jpg,gif',
            'avatar.mimes' => 'Yêu cầu phải là ảnh có đuôi jpeg,png,jpg,gif',
            'avatar.max' => 'Ảnh không vượt quá 2MB',
        ]);

        if ($validator->fails()) {
            return response()->json(['is' => 'failed', 'error'=>$validator->errors()->all()]);
        }

        $data = $request->all();
        unset($data['_token']);
        $time = time();
        if($files = $request->file('avatar')) {
            $destinationPath = 'images/accounts/'; // upload path
            $time = time();
            $fileName = $time."".date('YmdHis')."".$files->hashName();
            $files->move($destinationPath, $fileName);
            $data['avatar'] = $fileName;
        }
        
        $data['birthday'] = \Carbon\Carbon::parse($data['birthday'])->format('Y-m-d H:i:s');

        $type = '';
        if($data['position'] == 'Student'){
            $data['field'] = 'Sinh viên';
            unset($data['working_process']);
            $type = 'sinh viên';
        }
        else if($data['position'] == 'Lecturer'){
            $type = 'giảng viên';
        }
        else if($data['position'] == 'Administrators'){
            $type = 'trợ lý phòng đào tạo';
            unset($data['faculty_id']);
        }
        
        $data['status'] = 1;
        $data['password'] = bcrypt($data['password']);

        $account = Account::create($data);

        if(!isset($account)){
            return response()->json(['is' => 'unsuccess', 'unsuccess'=>'Lỗi tạo tài khoản ' . $type]);
        }

        if($data['position'] == 'Student'){
            Student::create([
                'cpa' => 0,
                'tpa' => 0,
                'warning_level' => 0,
                'faculty_id' => $data['faculty_id'],
                'class_id' => $data['class_id'],
                'account_id' => $account->id,
            ]);
        }
        else if($data['position'] == 'Lecturer'){
            Lecturer::create([
                'working_process' => $data['working_process'],
                'faculty_id' => $data['faculty_id'],
                'class_id' => $data['class_id'],
                'account_id' => $account->id,
            ]);
        }
        return response()->json(['is' => 'success', 'complete'=>'Tạo tài khoản ' . $type . ' thành công']);
    }


    public function show($id)
    {
        $user = Account::find($id);
        return $user;
    }

    public function updateUser(Request $request, $id)
    {       
        $data = $request->all();
        unset($data['_token']);
        $account = Account::find($data['id']);

        if ($account->status == 0) {
            $account->status = 1;
        } else {
            $account->status = 0;
        }

        $flag = $account->save();
        if ($flag) {
            return response()->json(['is' => 'success', 'complete' => 'Cập nhật tài khoản thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Lỗi cập nhật tài khoản']);

    }

    public function destroyAccount($id)
    {
        $user = Lecturer::findOrFail($id)->delete();
        if($user){
            return response()->json(['is' => 'success', 'complete'=>'Xóa tài khoản thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'unsuccess'=>'Lỗi xóa tài khoản']);
    }

    public function showStudent($id)
    {
        $user = DB::table('accounts')
        ->select('accounts.*', 'students.cpa', 'students.tpa', 'students.warning_level', 'classes.id as class_id', 'classes.name as class_name', 'faculties.name as faculty_name', 'faculties.id as faculty_id')
        ->join('students', 'students.account_id', '=', 'accounts.id')
        ->join('classes', 'classes.id', '=', 'students.class_id')
        ->join('faculties', 'faculties.id', '=', 'students.faculty_id')
        ->where('accounts.id', '=', $id)
        ->where('accounts.position', 'Student')
        ->first();
        if ($user) {
            return view('user.student_edit', ['user' => $user]);
        }
    } 

    public function showLecturer($id)
    {
        $user = DB::table('accounts')
        ->select('accounts.*', 'lecturers.working_process', 'classes.id as class_id', 'classes.name as class_name', 'faculties.name as faculty_name', 'faculties.id as faculty_id')
        ->join('lecturers', 'lecturers.account_id', '=', 'accounts.id')
        ->join('classes', 'classes.id', '=', 'lecturers.class_id')
        ->join('faculties', 'faculties.id', '=', 'lecturers.faculty_id')
        ->where('accounts.id', '=', $id)
        ->where('accounts.position', 'Lecturer')
        ->first();
        if ($user) {
            return view('user.lecturer_edit', ['user' => $user]);
        }
    } 

    public function showAdministrator($id)
    {
        $user = Account::where('id', $id)->first();
        if ($user) {
            return view('user.administrator_edit', ['user' => $user]);
        }
    } 

    public function updateInformationUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'code' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'phone' => 'required|max:10',
            'email' => 'required|email',
            'address' => 'required',
        ],
        [
            'username.required' => 'Tên đăng nhập không được để trống',
            'code.required' => 'Mã không được để trống',
            'first_name.required' => 'Họ & tên đệm không được để trống',
            'last_name.required' => 'Tên không được để trống',
            'gender.required' => 'Giới tính không được để trống',
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.max' => 'Số điện thoại không quá 10 số',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email chưa đúng định dạng',
            'address.required' => 'Địa chỉ không được để trống',
        ]);

        if ($validator->fails()) {
            return response()->json(['is' => 'failed', 'error' => $validator->errors()->all()]);
        }

        $data = $request->all();

        $find_user = Account::where('id', $data['id'])->first();
        if(!$find_user){
            return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Tài khoản không tồn tại']);
        }

        $check_exist_code = Account::where('code', $data['code'])->where('id', '!=', $data['id'])->first();
        if ($check_exist_code) {
            return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Mã ' . $data['code'] . ' đã tồn tại']);
        }

        unset($data['_token']);
        $time = time();

        $data['avatar'] = $find_user['avatar'];
        if ($files = $request->file('avatar')) {
            $destinationPath = 'images/accounts/'; // upload path
            $time = time();
            $fileName = $time . "" . date('YmdHis') . "" . $files->hashName();
            $files->move($destinationPath, $fileName);
            $data['avatar'] = $fileName;
        }

        if(!isset($data['birthday'])){
            $data['birthday'] = $find_user->birthday;
        }

        $user = Account::where('id', $data['id'])->update([
            'username' => $data['username'],
            'avatar' => $data['avatar'],
            'birthday' => $data['birthday'],
            'gender' => $data['gender'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'address' => $data['address'],
            'code' => $data['code'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'description' => $data['description'],
            'field' => $data['field'],
        ]);

        if($data['position'] == 'Student'){
            Student::where('account_id', $data['id'])->update([
                'faculty_id' => $data['faculty_id'],
                'class_id' => $data['class_id'],
                'cpa' => $data['cpa'],
                'tpa' => $data['tpa'],
                'warning_level' => $data['warning_level'],
            ]);
        }
        else if($data['position'] == 'Lecturer'){
            Lecturer::where('account_id', $data['id'])->update([
                'working_process' => $data['working_process'],
                'faculty_id' => $data['faculty_id'],
                'class_id' => $data['class_id'],
            ]);
        }

        if ($user) {
            return response()->json(['is' => 'success', 'complete' => 'Cập nhật tài khoản thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Cập nhật tài khoản thất bại']);
    }
}
