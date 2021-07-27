<?php

namespace Nrz\Order\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nrz\Product\Models\Attribute;
use Nrz\Product\Models\Product;
use Nrz\User\Models\User;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        "price",
        "status",
        "consume_location",
        "user_id",
        "quantity",
        "user_id",
        "order_id",
        "product_id",
        "attribute_id",
        "value_id",
    ];

    //status
    const STATUS_WAITING = "waiting";
    const STATUS_PREPARATION = "preparation";
    const STATUS_READY = "ready";
    const STATUS_DELIVERED = "delivered";
    const STATUS_CANCELED = "canceled";
    const  STATUSES = [
        self::STATUS_WAITING,
        self::STATUS_PREPARATION,
        self::STATUS_READY,
        self::STATUS_DELIVERED,
        self::STATUS_CANCELED
    ];

    // Consume location
    const LOCATE_SHOP = "shop";
    const LOCATE_TAKE_AWAY = "take_away";
    const LOCATE = [
        self::LOCATE_SHOP,
        self::LOCATE_TAKE_AWAY
    ];


    public function products()
    {
        return $this->belongsToMany(Product::class,"order_product")
            ->using(OrderProductValue::class)->withPivot(['value_id','attribute_id','product_id']);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }



}
