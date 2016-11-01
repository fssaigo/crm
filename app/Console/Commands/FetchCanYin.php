<?php

namespace App\Console\Commands;

use App\Util\Helper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FetchCanYin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'FetchCanYin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Data From Other Database';

    /**
     * Create a new command instance.
     *
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
        $this->web();
        $this->zone();
        $this->call400();
    }

    public function web() {
        $results = DB::connection('91')->select('SELECT `c`.*,`p`.`name` AS `project`,`p`.`pinyin` FROM `sh_client` AS `c` INNER JOIN `sh_project` AS `p` USING(`p_id`) WHERE `c`.`is_send_crm` = :is_send_crm ORDER BY `c`.`c_id` DESC LIMIT 0,10 ', ['is_send_crm' => 0]);
        $ids = '';
        foreach ($results as $record) {
            if ($record->c_id) {
                $ids .= $record->c_id.',';
                $arrTemp = [];
                $arrTemp['name'] = $record->name;
                $arrTemp['mobile'] = $record->mobile;
                $arrTemp['phone'] = '';
                $arrTemp['qq'] = '';
                $arrTemp['email'] = '';
                $arrTemp['channel_id'] = $record->door;
                $arrTemp['project'] = $record->project;
                $arrTemp['project_url'] = 'http://'.$record->pinyin.'.91canyin.com';
                $arrTemp['created_at'] = time();
                $arrTemp['updated_at'] = time();
                DB::table('ponds')->insert($arrTemp);
            }
        }
        $ids = substr($ids, 0, -1);
        if (Helper::isIds($ids)) {
            DB::connection('91')->table('sh_client')
                ->whereIn('c_id', explode(',', $ids))
                ->update(['is_send_crm' => 1]);
        }
    }

    public function zone() {
        $results = DB::connection('zone')->select('SELECT * FROM `91analytics`.`stat_records` WHERE `is_send_crm` = 0 AND `visitor_qq` !=  :visitor_qq ORDER BY `id` DESC LIMIT 0, 10', ['visitor_qq' => '']);
        $ids = '';
        foreach ($results as $record) {
            if ($record->id) {
                $ids .= $record->id.',';
                $arrTemp = [];
                $arrTemp['name'] = $record->visitor_nickname;
                $arrTemp['mobile'] = '';
                $arrTemp['phone'] = '';
                $arrTemp['qq'] = $record->visitor_qq;
                $arrTemp['email'] = '';
                $arrTemp['channel_id'] = 100;
                $arrTemp['project'] = $record->page_title;
                $arrTemp['project_url'] = $record->page_url;
                $arrTemp['created_at'] = time();
                $arrTemp['updated_at'] = time();
                DB::table('ponds')->insert($arrTemp);
            }
        }
        $ids = substr($ids, 0, -1);
        if (Helper::isIds($ids)) {
            DB::connection('zone')->table('stat_records')
                ->whereIn('id', explode(',', $ids))
                ->update(['is_send_crm' => 1]);
        }
    }

    public function call400() {
        $results = DB::connection('call')->select('SELECT `c`.*,`p`.`name` AS `project`,`p`.`pinyin` FROM `sh_call` AS `c` LEFT JOIN `sh_project` AS `p` ON `c`.`project_id` = `p`.`p_id`  WHERE `c`.`is_send_crm` = 0 AND `c`.`call_no` !=  :call_no ORDER BY `c`.`id` DESC LIMIT 0, 10', ['call_no' => '']);
        $ids = '';
        foreach ($results as $record) {
            if ($record->id) {
                $project = $record->project ? $record->project : '';
                $ids .= $record->id.',';
                $arrTemp = [];
                $arrTemp['name'] = '';
                $arrTemp['mobile'] = $record->call_no;
                $arrTemp['phone'] = '';
                $arrTemp['qq'] = '';
                $arrTemp['email'] = '';
                $arrTemp['channel_id'] = 200;
                $arrTemp['project'] = $project;
                $arrTemp['project_url'] = 'http://'.$record->pinyin.'.91canyin.com';
                $arrTemp['created_at'] = time();
                $arrTemp['updated_at'] = time();
                DB::table('ponds')->insert($arrTemp);
            }
        }
        $ids = substr($ids, 0, -1);
        if (Helper::isIds($ids)) {
            DB::connection('call')->table('sh_call')
                ->whereIn('id', explode(',', $ids))
                ->update(['is_send_crm' => 1]);
        }
    }

}
