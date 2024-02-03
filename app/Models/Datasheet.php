<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;


class Datasheet extends Model
{
    use HasFactory, SoftDeletes;

    const IS_UPLOADED = '0';
    const IS_INPROGRESS = '1';
    const IS_COMPLETE = '2';
    const IS_PUBLISH = '3';
    const IS_FAILED = '4';
    const IS_DRAFT = '5';
    
    protected $fillable = [
        'data_assessor',
        'uploaded_by',
        'date_time',
        'reporting_start_date',
        'reporting_end_date',
        'uploaded_file_name',
        'calculated_file_name',
        'source_id',
        'description',
        'status',
        'is_draft',
        'published_at',
        'uploded_sheet',
        'emission_calculated',
    ];

    /**
     * Get the user that owns the Datasheet
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function get_name(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getUplodedSheetAttribute()
    {   
        if(!empty($this->attributes['uploded_sheet']) && Storage::disk('datasheet')->exists($this->attributes['uploded_sheet'])){
            $imgpath = Storage::disk('datasheet')->url($this->attributes['uploded_sheet']);
        }else{
            $imgpath = '-';
        }
        return $imgpath;
    }

    public function getEmissionCalculatedAttribute()
    {   
        if(!empty($this->attributes['emission_calculated']) && Storage::disk('calculated_datasheet')->exists($this->attributes['emission_calculated'])){
            $imgpath = Storage::disk('calculated_datasheet')->url($this->attributes['emission_calculated']);
        }else{
            $imgpath = '-';
        }
        return $imgpath;
    }

    public static function generateSourceId()
    {
        $lastRecord = self::latest()->first();
        if ($lastRecord) {
            $lastId = $lastRecord->id + 1;
        } else {
            $lastId = 1;
        }
        
        return 'DS' . str_pad($lastId, 8, '0', STR_PAD_LEFT);
    }

    public function company()
    {
        return $this->hasOne(Company::class,'id','company_id');
    }
}
