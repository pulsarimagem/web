<?php
//alter table usuarios add column role int(11);
$sql_create = "CREATE TABLE `role` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`nome` varchar(255) NOT NULL,
`status` varchar(2) NOT NULL,
`creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
KEY `id` (`id`)
)";

$sql_create = "CREATE TABLE `rel_role` (
`id_role` int(11) unsigned NOT NULL,
`menu_option` varchar(255) NOT NULL,
`flag` varchar(2) NOT NULL,
`status` varchar(2) NOT NULL,
`creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
KEY `id` (`id`)
)";
?>