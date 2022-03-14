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
('admin@edunova.hr','$2a$12$a8OIgLeIoJZ5tiaC7b9PAewEKDnDjAf0Ir6SlaxQWLwraLa/Sb6PS','Administrator','Edunova','admin'),
# lozinka o
('oper@edunova.hr','$2a$12$gpnK6Y7nilGcNZba9dOaYuMQnM9gGLbtFn5d6iD1e1zdEHKRhr7NC','Operater','Edunova','oper');

#insertProduct

insert into product (id,item_name,item_price,item_description,item_image) values
(null,'Brown Linen Single Cuff Slim Fit Shirt','199.99','One of the beautiful characteristics of linen is its versatility. Linen clothing manages to do something that few other fabrics can, the ability to make the wearer look both casual and smart at the same time. If you’re looking for a shirt to compliment a summer suit or trousers, you really can’t go far wrong with a classic linen shirt, for whatever occasion befits. With a relaxed single cuff, tailored fit, our linen shirts come with our house collar; a generous spread that looks as good with a tie, as it does without.','./public/img/product1.jpg'),
(null,'Sage Flannel Single Cuff Shirt','299.99','An intimate cotton-wool fabric blend, our slim fit flat front shirt combines the two preeminent qualities of raw materials we love: the lightness, softness, and warmth of wool, and the fit and breathability of cotton, to create a flannel shirt which feels better with every single wear. The result is an elegant casual shirt with a light and soft hand-feel and a perfect fit.','./public/img/product1.jpg'),
(null,'White Poplin Marcella Classic Double Cuff Shirt','99.99','The ultimate white cotton shirt: a staple of every gentleman’s wardrobe. Classic fit with a floating Hammick collar offering room to move in style. Beautifully made from the highest grade Egyptian cotton with a two-fold composition for strength and comfort. Cut by hand to follow the body’s contours, with every button sewn on one by one, and secured with wax thread. Double cuff, for more formal occasions.','./public/img/product1.jpg'),
(null,'Black tox Suit','1,999.99','A pinnacle of sophisticated menswear for elegant times, this tox suit is refined into an elegant easy-to-wear suit.','./public/img/product3.jpg'),
(null,'Wool Twill Suit','1,500.99','A pinnacle of sophisticated menswear for winter, this wool Twill suit is refined into an elegant easy-to-wear suit.','./public/img/product2.jpg'),
(null,'3p suits ','2,500.99','A pinnacle of sophisticated menswear for spring and summer, this 3p suit is refined into an elegant easy-to-wear suit. ','./public/img/product2.jpg');

#insertUser

insert into user (id,username,userPassword,firstName,lastName,email,register_date) values

(null,'user1','$2a$12$d3NqmWRBy2Az67YpZbG7kO5MpTjSOOISD6.BNWBHqPwpAfLKyd98G','Mateo','Opančar','user1@edunova.hr',null),
(null,'user2','$2a$12$oFu5bYKcOfmCn/1suEN8X.yW6.rOW/l44MpvnQGjFWqLvD3whMPSC','Bizran','Opančar','user2@edunova.hr',null);

#insertCart

insert into cart (id,user,product,quantity,price) values
(null,'1','1','1',null),
(null,'1','2','1',null),
(null,'1','3','1',null);


           
        