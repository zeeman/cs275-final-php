-- represents an entity who is responsible for a creative work in some way
create table `Contributor` (
    `contributor_id` int unsigned not null auto_increment,
    `name` varchar(5000),
    primary key (`contributor_id`)
);

-- represents a particular kind of responsibility that a contributor may have
-- (ex. author, producer)
create table `Role` (
    `role_id` int unsigned not null auto_increment,
    `name` varchar(100),
    primary key (`role_id`)
);

-- used to group similar works, ex. action movies
create table `Category` (
    `category_id` int unsigned not null auto_increment,
    `name` varchar(100),
    primary key (`category_id`)
);

-- represents a distinct creative work
create table `Work` (
    `work_id` int unsigned not null auto_increment,
    `title` text not null,
    `description` text,
    `category_id` int unsigned not null,
    primary key (`work_id`),
    foreign key (`category_id`) references `Category` (`category_id`)
);

-- represents a particular contributor's role on a work
create table `Contributor_Work` (
    `contributor_id` int unsigned not null,
    `role_id` int unsigned not null,
    `work_id` int unsigned not null,
    primary key (`contributor_id`, `role_id`, `work_id`),
    foreign key (`contributor_id`) references `Contributor` (`contributor_id`),
    foreign key (`role_id`) references `Role` (`role_id`),
    foreign key (`work_id`) references `Work` (`work_id`)
);

-- each entity corresponds to a distinct real world object that is a
-- manifestation of a given work, ex. a copy of Macbeth
create table `Item` (
    `item_id` int unsigned not null auto_increment,
    `description` text,
    `medium` varchar(100),
    `location` varchar(250),
    `barcode` varchar(8000),
    `work_id` int unsigned not null,
    primary key (`item_id`),
    foreign key (`work_id`) references `Work` (`work_id`),
    index(`barcode`)
);

-- each patron may have items loaned to them
create table `Patron` (
    `patron_id`       int unsigned    not null auto_increment,
    `name`            varchar(50)     not null,
    -- max email len = 254 (http://stackoverflow.com/a/574698/700375)
    `email`           varchar(254)    null default null,
    `phone`           varchar(25)     null default null,
    primary key (`patron_id`)
);

-- represents a loan for a given entity
create table `Loan` (
    `loan_id` int unsigned not null auto_increment,
    `patron_id` int unsigned not null,
    `item_id` int unsigned not null,
    `out_date` date not null,
    `return_date` date null,
    `due_date` date null,
    primary key (`loan_id`, `patron_id`, `item_id`),
    foreign key (`patron_id`) references `Patron` (`patron_id`),
    foreign key (`item_id`) references `Item` (`item_id`)
);