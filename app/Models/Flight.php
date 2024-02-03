<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Flight extends Model
{
    use HasFactory, SoftDeletes;

    const CLASS_TYPE = [
        'Economy',
        'Business',
     ];

     const CLASS_TYPE1 = [
      'Economy',
      'Business',
      'Premium economy class',
      'First class',
   ];

     const SINGLE_WAY_RETURN = [
        'Single way',
        'Return',
     ];

     public function origin()
     {
        return $this->hasOne(City::class,'id','origin')->select('id','name');
     }
     public function destination()
     {
        return $this->hasOne(City::class,'id','destination')->select('id','name');
     }
}
