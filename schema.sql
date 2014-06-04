create table `Creation` (
  `creation_id`     int unsigned        not null auto_increment,
  `main_title`      varchar(4000)       not null,
  `release_year`    smallint unsigned   null default null,
  `default_loan_duration` int unsigned null default null,

    primary key (`creation_id`)
);


create table `CreationAttribute` (
  `creation_attribute_id`   int unsigned    not null auto_increment,
  `name`                    varchar(100)    not null,
  `help_text`               TEXT            null default null,

    primary key (`creation_attribute_id`)
);


-- A well-recognized problem for library databases is the sheer complexity of
-- bilbiographic data (see the MARC and BIBFRAME standards). Necessary details
-- for a given work may vary widely between any given set of works. In addition,
-- attempting to determine every possible attribute ahead of time is a herculean
-- task beyond the scope of this project. Therefore, I am implementing a
-- semi-structured entity-attribute-value data model which allows admins to
-- define custom attributes as needed. This allows the
create table `CreationAV` (
  `creation_attribute_id`   int unsigned    not null,
  `creation_id`             int unsigned    not null,
  `attribute_value`         varchar(1000)   not null,

    primary key (`creation_attribute_id`, `creation_id`),
    foreign key (`creation_attribute_id`)
    references `CreationAttribute` (`creation_attribute_id`),
    foreign key (`creation_id`)
    references `Creation` (`creation_id`)
);


-- Any entity that is authoritative over a given work. For example, an authority
-- could be an author, publisher, editor, translator, producer, recording
-- artist, or record label, amongst other things.
-- In an ideal implementation, there would be a means for adding semi-structured
-- data to an Authority, such as a JSON-encoded field or an EAV model.
create table `Authority` (
  `authority_id`    int unsigned                    not null auto_increment,
  `name`            varchar(4000)                   not null,

    primary key (`authority_id`)
);


create table `Role` (
  `role_id`         int unsigned    not null auto_increment,
  `name`            varchar(30)     not null,

    primary key (`role_id`)
);


-- Glue table between works and authorities, with an additional FK to the
-- authority's role in the work. This allows for situations where an authority
-- takes on multiple roles, such as on the album "2001" by Dr. Dre, where Dre
-- is both the main credited artist and executive producer.
create table `CreationAuthority` (
  `creation_id`     int unsigned    not null,
  `authority_id`    int unsigned    not null,
  `role_id`         int unsigned    not null,

    primary key (`creation_id`, `authority_id`, `role_id`),
    foreign key (`creation_id`)
    references `Creation` (`creation_id`),
    foreign key (`authority_id`)
    references `Authority` (`authority_id`),
    foreign key (`role_id`)
    references `Role` (`role_id`)
);


-- Creations may be classified by a standard list of subjects.
create table `Subject` (
  `subject_id`      int unsigned    not null auto_increment,
  `name`            varchar(250)    not null,

    primary key (`subject_id`)
);


-- Glue table for Creation and Subject, since multiple subjects may apply.
create table `CreationSubject` (
  `creation_id`     int unsigned    not null auto_increment,
  `subject`         int unsigned    not null,

    primary key (`creation_id`, `subject`),
    foreign key (`creation_id`)
    references `Creation` (`creation_id`),
    foreign key (`subject`)
    references `Subject` (`subject_id`)
);


-- A resource is in a particular medium, such as CD, VHS, Book, Journal Article,
-- and so on.
create table `Medium` (
  `medium_id`       int unsigned    not null auto_increment,
  `name`            varchar(32)     not null,

    primary key (`medium_id`)
);


create table `Resource` (
  `resource_id`     int unsigned    not null auto_increment,
  `call_number`     varchar(32)     not null,
  `barcode`         varchar(100)    null default null,
  `creation_id`     int unsigned    not null,
  `medium_id`       int unsigned    not null,

    primary key (`resource_id`),
    foreign key (`creation_id`)
    references `Creation` (`creation_id`),
    foreign key (`medium_id`)
    references `Medium` (`medium_id`)
);


create table `Patron` (
  `patron_id`       int unsigned    not null auto_increment,
  `name`            varchar(50)     not null,
  -- max email len = 254 (http://stackoverflow.com/a/574698/700375)
  `email`           varchar(254)    null default null,
  `phone`           varchar(25)     null default null,

    primary key (`patron_id`)
);


create table `Loan` (
  `out_date`        datetime        not null,
  `patron_id`       int unsigned    not null,
  `resource_id`     int unsigned    not null,
  `return_date`     datetime        null default null,
  `due_date`        date            null default null,

    primary key (`out_date`, `patron_id`, `resource_id`),
    foreign key (`patron_id`)
    references `Patron` (`patron_id`),
    foreign key (`resource_id`)
    references `Resource` (`resource_id`)
);


-- This table is used to keep track of people who have permissions to do things.
create table `Librarian` (
  `librarian_id`    int unsigned    not null auto_increment,
  `username`        varchar(35)     not null,
  `password`        char(64)        not null,
  `salt`            char(16)        not null,
  `user_level`      int             not null,

    primary key (`librarian_id`)
);