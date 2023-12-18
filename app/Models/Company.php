<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Company extends Model
{
    use HasFactory;

    public function getList() {
        // companiesテーブルからデータを取得
        $companies = DB::table('companies')->pluck('company_name', 'id')->toArray();
        return $companies;
    }

}
