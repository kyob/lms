<?php
$cid = $document['customerid'];

$customerinfo = $LMS->GetCustomer($cid);
$assignments = $LMS->GetCustomerAssignments($cid);
$customernodes = $LMS->GetCustomerNodes($cid);
$tariffs = $LMS->GetTariffs();


unset($customernodes['total']);

if($customernodes)
	foreach($customernodes as $idx => $row)	{
		$customernodes[$idx]['net'] = $DB->GetRow('SELECT *, inet_ntoa(address) AS ip FROM networks WHERE address = (inet_aton(mask) & ?)', array($row['ipaddr']));
	}

if($customeraccounts = $DB->GetAll('SELECT passwd.*, domains.name AS domain
				FROM passwd LEFT JOIN domains ON (domainid = domains.id)
				WHERE passwd.ownerid = ? ORDER BY login', array($cid)))
	foreach($customeraccounts as $idx => $account)	{
		$customeraccounts[$idx]['aliases'] = $DB->GetCol('SELECT login FROM aliases a 
			LEFT JOIN aliasassignments aa ON a.id = aa.aliasid WHERE aa.accountid=?', array($account['id']));
	}

$document['template'] = $DB->GetOne('SELECT template FROM numberplans WHERE id=?', array($document['numberplanid']));
$document['nr'] = docnumber($document['number'], $document['template']);

$SMARTY->assign(
		array(
			'customernodes' => $customernodes,
			'assignments' => $assignments,
			'customerinfo' => $customerinfo,
			'tariffs' => $tariffs,
			'customeraccounts' => $customeraccounts,
			'document' => $document,
			'engine' => $engine,
			'urzadzenia' => $urzadzenia,                    
		     )
		);

$output = $SMARTY->fetch(DOC_DIR.'/templates/'.$engine['name'].'/'.$engine['template']);
?>
