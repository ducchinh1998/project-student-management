<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Student;
use App\Models\CreditClass;
use App\Models\RegisterClass;
use Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Log;

class PointController extends Controller
{
    public function index()
    {
        return view('point.list', ['data' => RegisterClass::all()]);
    }

    public function validationRequest($request)
    {
        return Validator::make(
            $request->all(),
            [
                'attendance_point' => 'required',
                'revise_point' => 'required',
                'practice_point' => 'required',
                'middle_test_point' => 'required',
                'finish_test_point' => 'required',
            ],
            [
                'attendance_point.required' => 'Điểm chuyên cần là bắt buộc',
                'revise_point.required' => 'Điểm bài tập là bắt buộc',
                'practice_point.required' => 'Điểm thực hành là bắt buộc',
                'middle_test_point.required' => 'Điểm thi giữa kỳ là bắt buộc',
                'finish_test_point.required' => 'Điểm thi cuối kỳ là bắt buộc',
            ]
        );
    }

    public function update(Request $request, $student_id, $credit_class_id)
    {
        $validator = $this->validationRequest($request);
        if ($validator->fails()) {
            return response()->json(['is' => 'failed', 'error' => $validator->errors()->all()]);
        }

        $data = $request->all();
        unset($data['_token']);

        $class = RegisterClass::where('student_id', $student_id)->where('credit_class_id', $credit_class_id)->first();
        if (!isset($class)) {
            return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Sinh viên chưa đăng ký lớp học']);
        }

        $find_credit_class = CreditClass::find($credit_class_id);
        if (!isset($find_credit_class)) {
            return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Không tồn tại dữ liệu của lớp tín chỉ']);
        }

        $avg = $data['attendance_point'] * $find_credit_class['attendance_weight'] + 
        $data['revise_point'] * $find_credit_class['revise_weight'] + 
        $data['practice_point'] * $find_credit_class['practice_weight'] + 
        $data['middle_test_point'] * $find_credit_class['middle_test_weight'] + 
        $data['finish_test_point'] * $find_credit_class['finish_test_weight'];

        $class = RegisterClass::where('student_id', $student_id)
        ->where('credit_class_id', $credit_class_id)
        ->update([
            "attendance_point" => $data['attendance_point'],
            "revise_point" => $data['revise_point'],
            "practice_point" => $data['practice_point'],
            "middle_test_point" => $data['middle_test_point'],
            "finish_test_point" => $data['finish_test_point'],
            "avg_point" => $avg,
        ]);
        
        if (isset($class)) {
            return response()->json(['is' => 'success', 'complete' => 'Nhập điểm thành công']);
        }
        return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Nhập điểm thất bại']);
    }

    public function find($student_id, $credit_class_id)
    {
        $class = RegisterClass::where('student_id', $student_id)->where('credit_class_id', $credit_class_id)->first();
        return $class;
    }

    public function viewImport($credit_class_id)
    {
        return view('point.import_point', ['data' => $credit_class_id]);
    }

