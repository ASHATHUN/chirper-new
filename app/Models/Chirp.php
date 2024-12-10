<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chirp extends Model
{
    //บาง column ใน table เขาไม่ต้องการให้ไปยุ่ง เลยกำหนดค่าว่าเราสามารถใส่ข้อะความเข้าไปใน column ไหนได้บ้าง กรณีนี้ใส่แค่ message
    protected $fillable = [
        'message',
    ];

    public function user(): BelongsTo
    {
        // belongsto แทนที่จะเอามาทั้งหมด จะเอามาแค่ข้อความจากuser ของใครของมัน
        return $this->belongsTo(User::class);
    }
}
