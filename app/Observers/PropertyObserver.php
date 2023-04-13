<?php

namespace App\Observers;

use Botble\RealEstate\Models\Property;

class PropertyObserver
{
    public function retrieved(Property $property)
    {
        if(isset($property->duration) && $property->created_at < now()->subDays($property->duration)){
        // dd(now()->subDays($property->duration),$property->duration);

            // $property->duration = now()->subDays($property->duration);
            // $property->save();
            $property->delete();
        }
    }
    /**
     * Handle the Property "created" event.
     *
     * @param  \App\Models\Property  $property
     * @return void
     */
    public function created(Property $property)
    {
        $property->moderation_status='approved';
        $property->save();
    }

    /**
     * Handle the Property "updated" event.
     *
     * @param  \App\Models\Property  $property
     * @return void
     */
    public function updated(Property $property)
    {
        //
    }

    /**
     * Handle the Property "deleted" event.
     *
     * @param  \App\Models\Property  $property
     * @return void
     */
    public function deleted(Property $property)
    {
        //
    }

    /**
     * Handle the Property "restored" event.
     *
     * @param  \App\Models\Property  $property
     * @return void
     */
    public function restored(Property $property)
    {
        //
    }

    /**
     * Handle the Property "force deleted" event.
     *
     * @param  \App\Models\Property  $property
     * @return void
     */
    public function forceDeleted(Property $property)
    {
        //
    }
}
