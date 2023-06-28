<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CronLogModel extends Model
{
    protected $table = 'cron_logs';
    protected $fillable = ['cron_signature','start_datetime','end_datetime'];
}
