<?php


namespace App\Models\Traits;


use App\Models\Right;
use App\Models\User;
use Illuminate\Support\Collection;

/**
 * Class ManagesUserRightsTrait
 * @package App\Models\Traits
 */
trait ManagesUserRightsTrait
{
  /**
   * Grants right to this user
   *
   * @see grantRights()
   * @param int|Right $right The right to grant
   * @param bool $reload Reload the relation on this model
   * @return $this
   */
  public function grantRight($right, $reload = true)
  {
    /** @var User $this */
    return $this->grantRights($right, $reload);
  }

  /**
   * Grant rights to this user
   *
   * @param int|int[]|Right|Right[]|Collection $rights The rights to grant
   * @param bool $reload Reload the relation on this model
   * @return $this
   */
  public function grantRights($rights, $reload = true)
  {
    /** @var User $this */

    $this->rights()->attach($rights);
    if ($reload) {
      $this->load('rights');
    }

    return $this;
  }

  /**
   * Sync the rights for this user
   *
   * Note: This removes the rights which are assigned and assigns the ones specified.
   *
   * @param int|int[]|Right|Right[]|Collection $rights The rights to sync
   * @param bool $reload Reload the relation on this model
   * @return array
   */
  public function syncRights($rights, $reload = true)
  {
    /** @var User $this */

    $synced = $this->rights()->sync($rights);
    if ($reload) {
      $this->load('rights');
    }

    return $synced;
  }

  /**
   * Revoke right for this user
   *
   * @see revokeRights()
   * @param int|Right $right The right to revoke
   * @param bool $reload Reload the relation on this model
   * @return $this
   */
  public function revokeRight($right, $reload = true)
  {
    return $this->revokeRights($right, $reload);
  }

  /**
   * Revoke rights for this user
   *
   * @param int|int[]|Right|Right[]|Collection $rights The rights to revoke
   * @param bool $reload Reload the relation on this model
   * @return $this
   */
  public function revokeRights($rights, $reload = true)
  {
    /** @var User $this */

    $this->rights()->detach($rights);
    if ($reload) {
      $this->load('rights');
    }

    return $this;
  }
}