    public function import(Request $request) {
        try {
            $file = $request -> file;
            $credit_class_id = $request -> credit_class_id;

            // Load file Excel
            $spreadsheet = IOFactory::load($file);
            
            // Lấy sheet đầu tiên (nếu có nhiều sheet, bạn có thể chọn sheet cụ thể)
            $sheet = $spreadsheet->getActiveSheet();
    
            // Lấy số dòng và cột tối đa
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
    
            // Chuyển đổi cột về dạng số (ví dụ: A -> 1, B -> 2, ..., Z -> 26, AA -> 27, ...)
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
    
            // Lặp qua từng dòng và cột để lấy dữ liệu
            for ($row = 2; $row <= $highestRow; $row++) {
        
                $maSV = $sheet->getCellByColumnAndRow(1, $row)->getValue();
                $data['attendance_point'] = $sheet->getCellByColumnAndRow(3, $row)->getValue();
                $data['revise_point'] = $sheet->getCellByColumnAndRow(4, $row)->getValue();
                $data['middle_test_point'] = $sheet->getCellByColumnAndRow(5, $row)->getValue();
                $data['practice_point'] = $sheet->getCellByColumnAndRow(6, $row)->getValue();
                $data['finish_test_point'] = $sheet->getCellByColumnAndRow(7, $row)->getValue();
                
                $account = Account::where('code', $maSV)->first();
                $student = Student::where('account_id', $account->id)->first();
                $student_id = $student -> id;
                
                $class = RegisterClass::where('student_id', $student_id)->where('credit_class_id', $credit_class_id)->first();
                if (!isset($class)) {
                    return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Sinh viên chưa đăng ký lớp học']);
                }

                $find_credit_class = CreditClass::find($credit_class_id);
                if (!isset($find_credit_class)) {
                    return response()->json(['is' => 'unsuccess', 'unsuccess' => 'Không tồn tại dữ liệu của lớp tín chỉ']);
                }

                $avg = $data['attendance_point'] * $find_credit_class['attendance_weight'] + 
                $data['revise_point'] * $find_credit_class['revise_weight'] + 
                $data['practice_point'] * $find_credit_class['practice_weight'] + 
                $data['middle_test_point'] * $find_credit_class['middle_test_weight'] + 
                $data['finish_test_point'] * $find_credit_class['finish_test_weight'];

                $class = RegisterClass::where('student_id', $student_id)
                ->where('credit_class_id', $credit_class_id)
                ->update([
                    "attendance_point" => $data['attendance_point'],
                    "revise_point" => $data['revise_point'],
                    "practice_point" => $data['practice_point'],
                    "middle_test_point" => $data['middle_test_point'],
                    "finish_test_point" => $data['finish_test_point'],
                    "avg_point" => $avg,
                ]);
              
            }
            return response()->json(['is' => 'success', 'complete'=>'Nhập điểm thành công']);
        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            // Xử lý ngoại lệ nếu có lỗi khi đọc file
            echo 'Lỗi đọc file Excel: ', $e->getMessage();
            return response()->json(['is' => 'unsuccess', 'unsuccess'=>'Lỗi đọc file']);
        }
    }

    public function statistical(Request $request){

        $classes = CreditClass::all();

        return view('statisticals.index', [
            'classes' => $classes,
        ]);
    }

    public function statisticalPointClass(Request $request) {
        $data = $request->except('_token');

        $point["bad"] = [];
        $point["medium"] = [];
        $point["good"] = [];
        $point["better"] = [];

        $students = RegisterClass::select("student_id", "credit_class_id", "avg_point")
                            ->with(['students' => function($query) {
                                $query->with(['account' => function($query2) {
                                    $query2->select("id", "username", "code");
                                }]);
                            } , 'creditClass' => function($query) {
                                $query->select("id", "name", "code");
                            }])
                            ->where("credit_class_id", $data['classId'])
                            ->get();
        
        foreach ($students as $student) {
            if(0 <= $student->avg_point && $student->avg_point < 5) {
                array_push($point["bad"], $student->avg_point);
            }else if(5 <= $student->avg_point && $student->avg_point <  6.5) {
                array_push($point["medium"], $student->avg_point);
            }else if(6.5 <= $student->avg_point && $student->avg_point < 8 ) {
                array_push($point["good"], $student->avg_point);
            }else {
                array_push($point["better"], $student->avg_point);
            }
        }

        $dataPoint = [
            [
                "rank" => "Yếu",
                "point" => $this->avgPoint($point["bad"]),
                "count" => count($point["bad"])
            ],
            [
                "rank" => "Trung bình",
                "point" => $this->avgPoint($point["medium"]),
                "count" => count($point["medium"])
            ],
            [
                "rank" => "Khá",
                "point" => $this->avgPoint($point["good"]),
                "count" => count($point["good"])
            ],
            [
                "rank" => "Giỏi",
                "point" => $this->avgPoint($point["better"]),
                "count" => count($point["better"])
            ]
        ];

        
        return response()->json(["students" => $students, "dataPoint" => $dataPoint , "code" => 0], 200);
    }

    private function avgPoint($point) {
        if(count($point) > 0) {
            $arrPoint = array_filter($point);
            $average = array_sum($arrPoint) == 0 ? 0 : array_sum($arrPoint)/count($arrPoint);

            return round($average, 3);
        }
       
        return 0;
    }
}
