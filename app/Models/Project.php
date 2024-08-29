<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Project Model
 *
 * @category App
 * @package  App\Models
 * @author   Orcun Candan <orcuncandan89@gmail.com>
 * @license  MIT License (https://orcuncandan.mit-license.org)
 * @link     https://orcuncandan.com
 */

class Project extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'description',
    ];
}
