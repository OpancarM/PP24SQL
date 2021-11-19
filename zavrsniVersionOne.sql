# databaseVersionOne

drop database if exists edunovapp24;
create database edunovapp24 character set utf8;
use edunovapp24;

#servicesTable

create table services
(
    id                  int not null primary key auto_increment,
    product             int not null,
    bespoke             int not null,
    narrowing           int not null,
    shortening          int not null
);

#productTable

create table product
(
    id                  int not null primary key auto_increment,
    suit                int not null,
    dressShirt          int not null,
    shoes               int not null,
    accessories         int not null,
    bag                 int not null
);

#suitTable

create table suit
(
    id                  int not null primary key auto_increment,
    item_name           varchar(50) not null,
    item_desription     varchar(255) not null,
    item_price          decimal(18,2) not null,
    item_image          varchar(255)
);

#dressShirtTable

create table dressShirt
(
    id                  int not null primary key auto_increment,
    item_name           varchar(50) not null,
    item_desription     varchar(255) not null,
    item_price          decimal(18,2) not null,
    item_image          varchar(255)
);

#shoesTable

create table shoes
(
    id                  int not null primary key auto_increment,
    item_name           varchar(50) not null,
    item_desription     varchar(255) not null,
    item_price          decimal(18,2) not null,
    item_image          varchar(255)
);

#accessoriesTable

create table accessories
(
    id                  int not null primary key auto_increment,
    item_name           varchar(50) not null,
    item_desription     varchar(255) not null,
    item_price          decimal(18,2) not null,
    item_image          varchar(255)
);

#bagTable

create table bag
(
    id                  int not null primary key auto_increment,
    item_name           varchar(50) not null,
    item_desription     varchar(255) not null,
    item_price          decimal(18,2) not null,
    item_image          varchar(255)
);

#bespokeTable

create table bespoke
(
    id                  int not null primary key auto_increment,
    tailoring           int not null,
    shoemaking          int not null
);

#tailoringTable

create table tailoring
(
    id                  int not null primary key auto_increment,
    tailor              int not null,
    price               decimal(18,2)
);

#tailorTable

create table tailor
(
    id                  int not null primary key auto_increment,
    firstName           varchar(50) not null,
    lastName            varchar(50) not null
);

#shoemakingTable

create table shoemaking
(
    id                  int not null primary key auto_increment,
    shoemaker           int not null,
    price               decimal(18,2)
);

#tailorTable

create table shoemaker
(
    id                  int not null primary key auto_increment,
    firstName           varchar(50) not null,
    lastName            varchar(50) not null
);

#narrowingTable

create table narrowing
(
    id                  int not null primary key auto_increment,
    price               decimal(18,2)
);

#shorteningTable

create table shortening
(
    id                  int not null primary key auto_increment,
    price               decimal(18,2)
);

#servicesAlterTable

alter table services add foreign key (product) references product(id);
alter table services add foreign key (bespoke) references bespoke(id);
alter table services add foreign key (narrowing) references narrowing(id);
alter table services add foreign key (shortening) references shortening(id);

#productAlterTable

alter table product add foreign key (suit) references suit(id);
alter table product add foreign key (dressShirt) references dressShirt(id);
alter table product add foreign key (shoes) references shoes(id);
alter table product add foreign key (accessories) references accessories(id);
alter table product add foreign key (bag) references bag(id);

#bespokeAlterTable

alter table bespoke add foreign key (tailoring) references tailoring(id);
alter table bespoke add foreign key (shoemaking) references shoemaking(id);

#tailoringAlterTable

alter table tailoring add foreign key (tailor) references tailor(id);

#shoemakingAlterTable

alter table shoemaking add foreign key (shoemaker) references shoemaker(id);
