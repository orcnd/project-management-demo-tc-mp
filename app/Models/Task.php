<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Task Model
 *
 * @category App
 * @package  App\Models
 * @author   Orcun Candan <orcuncandan89@gmail.com>
 * @license  MIT License (https://orcuncandan.mit-license.org)
 * @link     https://orcuncandan.com
 */
class Task extends Model
{
    protected $fillable=[
        'name', 'description', 'project_id', 'status',
    ];

}
