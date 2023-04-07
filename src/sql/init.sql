create table todos (
  id serial primary key,
  title text not null,
  completed boolean not null default false
);

create table attachments (
  id serial primary key,
  todo_id integer not null references todos(id) on delete cascade,
  filename text not null,
  content_type text not null,
  content bytea not null
);