<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies'; // 👈 match your table name
    protected $primaryKey = 'Company_ID';

    protected $fillable = [
        'Company_Name',
        'Company_Email',
        'Company_Address',
        'KVK',
        'Profession_ID',
        'field',
    ];

    public function profession()
    {
        return $this->belongsTo(Profession::class, 'Profession_ID', 'Profession_ID'); // Fixed reference
    }
}
