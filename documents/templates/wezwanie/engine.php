<?php

/*
 * LMS version 1.11-git
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

$cid = $document['customerid'];

$customerinfo = $LMS->GetCustomer($cid);
$assignments = $LMS->GetCustomerAssignments($cid);
$customernodes = $LMS->GetCustomerNodes($cid);
$tariffs = $LMS->GetTariffs();
$invoice = $LMS->GetInvoiceContent($cid);
$nrb = format_bankaccount(bankaccount($customerinfo['id'], $invoice['account']));

/*  bilans */

$date['from'] = 0;
$date['to'] = mktime(23, 59, 59); //koniec dnia dzisiejszego

$id = $cid;

$list['balance'] = 0;
$list['income'] = 0;
$list['expense'] = 0;
$list['liability'] = 0;
$list['summary'] = 0;
$list['customerid'] = $id;

if ($tslist = $DB->GetAll('SELECT c.id AS id, time, type, c.value AS value, 
				    taxes.label AS taxlabel, customerid, comment, name AS username 
				    FROM cash c
				    LEFT JOIN taxes ON (c.taxid = taxes.id)
				    LEFT JOIN users ON (users.id = userid)
				    WHERE c.customerid = ? 
					    AND NOT EXISTS (
				                    SELECT 1 FROM customerassignments a
					            JOIN excludedgroups e ON (a.customergroupid = e.customergroupid)
					            WHERE e.userid = lms_current_user() AND a.customerid = ?)
				    ORDER BY time', array($id, $id))
) {
    foreach ($tslist as $row)
        foreach ($row as $column => $value)
            $saldolist[$column][] = $value;

    $saldolist['balance'] = 0;

    foreach ($saldolist['id'] as $i => $v) {
        $saldolist['after'][$i] = $saldolist['balance'] + $saldolist['value'][$i];
        $saldolist['balance'] += $saldolist['value'][$i];
        $saldolist['date'][$i] = date('Y/m/d', $saldolist['time'][$i]);

        if ($saldolist['time'][$i] >= $date['from'] && $saldolist['time'][$i] <= $date['to']) {
            $list['id'][] = $saldolist['id'][$i];
            $list['type'][] = $saldolist['type'][$i];
            $list['after'][] = $saldolist['after'][$i];
            $list['before'][] = $saldolist['balance'];
            $list['value'][] = $saldolist['value'][$i];
            $list['taxlabel'][] = $saldolist['taxlabel'][$i];
            $list['date'][] = date('Y/m/d', $saldolist['time'][$i]);
            $list['username'][] = $saldolist['username'][$i];
            $list['comment'][] = $saldolist['comment'][$i];
            $list['summary'] += $saldolist['value'][$i];

            if ($saldolist['type'][$i]) {
                if ($saldolist['value'][$i] > 0)
                //income
                    $list['income'] += $saldolist['value'][$i];
                else
                //expense
                    $list['expense'] -= $saldolist['value'][$i];
            } else
                $list['liability'] -= $saldolist['value'][$i];
        }
    }

    $list['total'] = sizeof($list['id']);
}
//echo '<pre>';print_r($list);echo '</pre>';
/* END bialns */

unset($customernodes['total']);

if ($customernodes)
    foreach ($customernodes as $idx => $row) {
        $customernodes[$idx]['net'] = $DB->GetRow('SELECT *, inet_ntoa(address) AS ip FROM networks WHERE address = (inet_aton(mask) & ?)', array($row['ipaddr']));
    }

if ($customeraccounts = $DB->GetAll('SELECT passwd.*, domains.name AS domain
				FROM passwd LEFT JOIN domains ON (domainid = domains.id)
				WHERE passwd.ownerid = ? ORDER BY login', array($cid)))
    foreach ($customeraccounts as $idx => $account) {
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
            'nrb' => $nrb,
            'balancelist' => $list,
        )
);

$output = $SMARTY->fetch(DOC_DIR . '/templates/' . $engine['name'] . '/' . $engine['template']);
?>
