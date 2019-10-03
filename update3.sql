alter table elgg_private_settings drop key value;
alter table elgg_entities drop key type_subtype_container;
alter table elgg_entities drop key type_subtype_owner;
alter table elgg_entities drop key type_subtype;
truncate elgg_users_sessions;