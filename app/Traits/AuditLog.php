<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait AuditLog
{
    /**
     * Boot the audit log trait.
     */
    public static function bootAuditLog()
    {
        static::created(function ($model) {
            $model->logAction('created');
        });

        static::updated(function ($model) {
            $model->logAction('updated');
        });

        static::deleted(function ($model) {
            $model->logAction('deleted');
        });
    }

    /**
     * Log an action for the model.
     */
    protected function logAction($action)
    {
        if (!Auth::check()) {
            return;
        }

        \DB::table('audit_logs')->insert([
            'user_id' => Auth::id(),
            'model_type' => get_class($this),
            'model_id' => $this->id,
            'action' => $action,
            'old_values' => json_encode($this->getOriginal()),
            'new_values' => json_encode($this->getAttributes()),
            'created_at' => now(),
        ]);
    }
}
