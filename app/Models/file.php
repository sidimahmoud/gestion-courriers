<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class file extends Model
{
    use HasUuids;

    /**
     * The possible types of files.
     */
    public const TYPES = [
        'arrival',    // Incoming files/documents received by the ministry
        'departure',  // Outgoing files/documents sent from the ministry
        'internal',   // Files/documents circulated within the ministry
    ];

    /**
     * The possible statuses for files in the ministry workflow.
     */
    public const STATUSES = [
        'draft',        // File is being prepared
        'submitted',    // Officially submitted, awaiting review
        'in_review',    // Under review by authority
        'assigned',  // Actions are being carried out
        'completed',    // All actions finished
        'archived',     // No longer active, archived
        'returned',     // Sent back for corrections/info
    ];

    protected $fillable = [
        'object',
        'description',
        'path',
        'type',
        'sender_name',
        'destination_name',
        'tags',
        'file_number',
        'date_arrival',
        'date_sent',
        'observation',
        'is_archived',
        'is_private',
        'priority',
        'status',
        'created_by',
        'destination_id',
        'sender_id',
        'category_id',
        'name',
    ];

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }
}
