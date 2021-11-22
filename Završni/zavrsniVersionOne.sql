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
    tailoring           int not null
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

#userTable

create table user
(
    id                  int not null primary key auto_increment,
    username            varchar(50) not null,
    userPassword        varchar(50) not null,
    firstName           varchar(50) not null,
    lastName            varchar(50) not null,
    telephone           int not null,
    adress              varchar(50),
    email               varchar(50)
);

#orderTable

create table orders
(
    id                  int not null primary key auto_increment,
    user                int not null,
    dateOrder           datetime,
    cart                int not null,
    cost                decimal(18,2)
);

#cartTable

create table cart
(
    id                  int not null primary key auto_increment,
    product             int not null,
    quantity            int not null,
    discount            int,
    price               decimal(18,2),
    total               decimal(18,2)
);

#shippinigTable

create table shipping 
(
    id                  int not null primary key auto_increment,
    shippingProvider    varchar(50),
    orders               int not null,
    cost                decimal(18,2)
);

#paymentTable

create table payment
(
    id                  int not null primary key auto_increment,
    paymentType         varchar(50),
    currency            varchar(50),
    orders               int not null,
    user                int not null
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

#tailoringAlterTable

alter table tailoring add foreign key (tailor) references tailor(id);

#cartAlterTable

alter table cart add foreign key (product) references product(id);

#orderAlterTable

alter table orders add foreign key (user) references user(id);
alter table orders add foreign key (cart) references cart(id);

#shippingAlterTable

alter table shipping add foreign key (orders) references orders(id);

#paymentAlterTable

alter table payment add foreign key (orders) references orders(id);
alter table payment add foreign key (user) references user(id);
