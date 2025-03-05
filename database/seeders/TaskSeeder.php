<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    public function run()
    {
        $tasks = [
            ['task_name' => 'ホール'],
            ['task_name' => 'キッチン'],
            ['task_name' => '洗い場'],
            ['task_name' => 'レジ・品出し・商品整理'],
            ['task_name' => '接客・販売'],
            ['task_name' => 'ポスティング・ビラ配り'],
            ['task_name' => 'コンビニ業務'],
            ['task_name' => 'ホテル業務'],
            ['task_name' => '受付・案内'],
            ['task_name' => '事務・データ入力'],
            ['task_name' => 'コールセンター・テレアポ'],
            ['task_name' => '引越し・運搬'],
            ['task_name' => '会場設営'],
            ['task_name' => '梱包・シール貼り'],
            ['task_name' => '検品・仕分け'],
            ['task_name' => '清掃'],
            ['task_name' => '作業補助'],
            ['task_name' => '農業'],
            ['task_name' => 'フードデリバリー'],
            ['task_name' => '配達・配送'],
            ['task_name' => '送迎'],
            ['task_name' => '保育'],
            ['task_name' => '教育・指導'],
            ['task_name' => 'その他'],
            ['task_name' => '小売・販売'],
            ['task_name' => '接客・サービス'],
            ['task_name' => 'ベッドメイク'],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}
