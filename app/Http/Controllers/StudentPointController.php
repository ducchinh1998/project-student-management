<?php

namespace App\Http\Controllers;

use App\Models\RegisterClass;
use App\Models\CreditClass;
use App\Models\Lecturer;
use App\Models\Student;
use Auth;

class StudentPointController extends Controller
{
    public function lecturerCreditClassManage()
    {
        $account = Auth::guard('admin')->user();
        if($account->position == 'Lecturer'){
            $find_credit_classes = CreditClass::where('lecturer_id', $account->id)->get();
            return view('credit_class.lecturer', ['data' => $find_credit_classes]);
        }
    }

    public function lecturerPointManage()
    {
        $account = Auth::guard('admin')->user();
        if($account->position == 'Lecturer'){
            $find_credit_classes = CreditClass::where('lecturer_id', $account->id)->get();
            return view('point.lecturer', ['data' => $find_credit_classes]);
        }
    }
    
    public function pointsByCreditClass($credit_class_id)
    {
        $account = Auth::guard('admin')->user();
        if($account->position == 'Lecturer'){
            $points = RegisterClass::where('credit_class_id', $credit_class_id)->get();
            return view('point.lecturer_point', ['data' => $points, 'credit_class_id' => $credit_class_id]);
        }
    }

    public function index()
    {
        $account = Auth::guard('admin')->user();
        if($account->position == 'Student'){
            $find_student = Student::where('account_id', $account->id)->first();
            $points = RegisterClass::where('student_id', $find_student->id)->get();
            return view('student_point.list', ['data' => $points]);
        }
    }
}
