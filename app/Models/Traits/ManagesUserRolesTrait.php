<?php


namespace App\Models\Traits;


use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Collection;

trait ManagesUserRolesTrait
{
  /**
   * Grants role to this user
   *
   * @see grantRoles()
   * @param int|Role $role The role to grant
   * @param bool $reload Reload the relation on this model
   * @return $this
   */
  public function grantRole($role, $reload = true)
  {
    /** @var User $this */
    return $this->grantRoles($role, $reload);
  }


  /**
   * Grant roles to this user
   *
   * @param int|int[]|Role|Role[]|Collection $roles The roles to grant
   * @param bool $reload Reload the relation on this model
   * @return $this
   */
  public function grantRoles($roles, $reload = true)
  {
    /** @var User $this */

    $this->roles()->attach($roles);
    if ($reload) {
      $this->load('roles');
    }

    return $this;
  }

  /**
   * Sync the roles for this user
   *
   * Note: This removes the roles which are assigned and only assigns the ones specified.
   *
   * @param int|int[]|Role|Role[]|Collection $roles The roles to sync
   * @param bool $reload Reload the relation on this model
   * @return array
   */
  public function syncRoles($roles, $reload = true)
  {
    /** @var User $this */

    $synced = $this->roles()->sync($roles);
    if ($reload) {
      $this->load('roles');
    }

    return $synced;
  }


  /**
   * Revoke role for this user
   *
   * @see revokeRoles()
   * @param int|Role $role The role to revoke
   * @param bool $reload Reload the relation on this model
   * @return $this
   */
  public function revokeRole($role, $reload = true)
  {
    return $this->revokeRoles($role, $reload);
  }

  /**
   * Revoke roles for this user
   *
   * @param int|int[]|Role|Role[]|Collection $roles The roles to revoke
   * @param bool $reload Reload the relation on this model
   * @return $this
   */
  public function revokeRoles($roles, $reload = true)
  {
    /** @var User $this */

    $this->roles()->detach($roles);
    if ($reload) {
      $this->load('roles');
    }

    return $this;
  }
}