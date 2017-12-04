<?php namespace Syscover\Review\Traits;

use Syscover\Review\Models\Review;

trait Reviewable
{
    public function reviews()
    {
        return $this->morphMany(
            Review::class,
            'object',
            'object_type',
            'object_id',
            'id'
        );
    }
}
