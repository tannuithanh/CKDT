<?php

namespace App\Http\Controllers;

use App\Models\ApproveLf;
use App\Models\LeaveForm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\LeaveFormMail;
use App\Mail\LeaveFormMailNew;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class LeaveForms extends Controller
{
    public function leaveForms(){
        $users = $this->getUsers();
        $usersConsider = $this->getUserConsider();
        $usersReplace = $this->getUserReplace();
        return view('forms.leaveForms', compact('users','usersConsider','usersReplace'));
    }

    public function saveLeaveForms(Request $request){
        // Lấy dữ liệu từ request
        $employeeCode = $request->input('employeeCode');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $reason = $request->input('reason');
        $usersReplace = $request->input('usersReplace');
        $note = $request->input('note');
        $createdDate = $request->input('createdDate');
        $reviewName = $request->input('reviewName');
        $approvalName = $request->input('approvalName');

        // Tìm người dùng dựa trên employeeCode
        $user = User::where('MSNV', $employeeCode)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $userId = $user->id; // ID của người dùng

        // Tạo mã đơn xin nghỉ phép
        $now = new \DateTime();
        $formattedDate = $now->format('Ymd');
        $hours = $now->format('H');
        $minutes = $now->format('i');
        $seconds = $now->format('s');
        $codeLeaveForm = "GXP{$userId}{$formattedDate}{$hours}{$minutes}{$seconds}";

        // Tạo và lưu LeaveForm
        $leaveForm = new LeaveForm();
        $leaveForm->CodeLeaveForm = $codeLeaveForm;
        $leaveForm->IDMemberLeave = $userId;
        $leaveForm->TimeLeaveStart = $startDate;
        $leaveForm->TimeLeaveEnd = $endDate;
        $leaveForm->Reason = $reason;
        $leaveForm->IDMemberReplace = $usersReplace;
        $leaveForm->IDMemberCreated = Auth::id(); // ID của người tạo phiếu (người dùng hiện tại)
        $leaveForm->DateCreated = $createdDate;
        $leaveForm->Note = $note;
        $leaveForm->save();

        // Lấy ID của LeaveForm vừa tạo
        $leaveFormId = $leaveForm->id;

        // Lưu thông tin vào bảng approvelf cho reviewName
        ApproveLf::create([
            'IDLeaveForms' => $leaveFormId,
            'IDMember' => $reviewName,
            'No' => 1
        ]);

        // Lưu thông tin vào bảng approveLf cho approvalName
        ApproveLf::create([
            'IDLeaveForms' => $leaveFormId,
            'IDMember' => $approvalName,
            'No' => 2
        ]);

        $leaveForm = LeaveForm::with([
            'memberLeave.position',
            'memberLeave.department',
            'approvelfs.member.position',
            'approvelfs.member.department',
            'memberReplace.position',
            'memberReplace.department',
            'memberCreated.position',
            'memberCreated.department'
        ])->find($leaveFormId);

        // Lấy thông tin người dùng từ reviewName và approvalName
        $reviewUser = User::find($reviewName);
        $approvalUser = User::find($approvalName);

        // Dữ liệu để gửi mail
        $mailData = [
            'leaveForm' => $leaveForm,
            'reviewUser' => $reviewUser,
            'approvalUser' => $approvalUser
        ];
        // dd($leaveForm->toArray());
        // Gửi mail
        Mail::to($reviewUser->MailAddress)->send(new LeaveFormMail($mailData));

        return response()->json(['success' => 'Đơn xin nghỉ phép được gửi thành công'], 200);
    }

    public function getLeaveForms($code) {
        // Lấy dữ liệu leave form và các quan hệ liên quan
        $leaveForm = LeaveForm::with([
            'memberLeave.position',
            'memberLeave.department',
            'approvelfs.member.position',
            'approvelfs.member.department',
            'memberReplace.position',
            'memberReplace.department',
            'memberCreated.position',
            'memberCreated.department'
        ])->where('CodeLeaveForm', $code)->first();

        if (!$leaveForm) {
            return view('error.errorForm');
        }

        // Lấy ID của người dùng hiện tại
        $currentUser = auth()->user();
        $currentUserId = $currentUser->id;

        // Kiểm tra nếu ID của người dùng hiện tại trùng với các ID liên quan
        $isCurrentUserInvolved =
            $leaveForm->memberCreated->id == $currentUserId ||
            $leaveForm->memberReplace->id == $currentUserId ||
            $leaveForm->memberLeave->id == $currentUserId ||
            $leaveForm->approvelfs->pluck('member.id')->contains($currentUserId);

        // Kiểm tra các điều kiện ngoại lệ
        $isException =
            ($currentUser->IDPosition == 14 && $currentUser->IDDepartment == $leaveForm->memberLeave->IDDepartment) ||
            in_array($currentUser->IDPosition, [15, 1, 2]);

        // Nếu người dùng không có quyền truy cập, trả về trang lỗi
        if (!$isCurrentUserInvolved && !$isException) {
            return view('error.errorForm');
        }

        // Định dạng trường DateCreated
        $formattedDateCreated = Carbon::parse($leaveForm->DateCreated)->format('d \t\h\á\n\g m \nă\m Y');

        // Lấy thông tin người dùng hiện tại
        $users = $this->getUsers();

        // Kiểm tra các điều kiện và chuẩn bị dữ liệu cho view
        $approvelf1 = $leaveForm->approvelfs[1] ?? null;
        $approvelf0 = $leaveForm->approvelfs[0] ?? null;

        // Điều kiện hiển thị nút cho người kiểm tra
        $showCheckButtons = $approvelf0 && is_null($approvelf0->Status) && $approvelf0->No == 1 && $users->MSNV == $approvelf0->member->MSNV;
        $showCheckSignature = $approvelf0 && !is_null($approvelf0->Status) && $approvelf0->No == 1;

        // Điều kiện hiển thị nút cho người duyệt phiếu cuối cùng
        $showApproveButtons = $approvelf1 && $leaveForm->approvelfs->where('No', 1)->first()->Status == 1 && is_null($approvelf1->Status) && $approvelf1->No == 2 && $users->MSNV == $approvelf1->member->MSNV;
        $showApproveSignature = $approvelf1 && !is_null($approvelf1->Status) && $approvelf1->No == 2;

        return view('forms.getLeaveForm', compact(
            'leaveForm',
            'users',
            'approvelf1',
            'approvelf0',
            'showApproveButtons',
            'showApproveSignature',
            'showCheckButtons',
            'showCheckSignature',
            'formattedDateCreated' // truyền giá trị ngày đã định dạng đến view
        ));
    }

    public function handleCheck(Request $request) {
        $type = $request->input('type');
        $action = $request->input('action');
        $code = $request->input('code');

        // Tìm leave form theo code
        $leaveForm = LeaveForm::where('CodeLeaveForm', $code)
            ->with(['memberCreated', 'approvelfs.member'])
            ->first();

        if ($leaveForm) {
            $email = '';
            $name = '';
            $loaiphieu = $leaveForm->CodeLeaveForm;
            if (substr($leaveForm->CodeLeaveForm, 0, 3) === "GXP") {
                $loaiphieu = "Giấy xin phép";
            }
            $member = $leaveForm->memberCreated->FullName;

            if ($type === 'check') {
                $approvelf = $leaveForm->approvelfs->where('No', 1)->first();
                if ($approvelf) {
                    if ($action === 'accept') {
                        $approvelf->Status = 1; // Chấp nhận
                        $approvelf->TimeStamp = now(); // Cập nhật thời gian phê duyệt
                        $approvelf->save();

                        // Gửi email cho người có No = 2
                        $approvelfNo2 = $leaveForm->approvelfs->where('No', 2)->first();
                        if ($approvelfNo2) {
                            $email = $approvelfNo2->member->MailAddress;
                            $name = 'Anh có yêu cầu cần được phê duyệt từ phần mềm chữ ký điện tử';

                            // Thực hiện gửi email
                            Mail::to($email)->send(new LeaveFormMailNew(
                                $leaveForm->memberCreated->department->NameDept,
                                $leaveForm->approvelfs['1']['member']['FullName'],
                                $name,
                                $loaiphieu,
                                $leaveForm->CodeLeaveForm,
                                $member,
                                route('getLeaveForms', $leaveForm->CodeLeaveForm)
                            ));
                        }
                    } elseif ($action === 'reject') {
                        $approvelf->Status = 0; // Từ chối
                        $approvelf->TimeStamp = now();
                        $approvelf->save();

                        $email = $leaveForm->memberCreated->MailAddress;
                        $name = 'Giấy xin phép của Anh/Chị đã bị <b style="color: red">TỪ CHỐI</b>';

                        // Thực hiện gửi email
                        Mail::to($email)->send(new LeaveFormMailNew(
                            $leaveForm->memberCreated->department->NameDept,
                            $leaveForm->memberCreated->department->FullName,
                            $name,
                            $loaiphieu,
                            $leaveForm->CodeLeaveForm,
                            $member,
                            route('getLeaveForms', $leaveForm->CodeLeaveForm)
                        ));
                    }
                }
            } else if ($type === 'approve') {
                $approvelf = $leaveForm->approvelfs->where('No', 2)->first();
                if ($approvelf) {
                    if ($action === 'accept') {
                        $approvelf->Status = 1; // Chấp nhận
                        $approvelf->TimeStamp = now(); // Cập nhật thời gian phê duyệt
                        $approvelf->save();

                        $email = $leaveForm->memberCreated->MailAddress;
                        $name = 'Giấy xin phép của Anh/Chị đã được <b style="color: green">PHÊ DUYỆT</b>';

                        // Lấy email của người kiểm tra (No == 1) để CC
                        $approvelfNo1 = $leaveForm->approvelfs->where('No', 1)->first();
                        $ccEmail = $approvelfNo1 ? $approvelfNo1->member->MailAddress : null;

                        // Gửi email cho người tạo đơn và CC cho người duyệt trước đó
                        $mail = Mail::to($email);

                        if ($ccEmail) {
                            $mail->cc($ccEmail);
                        }

                        $mail->send(new LeaveFormMailNew(
                            $leaveForm->memberCreated->department->NameDept,
                            $leaveForm->approvelfs['1']['member']['FullName'],
                            $name,
                            $loaiphieu,
                            $leaveForm->CodeLeaveForm,
                            $member,
                            route('getLeaveForms', $leaveForm->CodeLeaveForm)
                        ));
                    } elseif ($action === 'reject') {
                        $approvelf->Status = 0; // Từ chối
                        $approvelf->TimeStamp = now();
                        $approvelf->save();

                        $subjectMail = $loaiphieu . ' của Anh/Chị đã bị từ chối';
                        $email = $leaveForm->memberCreated->MailAddress;
                        $name = 'Giấy xin phép của Anh/Chị đã bị <b style="color: red">TỪ CHỐI</b>';

                        // Lấy email của người kiểm tra (No == 1) để CC
                        $approvelfNo1 = $leaveForm->approvelfs->where('No', 1)->first();
                        $ccEmail = $approvelfNo1 ? $approvelfNo1->member->MailAddress : null;

                        // Gửi email cho người tạo đơn và CC cho người duyệt trước đó
                        $mail = Mail::to($email);

                        if ($ccEmail) {
                            $mail->cc($ccEmail);
                        }

                        $mail->send(new LeaveFormMailNew(
                            $leaveForm->memberCreated->department->NameDept,
                            $leaveForm->approvelfs['1']['member']['FullName'],
                            $name,
                            $loaiphieu,
                            $leaveForm->CodeLeaveForm,
                            $member,
                            route('getLeaveForms', $leaveForm->CodeLeaveForm)
                        ));
                    }
                }
            }

            // Kiểm tra email đã gửi
            return response()->json(['success' => true, 'email' => $email]);
        }

        return response()->json(['success' => false, 'message' => 'Leave form not found']);
    }


}


