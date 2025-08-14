<?php

namespace App\Models\Admin\Inventory;

use App\Models\Admin\MasterData\DeviceBrand;
use App\Models\Admin\MasterData\Region;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessPoint extends Model
{
    use HasFactory;
    protected $table = 'access_point';
    protected $guarded = ['id'];

    public function getAllData()
    {
        return $this->latest()->get();
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'kd_region', 'kd_region');
    }

}
