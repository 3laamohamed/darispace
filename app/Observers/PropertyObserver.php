<?php

namespace App\Observers;

use Botble\RealEstate\Models\Property;
use Carbon\Carbon;

class PropertyObserver
{
    public function retrieved(Property $property)
    {
        if(isset($property->duration) && $property->created_at < now()->subDays($property->duration)){
        // dd(now()->subDays($property->duration),$property->duration);

            // $property->duration = now()->subDays($property->duration);
            // $property->save();
            // $property->delete();
            $property->moderation_status='pending';
            $property->save();

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

    }
    public function updating(Property $property)
    {
        if($property->moderation_status != 'approved' && request()->moderation_status == 'approved'){
            if(isset($property->duration) && $property->created_at < now()->subDays($property->duration)){
                $property->created_at = Carbon::now();
                }
        }
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
