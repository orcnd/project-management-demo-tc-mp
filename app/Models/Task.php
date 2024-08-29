<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Project;

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

    /**
     * Summary of project
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    function project():BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

}
