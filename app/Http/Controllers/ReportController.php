<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CreditClass;
use App\Models\Student;
use Validator;
use Illuminate\Support\Facades\DB;  
use Auth;

class ReportController extends Controller
{
    public function reportStudentsByCreditClass()
    {
        $data = DB::table('credit_classes as cc')
        ->select('cc.id', 'cc.code', 'cc.name', DB::Raw('COUNT(rcc.student_id) AS total_students'), 's.name AS subject_name', 'f.name AS faculty_name', DB::Raw("CONCAT(sy.name, ' ', sy.session) AS school_year_name"), DB::Raw("CONCAT(a.first_name, ' ', a.last_name) AS lecturer_name"))
        ->join('student_register_credit_classes as rcc', 'rcc.credit_class_id', '=', 'cc.id')
        ->join('subjects as s', 's.id', '=', 'cc.subject_id')
        ->join('faculties as f', 'f.id', '=', 'cc.faculty_id')
        ->join('school_years as sy', 'sy.id', '=', 'cc.school_year_id')
        ->join('accounts as a', 'a.id', '=', 'cc.lecturer_id')
        ->groupBy('cc.id')
        ->get();

        return view('report.credit_class_list', ['data' => $data]);
    }

    public function show($id)
    {
        $data = DB::table('student_register_credit_classes as rcc')
        ->select('a.id', 'a.code', 'a.avatar', 'a.phone', 'a.email', 'a.birthday', 'a.address', 'c.name as class_name', DB::Raw("CONCAT(a.first_name, ' ', a.last_name) AS student_name"))
        ->join('students as s', 's.id', '=', 'rcc.student_id')
        ->join('classes as c', 'c.id', '=', 's.class_id')
        ->join('accounts as a', 'a.id', '=', 's.account_id')
        ->where('rcc.credit_class_id', $id)
        ->get();

        return view('report.student_class_list', ['data' => $data]);
    }

    public function progress()
    {
        // Điểm GPA
        $account = Auth::guard('admin')->user();
        if($account->position == 'Student'){
            $data = DB::table('student_register_credit_classes as rcc')
            ->select('sy.id', 'sy.name', 'sy.session', DB::Raw("AVG(rcc.avg_point) AS gpa"))
            ->join('credit_classes as cc', 'rcc.credit_class_id', '=', 'cc.id')
            ->join('school_years as sy', 'sy.id', '=', 'cc.school_year_id')
            ->join('students as s', 's.id', '=', 'rcc.student_id')
            ->join('accounts as a', 'a.id', '=', 's.account_id')
            ->where('a.id', $account->id)
            ->groupBy('sy.id')
            ->orderBy('sy.created_at', 'desc')
            ->get();

            return view('student_point.overall', ['data' => $data, 'student' => $account]);
        }
    }
}
