grant all on upload.* to dbuser@localhost identified by 'Roim0624';

use upload

create table post (
  id int not null auto_increment primary key,
  username varchar(255),
  comment text,
  postdate datetime,
  imagefile varchar(255)
);

desc post;
