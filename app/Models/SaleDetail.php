<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{

    use LogsActivity;

    protected $activityLogType = 'transaction';
    protected $activityLogModule = 'sale detail';

    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'selling_price',
        'subtotal'
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
