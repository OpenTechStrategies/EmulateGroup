-- MySQL/SQLite schema for the Teamteamcomments extension

CREATE TABLE /*_*/EmulateGroupCurrentlyEmulating (
  user_id int(11) NOT NULL UNIQUE,
  group_name varchar(255) NOT NULL
) /*$wgDBTableOptions*/;
