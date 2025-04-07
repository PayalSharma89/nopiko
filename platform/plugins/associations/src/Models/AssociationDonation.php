<?php 

namespace Botble\Associations\Models;

use Botble\Base\Models\BaseModel;

class AssociationDonation extends BaseModel
{
    protected $table = 'association_donations';

    protected $fillable = [
        'association_id',
        'order_id',
        'product_id',
        'donation_amount',
    ];

    public function association()
    {
        return $this->belongsTo(Association::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
