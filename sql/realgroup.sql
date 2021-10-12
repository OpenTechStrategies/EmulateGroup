CREATE TABLE /*_*/EmulateGroupRealGroup (
  user_id int(11) NOT NULL,
  group_name varchar(255) NOT NULL,

  UNIQUE(user_id, group_name)
) /*$wgDBTableOptions*/;
