<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prospecto extends Model
{
    use HasFactory;
        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'datos_prospectos';
        /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
        /**
     * The model's default values for attributes.
     *
     * @var array
     */
       /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'seniority',
        'disponibility',
        'curriculum_filename'
    ];

}
