<?php

namespace App\Console\Commands;

use App\Models\Followup\FollowupMonitor;
use App\Models\Followup\FollowupRegItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class Followup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'followup:deadline';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'followup:deadline';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('followup:deadline ' . now()->format('Y-m-d h:m:s'));
        $followup_reg_items_query = FollowupRegItem::with(
            [
                'reg.monitor'
            ]
        )
            ->selectRaw("id, reg_id, detail_id, DATE_FORMAT(deadline, '%Y%m%d') - " . now()->format('Ymd') . " AS deadline_day_count")
            // ->whereRaw('day_count < 4')
            ->whereRaw("(DATE_FORMAT(`deadline`, '%Y%m%d') - " . now()->format('Ymd') . ") < 4")
            ->whereHas(
                'reg.monitor',
                function ($q) {
                    $q->whereIn('status', ['new', 'draft']);
                }
            );
        $followup_reg_items = $followup_reg_items_query->get();
        $monitor_ids = $followup_reg_items->pluck('reg.monitor.id')->toArray();
        $monitors = FollowupMonitor::select('id', 'summary_id')
            ->with('summary')
            ->whereIn('id', $monitor_ids)->get();
        foreach ($monitors as $key => $monitor) {
            $user_ids = array_unique(array_merge(
                [
                    $monitor->summary->vp_spi_id,
                    $monitor->summary->pic_id,
                    $monitor->summary->supervisor_id,
                    $monitor->summary->leader_id,
                ],
                $monitor->summary->members()->pluck('id')->toArray(),
            ));
            $monitor->addNotify(
                [
                    'message'   => 'Peringatan Batas Waktu Hampir Habis',
                    'module'    => 'followup_followup-monitor',
                    'url'       => rut('followup.followup-monitor.detail', $monitor->id),
                    'user_ids'  => $user_ids,
                ]
            );
        }
        return 0;
    }
}
