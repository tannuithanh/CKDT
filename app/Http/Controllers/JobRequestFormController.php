<?php

namespace App\Http\Controllers;

use App\Mail\JobRequestFormMail;
use App\Mail\JobRequestFormMailNew;
use App\Models\ApproveJsf;
use App\Models\JobRequestForm;
use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class JobRequestFormController extends Controller
{
    public function jobRequestForm(){
        $users = $this->getUsers();
        $departmentAll = $this->getDepartments();
        $userConsider = $this->getUserConsiderJobForm();
        $usersBanLanhDao = User::where('IDDepartment', 1)->get();

        return view('forms.jobRequestForm',compact('users','departmentAll','userConsider','usersBanLanhDao'));
    }

    public function getUserByDepartment(Request $request){
        $departmentId = $request->input('department_id');

        // Lấy thông tin phòng ban để kiểm tra group
        $department = Department::find($departmentId);
        $group = $department->group;

        // Lấy nhân sự theo vị trí (position) cho phần xem xét
        $userConsider = User::where('IDDepartment', $departmentId)
                            ->where(function($query) use ($departmentId) {
                                $query->whereIn('IDPosition', [6, 7]);

                                if ($departmentId == 12) {
                                    $query->orWhere('IDPosition', 17);
                                }
                            })
                            ->get();

        // Lấy nhân sự theo vị trí (position) cho phần phê duyệt (không phụ thuộc vào phòng ban)
        $userApprove = User::query();

        switch ($group) {
            case 'TK':
                $userApprove->whereIn('IDPosition', [1, 2, 4]);
                break;
            case 'XM':
                $userApprove->whereIn('IDPosition', [1, 2, 3]);
                break;
            case 'MP-TN':
                $userApprove->whereIn('IDPosition', [1, 2, 5]);
                break;
            default:
                $userApprove->whereIn('IDPosition', [1, 2]);
                break;
        }

        $userApprove = $userApprove->get();

        // Trả về dữ liệu dưới dạng JSON
        return response()->json([
            'userConsider' => $userConsider,
            'userApprove' => $userApprove,
        ]);
    }

    public function saveRequestForm(Request $request){
        // Validate dữ liệu gửi lên từ form
        $validatedData = $request->validate([
            'IDDepartmentRequest' => 'required|string',
            'IDDepartmentPerforming' => 'required|integer',
            'Content' => 'required|string',
            'TimeFinish' => 'required|date',
            'Note' => 'nullable|string',
            'DateCreate' => 'required|date',
        ]);

        // Lấy ID của DepartmentRequest dựa trên tên phòng ban
        $departmentRequest = Department::where('NameDept', $validatedData['IDDepartmentRequest'])->firstOrFail();

        // Lấy ID người dùng dựa trên MSNV
        $creator = User::where('MSNV', $request['creatorId'])->firstOrFail();
        $checkPerson = User::where('MSNV', $request['checkPersonId'])->firstOrFail();
        $reviewPerson = User::where('MSNV', $request['reviewPersonId'])->firstOrFail();
        $approvePerson = User::where('MSNV', $request['approvePersonId'])->firstOrFail();

        // Tạo CodeJobRequestForms
        $formattedDate = now()->format('YmdHis'); // Ngày tháng năm và giờ phút giây
        $codeJobRequestForm = 'PYC' . $departmentRequest->id . $validatedData['IDDepartmentPerforming'] . $formattedDate;

        // Lưu phiếu yêu cầu công việc
        $jobRequestForm = JobRequestForm::create([
            'CodeJobRequestForms' => $codeJobRequestForm,
            'IDDepartmentRequest' => $departmentRequest->id,
            'IDDepartmentPerforming' => $validatedData['IDDepartmentPerforming'],
            'Content' => $validatedData['Content'],
            'TimeFinish' => $validatedData['TimeFinish'],
            'Note' => $validatedData['Note'],
            'DateCreate' => $validatedData['DateCreate'], // Sử dụng thời gian hiện tại
        ]);

        // Lưu thông tin phê duyệt
        $approveJsfData = [];

        if ($creator->id !== $checkPerson->id) {
            $approveJsfData[] = [
                'IDJobRequestForms' => $jobRequestForm->id,
                'IDMember' => $creator->id,
                'No' => 1,
                'status' => '1',
                'TimeStamp'=> now()
            ];
            $approveJsfData[] = [
                'IDJobRequestForms' => $jobRequestForm->id,
                'IDMember' => $checkPerson->id,
                'No' => 2,
                'status' => null,
                'TimeStamp'=> Null
            ];
            $approveJsfData[] = [
                'IDJobRequestForms' => $jobRequestForm->id,
                'IDMember' => $reviewPerson->id,
                'No' => 3,
                'status' => null,
                'TimeStamp'=> Null
            ];
            $approveJsfData[] = [
                'IDJobRequestForms' => $jobRequestForm->id,
                'IDMember' => $approvePerson->id,
                'No' => 4,
                'status' => null,
                'TimeStamp'=> Null
            ];
        } else {
            $approveJsfData[] = [
                'IDJobRequestForms' => $jobRequestForm->id,
                'IDMember' => $creator->id,
                'No' => 1,
                'status' => '1',
                'TimeStamp'=> now()
            ];
            $approveJsfData[] = [
                'IDJobRequestForms' => $jobRequestForm->id,
                'IDMember' => $reviewPerson->id,
                'No' => 2,
                'status' => null,
                'TimeStamp'=> Null
            ];
            $approveJsfData[] = [
                'IDJobRequestForms' => $jobRequestForm->id,
                'IDMember' => $approvePerson->id,
                'No' => 3,
                'status' => null,
                'TimeStamp'=> Null
            ];
        }

        ApproveJsf::insert($approveJsfData);
        $approveJsf = ApproveJsf::where('IDJobRequestForms', $jobRequestForm->id)
                             ->where('No', 2)
                             ->first();
        $approveCreated = ApproveJsf::where('IDJobRequestForms', $jobRequestForm->id)
                             ->where('No', 1)
                             ->first();


        if ($approveJsf) {
            // Tìm user dựa trên IDMember trong approveJsf
            $user = User::find($approveJsf->IDMember);
            $userCreated = User::with('department')->find($approveCreated->IDMember);
            if ($user && $user->MailAddress) {
                // Gửi email
                Mail::to($user->MailAddress)->send(new JobRequestFormMail($jobRequestForm,$userCreated));
            }
        }
        return response()->json(['success' => true, 'message' => 'Phiếu yêu cầu công việc đã lưu thành công']);
    }

    public function checkRequestForms($code){
        // Lấy dữ liệu JobRequestForm và các quan hệ liên quan
        $jobRequestForm = JobRequestForm::with(['approvejsfs'])
            ->where('CodeJobRequestForms', $code)
            ->first();

        // Nếu phiếu không tồn tại, trả về lỗi 404
        if (!$jobRequestForm) {
            return view('error.errorForm');
        }

        // Lấy ID của người dùng hiện tại
        $currentUser = auth()->user();
        $currentUserId = $currentUser->id;
        $currentUserDepartmentId = $currentUser->IDDepartment;
        $currentUserPosition = $currentUser->IDPosition;

        // Kiểm tra quyền truy cập dựa trên các điều kiện
        $isCurrentUserInvolved =
            $jobRequestForm->departmentRequest->id == $currentUserDepartmentId ||
            $jobRequestForm->departmentPerforming->id == $currentUserDepartmentId ||
            $jobRequestForm->approvejsfs->pluck('IDMember')->contains($currentUserId);

        // Lấy group của phòng ban hiện tại của người dùng
        $currentUserDepartmentGroup = $currentUser->department->Group;

        // Kiểm tra các điều kiện ngoại lệ
        $isException =
            ($currentUserPosition == 4 && $currentUserDepartmentGroup == 'TK') ||
            ($currentUserPosition == 5 && $currentUserDepartmentGroup == 'MP-TN') ||
            ($currentUserPosition == 3 && $currentUserDepartmentGroup == 'XM') ||
            in_array($currentUserPosition, [1, 2]);

        // Nếu người dùng không có quyền truy cập và không nằm trong các điều kiện ngoại lệ
        if (!$isCurrentUserInvolved && !$isException) {
            return view('error.errorForm');
        }

        // Nếu người dùng có quyền truy cập, thực hiện các thao tác tiếp theo hoặc trả về view tương ứng
        return view('forms.getJobRequestForm', compact('jobRequestForm'));
    }

    public function getJRFByCode(Request $request){
        // Lấy mã code từ yêu cầu AJAX
        $code = $request->input('code');

        // Tìm kiếm trong bảng JobRequestForm dựa trên CodeJobRequestForms
        $jobRequestForm = JobRequestForm::with(['departmentRequest', 'departmentPerforming', 'approvejsfs.member'])
            ->where('CodeJobRequestForms', $code)
            ->first();
        $user = $this->getUsers();
        // Kiểm tra nếu không tìm thấy phiếu yêu cầu công việc
        if (!$jobRequestForm) {
            return response()->json(['message' => 'Phiếu yêu cầu công việc không tồn tại'], 404);
        }

        // Đếm số lượng approvejsfs
        $approvejsfCount = $jobRequestForm->approvejsfs->count();

        // Trả về dữ liệu phiếu yêu cầu công việc và số lượng approvejsfs
        return response()->json([
            'jobRequestForm' => $jobRequestForm,
            'approvejsfCount' => $approvejsfCount,
            'user_id'=>$user->id
        ]);
    }

    public function approveFormRequest(Request $request){
        // Lấy giá trị từ request
        $code = $request->input('code');
        $no = $request->input('no');
        $decision = $request->input('decision'); // 1 = đồng ý, 0 = từ chối
        $comment = $request->input('comment');

        // Tìm JobRequestForm dựa vào code
        $jobRequestForm = JobRequestForm::where('CodeJobRequestForms', $code)->first();
        $approveCreated = ApproveJsf::where('IDJobRequestForms', $jobRequestForm->id)
                                    ->where('No', 1)
                                    ->first();
        $userCreatedJSF = User::with('department')->find($approveCreated->IDMember);
        if ($jobRequestForm) {
            // Lấy ID từ JobRequestForm
            $jobRequestFormId = $jobRequestForm->id;

            // Tìm ApproveJsf với IDJobRequestForms và No
            $approveJsf = ApproveJsf::where('IDJobRequestForms', $jobRequestFormId)
                                    ->where('No', $no)
                                    ->first();

            if ($approveJsf) {
                // Cập nhật thông tin ApproveJsf
                $approveJsf->Status = $decision;
                $approveJsf->TimeStamp = now();

                // Kiểm tra và gán giá trị comment nếu có
                if (!empty($comment)) {
                    $approveJsf->Note = $comment;
                }

                $approveJsf->save();

                // Lấy danh sách tất cả các No cho JobRequestForm này
                $allApprovals = ApproveJsf::where('IDJobRequestForms', $jobRequestFormId)
                                            ->orderBy('No')
                                            ->get();

                // Gửi email dựa trên logic của No hiện tại
                $totalNo = $allApprovals->count();

                if ($decision == 0) { // Nếu từ chối
                    $messageContent = 'Phiếu yêu cầu của Anh/Chị đã bị <b style="color: red">TỪ CHỐI</b>.';
                    if ($no == 2) {
                        $creator = User::find($approveCreated->IDMember);
                        Mail::to($creator->MailAddress)->send(new JobRequestFormMailNew($jobRequestForm, $messageContent, $userCreatedJSF));
                    } elseif ($no == 3) {
                        $creator = User::find($approveCreated->IDMember);
                        $ccUser = User::find($allApprovals->where('No', 2)->first()->IDMember);
                        Mail::to($creator->MailAddress)
                            ->cc($ccUser->MailAddress)
                            ->send(new JobRequestFormMailNew($jobRequestForm, $messageContent, $userCreatedJSF));
                    } elseif ($no == 4) {
                        $creator = User::find($approveCreated->IDMember);
                        $ccUsers = User::whereIn('id', $allApprovals->whereIn('No', [2, 3])->pluck('IDMember'))->pluck('MailAddress');
                        Mail::to($creator->MailAddress)
                            ->cc($ccUsers)
                            ->send(new JobRequestFormMailNew($jobRequestForm, $messageContent, $userCreatedJSF));
                    }
                } else if ($decision == 1) { // Nếu phê duyệt
                    if ($no < $totalNo) {
                        // Gửi email cho người có No kế tiếp
                        $nextApproval = $allApprovals->where('No', $no + 1)->first();
                        if ($nextApproval) {
                            $nextUser = User::find($nextApproval->IDMember);
                            if ($nextUser && $nextUser->MailAddress) {
                                $messageContent = 'Phiếu yêu cầu đang chờ bạn kiểm tra';
                                Mail::to($nextUser->MailAddress)->send(new JobRequestFormMailNew($jobRequestForm, $messageContent, $userCreatedJSF));
                            }
                        }
                    } else {
                        // Trường hợp No hiện tại là cuối cùng
                        $firstApproval = $allApprovals->where('No', 1)->first();
                        $ccRecipients = $allApprovals->where('No', '<', $no)->pluck('IDMember');

                        // Lấy email người CC
                        $ccEmails = User::whereIn('id', $ccRecipients)->pluck('MailAddress');

                        if ($firstApproval) {
                            $firstUser = User::find($firstApproval->IDMember);
                            if ($firstUser && $firstUser->MailAddress) {
                                $messageContent = 'Phiếu yêu cầu của Anh/Chị đã được <b style="color: green">PHÊ DUYỆT</b>.';
                                Mail::to($firstUser->MailAddress)
                                    ->cc($ccEmails)
                                    ->send(new JobRequestFormMailNew($jobRequestForm, $messageContent, $userCreatedJSF));
                            }
                        }
                    }
                }

                // Trả về JSON với thông báo tiếng Việt
                return response()->json(['status' => 'success', 'message' => 'Thành công! Đã gửi mail.']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Không tìm thấy bản ghi ApproveJsf phù hợp.'], 404);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Không tìm thấy biểu mẫu yêu cầu công việc.'], 404);
        }
    }

}
