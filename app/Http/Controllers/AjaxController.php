<?php

namespace App\Http\Controllers;

use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Models\Globals\Notification;
use App\Models\Globals\TempFiles;
use App\Models\IACM\IacmLevel;
use App\Models\IACM\IacmParameter;
use App\Models\Master\Aspect\Aspect;
use App\Models\Master\Document\DocumentItem;
use App\Models\Master\Document\DocumentType;
use App\Models\Master\Extern\ExternInstance;
use App\Models\Master\Fee\BankAccount;
use App\Models\Master\Fee\CostComponent;
use App\Models\Master\Geografis\City;
use App\Models\Master\Geografis\Province;
use App\Models\Master\Ict\IctObject;
use App\Models\Master\Ict\IctType;
use App\Models\Master\Org\OrgStruct;
use App\Models\Master\Org\LevelPosition;
use App\Models\Master\Org\Position;
use App\Models\Master\Penilaian\PenilaianCategory;
use App\Models\Master\Procedure\ProcedureAudit;
use App\Models\Master\Risk\AuditRating;
use App\Models\Master\Risk\LevelDampak;
use App\Models\Master\Risk\LevelKemungkinan;
use App\Models\Master\Risk\RiskCode;
use App\Models\Master\Risk\RiskRating;
use App\Models\Master\Risk\RiskStatus;
use App\Models\Master\Risk\RiskType;
use App\Models\Master\Risk\TypeInspection;
use App\Models\Master\ServiceProvider\Provider;
use App\Models\Master\Training\TrainingInstitute;
use App\Models\Master\Training\TrainingType;
use App\Models\PenilaianKinerja\PenilaianKinerja;
use App\Models\PenilaianKinerja\PenilaianKinerjaAuditor;
use App\Models\Preparation\ApmKbn\ApmKbnDetail;
use App\Models\Preparation\Apm\ApmDetail;
use App\Models\Rkia\Rkia;
use App\Models\Rkia\Summary;
use App\Models\Survey\SurveyReg;
use App\Models\Survey\SurveyRegUser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;



