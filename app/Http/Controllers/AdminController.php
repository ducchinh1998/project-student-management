<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use App\Models\Student;
use App\Models\Notification;
use App\Models\Faculty;
use App\Models\Classes;
use App\Models\Creditclass;
use App\Models\Lecturer;
use App\Models\Subject;


use Validator;
use Auth;

use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
	public function homePage()
	{
		$account = Auth::guard('admin')->user();
		$account_id = $account->id;
		$faculities = Faculty::all();
		$classes = Classes::all();
		$creditclass = Creditclass::all();
		$lecturer = Lecturer::all();
		$student =Student::all();
		$subject= Subject::all();
		if ($account->position == 'Student') {
			$user_id = Student::where('account_id', $account_id)->first()->id;
			$notifications = Notification::where('student_id', $user_id)
							->orderby('created_at', 'desc')
							->take(5)->get();
			return view('admin.home_page')->with(compact('faculities','classes','creditclass','lecturer','student','subject','notifications'));
		}
		return view('admin.home_page')->with(compact('faculities','classes','creditclass','lecturer','student','subject'));
	}
}
