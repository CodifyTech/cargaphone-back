<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Anuncio;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AnuncioPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Anuncio  $anuncio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Anuncio $anuncio)
    {
        return $user->tenant_id === $anuncio->tenant_id
            && $user->perfil == 2
            || $user->perfil == 1
            ? Response::allow()
            : Response::deny('Você não tem autorizacão para visualizar este anúncio.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->perfil == 2
            || $user->perfil == 1
            ? Response::allow()
            : Response::deny('Você não tem autorizacão para criar um anúncio.');
    }

    /**
     * Determine whether the user can synchronize models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function sync(User $user, Anuncio $anuncio)
    {
        return
            $user->tenant_id == $anuncio->tenant_id
            &&
            $user->perfil == 2
            || $user->perfil == 1
            ? Response::allow()
            : Response::deny('Você não tem autorizacão para vincular um anúncio a um totem.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Anuncio  $anuncio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Anuncio $anuncio)
    {
        return $user->tenant_id === $anuncio->tenant_id
            && $user->perfil == 2
            || $user->perfil == 1
            ? Response::allow()
            : Response::deny('Você não tem autorizacão para editar este anúncio.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Anuncio  $anuncio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Anuncio $anuncio)
    {
        return
            $user->tenant_id === $anuncio->tenant_id
            &&
            $user->perfil == 2
            || $user->perfil == 1
            ? Response::allow()
            : Response::deny('Você não tem autorizacão para excluir este anúncio.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Anuncio  $anuncio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Anuncio $anuncio)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Anuncio  $anuncio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Anuncio $anuncio)
    {
        //
    }
}
