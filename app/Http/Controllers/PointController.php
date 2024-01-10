<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Student;
use App\Models\CreditClass;
use App\Models\RegisterClass;
use Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Log;
use Carbon\Carbon;

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

    public function export(Request $request) {
        $fontArray = [
            'font' => [
                'bold' => true,
                'size' => 15,
            ],
        ];

        $boldArray = [
            'font' => [
                'bold' => true,
            ],
        ];

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('C')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('D')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('E')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('F')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('G')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('H')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('I')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('J')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('K')->setAutoSize(true);
        $activeWorksheet->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $activeWorksheet->getStyle('B')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $activeWorksheet->getStyle('C')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $activeWorksheet->getStyle('D')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $activeWorksheet->getStyle('E')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $activeWorksheet->getStyle('F')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $activeWorksheet->getStyle('G')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $activeWorksheet->getStyle('H')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $activeWorksheet->getStyle('I')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $activeWorksheet->getStyle('J')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $activeWorksheet->getStyle('K')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $activeWorksheet->setCellValue('E1' ,'Danh sách điểm')->mergeCells('E1:G1');
        $activeWorksheet->getStyle('E1')->applyFromArray($fontArray);
        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $activeWorksheet->setCellValue('A3' ,'STT')->getStyle('A3')->applyFromArray($boldArray);
        $activeWorksheet->setCellValue('B3' ,'Mã lớp')->getStyle('B3')->applyFromArray($boldArray);
        $activeWorksheet->setCellValue('C3' ,'Tên lớp')->getStyle('C3')->applyFromArray($boldArray);
        $activeWorksheet->setCellValue('D3' ,'Mã sinh viên')->getStyle('D3')->applyFromArray($boldArray);
        $activeWorksheet->setCellValue('E3' ,'Sinh viên')->getStyle('E3')->applyFromArray($boldArray);
        $activeWorksheet->setCellValue('F3' ,'Điểm chuyên cần')->getStyle('F3')->applyFromArray($boldArray);
        $activeWorksheet->setCellValue('G3' ,'Điểm bài tập')->getStyle('G3')->applyFromArray($boldArray);
        $activeWorksheet->setCellValue('H3' ,'Điểm thực hành')->getStyle('H3')->applyFromArray($boldArray);
        $activeWorksheet->setCellValue('I3' ,'Điểm thi giữa kỳ')->getStyle('I3')->applyFromArray($boldArray);
        $activeWorksheet->setCellValue('J3' ,'Điểm thi cuối kỳ')->getStyle('J3')->applyFromArray($boldArray);
        $activeWorksheet->setCellValue('K3' ,'Điểm trung bình')->getStyle('K3')->applyFromArray($boldArray);

       if($request->has('id')) {
            $credit_class_id = $request->id;
            $points = RegisterClass::where('credit_class_id', $credit_class_id)->get();
       }else{
            $points = RegisterClass::all();
       }

       //Hiển thị dữ liệu bắt đầu từ hàng thứ 4
       $indexColumn = 4;
       foreach($points as $index => $point) {
            $activeWorksheet->setCellValue('A'.$indexColumn, ++$index);
            $activeWorksheet->setCellValue('B'.$indexColumn, $point->creditClass->code);
            $activeWorksheet->setCellValue('C'.$indexColumn, $point->creditClass->name);
            $activeWorksheet->setCellValue('D'.$indexColumn, $point->students->account->code);
            $activeWorksheet->setCellValue('E'.$indexColumn, $point->students->account->first_name .' '. $point->students->account->last_name);
            $activeWorksheet->setCellValue('F'.$indexColumn, $point->attendance_point);
            $activeWorksheet->setCellValue('G'.$indexColumn, $point->revise_point);
            $activeWorksheet->setCellValue('H'.$indexColumn, $point->practice_point);
            $activeWorksheet->setCellValue('I'.$indexColumn, $point->middle_test_point);
            $activeWorksheet->setCellValue('J'.$indexColumn, $point->finish_test_point);
            $activeWorksheet->setCellValue('K'.$indexColumn, $point->avg_point);
            $indexColumn++;
       }

        $activeWorksheet->setCellValue('J'.(count($points)+5), 'Đã được xuất vào '.Carbon::now()->setTimezone('Asia/Ho_Chi_Minh')->format('H:i d/m/Y'))
                        ->mergeCells('J'.(count($points)+5).':'.'L'.(count($points)+6));
        $activeWorksheet->getStyle('A3:K'.(count($points)+3))->applyFromArray($styleArray);
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="file-diem.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
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
