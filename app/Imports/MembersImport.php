<?php

namespace App\Imports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MembersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Member([
            "group_id"=>$row['group_id'],
            "name"=>$row['nama'],
            "address"=>$row['alamat'],
            "phone"=>$row['hp'],
            "email"=>$row['email'],
            "profile_pic"=>$row['foto'],
        ]);
    }
}
