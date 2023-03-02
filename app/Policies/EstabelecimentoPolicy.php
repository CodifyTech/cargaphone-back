<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Estabelecimento;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EstabelecimentoPolicy
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
     * @param  \App\Models\Estabelecimento  $estabelecimento
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Estabelecimento $estabelecimento)
    {
        return $user->perfil === 2 || $user->perfil === 1
            ? Response::allow()
            : Response::deny('Você não tem autorização visualizar este estabelecimento.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, Estabelecimento $estabelecimento)
    {
        return $user->perfil === 2 || $user->perfil === 1
            ? Response::allow()
            : Response::deny('Você não tem autorização para criar um estabelecimento.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Estabelecimento  $estabelecimento
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Estabelecimento $estabelecimento)
    {
        return
            $user->perfil === 1
            ||
            $user->perfil === 2
            &&
            $user->tenant_id === $estabelecimento->tenant_id
            ? Response::allow()
            : Response::deny('Você não é o dono deste estabelecimento.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Estabelecimento  $estabelecimento
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Estabelecimento $estabelecimento)
    {
        return $user->perfil === 1 || $user->perfil === 2
            ? Response::allow()
            : Response::deny('Você não tem autorização para excluir um estabelecimento');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Estabelecimento  $estabelecimento
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Estabelecimento $estabelecimento)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Estabelecimento  $estabelecimento
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Estabelecimento $estabelecimento)
    {
        //
    }
}
