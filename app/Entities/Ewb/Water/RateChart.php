<?php

/**
 * Created by PhpStorm.
 * User: Hossian
 * Date: 4/26/20
 * Time: 01:00 PM
 */

namespace App\Entities\Ewb\Water;

use Illuminate\Database\Eloquent\Model;

class RateChart extends Model
{
    protected $table = 'w_rate_chart';
    protected $primaryKey = 'w_rate_chart_id';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function delivery_area_type()
    {
        return $this->belongsTo(LDeliveryAreaType::class, 'delivery_area_type_id');
    }
}
