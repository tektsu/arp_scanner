create table if not exists `users` (
	`id` int(10) unsigned auto_increment not null primary key,
	`member_id` int(10) unsigned null,
	`name` varchar(255),
	`message` varchar(255)
) engine=InnoDB;

create table if not exists `macs` (
	`id` int(10) unsigned auto_increment not null primary key,
	`user_id` int(10) unsigned null,
	`mac` varchar(17),
	`ip` varchar(40),
	`since` datetime,
	`refreshed` datetime,
	`active` boolean default 0,
	foreign key (`user_id`) references users(`id`) on delete cascade on update cascade
) engine=InnoDB;

create table if not exists `logs` (
	`id` int(10) unsigned auto_increment not null primary key,
	`created_at` datetime,
	`mac` varchar(17),
	`ip` varchar(40),
	`action` varchar(50)
) engine=InnoDB;


