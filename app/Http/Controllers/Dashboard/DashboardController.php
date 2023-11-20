<?php

namespace App\Http\Controllers\Dashboard;

use App;
use App\Http\Controllers\Controller;
use App\Models\Master\Org\OrgStruct;
use App\Models\Master\Org\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $module =  'dashboard';
    protected $routes =  'dashboard';
    protected $views =  'dashboard';

    public function __construct()
    {
        $this->prepare([
            'module' => $this->module,
            'routes' => $this->routes,
            'views' => $this->views,
            'title' => 'Dashboard',
        ]);
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        if ($user->status != 'active') {
            return $this->render($this->views.'.nonactive');
        }
        if (!$user->checkPerms('dashboard.view') || !$user->roles()->exists()) {
            return abort(403);
        }

        $progress = [
            [
                'name' => 'reporting',
                'title' => 'Pelaporan Audit',
                'color' => 'success',
                'icon' => 'fas fa-bookmark',
            ],
            [
                'name' => 'followup',
                'title' => 'Tindak Lanjut Audit',
                'color' => 'warning',
                'icon' => 'fas fa-id-card',
            ],
        ];

        $is_auditor = false;

        if(isset($user->position->id) && $user->position->imAuditor()) {
            $is_auditor = true;

            array_unshift($progress, [
                'name' => 'conducting',
                'title' => 'Pelaksanaan Audit',
                'color' => 'danger',
                'icon' => 'fa fa-tags',
            ]);

            array_unshift($progress, [
                'name' => 'preparation',
                'title' => 'Persiapan Audit',
                'color' => 'primary',
                'icon' => 'fas fa-paper-plane',
            ]);
        }

        return $this->render($this->views.'.index', ['progress' => $progress, 'is_auditor' => $is_auditor]);
    }

    public function setLang($lang)
    {
        App::setLocale($lang);
        session()->put('locale', $lang);

        return redirect()->back();
    }

    public function progress(Request $request)
    {
        // Preparation
        $total = Summary::gridAssignment()
                        ->filters()
                        ->count();
        $compl = Summary::gridAssignment()
                        // ->hasCompleted('assignment')
                        // ->hasCompleted('document')
                        ->whereHas('document', function ($q) {
                            $q->whereHas('docFull', function ($qq) {
                                $qq->where('status', 'completed');
                            });
                        })
                        // ->hasCompleted('apm')
                        // ->hasCompleted('fee')
                        ->filters()
                        ->count();

        $percent = ($compl > 0 && $total > 0) ? round(($compl/$total*100), 0) : 0;
        $cards[] = [
            'name' => 'preparation',
            'total' => $total,
            'completed' => $compl,
            'percent' => $percent,
        ];

        // Conducting
        $total = Summary::gridOpening()
                        ->filters()
                        ->count();
        $compl = Summary::gridOpening()
                        // ->hasCompleted('opening')
                        // ->hasCompleted('sample')
                        // ->hasCompleted('feedback')
                        // ->hasCompleted('worksheet')
                        ->hasCompleted('closing')
                        ->filters()
                        ->count();

        $percent = ($compl && $total) ? round(($compl/$total*100), 0) : 0;
        $cards[] = [
            'name' => 'conducting',
            'total' => $total,
            'completed' => $compl,
            'percent' => $percent,
        ];

        // Reporting
        $total = Summary::gridExiting()
                        ->filters()
                        ->count();
        $compl = Summary::gridExiting()
                        // ->hasCompleted('lha')
                        ->hasCompleted('exiting')
                        ->filters()
                        ->count();

        $percent = ($compl && $total) ? round(($compl/$total*100), 0) : 0;
        $cards[] = [
            'name' => 'reporting',
            'total' => $total,
            'completed' => $compl,
            'percent' => $percent,
        ];

        // Followup
        $total = Summary::gridFollowupReg()
                        ->filters()
                        ->count();
        $compl = Summary::gridFollowupReg()
                        // ->hasCompleted('followupReg')
                        ->hasCompleted('followupMonitor')
                        ->filters()
                        ->count();

        $percent = ($compl && $total) ? round(($compl/$total*100), 0) : 0;
        $cards[] = [
            'name' => 'followup',
            'total' => $total,
            'completed' => $compl,
            'percent' => $percent,
        ];

        return response()->json([
            'data' => $cards
        ]);
    }

    public function chartFinding(Request $request)
    {
        $request->merge(['year_start' => $request->finding_start ?? date('Y') - 10]);
        $request->merge(['year_end' => $request->finding_end ?? date('Y')]);

        $years = range($request->year_start, $request->year_end);
        $object = $this->getObject($request->finding_object);
        $data = KkaSampleDetail::countFindingForDashboard($years, $object);
        // $title = 'Temuan '.$object['object_name'].' '.$request->year_start.'/'.$request->year_end;
        $title = '  ';

        $series = [];
        foreach ($data as $key => $value) {
            $series[] = [
                'name'  => $key,
                'type'  => $key === 'total' ? 'area': 'column',
                'data'  => $value,
            ];
        }
        // dd(
        //     189,
        //     $request->all(),
        //     $data
        // );

        return [
            'title' => ['text' => $title],
            'series' => $series,
            'xaxis' => ['categories' => $years]
        ];
    }

    public function chartFollowup(Request $request)
    {
        $request->merge(['year_start' => $request->followup_start ?? date('Y') - 10]);
        $request->merge(['year_end' => $request->followup_end ?? date('Y')]);

        $years = range($request->year_start, $request->year_end);
        $object = $this->getObject($request->followup_object);
        $data = KkaSampleDetail::countFollowupForDashboard($years, $object);
        // $title = 'Tindak Lanjut Temuan '.$object['object_name'].' '.$request->year_start.'/'.$request->year_end;
        $title = '  ';

        return [
            'title' => ['text' => $title],
            'series' => [
                [
                    'name' => 'Total',
                    'type' => 'area',
                    'data' => $data['total']
                ],[
                    'name' => 'Open',
                    'type' => 'column',
                    'data' => $data['open']
                ],[
                    'name' => 'Close',
                    'type' => 'column',
                    'data' => $data['close']
                ],
            ],
            'xaxis' => ['categories' => $years]
        ];
    }

    public function chartStage(Request $request)
    {
        $request->merge(['year' => $request->stage_year ?? date('Y')]);
        $object = $this->getObject($request->stage_object);

        $categories = [];
        $total = [];
        $completed = [];
        $progress = [];

        // Surat Penugasan
        $categories[] = 'Surat Penugasan';
        $total[] = Summary::gridAssignment()->chartStage($object)->count();
        $completed[] = Summary::gridAssignment()->chartStage($object, 'assignment')->count();
        $progress[] = (end($total) - end($completed));

        // Permintaan Dokumen
        $categories[] = 'Permintaan Dokumen';
        $total[] = Summary::gridDocReq()->chartStage($object)->count();
        $completed[] = Summary::gridDocReq()->chartStage($object, 'document')->count();
        $progress[] = (end($total) - end($completed));

        // Pemenuhan Dokumen
        $categories[] = 'Pemenuhan Dokumen';
        $total[] = Summary::gridDocFull()->chartStage($object)->count();
        $completed[] = Summary::gridDocFull()
                                ->chartStage($object)
                                ->whereHas('document', function ($q) {
                                    $q->whereHas('docFull', function ($qq) {
                                        $qq->where('status', 'completed');
                                    });
                                })
                                ->count();
        $progress[] = (end($total) - end($completed));

        // APM
        $categories[] = 'APM';
        $total[] = Summary::gridApm()->chartStage($object)->count();
        $completed[] = Summary::gridApm()->chartStage($object, 'apm')->count();
        $progress[] = (end($total) - end($completed));

        // Biaya Penugasan
        $categories[] = 'Biaya Penugasan';
        $total[] = Summary::gridFee()->chartStage($object)->count();
        $completed[] = Summary::gridFee()->chartStage($object, 'fee')->count();
        $progress[] = (end($total) - end($completed));

        // Opening Meeting
        $categories[] = 'Opening Meeting';
        $total[] = Summary::gridOpening()->chartStage($object)->count();
        $completed[] = Summary::gridOpening()->chartStage($object, 'opening')->count();
        $progress[] = (end($total) - end($completed));

        // Kertas Kerja
        $categories[] = 'Kertas Kerja';
        $total[] = Summary::gridSample()->chartStage($object)->count();
        $completed[] = Summary::gridSample()->chartStage($object, 'sample')->count();
        $progress[] = (end($total) - end($completed));

        // Feedback
        $categories[] = 'Feedback';
        $total[] = Summary::gridFeedback()->chartStage($object)->count();
        $completed[] = Summary::gridFeedback()->chartStage($object, 'feedback')->count();
        $progress[] = (end($total) - end($completed));

        // Audit Worksheet
        $categories[] = 'Audit Worksheet';
        $total[] = Summary::gridWorksheet()->chartStage($object)->count();
        $completed[] = Summary::gridWorksheet()->chartStage($object, 'worksheet')->count();
        $progress[] = (end($total) - end($completed));

        // Closing Meeting
        $categories[] = 'Closing Meeting';
        $total[] = Summary::gridClosing()->chartStage($object)->count();
        $completed[] = Summary::gridClosing()->chartStage($object, 'closing')->count();
        $progress[] = (end($total) - end($completed));

        // Exit Meeting
        $categories[] = 'Exit Meeting';
        $total[] = Summary::gridExiting()->chartStage($object)->count();
        $completed[] = Summary::gridExiting()->chartStage($object, 'exiting')->count();
        $progress[] = (end($total) - end($completed));

        // LHA
        $categories[] = 'LHA';
        $total[] = Summary::gridLha()->chartStage($object)->count();
        $completed[] = Summary::gridLha()->chartStage($object, 'lha')->count();
        $progress[] = (end($total) - end($completed));

        // Register Tindak Lanjut
        $categories[] = 'Register Tindak Lanjut';
        $total[] = Summary::gridFollowupReg()->chartStage($object)->count();
        $completed[] = Summary::gridFollowupReg()->chartStage($object, 'followupReg')->count();
        $progress[] = (end($total) - end($completed));

        // Monitoring Tindak Lanjut
        $categories[] = 'Monitoring Tindak Lanjut';
        $total[] = Summary::gridFollowupMonitor()->chartStage($object)->count();
        $completed[] = Summary::gridFollowupMonitor()->chartStage($object, 'followupMonitor')->count();
        $progress[] = (end($total) - end($completed));

        // Survey Kepuasan Audit
        $categories[] = 'Survey Kepuasan Audit';
        $total[] = Summary::gridSurveyRecap()->chartStage($object)->count();
        $completed[] = Summary::gridSurveyRecap()->chartStage($object, 'surveyReg')->count();
        $progress[] = (end($total) - end($completed));

        return [
            'title' => ['text' => 'Tahap Audit '.$object['object_name'].' '.$request->year],
            'series' => [
                [
                    'name' => 'Total',
                    'type' => 'area',
                    'data' => $total
                ],[
                    'name' => 'On Progress',
                    'type' => 'column',
                    'data' => $progress
                ],[
                    'name' => 'Completed',
                    'type' => 'column',
                    'data' => $completed
                ],
            ],
            'xaxis' => ['categories' => $categories]
        ];
    }

    public function getObject($object = null)
    {
        $object = ($object != 'all') ? $object : null;
        $obj = [
            'categories' => [],
            'object_id' => 0,
            'ict_object_id' => 0,
            'object_name' => '',
        ];
        if ($object) {
            // format object = struct--id_of_org_structs || ict--id_of_ref_ict_objects
            $object = explode('--', $object);
            if ($object[0] == 'struct') {
                $obj['categories'] = ['operation','special'];
                $obj['object_id'] = (int) $object[1];
                $obj['object_name'] = OrgStruct::find($obj['object_id'])->name ?? '';
            }
            if ($object[0] == 'ict') {
                $obj['categories'] = ['ict'];
                $obj['ict_object_id'] = (int) $object[1];
                $obj['object_name'] = IctObject::find($obj['ict_object_id'])->name ?? '';
            }
        }

        return $obj;
    }
}
