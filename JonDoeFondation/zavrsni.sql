drop database if exists edunovapp24;
create database edunovapp24 character set utf8mb4;
# c:\xampp\mysql\bin\mysql -uedunova -pedunova --default_character_set=utf8 < \
use edunovapp24;



create table operater(
    sifra               int not null primary key auto_increment,
    email               varchar(50) not null,
    lozinka             char(60) not null,
    ime                 varchar(50) not null,
    prezime             varchar(50) not null,
    uloga               varchar(10) not null
);

create table tecaj(
    sifra               int not null primary key auto_increment,
    naziv               varchar(50) not null,
    trajanje            int not null,
    cijena              decimal(18,2),
    certificiran        boolean,
    vrijemeunosa        datetime not null default now()
);

create table osoba(
    sifra               int not null primary key auto_increment,
    ime                 varchar(50) not null,
    prezime             varchar(50) not null,
    oib                 char(11),
    email               varchar(50)
);

create table radionica(
    sifra               int not null primary key auto_increment,
    naziv               varchar(50) not null,
    tecaj               int not null,
    trener              int,
    datumpocetka        datetime
);

create table trener(
    sifra               int not null primary key auto_increment,
    osoba               int not null,
    ples                varchar(50)
);

create table plesac(
    sifra               int not null primary key auto_increment,
    osoba               int not null,
    ples                varchar(50)
    
);

create table grupa(
    radionica           int not null,
    plesac              int not null
);


alter table radionica add foreign key (tecaj) references tecaj(sifra);
alter table radionica add foreign key (trener) references trener(sifra);

alter table trener add foreign key (osoba) references osoba(sifra);

alter table plesac add foreign key (osoba) references osoba(sifra);

alter table grupa add foreign key (radionica) references radionica(sifra);
alter table grupa add foreign key (plesac) references plesac(sifra);

insert into operater(email,lozinka,ime,prezime, uloga) values
# lozinka a
('admin@edunova.hr','$2a$12$gcFbIND0389tUVhTMGkZYem.9rsMa733t9J9e9bZcVvZiG3PEvSla','Administrator','Edunova','admin');

insert into tecaj (sifra,naziv,trajanje,cijena,certificiran)
values 
(null,'Salsa',300,null,true),
(null,'Bachata',300,null,true),
(null,'Kizomba',300,null,true),
(null,'Diskofox',300,null,true);

insert into osoba (sifra,ime,prezime,oib,email) values
(null,'Jon','Doe',null,'jondoe@gmail.com'),
(null,'Jon1','Doe',null,'jondoe@gmail.com'),
(null,'Jon2','Doe',null,'jondoe@gmail.com'),
(null,'Jon3','Doe',null,'jondoe@gmail.com'),
(null,'Jon4','Doe',null,'jondoe@gmail.com'),
(null,'Jon5','Doe',null,'jondoe@gmail.com'),
(null,'Jon6','Doe',null,'jondoe@gmail.com'),
(null,'Jon7','Doe',null,'jondoe@gmail.com'),
(null,'Jon8','Doe',null,'jondoe@gmail.com'),
(null,'Jon9','Doe',null,'jondoe@gmail.com'),
(null,'Jon10','Doe',null,'jondoe@gmail.com'),
(null,'Jon11','Doe',null,'jondoe@gmail.com'),
(null,'Jon12','Doe',null,'jondoe@gmail.com'),
(null,'Jon13','Doe',null,'jondoe@gmail.com'),
(null,'Jon14','Doe',null,'jondoe@gmail.com'),
(null,'Jon15','Doe',null,'jondoe@gmail.com'),
(null,'Jon16','Doe',null,'jondoe@gmail.com'),
(null,'Jon17','Doe',null,'jondoe@gmail.com'),
(null,'Jon18','Doe',null,'jondoe@gmail.com'),
(null,'Jon19','Doe',null,'jondoe@gmail.com'),
(null,'Jon20','Doe',null,'jondoe@gmail.com');


# 1
insert into trener (sifra,osoba,ples) values 
(null,1,'Salsa'),
(null,2,'Bachata'),
(null,3,'Kizomba'),
(null,4,'Diskofox');



# 1 - 20
insert into plesac (sifra,osoba,ples) values
(null,5,'Salsa'),
(null,6,'Salsa'),
(null,7,'Salsa'),
(null,8,'Salsa'),
(null,9,'Salsa'),
(null,10,'Bachata'),
(null,11,'Bachata'),
(null,12,'Bachata'),
(null,13,'Bachata'),
(null,14,'Bachata'),
(null,15,'Kizomba'),
(null,16,'Kizomba'),
(null,17,'Kizomba'),
(null,18,'Kizomba'),
(null,19,'Diskofox'),
(null,20,'Diskofox');

insert into radionica (sifra,naziv,tecaj,trener,datumpocetka) values 
(null,'Salsa',1,1,'2022-10-25'),
(null,'Bachata',2,2,'2022-10-25'),
(null,'Kizomba',3,3,'2022-10-25'),
(null,'Diskofox',4,4,'2022-10-25');




insert into grupa (radionica,plesac) values
(1,1),
(1,2),
(1,3),
(1,4),
(1,5),
(2,6),
(2,7),
(2,8),
(2,9),
(2,10),
(3,11),
(3,12),
(3,13),
(4,14),
(4,15);








