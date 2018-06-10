<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Right extends Model
{
  const INSTITUTIONS_INDEX = 'institutions.index';
  const INSTITUTIONS_CREATE = 'institutions.create';
  const INSTITUTIONS_EDIT = 'institutions.edit';
  const INSTITUTIONS_SHOW = 'institutions.show';
  const INSTITUTIONS_DESTROY = 'institutions.delete';

  const INSTITUTIONS_TYPE_INDEX = 'institutionsType.index';
  const INSTITUTIONS_TYPE_CREATE = 'institutionsType.create';
  const INSTITUTIONS_TYPE_EDIT = 'institutionsType.edit';
  const INSTITUTIONS_TYPE_SHOW = 'institutionsType.show';
  const INSTITUTIONS_TYPE_DESTROY = 'institutionsType.delete';

  const PERSONS_INDEX = 'persons.index';
  const PERSONS_CREATE = 'persons.create';
  const PERSONS_EDIT = 'persons.edit';
  const PERSONS_SHOW = 'persons.show';
  const PERSONS_DESTROY = 'persons.delete';

  const PERSONS_TYPE_INDEX = 'personsType.index';
  const PERSONS_TYPE_CREATE = 'personsType.create';
  const PERSONS_TYPE_EDIT = 'personsType.edit';
  const PERSONS_TYPE_SHOW = 'personsType.show';
  const PERSONS_TYPE_DESTROY = 'personsType.delete';

  const PERSONS_STATUS_INDEX = 'personsStatus.index';
  const PERSONS_STATUS_CREATE = 'personsStatus.create';
  const PERSONS_STATUS_EDIT = 'personsStatus.edit';
  const PERSONS_STATUS_SHOW = 'personsStatus.show';
  const PERSONS_STATUS_DESTROY = 'personsStatus.delete';

  const AUTHORITIES_INDEX = 'authorities.index';
  const AUTHORITIES_CREATE = 'authorities.create';
  const AUTHORITIES_EDIT = 'authorities.edit';
  const AUTHORITIES_SHOW = 'authorities.show';
  const AUTHORITIES_DESTROY = 'authorities.delete';

  const SOURCES_INDEX = 'sources.index';
  const SOURCES_CREATE = 'sources.create';
  const SOURCES_EDIT = 'sources.edit';
  const SOURCES_SHOW = 'sources.show';
  const SOURCES_DESTROY = 'sources.delete';

  const SOURCE_TYPES_INDEX = 'sourceTypes.index';
  const SOURCE_TYPES_CREATE = 'sourceTypes.create';
  const SOURCE_TYPES_EDIT = 'sourceTypes.edit';
  const SOURCE_TYPES_SHOW = 'sourceTypes.show';
  const SOURCE_TYPES_DESTROY = 'sourceTypes.delete';

  const FACTOIDS_INDEX = 'factoids.index';
  const FACTOIDS_CREATE = 'factoids.create';
  const FACTOIDS_EDIT = 'factoids.edit';
  const FACTOIDS_SHOW = 'factoids.show';
  const FACTOIDS_DESTROY = 'factoids.delete';

  const FACTOID_TYPES_INDEX = 'factoidTypes.index';
  const FACTOID_TYPES_CREATE = 'factoidTypes.create';
  const FACTOID_TYPES_EDIT = 'factoidTypes.edit';
  const FACTOID_TYPES_SHOW = 'factoidTypes.show';
  const FACTOID_TYPES_DESTROY = 'factoidTypes.delete';

  const PLACES_INDEX = 'places.index';
  const PLACES_CREATE = 'places.create';
  const PLACES_EDIT = 'places.edit';
  const PLACES_SHOW = 'places.show';
  const PLACES_DESTROY = 'places.delete';

  const GLOSSARIES_INDEX = 'glossaries.index';
  const GLOSSARIES_CREATE = 'glossaries.create';
  const GLOSSARIES_EDIT = 'glossaries.edit';
  const GLOSSARIES_SHOW = 'glossaries.show';
  const GLOSSARIES_DESTROY = 'glossaries.delete';

  const USERS_INDEX = 'users.index';
  const USERS_CREATE = 'users.create';
  const USERS_EDIT = 'users.edit';
  const USERS_SHOW = 'users.show';
  const USERS_DESTROY = 'users.delete';

  const USER_GROUPS_INDEX = 'user_groups.index';
  const USER_GROUPS_CREATE = 'user_groups.create';
  const USER_GROUPS_EDIT = 'user_groups.edit';
  const USER_GROUPS_SHOW = 'user_groups.show';
  const USER_GROUPS_DESTROY = 'user_groups.delete';

  const ROLES_INDEX = 'roles.index';
  const ROLES_CREATE = 'roles.create';
  const ROLES_EDIT = 'roles.edit';
  const ROLES_DESTROY = 'roles.delete';

  const APPROVE_REQUESTS = 'requests.approve';
  const PUBLISH_OWN_REQUESTS = 'requests.publish_own';
  const DELETE_ANY_RECORD = 'requests.delete_any';

  const LOGS = 'system.logs';
  const TRASH = 'system.trash';
  const STATISTIC = 'users.statistic';

  public function users() {
    return $this->belongsToMany(User::class, 'user_rights', 'right_id', 'user_id');
  }
}
