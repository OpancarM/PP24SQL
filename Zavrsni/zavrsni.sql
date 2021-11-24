# databaseVersionOne

drop database if exists edunovapp24;
create database edunovapp24 character set utf8;
use edunovapp24;


#productTable

create table products
(
    id                  int not null primary key auto_increment,
    item_name           varchar(50),
    item_price          decimal(18,2),
    item_description    varchar(50)
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
    telephone           int,
    adress              varchar(50),
    email               varchar(50),
    register_date       datetime
);

#cartTable

create table cart
(
    id                  int not null primary key auto_increment,
    products            int not null,
    quantity            int not null,
    discount            int,
    price               decimal(18,2),
    paymentType         varchar(50),
    user                int not null,
    dateOrder           datetime
);




#productsAlterTable

alter table products add foreign key (suit) references suit(id);
alter table products add foreign key (dressShirt) references dressShirt(id);
alter table products add foreign key (shoes) references shoes(id);
alter table products add foreign key (accessories) references accessories(id);
alter table products add foreign key (bag) references bag(id);

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
