create table users (
  id int not null primary key auto_increment,
  username text not null unique,
  password text not null
);

create table groups (
  id int not null primary key auto_increment,
  name text not null unique,
  create_by int not null,
  foreign key (create_by) references users(id) on delete cascade
);

create table todos (
  id int primary key auto_increment,
  group_id integer not null,
  title text not null,
  completed boolean not null default false,
  create_by integer not null,
  foreign key(group_id) references groups(id) on delete cascade,
  foreign key(create_by) references users(id) on delete cascade
);

create table shares (
  id int not null primary key auto_increment,
  group_id integer not null,
  user_id integer not null,
  foreign key(group_id) references groups(id) on delete cascade,
  foreign key(user_id) references users(id) on delete cascade
);