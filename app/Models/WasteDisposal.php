<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class WasteDisposal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'waste_type',
        'type',
        'factors', 
    ];
    
    const TYPE = [
        'Material',
        'Metals',
        'Paper',
        'Plastic',
    ];
    const WASTE_TYPE = [
        'Aggregates',
        'Asbestos',
        'Asphalt',
        'Batteries',
        'Bricks',
        'Clothing',
        'Commercial and Industrial Waste',
        'Concreate',
        'Glass',
        'Household Residual Waste',
        'Insulation',
        'Metal: aluminium cans and foil (excl.forming)',
        'Metal: mixed cans',
        'Metal: scrap metal',
        'Metal: steel cans',
        'Metals', 
        'Organic: food and drink waste',
        'Organic: garden waste',
        'Organic: mixed food and garden waste',
        'Paper and board: board',
        'Paper and board: mixed',
        'Paper and board: paper',
        'Plasterboard',
        'Plastics: average plastic film',
        'Plastics: average plastic rigid',
        'Plastics: average plastics',
        'Plastics: HDPE (incl.forming)',
        'Plastics: LDPE and LLDPE (incl.forming)',
        'Plastics: PET (incl.forming)',
        'Plastics: PP (incl.forming)',
        'Plastics: PS (incl.forming)',
        'Plastics: PVP (incl.forming)',
        'Soils',
        'WEEE: fridges and freezers',
        'WEEE: large',
        'WEEE: mixed',
        'WEEE: small',
        'Wood'
     ];
}
