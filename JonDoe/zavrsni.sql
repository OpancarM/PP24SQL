#databaseFinal

drop database if exists edunovapp24;
create database edunovapp24 character set utf8mb4;
use edunovapp24;

#operatorTable

create table operator
(
    id                  int not null primary key auto_increment,
    email               varchar(50) not null,
    user_password       char(60) not null, 
    first_name          varchar(50) not null,
    last_Name           varchar(50) not null,
    operator_role       varchar(10) not null
);

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
    email               varchar(50),
    register_date       datetime
);

#cartTable

create table cart
(
    id                  int not null primary key auto_increment,
    user                int not null,
    product             int not null,
    quantity            int,
    price               decimal(18,2)
);

#cartAlterTable

alter table cart add foreign key (product) references product(id);
alter table cart add foreign key (user) references user(id);

#insertOperator

insert into operator(email,user_password,first_name,last_name, operator_role) values
# lozinka a
('admin@edunova.hr','$2a$12$gcFbIND0389tUVhTMGkZYem.9rsMa733t9J9e9bZcVvZiG3PEvSla','Administrator','Edunova','admin'),
# lozinka o
('oper@edunova.hr','$2a$12$S6vnHiwtRDdoUW4zgxApvezBlodWj/tmTADdmKxrX28Y2FXHcoHOm','Operater','Edunova','oper');

#insertProduct

insert into product (id,item_name,item_price,item_description,item_image) values
(null,'Oxford cotton shirts','199,99','Tailored fit with kent collar and 2-buttons cuffs.(white,blue,red,navy and other)',null),
(null,'Cashmere blend shirts','299,99','Tailored fit with kent collar and 2-button cuffs.(white,blue,red,navy and other)',null),
(null,'Cotton with stripes shirts','99,99','Tailored fit with kent collar and 2-buttons cuffs.(white,blue,red,navy and other)',null),
(null,'Black single breasted suits','1999,99','Peak lapel evening suits.',null),
(null,'Single breasted','1500,99','3P suits and 2P suits.',null),
(null,'Double breasted suits','2500,99','3P suits and 2P suits.',null);

#insertUser

insert into user (id,username,userPassword,firstName,lastName,email,register_date) values
(null,'mateouser','12345','Mateo','Opančar','opancarmateo@gmail.com',null),
(null,'userbizran','12345','Bizran','Opančar','opancarmateo@gmail.com',null);

#insertCart

insert into cart (id,user,product,quantity,price) values
(null,'1','1','1',null),
(null,'2','2','1',null),
(null,'1','3','1',null);


           
        