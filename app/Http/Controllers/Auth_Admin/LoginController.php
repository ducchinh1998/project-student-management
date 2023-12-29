<?php

namespace App\Http\Controllers\Auth_Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use Illuminate\Support\Facades\Hash;
class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin/accounts';

    public function __construct()
    {
        $this->middleware('guest:admin')->except('showLoginForm', 'logoutAdmin', 'getChangePassword', 'changePassword');
    }

    public function showLoginForm()
    {
        return view('auth_admin.login');
    }

    /**
     * login admin
     */
    public function postLoginAdmin(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'username' => 'required',
                'password' => 'required|min:6|max:32'
            ],
            [
                'username.required' => 'Yêu cầu nhập tên đăng nhập',
                'password.required' => 'Yêu cầu nhập mật khẩu',
                'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
                'password.max' => 'Mật khẩu tối đa 32 kí tự',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['is' => 'login-failed', 'error' => $validator->errors()->all()]);
        }
        $check_account = Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password]);
        if (!$check_account) {
            return response()->json(['is' => 'incorrect', 'incorrect' => 'Sai tên đăng nhập hoặc mật khẩu!']);
        }
        if (Auth::guard('admin')->user()->status != 0) {
            return response()->json(['is' => 'login-success']);
        }
        Auth::logout();
        return response()->json(['is' => 'block', 'block' => 'Tài khoản của bạn đang bị khóa. Vui lòng liên hệ với admin để được hỗ trợ! Trân trọng!']);
    }

    public function logoutAdmin()
    {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }

    public function getChangePassword()
    {
        return view('admin.change_password');
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'old_pass' => 'required',
                'new_pass' => 'required|min:8|max:32',
                're_new_pass' => 'required'
            ],
            [
                'old_pass.required' => 'Bạn chưa nhập mật khẩu cũ',
                'new_pass.required' => 'Bạn chưa nhập mật khẩu mới',
                're_new_pass.required' => 'Bạn cần nhập lại mật khẩu mới',
                'new_pass.min' => 'Mật khẩu tối thiểu 8 kí tự',
                'new_pass.max' => 'Mật khẩu tối đa 32 kí tự',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['is' => 'failed', 'error' => $validator->errors()->all()]);
        }
        $old_pass =  $request->old_pass;
        $new_pass = trim($request->new_pass);
        $re_new_pass = trim($request->re_new_pass);

        if ($new_pass !== $re_new_pass) {
            return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Mật khẩu mới không khớp !!']);
        }

        $instance = Auth::guard('admin')->user();
        if ($instance) {
            $password = \DB::table('admins')->find($instance->id)->password;
        } else {
            return redirect()->back();
        }

        if (Hash::check($old_pass, $password)) {
            \DB::table('admins')->where('id', $id)->update(['password' => bcrypt($new_pass)]);
            Auth::guard('admin')->logout();
            return response()->json(['is' => 'success', 'complete' => 'Đổi mật khẩu thành công']);
        }

        return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Mật khẩu hiện tại không đúng']);
    }
}
