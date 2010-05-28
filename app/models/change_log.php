<?php
/**
 * Model for Auto Logger
 *
 * @filesource
 * @author Ryutaro "Ryuzee" YOSHIBA
 * @link http://www.ryuzee.com
 * @license	http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package app
 * @subpackage app.models.behaviors
 * @description before using this behaviro, you have to create a new table named "update_histories".
 *
 * CREATE TABLE `change_logs` (
 *   `id` int(11) NOT NULL AUTO_INCREMENT,
 *   `mode` varchar(6) NOT NULL,
 *   `name` varchar(255) DEFAULT NULL,
 *   `old_value` text,
 *   `new_value` text,
 *   `created` datetime NOT NULL,
 *   PRIMARY KEY (`id`)
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 *
 */

class ChangeLog extends AppModel
{
	var $name = 'ChangeLog';
	var $displayField = 'name';
}
?>