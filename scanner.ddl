create table if not exists `users` (
	`id` int(10) unsigned auto_increment not null primary key,
	`member_id` int(10) unsigned null comment 'Member id if user is a member',
	`name` varchar(255) comment 'User name',
	`message` varchar(255) comment 'User status'
) engine=InnoDB comment 'User information for MAC addresses';

create table if not exists `macs` (
	`id` int(10) unsigned auto_increment not null primary key,
	`user_id` int(10) unsigned null comment 'FK to user entry, if one exists',
	`mac` varchar(17) comment 'MAC address',
	`ip` varchar(40) comment 'IP address associated with MAC address',
	`since` datetime comment 'MAC address has been active since this time',
	`refreshed` datetime comment 'active flag was last updated at this time',
	`active` boolean default 0 comment 'True if the MAC address is currently active, False if not',
	foreign key (`user_id`) references users(`id`) on delete cascade on update cascade
) engine=InnoDB comment 'MAC addresses seen on the network';

create table if not exists `logs` (
	`id` int(10) unsigned auto_increment not null primary key,
	`created_at` datetime,
	`mac` varchar(17) comment 'The mac address being logged',
	`ip` varchar(40) comment 'The IP address associated with the mac address',
	`action` varchar(50) comment 'The action that was taken'
) engine=InnoDB comment 'Log of changes to mac entries';


