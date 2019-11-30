<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Archive extends Model
{
    //静的メソッドとして呼び出している。
    public static function getArchiveList()
    {
      //グループ化し。year,monthname post_countカラムを持つレコードを表示
       $archives_list = DB::table('posts')
            ->whereNull('deleted_at')
            ->selectRaw('
                year(extract(created_at)) as year,
                month(extract(created_at)) as month, 
                COUNT(*) as post_count
            ')
            ->groupBy('year')
            ->groupBy('month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

            foreach ($archives_list as $value) {
            // YYYY-MM をハイフンで分解して、YYYY年MM月という表記を作る
            $year = $value->year;
            (int)$month = $value->month;
            $value->year_month = sprintf("%04d年%02d月", $year, $month);
            //(format[d=整数値, s=文字列],文字1, 文字2)
        }
        return $archives_list;
      }
}