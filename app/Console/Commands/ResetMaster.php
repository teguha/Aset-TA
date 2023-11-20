<?php

namespace App\Console\Commands;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ResetMaster extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'master:truncate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset data master';

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
     * @return mixed
     */
    public function handle()
    {

        $this->output->title($this->description);
        try {
            if ($this->confirm('Semua data Master akan dihapus, Lanjutkan ?')) {
                // DB::beginTransaction();
                Schema::disableForeignKeyConstraints();

                DB::table('ref_aspects')->truncate();
                DB::table('ref_bank_accounts')->truncate();
                DB::table('ref_city')->truncate();
                DB::table('ref_cost_components')->truncate();
                DB::table('ref_district')->truncate();
                DB::table('ref_document_dinas')->truncate();
                DB::table('ref_document_items')->truncate();
                DB::table('ref_extern_instances')->truncate();
                DB::table('ref_ict_objects')->truncate();
                DB::table('ref_ict_types')->truncate();
                DB::table('ref_last_audits')->truncate();
                DB::table('ref_letters')->truncate();
                DB::table('ref_org_structs')->truncate();
                DB::table('ref_org_structs_groups')->truncate();
                DB::table('ref_positions')->truncate();
                DB::table('ref_province')->truncate();
                DB::table('ref_risk_assessments')->truncate();
                DB::table('ref_risk_assessments_details')->truncate();
                DB::table('ref_risk_ratings')->truncate();
                DB::table('ref_surveys')->truncate();
                DB::table('ref_surveys_statements')->truncate();
                DB::table('ref_survey_categories')->truncate();
                DB::table('ref_training_institutes')->truncate();
                DB::table('ref_training_types')->truncate();

                Schema::enableForeignKeyConstraints();
                // DB::commit();
                app()->make(DatabaseSeeder::class)->run();
                $this->output->info($this->description . ' berhasil');
            } else {
                $this->output->info('Penghapusan dibatalkan');
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
