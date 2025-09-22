<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'company'; // 👈 match your table name
    protected $primaryKey = 'company_id';

    protected $fillable = [
        'company_name',
        'company_email',
        'company_address',
        'kvk',
        'profession_id',
        'field',
    ];

    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }
}
