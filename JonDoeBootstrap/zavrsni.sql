#databaseFinal

drop database if exists edunovapp24;
create database edunovapp24 character set utf8mb4;
use edunovapp24;



#operatorTable

create table operator
(
    id                  int not null primary key auto_increment,
    email               varchar(50) not null,
    userpassword        char(60) not null, 
    firstname           varchar(50) not null,
    lastName            varchar(50) not null,
    operatorrole        varchar(10) not null
);

#productTable

create table product
(
    id                  int not null primary key auto_increment,
    item_name           varchar(50),
    item_price          decimal(18,2),
    item_description    varchar(255),  
);

#customerTable

create table customer
(
    id                  int not null primary key auto_increment,
    email               varchar(50) not null,
    userpassword        char(60) not null, 
    firstname           varchar(50) not null,
    lastname            varchar(50) not null
);

#cartTable

create table cart
(
    id                  int not null primary key auto_increment,
    customer            int not null,
    product             int not null,
    quantity            int,
    price               decimal(18,2)
);

#cartAlterTable

alter table cart add foreign key (product) references product(id);
alter table cart add foreign key (customer) references customer(id);

#insertOperator

insert into operator(email,userpassword,firstname,lastname, operatorrole) values
# pass a
('admin@edunova.hr','$2a$12$QXMPLqMNoqhdKAYsV2.NmOvRRNfSAfuDMyODYaI/H.kss21UYEv4S','Admin','Edunova','admin'),
# pass o
('oper@edunova.hr','$2a$12$6RsJ3lGidFiEb6tufZPLWOWkVRvMi5RfbFsTcZRNxgtnDueKj9CEK','Operater','Edunova','oper');

#insertProduct

insert into product (id,item_name,item_price,item_description) values
(null,'Brown Linen Single Cuff Slim Fit Shirt','199.99',' Linen clothing manages to do something that few other fabrics can, the ability to make the wearer look both casual and smart at the same time.'),
(null,'Sage Flannel Single Cuff Shirt','299.99','An intimate cotton-wool fabric blend, our slim fit flat front shirt combines the two preeminent qualities of raw materials'),
(null,'White Poplin Marcella Classic Double Cuff Shirt','99.99','The ultimate white cotton shirt: a staple of every gentleman’s wardrobe. Classic fit with a floating Hammick collar offering room to move in style.'),
(null,'Black tox Suit','999.99','A pinnacle of sophisticated menswear for elegant times, this tox suit is refined into an elegant easy-to-wear suit.'),
(null,'Wool Twill Suit','999.99','A pinnacle of sophisticated menswear for winter, this wool Twill suit is refined into an elegant easy-to-wear suit.'),
(null,'3p suits ','999.99','A pinnacle of sophisticated menswear for spring and summer, this 3p suit is refined into an elegant easy-to-wear suit. ');

#insertCustomer

insert into customer (id,email,userpassword,firstname,lastname) values
# pass b
(null,'user1@edunova.hr','$2a$12$AT3wMgSIOV2oHkWA1twGwuwN7qax2DCtwvEvtfAW4I9qPaN/KlZNq','Mateo','Opančar'),
# pass c
(null,'user2@edunova.hr','$2a$12$lUjVDEnJa5C0bQvJGEjIZ.X6Qu7Ker8Pt/Xm9nPmnuyTUw2xChpfS','Bizran','Opančar');

#insertCart

insert into cart (id,customer,product,quantity,price) values
(null,'1','1','1',null),
(null,'1','2','1',null),
(null,'1','3','1',null);


           
        