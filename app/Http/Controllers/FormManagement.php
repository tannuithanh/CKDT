<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\JobRequestForm;
use App\Models\LeaveForm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormManagement extends Controller
{
    public function formsManagement(){
        $userAll = $this->getUsersAll();
        $users = $this->getUsers();  // Lấy thông tin người dùng hiện tại
        $userId = $users->id;  // Lấy ID người dùng hiện tại
        $userPosition = $users->IDPosition;  // Lấy vị trí (chức vụ) của người dùng
        $userDepartmentId = $users->IDDepartment;  // Lấy ID phòng ban của người dùng
        $limit = 20; // Số lượng bản ghi muốn lấy

        // Khởi tạo truy vấn cơ bản cho người dùng hiện tại
        $formsQuery = LeaveForm::where('IDMemberCreated', $userId)
                                ->with(['memberLeave.department', 'memberLeave.position',
                                        'memberReplace.department', 'memberReplace.position',
                                        'memberCreated.department', 'memberCreated.position',
                                        'approvelfs'])
                                ->orderBy('DateCreated');  // Sắp xếp phiếu theo ngày tạo

        // Kiểm tra theo vị trí (chức vụ) của người dùng
        switch ($userPosition) {
            case 6:
            case 7:
            case 14:
                // Lấy danh sách phiếu của phòng ban của mình
                $departmentUsers = User::where('IDDepartment', $userDepartmentId)->pluck('id');
                $formsQuery->orWhereIn('IDMemberCreated', $departmentUsers);
                break;

            case 1:
            case 2:
                // Lấy phiếu khi No = 1 và Status = 1 và các phiếu có No = 2 và status có giá trị
                $formsQuery->orWhereHas('approvelfs', function($query) {
                    $query->where(function($q) {
                        $q->where('No', 1)->where('Status', 1);
                    })->orWhere(function($q) {
                        $q->where('No', 2)->whereNotNull('Status');
                    });
                });
                break;

            case 15:
                // Lấy tất cả các phiếu của phòng ban, nhưng phiếu của người khác chỉ lấy khi No = 2 và Status = 1
                $departmentUsers = User::where('IDDepartment', $userDepartmentId)->pluck('id');
                $formsQuery->orWhere(function($query) use ($userId, $departmentUsers) {
                    $query->where('IDMemberCreated', $userId)
                          ->orWhereIn('IDMemberCreated', $departmentUsers)
                          ->whereHas('approvelfs', function($subQuery) {
                              $subQuery->where('No', 2)->where('Status', 1);
                          });
                });
                break;

            case 3:
                // Lấy phiếu của nhân sự thuộc phòng ban có group = XM
                $xmDepartmentUsers = User::whereHas('department', function($q) {
                    $q->where('group', 'XM');
                })->pluck('id');
                $formsQuery->orWhereIn('IDMemberCreated', $xmDepartmentUsers);
                break;

            case 4:
                // Lấy phiếu của nhân sự thuộc phòng ban có group = TK
                $tkDepartmentUsers = User::whereHas('department', function($q) {
                    $q->where('group', 'TK');
                })->pluck('id');
                $formsQuery->orWhereIn('IDMemberCreated', $tkDepartmentUsers);
                break;

            case 5:
                // Lấy phiếu của nhân sự thuộc phòng ban có group = MP-TN
                $mpTnDepartmentUsers = User::whereHas('department', function($q) {
                    $q->where('group', 'MP-TN');
                })->pluck('id');
                $formsQuery->orWhereIn('IDMemberCreated', $mpTnDepartmentUsers);
                break;

            default:
                break;
        }

        // Giới hạn số lượng bản ghi và lấy kết quả
        $forms = $formsQuery->take($limit)->get();

        // Xử lý các bước phê duyệt cho từng form
        $forms = $forms->map(function ($form) {
            $form->status = $this->determineFormStatus($form->approvelfs);
            return $form;
        });

        return view('formManagement', compact('users', 'forms', 'userAll'));  // Trả về view với dữ liệu
    }


    private function determineFormStatus($approvelfs) {
        foreach ($approvelfs as $approval) {
            if ($approval['Status'] === null) {
                if ($approval['No'] == 1) {
                    return 'Đang kiểm tra';
                } else {
                    return 'Đang chờ duyệt';
                }
            } elseif ($approval['Status'] == 0) {
                return 'Từ chối';
            }
        }
        return 'Đã duyệt';
    }

    public function deleteLeaveForm(Request $request){
        $formId = $request->input('form_id');

        // Tìm phiếu theo ID
        $form = LeaveForm::findOrFail($formId);

        // Kiểm tra xem người dùng hiện tại có quyền xóa phiếu này không
        $currentUser = auth()->user();
        if ($currentUser->id == $form->IDMemberCreated) {
            // Xóa phiếu
            $form->delete();

            // Trả về JSON response thành công
            return response()->json(['success' => 'Phiếu đã được xóa thành công']);
        } else {
            // Trả về JSON response lỗi
            return response()->json(['error' => 'Bạn không có quyền xóa phiếu này'], 403);
        }
    }

    public function getUsersAllInput() {
        $currentUser = $this->getUsers(); // Lấy người dùng hiện tại
        $userPosition = $currentUser->IDPosition; // Lấy vị trí của người dùng hiện tại
        $userDepartmentId = $currentUser->IDDepartment; // Lấy phòng ban của người dùng hiện tại

        $query = User::with(['position', 'department']);

        // Kiểm tra vị trí của người dùng hiện tại
        if (in_array($userPosition, [1, 2, 15])) {
            // Nếu vị trí là 1, 2, 15 thì lấy tất cả nhân sự
            $userAll = $query->get();
        } elseif (in_array($userPosition, [6, 7, 14])) {
            // Nếu vị trí là 6, 7, 14 thì chỉ lấy nhân sự trong cùng phòng ban
            $userAll = $query->where('IDDepartment', $userDepartmentId)->get();
        } elseif ($userPosition == 3) {
            // Nếu vị trí là 3 thì chỉ lấy nhân sự trong phòng ban có group là 'XM'
            $userAll = $query->whereHas('department', function($q) {
                $q->where('group', 'XM');
            })->get();
        } elseif ($userPosition == 4) {
            // Nếu vị trí là 4 thì chỉ lấy nhân sự trong phòng ban có group là 'TK'
            $userAll = $query->whereHas('department', function($q) {
                $q->where('group', 'TK');
            })->get();
        } elseif ($userPosition == 5) {
            // Nếu vị trí là 5 thì chỉ lấy nhân sự trong phòng ban có group là 'MP-TN'
            $userAll = $query->whereHas('department', function($q) {
                $q->where('group', 'MP-TN');
            })->get();
        } else {
            // Nếu vị trí không nằm trong các trường hợp trên, chỉ lấy người dùng hiện tại
            $userAll = $query->where('id', $currentUser->id)->get();
        }

        return response()->json($userAll);
    }

    public function searchLeaveFormData(Request $request) {
        $msnv = $request->input('employee_name');
        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $users = $this->getUsers();
        $userId = $users->id;
        $userPosition = $users->IDPosition;
        $userDepartmentId = $users->IDDepartment;

        // Điều kiện lọc cơ bản
        $query = LeaveForm::query();

        // Lọc theo quyền hạn của người dùng
        if (in_array($userPosition, [6, 7, 14])) {
            $departmentUsers = User::where('IDDepartment', $userDepartmentId)->pluck('id');
            $query->where(function($query) use ($userId, $departmentUsers) {
                $query->where('IDMemberCreated', $userId)
                      ->orWhereIn('IDMemberCreated', $departmentUsers);
            });
        } elseif (in_array($userPosition, [1, 2, 15])) {
            $query->whereNotNull('IDMemberCreated');
        } elseif ($userPosition == 3) {
            $xmDepartmentUsers = User::whereHas('department', function($q) {
                $q->where('group', 'XM');
            })->pluck('id');
            $query->whereIn('IDMemberCreated', $xmDepartmentUsers);
        } elseif ($userPosition == 4) {
            $tkDepartmentUsers = User::whereHas('department', function($q) {
                $q->where('group', 'TK');
            })->pluck('id');
            $query->whereIn('IDMemberCreated', $tkDepartmentUsers);
        } elseif ($userPosition == 5) {
            $mpTnDepartmentUsers = User::whereHas('department', function($q) {
                $q->where('group', 'MP-TN');
            })->pluck('id');
            $query->whereIn('IDMemberCreated', $mpTnDepartmentUsers);
        } else {
            $query->where('IDMemberCreated', $userId);
        }

        // Lọc theo MSNV (nếu có)
        if ($msnv) {
            $query->whereHas('memberLeave', function($query) use ($msnv) {
                $query->where('MSNV', $msnv);
            });
        }

        // Lọc theo trạng thái (nếu có)
        if ($status !== null) {
            $query->whereHas('approvelfs', function($subQuery) use ($status) {
                if ($status == 1) {
                    $subQuery->where('No', 2)->where('Status', 1);
                } else {
                    $subQuery->where(function($q) {
                        $q->where('No', 1)->where('Status', 0)
                          ->orWhere(function($q) {
                              $q->where('No', 2)->where('Status', 0);
                          });
                    });
                }
            });
        }

        // Lọc theo ngày bắt đầu và ngày kết thúc (nếu có)
        if ($startDate && $endDate) {
            $query->whereBetween('TimeLeaveStart', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->whereDate('TimeLeaveStart', '>=', $startDate);
        } elseif ($endDate) {
            $query->whereDate('TimeLeaveEnd', '<=', $endDate);
        }

        // Giới hạn số lượng kết quả trả về là 20
        $forms = $query->with(['memberLeave.department', 'memberLeave.position',
                               'memberReplace.department', 'memberReplace.position',
                               'memberCreated.department', 'memberCreated.position',
                               'approvelfs'])
                       ->orderBy('DateCreated')
                       ->take(20) // Lấy tối đa 20 bản ghi
                       ->get(); // Lấy tất cả kết quả

        // Xử lý các bước phê duyệt cho từng form
        $forms = $forms->map(function ($form) {
            $form->status = $this->determineFormStatus($form->approvelfs);
            return $form;
        });

        // Trả về kết quả dưới dạng JSON để xử lý trong JavaScript
        return response()->json($forms);
    }


//GET PYC
    public function getPYC(){
        $users = $this->getUsers();  // Lấy thông tin người dùng hiện tại
        $userId = $users->id;  // Lấy ID người dùng hiện tại
        $userPosition = $users->IDPosition;  // Lấy vị trí (chức vụ) của người dùng
        $userDepartmentId = $users->IDDepartment;  // Lấy ID phòng ban của người dùng

        // Bắt đầu xây dựng truy vấn
        $formsQuery = JobRequestForm::query();

        // Áp dụng điều kiện truy vấn dựa trên quyền hạn của người dùng
        if (in_array($userPosition, [1, 2])) {
            // Người dùng với vị trí 1 và 2 có thể xem tất cả các phiếu
            $formsQuery->with(['departmentRequest', 'departmentPerforming', 'approvejsfs.member']);
        } elseif ($userPosition == 4) {
            // Xem được tất cả các phòng ban có group = TK
            $tkDepartmentIds = Department::where('Group', 'TK')->pluck('id');
            $formsQuery->whereIn('IDDepartmentRequest', $tkDepartmentIds)
                    ->orWhereIn('IDDepartmentPerforming', $tkDepartmentIds);
        } elseif ($userPosition == 5) {
            // Xem được tất cả các phòng ban có group = MP-TN
            $mpTnDepartmentIds = Department::where('Group', 'MP-TN')->pluck('id');
            $formsQuery->whereIn('IDDepartmentRequest', $mpTnDepartmentIds)
                    ->orWhereIn('IDDepartmentPerforming', $mpTnDepartmentIds);
        } elseif ($userPosition == 3) {
            // Xem được tất cả các phòng ban có group = XM
            $xmDepartmentIds = Department::where('Group', 'XM')->pluck('id');
            $formsQuery->whereIn('IDDepartmentRequest', $xmDepartmentIds)
                    ->orWhereIn('IDDepartmentPerforming', $xmDepartmentIds);
        } else {
            // Người dùng bình thường chỉ có thể xem phiếu của mình, của các thành viên trong phòng ban tạo và phòng ban được yêu cầu
            $formsQuery->where(function($query) use ($userDepartmentId) {
                $query->where('IDDepartmentRequest', $userDepartmentId)
                    ->orWhere('IDDepartmentPerforming', $userDepartmentId);
            });
        }

        // Lấy dữ liệu với các điều kiện
        $forms = $formsQuery->with(['departmentRequest', 'departmentPerforming', 'approvejsfs.member'])
                            ->get();

        // Xử lý trạng thái của mỗi form
        $forms->each(function($form) {
            $form->setAttribute('status', $this->determineFormStatusJRF($form->approvejsfs));
        });

        // Trả về dữ liệu dưới dạng JSON
        return response()->json($forms);
    }

    // Hàm xác định trạng thái của form
    private function determineFormStatusJRF($approvejsfs) {
        $status = 'Unknown'; // Giá trị mặc định

        // Kiểm tra các bước duyệt
        foreach ($approvejsfs as $approve) {

            if (is_null($approve->Status)) {
                // Kiểm tra từng No và trạng thái
                if ($approve->No == 1) {
                    return 'Người tạo phiếu';
                } elseif ($approve->No == 2) {
                    return 'Đang kiểm tra';
                } elseif ($approve->No == 3) {
                    return 'Đang xem xét';
                } elseif ($approve->No == 4) {
                    return 'Phiếu đã được duyệt';
                }
            } elseif ($approve->Status == 0) {
                // Nếu có bất kỳ bước nào bị từ chối
                return 'Từ chối';
            }
        }

        // Nếu tất cả các bước đều có trạng thái 1, trả về "Phiếu đã được duyệt"
        if ($approvejsfs->every(function($approve) {
            return $approve->Status == 1;
        })) {
            return 'Phiếu đã được duyệt';
        }

        return $status;
    }

    public function searchJRFData(Request $request){
        $users = $this->getUsers();  // Lấy thông tin người dùng hiện tại
        $userId = $users->id;  // Lấy ID người dùng hiện tại
        $userPosition = $users->IDPosition;  // Lấy vị trí (chức vụ) của người dùng
        $userDepartmentId = $users->IDDepartment;  // Lấy ID phòng ban của người dùng

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Bắt đầu xây dựng truy vấn
        $formsQuery = JobRequestForm::query();

        // Áp dụng điều kiện truy vấn dựa trên quyền hạn của người dùng
        if (in_array($userPosition, [1, 2])) {
            // Người dùng với vị trí 1 và 2 có thể xem tất cả các phiếu
            $formsQuery->with(['departmentRequest', 'departmentPerforming', 'approvejsfs.member']);
        } elseif ($userPosition == 4) {
            // Xem được tất cả các phòng ban có group = TK
            $tkDepartmentIds = Department::where('Group', 'TK')->pluck('id');
            $formsQuery->whereIn('IDDepartmentRequest', $tkDepartmentIds)
                    ->orWhereIn('IDDepartmentPerforming', $tkDepartmentIds);
        } elseif ($userPosition == 5) {
            // Xem được tất cả các phòng ban có group = MP-TN
            $mpTnDepartmentIds = Department::where('Group', 'MP-TN')->pluck('id');
            $formsQuery->whereIn('IDDepartmentRequest', $mpTnDepartmentIds)
                    ->orWhereIn('IDDepartmentPerforming', $mpTnDepartmentIds);
        } elseif ($userPosition == 3) {
            // Xem được tất cả các phòng ban có group = XM
            $xmDepartmentIds = Department::where('Group', 'XM')->pluck('id');
            $formsQuery->whereIn('IDDepartmentRequest', $xmDepartmentIds)
                    ->orWhereIn('IDDepartmentPerforming', $xmDepartmentIds);
        } else {
            // Người dùng bình thường chỉ có thể xem phiếu của mình, của các thành viên trong phòng ban tạo và phòng ban được yêu cầu
            $formsQuery->where(function($query) use ($userDepartmentId) {
                $query->where('IDDepartmentRequest', $userDepartmentId)
                    ->orWhere('IDDepartmentPerforming', $userDepartmentId);
            });
        }

        // Lọc theo ngày bắt đầu và kết thúc
        if ($startDate) {
            $formsQuery->whereDate('DateCreate', '>=', $startDate);
        }
        if ($endDate) {
            $formsQuery->whereDate('DateCreate', '<=', $endDate);
        }

        // Lấy dữ liệu với các điều kiện
        $forms = $formsQuery->with(['departmentRequest', 'departmentPerforming', 'approvejsfs.member'])
                            ->get();

        // Xử lý trạng thái của mỗi form
        $forms->each(function($form) {
            $form->setAttribute('status', $this->determineFormStatusJRF($form->approvejsfs));
        });

        // Trả về dữ liệu dưới dạng JSON
        return response()->json($forms);
    }


}
