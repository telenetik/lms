<?php

/*
 *  iNET LMS
 *
 *  (C) Copyright 2001-2012 LMS Developers
 *
 *  Please, see the doc/AUTHORS for more information about authors!
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
 *  $Id$
 */

function GroupList()
{
	global $DB;
	
	if($nodegrouplist = $DB->GetAll('SELECT id, name, description, 
	    	        (SELECT COUNT(*)
	                FROM networknodeassignments
	                WHERE networknodegroupid = networknodegroups.id
			) AS nodescount
	                FROM networknodegroups ORDER BY name ASC'))
	{
	        $nodegrouplist['total'] = sizeof($nodegrouplist);
	        $nodegrouplist['nodestotal'] = 0;
		
	        foreach($nodegrouplist as $idx => $row)
	        {
	        	$nodegrouplist['nodestotal'] += $row['nodescount'];
	        }
	}

        return $nodegrouplist;
}

$layout['pagetitle'] = 'Lista grup węzłów';

$nodegrouplist = GroupList();

$listdata['total'] = $nodegrouplist['total'];
$listdata['nodestotal'] = $nodegrouplist['nodestotal'];

unset($nodegrouplist['total']);
unset($nodegrouplist['nodestotal']);

$SMARTY->assign('nodegrouplist', $nodegrouplist);
$SMARTY->assign('listdata', $listdata);

$SMARTY->display('networknodegrouplist.html');

?>
