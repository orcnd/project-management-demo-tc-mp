<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    protected $fillable=[
        'name',
        'description',
    ];

    /**
     * Get the tasks for the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks():HasMany
    {
        return $this->hasMany(Task::class);
    }
}