class AjaxController extends Controller
{
    public function saveTempFiles(Request $request)
    {
        $this->beginTransaction();
        $mimes = null;
        if ($request->accept == '.xlsx') {
            $mimes = 'xlsx';
        }
        if ($request->accept == '.png, .jpg, .jpeg') {
            $mimes = 'png,jpg,jpeg';
        }
        if ($mimes) {
            $request->validate(
                ['file' => ['mimes:' . $mimes]]
            );
        }
        try {
            if ($file = $request->file('file')) {
                $file_path = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName());
                $file_path .= '-' . time() . '.' . $file->getClientOriginalExtension();

                $temp = new TempFiles;
                $temp->file_name = $file->getClientOriginalName();
                $temp->file_path = $file->storeAs('temp-files', $file_path, 'public');
                // $temp->file_type = $file->extension();
                $temp->file_size = $file->getSize();
                $temp->flag = $request->flag;
                $temp->save();
                return $this->commit(
                    [
                        'file' => TempFiles::find($temp->id)
                    ]
                );
            }
            return $this->rollback(['message' => 'File not found']);
        } catch (\Exception $e) {
            return $this->rollback(['error' => $e->getMessage()]);
        }
    }
    public function testNotification($emails)
    {
        if ($rkia = Rkia::latest()->first()) {
            request()->merge(
                [
                    'module' => 'rkia_operation',
                ]
            );
            $emails = explode('--', trim($emails));
            $user_ids = User::whereIn('email', $emails)->pluck('id')->toArray();
            $rkia->addNotify(
                [
                    'message' => 'Waiting Approval RKIA ' . $rkia->show_category . ' ' . $rkia->year,
                    'url' => rut('rkia.operation.summary', $rkia->id),
                    'user_ids' => $user_ids,
                ]
            );
            $record = Notification::latest()->first();
            return $this->render('mails.notification', compact('record'));
        }
    }

    public function userNotification()
    {
        $notifications = auth()->user()
            ->notifications()
            ->latest()
            ->simplePaginate(25);
        return $this->render('layouts.base.notification', compact('notifications'));
    }

    public function userNotificationRead(Notification $notification)
    {
        auth()->user()
            ->notifications()
            ->updateExistingPivot($notification, array('readed_at' => now()), false);
        return redirect($notification->full_url);
    }

    public function selectRole($search, Request $request)
    {
        $items = Role::where('name', '!=', 'Administrator')->keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;
            case 'approver':
                $perms = str_replace('_', '.', $request->perms) . '.approve';
                $items = $items->whereHas(
                    'permissions',
                    function ($q) use ($perms) {
                        $q->where('name', $perms);
                    }
                );
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }
        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectLevelPosition($search, Request $request)
    {
        $items = LevelPosition::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;
            case 'find':
                return $items->find($request->id);

            default:
                $items = $items->whereNull('id');
                break;
        }

        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectCostComponent($search, Request $request)
    {
        $items = CostComponent::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;
            case 'find':
                return $items->find($request->id);

            default:
                $items = $items->whereNull('id');
                break;
        }

        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectBankAccount($search, Request $request)
    {
        $items = BankAccount::keywordBy('number')->orderBy('number');
        switch ($search) {
            case 'all':
                $items = $items;
                break;
            case 'find':
                return $items->with('owner')->find($request->id);
                break;

            case 'byOwner':
                $owners = json_decode($request->owner);
                $items = $items->whereIn('user_id', $owners);
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }

        $items = $items->paginate();
        $results = [];
        $more = false;
        foreach ($items as $item) {
            $results[] = [
                'id' => $item->id,
                'text' => $item->number . ' - ' . $item->bank . ' - ' . $item->owner->name
            ];
        }
        if (method_exists($items, 'hasMorePages')) {
            $more = $items->hasMorePages();
        }
        return response()->json(compact('results', 'more'));
    }

    public function selectStruct($search, Request $request)
    {
        $items = OrgStruct::keywordBy('name')->orderBy('level')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;
            case 'parent_bod':
                $items = $items->whereIn('level', ['root']);
                break;
            case 'parent_department':
                $items = $items->whereIn('level', ['bod']);
                break;
            case 'parent_subdepartment':
                $items = $items->whereIn('level', ['department']);
                break;
            case 'parent_subsection':
                $items = $items->whereIn('level', ['subdepartment']);
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }
        $items = $items->when(
            $not = $request->not,
            function ($q) use ($not) {
                $q->where('id', '!=', $not);
            }
        )->get();
        $results = [];
        $more = false;

        $levels = ['root','bod', 'department', 'subdepartment', 'subsection'];
        $i = 0;
        foreach ($levels as $level) {
            if ($items->where('level', $level)->count()) {
                foreach ($items->where('level', $level) as $item) {
                    $results[$i]['text'] = strtoupper($item->show_level);
                    $results[$i]['children'][] = ['id' => $item->id, 'text' => $item->name];
                }
                $i++;
            }
        }
        return response()->json(compact('results', 'more'));
    }

    public function selectPosition($search, Request $request)
    {
        $items = Position::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;
            case 'by_location':
                $items = $items->where('location_id', $request->id);
                break;
            case 'divisi_spi':
                $location_id = OrgStruct::where('name', 'Satuan Pengawas Internal')->firstOrFail();
                $items = $items->where('location_id', $location_id);
                break;
            case 'auditor':
                $items = $items->whereHas(
                    'struct',
                    function ($qq) {
                        $qq->inAudit();
                    }
                );
                break;
            default:
                $items = $items->whereNull('id');
                break;
        }
        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectUser($search, Request $request)
    {
        $items = User::keywordBy('name')
            ->has('position')
            ->where('status', 'active')
            ->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items
                    ->when(
                        $with_admin = $request->with_admin,
                        function ($q) use ($with_admin) {
                            $q->orWhere('id', 1);
                        }
                    );
                break;
            case 'level_bod':
                $items = $items->whereHas(
                    'position',
                    function ($q) {
                        $q->whereHas(
                            'struct',
                            function ($qq) {
                                $qq->where('level', 'bod');
                            }
                        );
                    }
                );
                break;
            case 'level_boc':
                $items = $items->whereHas(
                    'position',
                    function ($q) {
                        $q->whereHas(
                            'struct',
                            function ($qq) {
                                $qq->where('level', 'boc');
                            }
                        );
                    }
                );
                break;
            case 'pengarah-nonpkpt':
                $location_id = $request->location_id ?? 0;
                $items = $items->whereHas(
                    'position',
                    function ($q) use ($location_id){
                        $q->whereHas(
                            'struct',
                            function ($qq) {
                                $qq->inAudit();
                            }
                        )->orWhereHas(
                            'nonpkpt', function ($q) use ($location_id){
                                $q->where('id', $location_id);
                            }
                        );
                    }
                );
                break;
            case 'auditor':
                $items = $items->whereHas(
                    'position',
                    function ($q) {
                        $q->whereHas(
                            'struct',
                            function ($qq) {
                                $qq->inAudit();
                            }
                        );
                    }
                );
                break;
            case 'pengendali_teknis':
                $items = $items->whereHas(
                    'position',
                    function ($q) {
                        $q->whereHas(
                            'struct',
                            function ($qq) {
                                $qq->inAudit();
                            }
                        )->whereHas('level', function ($q) {
                            $q->where('name', 'LIKE', '%' . 'Asisten Manajer SPI');
                        });
                    }
                );
                break;
            case 'assignment':
                $location_id = 0;
                if ($summary = Summary::find($request->summary_id)) {
                    $location_id = $summary->getStruct()->id ?? 0;
                }
                $items = $items->whereHas(
                    'position',
                    function ($q) use ($location_id) {
                        $q->whereHas(
                            'struct',
                            function ($qq) use ($location_id) {
                                $qq->where(
                                    function ($qqq) use ($location_id) {
                                        $qqq->where('id', $location_id);
                                    }
                                )
                                    ->orWhere(
                                        function ($qqq) {
                                            $qqq->inAudit();
                                        }
                                    );
                            }
                        );
                    }
                );
                break;
            case 'auditee':
                $location_id = 0;
                $summary = Summary::find($request->summary_id);
                $location_id = $summary->getStruct()->id ?? 0;
                $items = $items->whereHasLocationId($location_id);
                break;
            case 'not_auditor_auditee':
                $location_id = 0;
                if ($summary = Summary::find($request->summary_id)) {
                    $location_id = $summary->getStruct()->id ?? 0;
                }
                $items2 = User::keywordBy('name')
                    ->has('position')
                    ->where('status', 'active')
                    ->orderBy('name');
                $items3 = User::keywordBy('name')
                    ->has('position')
                    ->where('status', 'active')
                    ->orderBy('name');
                $auditee = $items3->whereHasLocationId($location_id);
                $auditor = $items2->whereHas(
                    'position',
                    function ($q) {
                        $q->whereHas(
                            'struct',
                            function ($qq) {
                                $qq->inAudit();
                            }
                        );
                    }
                );
                $items = $items->whereNotIn('id', $auditor->pluck('id')->toArray())->whereNotIn('id', $auditee->pluck('id')->toArray());
                break;
            case 'auditor_auditee':
                $location_id = 0;
                if ($summary = Summary::find($request->summary_id)) {
                    $location_id = $summary->getStruct()->id ?? 0;
                }
                $items2 = User::keywordBy('name')
                    ->has('position')
                    ->where('status', 'active')
                    ->orderBy('name');
                $items3 = User::keywordBy('name')
                    ->has('position')
                    ->where('status', 'active')
                    ->orderBy('name');
                $auditee = $items3->whereHasLocationId($location_id);
                $auditor = $items2->whereHas(
                    'position',
                    function ($q) {
                        $q->whereHas(
                            'struct',
                            function ($qq) {
                                $qq->inAudit();
                            }
                        );
                    }
                );
                $items = $items->whereIn('id', $auditor->pluck('id')->toArray())->orWhereIn('id', $auditee->pluck('id')->toArray());
                break;
            case 'auditor_auditee_bod':
                $location_id = 0;
                if ($summary = Summary::find($request->summary_id)) {
                    $location_id = $summary->getStruct()->id ?? 0;
                }
                $list = [];
                $auditee = User::keywordBy('name')
                    ->has('position')
                    ->where('status', 'active')
                    ->orderBy('name')
                    ->whereHasLocationId($location_id);
                $list = array_merge($list, $auditee->pluck('id')->toArray());
                $auditor = User::keywordBy('name')
                    ->has('position')
                    ->where('status', 'active')
                    ->orderBy('name')->whereHas(
                        'position',
                        function ($q) {
                            $q->whereHas(
                                'struct',
                                function ($qq) {
                                    $qq->inAudit();
                                }
                            );
                        }
                    );
                $list = array_merge($list, $auditor->pluck('id')->toArray());
                $bod = User::keywordBy('name')
                    ->has('position')
                    ->where('status', 'active')
                    ->orderBy('name')
                    ->whereHas(
                        'position',
                        function ($q) {
                            $q->whereHas(
                                'struct',
                                function ($qq) {
                                    $qq->whereIn('level', ['bod', 'boc']);
                                }
                            );
                        }
                    );
                $list = array_merge($list, $bod->pluck('id')->toArray());
                $items = $items->whereIn('id', $list);
                break;
            case 'cc':
                $location_id = 0;
                if ($summary = Summary::find($request->summary_id)) {
                    $location_id = $summary->getStruct()->id ?? 0;
                }
                $list = [];
                if($summary->rkia->category == 'operation'){
                    $auditee = User::keywordBy('name')
                    ->has('position')
                    ->where('status', 'active')
                    ->orderBy('name')
                    ->whereHasLocationId($location_id);
                    $list = array_merge($list, $auditee->pluck('id')->toArray());
                }
                $bod = User::keywordBy('name')
                    ->where('status', 'active')
                    ->orderBy('name')
                    ->whereHas(
                        'position',
                        function ($q) {
                            $q->whereHas(
                                'struct',
                                function ($qq) {
                                    $qq->whereIn('level', ['bod', 'boc']);
                                }
                            );
                        }
                    );
                $list = array_merge($list, $bod->pluck('id')->toArray());
                $items = $items->whereIn('id', $list);
                break;
            case 'auditor_summary':
                $get_id_auditors = [];
                if ($summary = Summary::find($request->summary_id)) {
                    $get_id_auditors = $summary->getAuditorIds('all');
                }
                $get_id_auditors_done = PenilaianKinerjaAuditor::where('penilaian_kinerja_id', $request->penilaian_kinerja_id)->pluck('auditor_id')->toArray();
                // $auditors_not_yet_reviewed = array_diff($get_id_auditors_done, $get_id_auditors);
                $items = $items->whereIn('id', $get_id_auditors)->whereNotIn('id', $get_id_auditors_done);
                break;
            case 'auditor_summary_all':
                $get_id_auditors = [];
                if ($summary = Summary::find($request->summary_id)) {
                    $get_id_auditors = $summary->getAuditorIds();
                }
                $items = $items->whereIn('id', $get_id_auditors);
                break;
            case 'auditor_summary_leader_and_member':
                $get_id_auditors = [];
                if ($summary = Summary::find($request->summary_id)) {
                    $get_id_auditors = $summary->getAuditorIds('leader_and_member');
                }
                $items = $items->whereIn('id', $get_id_auditors);
                break;
            case 'survey-auditee':
                $location_id = 0;
                if ($surveyUsers = SurveyRegUser::where('survey_reg_id', $request->summary_id)->get()) {
                    $location_id = $surveyUsers->pluck('user_id')->toArray() ?? 0;
                }
                $items = $items->whereIn('id', $location_id);
                break;
            case 'penilaian-kinerja-auditor':
                $location_id = 0;
                if ($penilaianAuditors = PenilaianKinerjaAuditor::where('penilaian_kinerja_id', $request->summary_id)->get()) {
                    $location_id = $penilaianAuditors->pluck('auditor_id')->toArray() ?? 0;
                }
                $items = $items->whereIn('id', $location_id);
                break;
            default:
                $items = $items->whereNull('id');
                break;
        }
        $items = $items->paginate();

        $results = [];
        $more = $items->hasMorePages();
        foreach ($items as $item) {
            $results[] = ['id' => $item->id, 'text' => $item->name . ' (' . ($item->position->name ?? '') . ')'];
        }
        return response()->json(compact('results', 'more'));
    }

    public function selectTypeInspection($search, Request $request)
    {
        $items = TypeInspection::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }

        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectIctType($search, Request $request)
    {
        $items = IctType::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }

        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectCity($search, Request $request)
    {
        $items = City::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;
            case 'by_province':
                $items = $items->where('province_id', $request->province_id);
                break;
            default:
                $items = $items->whereNull('id');
                break;
        }

        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function getAuditRating(Request $request)
    {
        $items = AuditRating::keywordBy('audit_rating')->orderBy('audit_rating');
        $items = $items->paginate();
        return $this->responseSelect2($items, 'audit_rating', 'id');
    }

    public function selectProvince($search, Request $request)
    {
        $items = Province::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }
        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectIctObject($search, Request $request)
    {
        $items = IctObject::keywordBy('name')->has('ictType')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;
            case 'object_audit':
                $items = $items->where('ict_type_id', $request->object_type);
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }

        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectAspect($search, Request $request)
    {
        $items = Aspect::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;
            case 'parent_level':
                $category       = $request->category;
                $object_type    = $request->object_type;
                $object_id      = $request->object_id;
                $items = $items->where('category', $category);
                if ($category === 'operation') {
                    $items
                        ->when(
                            in_array($object_type, ['subsidiary', 'sbu']),
                            function ($q) use ($object_type) {
                                $q->where(
                                    function ($q) use ($object_type) {
                                        $q
                                            ->whereIn('category', ['operation', 'special'])
                                            ->where('object_type', $object_type);
                                    }
                                );
                            },
                            function ($q) use ($object_type) {
                                $q->whereHas(
                                    'object',
                                    function ($q) use ($object_type) {
                                        $q->where('level', $object_type);
                                    }
                                );
                            },
                        )
                        ->select('id', 'name')
                        ->orderBy('name')
                        ->distinct('name')
                        ->get(['name']);
                } elseif ($category === 'special') {
                    $items->where('auditee_id', $object_id);
                } elseif ($category === 'ict') {
                    $items->where('ict_object_id', $object_type);
                } else {
                    $items->whereHas('object', function ($q) use ($object_type) {
                        $q->where('level', $object_type);
                    })
                    ->whereIn('id', function ($query) {
                        $query->selectRaw('MIN(id)')
                            ->from('ref_aspects')
                            ->groupBy('name');
                    })
                    ->select('id','name')
                    ->orderBy('name')
                    ->distinct('name')
                    ->get(['name']);
                }
                break;
            case 'parent_doc':
                $category = $request->category;
                $object_id = $request->object_id;
                $items = $items->where('category', $category);
                if ($category === 'operation') {
                    $items->where('object_id', $object_id);
                } elseif ($category === 'special') {
                    $items->where('auditee_id', $object_id);
                } elseif ($category === 'ict') {
                    $items->where('ict_object_id', $object_id);
                }
                break;
            case 'by_object':
                $category = $request->category;
                $object_id = $request->object_id;
                $items = $items->filterByObject($category, $object_id);
                break;
            case 'by_ids':
                $ids = $request->ids ?? [];
                $items = $items->whereIn('id', $ids);
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }

        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectObject(Request $request)
    {
        switch ($request->category) {
            case 'all':
                $levels = ['division', 'seksi', 'branch'];
                $items = OrgStruct::keywordBy('name')
                    ->whereIn('level', $levels)
                    ->orderBy('level')
                    ->orderBy('name')
                    ->get();
                $results = [];
                $optgroups = [];
                $i = 0;
                if (!empty($request->optstart_id) && !empty($request->optstart_text)) {
                    $results[$i]['id'] = $request->optstart_id;
                    $results[$i]['text'] = $request->optstart_text;
                    $i++;
                }
                foreach ($levels as $level) {
                    foreach ($items->where('level', $level) as $item) {
                        if (!in_array($item->level, $optgroups)) {
                            $optgroups[] = $item->level;
                            $results[$i]['text'] = strtoupper($item->show_level);
                        }
                        $results[$i]['children'][] = ['id' => 'struct--' . $item->id, 'text' => $item->name];
                        $i++;
                    }
                }
                // TI
                $items = Provider::keywordBy('name')
                    ->orderBy('name')
                    ->get();
                if ($items->count()) {
                    $results[$i]['text'] = strtoupper('TI');
                    foreach ($items as $item) {
                        $results[$i]['children'][] = ['id' => 'ict--' . $item->id, 'text' => $item->name];
                        $i++;
                    }
                }
                $more = false;
                return response()->json(compact('results', 'more'));
            case 'operation':
                $levels = ['division', 'seksi', 'branch'];
                $items = OrgStruct::keywordBy('name')
                    ->whereIn('level', $levels)
                    ->orderBy('level')
                    ->orderBy('name')
                    ->get();
                $results = [];
                $optgroups = [];
                $i = 0;
                foreach ($levels as $level) {
                    foreach ($items->where('level', $level) as $item) {
                        if (!in_array($item->level, $optgroups)) {
                            $optgroups[] = $item->level;
                            $results[$i]['text'] = strtoupper($item->show_level);
                        }
                        $results[$i]['children'][] = ['id' => $item->id, 'text' => $item->name];
                        $i++;
                    }
                }
                $more = false;
                return response()->json(compact('results', 'more'));
            case 'operation_with_nonpkpt':
                $levels = ['boc', 'bod', 'division', 'seksi', 'branch', 'group'];
                $items = OrgStruct::keywordBy('name')
                    ->whereIn('level', $levels)
                    ->orderBy('level')
                    ->orderBy('name')
                    ->get();
                $results = [];
                $optgroups = [];
                $i = 0;
                if (!empty($request->optstart_id) && !empty($request->optstart_text)) {
                    $results[$i]['id'] = $request->optstart_id;
                    $results[$i]['text'] = $request->optstart_text;
                    $i++;
                }
                foreach ($levels as $level) {
                    foreach ($items->where('level', $level) as $item) {
                        if (!in_array($item->level, $optgroups)) {
                            $optgroups[] = $item->level;
                            $results[$i]['text'] = strtoupper($item->show_level);
                        }
                        $results[$i]['children'][] = ['id' => 'struct--' . $item->id, 'text' => $item->name];
                        $i++;
                    }
                }
                $more = false;
                return response()->json(compact('results', 'more'));
            case 'special':
                $items = IctObject::keywordBy('name')
                    ->orderBy('name')
                    ->paginate();
                $results = [];
                $more = $items->hasMorePages();
                foreach ($items as $item) {
                    $results[] = ['id' => $item->id, 'text' => $item->name . ' (' . ($item->position ?? '') . ')'];
                }
                return response()->json(compact('results', 'more'));

            case 'ict':
                $items = Provider::keywordBy('name')->orderBy('name')->paginate();
                return $this->responseSelect2($items, 'name', 'id');

            default:
                $levels = ['division', 'seksi', 'branch'];
                $items = OrgStruct::keywordBy('name')
                    ->whereIn('level', $levels)
                    ->orderBy('level')
                    ->orderBy('name')
                    ->get();
                $results = [];
                $optgroups = [];
                $i = 0;
                if (!empty($request->optstart_id) && !empty($request->optstart_text)) {
                    $results[$i]['id'] = $request->optstart_id;
                    $results[$i]['text'] = $request->optstart_text;
                    $i++;
                }
                foreach ($levels as $level) {
                    foreach ($items->where('level', $level) as $item) {
                        if (!in_array($item->level, $optgroups)) {
                            $optgroups[] = $item->level;
                            $results[$i]['text'] = strtoupper($item->show_level);
                        }
                        $results[$i]['children'][] = ['id' => 'struct--' . $item->id, 'text' => $item->name];
                        $i++;
                    }
                }
                // TI
                $items = IctObject::keywordBy('name')
                    ->has('ictType')
                    ->orderBy('name')
                    ->get();
                if ($items->count()) {
                    $results[$i]['text'] = strtoupper('TI');
                    foreach ($items as $item) {
                        $results[$i]['children'][] = ['id' => 'ict--' . $item->id, 'text' => $item->name];
                        $i++;
                    }
                }
                $more = false;
                return response()->json(compact('results', 'more'));
                break;
        }
    }

    public function selectDocItem($search, Request $request)
    {
        $items = DocumentItem::keywordBy('name')->has('aspect')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;
            case 'find':
                return $items->find($request->id);
            case 'by_aspect':
                $items = $items->where('aspect_id', $request->aspect_id);
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }

        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectIacmLevelType($search, Request $request)
    {
        $items = IacmLevel::orderBy('created_at');
        switch ($search) {
            case 'all':
                $items = $items;
                break;
            case 'find':
                return $items->find($request->id);

            default:
                $items = $items->whereNull('id');
                break;
        }

        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectIacmParameterType($search, Request $request)
    {
        $items = IacmParameter::orderBy('created_at');
        switch ($search) {
            case 'all':
                $items = $items;
                break;
            case 'find':
                return $items->with('owner')->find($request->id);

            case 'byOwner':
                $owners = json_decode($request->owner);
                $items = $items->whereIn('user_id', $owners);
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }

        $items = $items->paginate();
        $results = [];
        $more = false;
        foreach ($items as $item) {
            $results[] = [
                'id' => $item->id,
                'text' => $item->number . ' - ' . $item->bank . ' - ' . $item->owner->name
            ];
        }
        if (method_exists($items, 'hasMorePages')) {
            $more = $items->hasMorePages();
        }
        return response()->json(compact('results', 'more'));
    }

    public function cityOptions(Request $request)
    {
        return City::when(
            $province_id = $request->province_id,
            function ($q) use ($province_id) {
                $q->where('province_id', $province_id);
            }
        )
            ->orderBy('name', 'ASC')
            ->get();
    }

    public function cityOptionsRoot(Request $request)
    {
        $items = City::when(
            $province_id = $request->province_id,
            function ($q) use ($province_id) {
                $q->where('province_id', $province_id);
            }
        )
            ->orderBy('name', 'ASC')
            ->get();

        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function provinceOptionsBySearch($search)
    {
        $items = Province::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;
            default:
                $items = $items->whereNull('id');
                break;
        }
        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function jabatanOptions(Request $request)
    {
        return Position::select('id', 'name')
            ->when(
                $location_id = $request->location_id,
                function ($q) use ($location_id) {
                    $q->where('location_id', $location_id);
                }
            )
            ->orderBy('name', 'ASC')
            ->get();
    }

    public function jabatanWithNonPKPTOptions(Request $request)
    {
        return Position::select('id', 'name')
            ->when(
                $location_id = $request->location_id,
                function ($q) use ($location_id) {
                    $cleanedLocationId = str_replace(['struct--', 'nonpkpt--'], '', $location_id);
                    if (Str::startsWith($location_id, 'struct--')) {
                        $q->where('location_id', $cleanedLocationId);
                    } elseif (Str::startsWith($location_id, 'nonpkpt--')) {
                        $q->where('nonpkpt_id', $cleanedLocationId);
                    }
                }
            )
            ->orderBy('name', 'ASC')
            ->get();
    }

    public function childStructOptions(Request $request)
    {
        return OrgStruct::select('id', 'name')
            ->when(
                $parent_id = $request->parent_id,
                function ($q) use ($parent_id) {
                    $q->where('parent_id', $parent_id);
                }
            )
            ->orderBy('name', 'ASC')
            ->get();
    }


    public function penilaianCategoryOptions()
    {
        $items = PenilaianCategory::keywordBy('name')->orderBy('name');
        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function getSurveyStatement(Request $request)
    {
        $record = SurveyReg::findOrFail($request->survey_reg_id);
        $summary = $record->summary;
        // $regUser = $record->surveyRegUsers()->whereIn('user_id', $request->user_ids)->firstOrFail();
        $regUser = $record->surveyRegUsers()
            ->where('user_id', $request->user_id)
            ->firstOrFail();
        $survey = $regUser->survey;
        $statements = $survey->statements()->with('category')->get();
        $categories = $statements->pluck('category')->unique();
        return response()->json(
            [
                'data'  => compact(
                    'record',
                    'summary',
                    'regUser',
                    'survey',
                    'statements',
                    'categories',
                )
            ]
        );
    }

    public function selectAuditeeNonPkpt($search, Request $request)
    {
        $items = AuditeeNonPKPT::keywordBy('name')
            ->orderBy('name')
            ->paginate();
        $results = [];
        $more = $items->hasMorePages();
        foreach ($items as $item) {
            $results[] = ['id' => $item->id, 'text' => $item->name];
        }
        return response()->json(compact('results', 'more'));
    }

    public function selectRiskRating($search, Request $request)
    {
        $items = RiskRating::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;
            case 'find':
                return $items->with('owner')->find($request->id);

            default:
                $items = $items->whereNull('id');
                break;
        }

        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectLevelDampak($search, Request $request)
    {
        $items = LevelDampak::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;
            case 'find':
                return $items->with('owner')->find($request->id);

            default:
                $items = $items->whereNull('id');
                break;
        }

        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectLevelKemungkinan($search, Request $request)
    {
        $items = LevelKemungkinan::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;
            case 'find':
                return $items->with('owner')->find($request->id);

            default:
                $items = $items->whereNull('id');
                break;
        }

        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectKodeResiko($search, Request $request)
    {
        $items = RiskCode::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;
            case 'find':
                return $items->with('owner')->find($request->id);

            default:
                $items = $items->whereNull('id');
                break;
        }

        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectJenisResiko($search, Request $request)
    {
        $items = RiskType::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;
            case 'find':
                return $items->with('owner')->find($request->id);

            default:
                $items = $items->whereNull('id');
                break;
        }

        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectStatusResiko($search, Request $request)
    {
        $items = RiskStatus::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;
            case 'find':
                return $items->with('owner')->find($request->id);

            default:
                $items = $items->whereNull('id');
                break;
        }

        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectDetailApm($search, Request $request)
    {
        $summary_id = $request->summary_id;
        $items = ApmDetail::with('procedureAudit')
            ->whereHas(
                'apm',
                function ($q) use ($summary_id) {
                    $q->where('summary_id', $summary_id);
                }
            )
            ->where('user_id', auth()->id())
            ->keywordBy('agenda')->orderBy('agenda');
        switch ($search) {
            case 'all':
                $items = $items;
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }

        $items = $items->paginate();
        return $this->responseSelect2ProcedureAudit($items, '', 'id');
        // return $this->responseSelect2($items, 'agenda', 'id');
    }

    public function selectDetailApm2(Request $request)
    {
        $summary_id = $request->summary_id;
        $aspect_id = $request->aspect_id;
        $items = ApmDetail::with('procedureAudit')
            ->whereHas(
                'apm',
                function ($q) use ($summary_id) {
                    $q->where('summary_id', $summary_id);
                }
            )
            // ->whereHas(
            //     'procedureAudit',
            //     function ($q) use ($aspect_id) {
            //         $q->where('aspect_id', $aspect_id);
            //     }
            // )
            ->where('user_id', auth()->id())
            ->keywordBy('agenda')->orderBy('agenda');
        $items = $items->paginate();
        return $this->responseSelect2ProcedureAudit($items, '', 'id');
        // return $this->responseSelect2($items, 'agenda', 'id');
    }
    public function selectProcedure(Request $request)
    {
        $items = ProcedureAudit::keywordBy('procedure')
            ->when(
                $aspect_ids = $request->aspect_ids,
                function ($q) use ($aspect_ids) {
                    // dd(1205, $aspect_ids);
                    $q->whereIn('aspect_id', $aspect_ids);
                }
            )
            ->orderBy('procedure')
            ->paginate();
        return $this->responseSelect2($items, 'procedure', 'id');
    }

    public function selectTrainingInstitute($search, Request $request)
    {
        $items = TrainingInstitute::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }

        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectTransportType($search, Request $request)
    {
        $items = TransportType::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }

        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectTrainingType($search, Request $request)
    {
        $items = TrainingType::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }

        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectExternInstance($search, Request $request)
    {
        $items = ExternInstance::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }

        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    public function selectServiceProvider($search, Request $request)
    {
        $items = Provider::keywordBy('name')->orderBy('name');
        switch ($search) {
            case 'all':
                $items = $items;
                break;

            default:
                $items = $items->whereNull('id');
                break;
        }

        $items = $items->paginate();
        return $this->responseSelect2($items, 'name', 'id');
    }

    // public function selectIacmLevelType($search, Request $request)
    // {
    //     $items = IacmLevel::orderBy('created_at');
    //     switch ($search) {
    //         case 'all':
    //             $items = $items;
    //             break;
    //         default:
    //             $items = $items->whereNull('id');
    //             break;
    //     }

    //     $items = $items->paginate();
    //     return $this->responseSelect2($items, 'name', 'id');
    // }

    // public function selectIacmParameterType($search, Request $request)
    // {
    //     $items = IacmParameter::orderBy('created_at');
    //     switch ($search) {
    //         case 'all':
    //             $items = $items;
    //             break;
    //         default:
    //             $items = $items->whereNull('id');
    //             break;
    //     }

    //     $items = $items->paginate();
    //     return $this->responseSelect2($items, 'name', 'id');
    // }
}
