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
    item_image          varchar(255)   
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
('admin@edunova.hr','$2a$12$QXMPLqMNoqhdKAYsV2.NmOvRRNfSAfuDMyODYaI/H.kss21UYEv4S','Administrator','Edunova','admin'),
# pass o
('oper@edunova.hr','$2a$12$6RsJ3lGidFiEb6tufZPLWOWkVRvMi5RfbFsTcZRNxgtnDueKj9CEK','Operater','Edunova','oper');

#insertProduct

insert into product (id,item_name,item_price,item_description,item_image) values
(null,'Brown Linen Single Cuff Slim Fit Shirt','199.99','One of the beautiful characteristics of linen is its versatility. Linen clothing manages to do something that few other fabrics can, the ability to make the wearer look both casual and smart at the same time. If you’re looking for a shirt to compliment a summer suit or trousers, you really can’t go far wrong with a classic linen shirt, for whatever occasion befits. With a relaxed single cuff, tailored fit, our linen shirts come with our house collar; a generous spread that looks as good with a tie, as it does without.','./public/img/product1.jpg'),
(null,'Sage Flannel Single Cuff Shirt','299.99','An intimate cotton-wool fabric blend, our slim fit flat front shirt combines the two preeminent qualities of raw materials we love: the lightness, softness, and warmth of wool, and the fit and breathability of cotton, to create a flannel shirt which feels better with every single wear. The result is an elegant casual shirt with a light and soft hand-feel and a perfect fit.','./public/img/product1.jpg'),
(null,'White Poplin Marcella Classic Double Cuff Shirt','99.99','The ultimate white cotton shirt: a staple of every gentleman’s wardrobe. Classic fit with a floating Hammick collar offering room to move in style. Beautifully made from the highest grade Egyptian cotton with a two-fold composition for strength and comfort. Cut by hand to follow the body’s contours, with every button sewn on one by one, and secured with wax thread. Double cuff, for more formal occasions.','./public/img/product1.jpg'),
(null,'Black tox Suit','999.99','A pinnacle of sophisticated menswear for elegant times, this tox suit is refined into an elegant easy-to-wear suit.','./public/img/product3.jpg'),
(null,'Wool Twill Suit','999.99','A pinnacle of sophisticated menswear for winter, this wool Twill suit is refined into an elegant easy-to-wear suit.','./public/img/product2.jpg'),
(null,'3p suits ','999.99','A pinnacle of sophisticated menswear for spring and summer, this 3p suit is refined into an elegant easy-to-wear suit. ','./public/img/product2.jpg');

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


           
        