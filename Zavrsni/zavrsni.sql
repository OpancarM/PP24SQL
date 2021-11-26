#databaseFinal

drop database if exists edunovapp24;
create database edunovapp24 character set utf8;
use edunovapp24;

#productTable

create table product
(
    id                  int not null primary key auto_increment,
    item_name           varchar(50),
    item_price          decimal(18,2),
    item_description    varchar(50),
    item_image          varchar(255)   
);

#userTable

create table user
(
    id                  int not null primary key auto_increment,
    username            varchar(50) not null,
    userPassword        varchar(50) not null,
    firstName           varchar(50) not null,
    lastName            varchar(50) not null,
    adress              varchar(50),
    email               varchar(50),
    register_date       datetime
);

#cartTable

create table cart
(
    id                  int not null primary key auto_increment,
    user                int not null,
    product             int not null
);

#cartAlterTable

alter table cart add foreign key (product) references product(id);
alter table cart add foreign key (user) references user(id);


