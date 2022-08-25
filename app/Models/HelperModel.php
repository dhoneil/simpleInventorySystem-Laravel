<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HelperModel extends Model
{
    use HasFactory;

    public static function GetAll($tablename='')
    {
        return DB::table($tablename)->get();
    }

    public static function GetSingle($tablename='',$columnname = '', $columnvalue='')
    {
        $entity = DB::table($tablename)->where($columnname, $columnvalue)->first();
        return $entity;
    }

    public static function Create($tablename,$object)
    {
        $request = $object->toArray();
        $object = Arr::except($request,['_token','isDelete']);
        $insert = DB::table($tablename)->insertGetId($object);
        return $insert;
    }

    public static function UpdateModel($tablename,$columnname,$columnvalue,$object)
    {
        $request = $object->toArray();
        $object = Arr::except($request,['_token','isDelete']);
        DB::table($tablename)
              ->where($columnname, $columnvalue)
              ->update($object);
    }

    public static function DeleteSingle($tablename='',$columnname = '', $columnvalue='')
    {
        DB::table($tablename)->where($columnname, $columnvalue)->delete();
    }
}
