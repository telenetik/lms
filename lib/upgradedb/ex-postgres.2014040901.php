<?php

/*
 *  iNET LMS
 *
 *  (C) Copyright 2001-2012 LMS Developers
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License Version 2 as
 *  published by the Free Software Foundation.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307,
 *  USA.
 *
 */



$DB->BeginTrans();




$DB->Execute("DROP VIEW nas");

$DB->Execute("ALTER TABLE netdevices ADD coaport varchar(5) DEFAULT NULL;");
$DB->Execute("UPDATE netdevices SET coaport='3799';");

$DB->Execute("CREATE VIEW nas AS 
		SELECT n.id, inet_ntoa(n.ipaddr) AS nasname, d.shortname, d.nastype AS type,
		d.clients AS ports, d.secret, d.server, d.community, d.coaport, d.description 
		FROM nodes n 
		JOIN netdevices d ON (n.netdev = d.id) 
		WHERE n.nas = 1");

$DB->addconfig('radius','auth_login','id');
$DB->addconfig('radius','coa_port','3799');
$DB->addconfig('radius','page_view','50');


$DB->Execute("UPDATE dbinfo SET keyvalue = ? WHERE keytype = ?", array('2014040901', 'dbvex'));
$DB->CommitTrans();

?>