<?php

/*
 *  iNET LMS
 *
 *  (C) Copyright 2012-2015 iNET LMS Developers
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
 *  Sylwester Kondracki
 *  sylwester.kondracki@gmail.com
 *  gadu-gadu : 6164816
 *
*/

$customerid = intval($_GET['id']);

$customerinfo = $LMS->GetContractor($customerid);
$SMARTY->assign('customerinfo',$customerinfo);

$customergroups = $LMS->ContractorgroupGetForContractor($customerid);
$SMARTY->assign('customergroups',$customergroups);

$othercustomergroups = $LMS->GetGroupNamesWithoutContractor($customerid);
$SMARTY->assignByRef('othercustomergroups', $othercustomergroups);

$balancelist = $LMS->GetCustomerBalanceList($customerid);
$SMARTY->assignByRef('balancelist', $balancelist);

$taxeslist = $LMS->GetTaxes();
$SMARTY->assignByRef('taxeslist', $taxeslist);

$SESSION->save('backto', $_SERVER['QUERY_STRING']);

$annex_info = array('section'=>'contractor','ownerid'=>$customerid);
$SMARTY->assign('annex_info',$annex_info);
include(MODULES_DIR.'/customer_xajax.inc.php');
$LMS->InitXajax();
$LMS->RegisterXajaxFunction(array('get_list_annex','delete_file_annex'));
$SMARTY->assign('xajax', $LMS->RunXajax());


$layout['pagetitle'] = trans('Contractor Info: $a',$customerinfo['customername']);
$SMARTY->display('contractorinfo.html');

?>