-- Project Name : test
-- Date/Time    : 2010/03/26 18:16:53
-- Author       : ryuzee
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- スプリント
-- drop table sprints cascade;

create table sprints (
  id integer auto_increment not null comment 'id'
  , name VARCHAR(200) not null comment 'name'
  , description text comment 'description'
  , startdate DATETIME not null comment 'startdate'
  , enddate DATETIME not null comment 'enddate'
  , disabled boolean default false comment 'disabled'
  , created DATETIME comment 'created'
  , updated DATETIME comment 'updated'
  , primary key (id)
) ;

-- 残存時間
-- drop table remaining_times cascade;

create table remaining_times (
  id integer auto_increment not null comment 'id'
  , task_id INT not null comment 'task_id'
  , hours INT not null comment 'hours'
  , created DATE not null comment 'created'
  , primary key (id)
) ;

-- タスク
-- drop table tasks cascade;

create table tasks (
  id integer auto_increment not null comment 'id'
  , sprint_id INT not null comment 'sprint_id'
  , story_id INT not null comment 'story_id'
  , name text not null comment 'name'
  , description text comment 'description'
  , estimate_hours INT default 0 comment 'estimate_hours'
  , user_id INT comment 'user_id'
  , disabled boolean default false comment 'disabled'
  , created DATETIME comment 'created'
  , updated DATETIME comment 'updated'
  , primary key (id)
) ;

-- ストーリー
-- drop table stories cascade;

create table stories (
  id integer auto_increment not null comment 'id'
  , name text not null comment 'name'
  , description text not null comment 'description'
  , businessvalue INT default 0 comment 'businessvalue'
  , priority_id INT comment 'priority_id'
  , disabled boolean default false comment 'disabled'
  , created DATETIME comment 'created'
  , updated DATETIME comment 'updated'
  , primary key (id)
) ;

-- チームメンバー
-- drop table teammembers cascade;

create table teammembers (
  id integer auto_increment not null comment 'id'
  , team_id INT not null comment 'team_id'
  , user_id INT not null comment 'user_id'
  , disabled boolean default false comment 'disabled'
  , updated DATETIME comment 'updated'
  , created DATETIME comment 'created'
  , primary key (id)
) ;

-- ユーザー
-- drop table users cascade;

create table users (
  id integer auto_increment not null comment 'id'
  , loginname VARCHAR(100) not null comment 'loginname'
  , password VARCHAR(100) not null comment 'password'
  , username VARCHAR(100) not null comment 'username'
  , email VARCHAR(100) comment 'email'
  , disabled boolean default false comment 'disabled'
  , created DATETIME comment 'created'
  , updated DATETIME comment 'updated'
  , primary key (id)
) ;

-- チーム
-- drop table teams cascade;

create table teams (
  id integer auto_increment not null comment 'id'
  , name VARCHAR(200) not null comment 'name'
  , description text comment 'description'
  , disabled boolean default false comment 'disabled'
  , created DATETIME comment 'created'
  , updated DATETIME comment 'updated'
  , primary key (id)
) ;

