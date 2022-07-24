<?php

namespace App\Imports;

use App\Models\Group;
use App\Models\Member;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
// use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class MembersImport implements ToModel, WithStartRow, WithCustomCsvSettings
{
    public function startRow(): int
    {
        return 2;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ','
        ];
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $group = Group::firstOrNew(['name' => $row[1]]);
	
	if(!isset($group->id)) $group->save();
	
        return new Member([
            "group_id"=>$group->id,
            "member_id"=>$row[0],
            "name"=>$row[2],
            "address"=>$row[3],
            "phone"=>$row[4],
            "email"=>$row[5]
        ]);
    }
}
