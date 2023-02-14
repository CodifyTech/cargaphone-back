<?php

namespace App\Observers;

use App\Models\Totem;

class IdentifierObserver
{
    /**
     * Handle the Totem "created" event.
     *
     * @param  \App\Models\Totem  $totem
     * @return void
     */
    public function created(Totem $totem)
    {
        //
    }

    public function creating(Totem $model)
    {
        $lastModel = Totem::orderBy('identificador', 'desc')->first();
        $model->identificador = 'T' . sprintf('%03d', $lastModel ? (substr($lastModel->identificador, 1) + 1) : 1);
    }

    /**
     * Handle the Totem "updated" event.
     *
     * @param  \App\Models\Totem  $totem
     * @return void
     */
    public function updated(Totem $totem)
    {
        //
    }

    /**
     * Handle the Totem "deleted" event.
     *
     * @param  \App\Models\Totem  $totem
     * @return void
     */
    public function deleted(Totem $totem)
    {
        //
    }

    /**
     * Handle the Totem "restored" event.
     *
     * @param  \App\Models\Totem  $totem
     * @return void
     */
    public function restored(Totem $totem)
    {
        //
    }

    /**
     * Handle the Totem "force deleted" event.
     *
     * @param  \App\Models\Totem  $totem
     * @return void
     */
    public function forceDeleted(Totem $totem)
    {
        //
    }
}
