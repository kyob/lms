<?php

/*
 *  LMS version 1.11-cvs
 *
 *  (C) Copyright 2001-2011 LMS Developers
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
 *  $Id: functions.php,v 1.7 2011/01/18 08:12:35 alec Exp $
 */

function module_main() {

// REPLACE THIS WITH PATH TO YOUR CONFIG FILE

$CONFIG_FILE = (is_readable('lms.ini')) ? 'lms.ini' : '/etc/lms/lms.ini';

// PLEASE DO NOT MODIFY ANYTHING BELOW THIS LINE UNLESS YOU KNOW
// *EXACTLY* WHAT ARE YOU DOING!!!
// *******************************************************************

ini_set('session.name', 'LMSSESSIONID');
ini_set('error_reporting', E_ALL & ~E_NOTICE);

// find alternative config files:
if (is_readable('lms.ini'))
    $CONFIG_FILE = 'lms.ini';
elseif (is_readable('/etc/lms/lms-' . $_SERVER['HTTP_HOST'] . '.ini'))
    $CONFIG_FILE = '/etc/lms/lms-' . $_SERVER['HTTP_HOST'] . '.ini';
elseif (!is_readable($CONFIG_FILE))
    die('Unable to read configuration file [' . $CONFIG_FILE . ']!');

// Parse configuration file
$CONFIG = (array) parse_ini_file($CONFIG_FILE, true);




















    $debug = 0;

    global $LMS, $SMARTY, $SESSION, $DB;

    $punkty = 0;
    $punkty_max = 7; //tyle ile pytan

    $userinfo = $LMS->GetCustomer($SESSION->id);
    $assignments = $LMS->GetCustomerAssignments($SESSION->id);


// FACEBOOK
 /*
    $url="https://graph.facebook.com/100002268918757/likes/148815148544441";
    print_r($url);

    */


    if ($userinfo[facebook] > 1) {

        $filename1 = 'assets/3rdparty/facebook/base_facebook.php';
        $filename2 = 'assets/3rdparty/facebook/facebook.php';
        if (file_exists($filename1)) {
            require $filename1;
        } else {
            echo "The file $filename1 does not exist";
        }
        if (file_exists($filename2)) {
            require $filename2;
        } else {
            echo "The file $filename2 does not exist";
        }
// Create our Application instance (replace this with your appId and secret).
        $facebook = new Facebook(array(
                    'appId' => $CONFIG['facebook']['appid'],
                    'secret' => $CONFIG['facebook']['secret'],
                ));
        
//$session = $facebook->getSession();
$user_id = $facebook->getUser();
    if($user_id) {
      // We have a user ID, so probably a logged in user.
      // If not, we'll get an exception, which we handle below.
      try {
        $user_profile = $facebook->api('/'.$userinfo[facebook],'GET');
        //print_r($user_profile);
        //echo "Name: " . $user_profile['name'];
        //print_r($user_profile);
      } catch(FacebookApiException $e) {
        // If the user is logged out, you can have a 
        // user ID even though the access token is invalid.
        // In this case, we'll get an exception, so we'll
        // just ask the user to login again here.
        $login_url = $facebook->getLoginUrl(); 
        //echo 'Please <a href="' . $login_url . '">login.1</a>';
        error_log($e->getType());
        error_log($e->getMessage());
      }   
    } else {
      // No user, print a link for the user to login
      $login_url = $facebook->getLoginUrl();
      //echo 'Please <a href="' . $login_url . '">login.2</a>';
    }
        
        $pic = $facebook->api("/110837305666220?fields=picture");
        $likes = $facebook->api("/" . $userinfo[facebook] . "/likes/".$CONFIG['facebook']['fbid'],'GET');
// 100005155653084  kopiszka
// 100000253907762 piwo
        //$likes = $facebook->api("/100000253907762/likes/110837305666220",'GET');
      //print_r($likes);

        if (!empty($likes['data'])) {
            //$punkty++;
            if ($debug == 1)
                echo "$userinfo[facebook] I like! <img src=" . $pic['picture']['data']['url'] . ">";
            $facebookid = true;
        } else {
            if ($debug == 1)
                echo "$userinfo[facebook] not a fan! <img src=" . $pic['picture']['data']['url'] . ">";
            $facebookid = false;
        }
    }

    //echo '<pre>';print_r($userinfo);echo '</pre>';
    //do testow i sprawdzania
    //if($userinfo[id]==10) $punkty++;

    if (!empty($userinfo[email])) {
        $punkty++;
        if ($debug == 1)
            echo "1. EMAIL OK<br>";
    }

    if ($userinfo[type] == 0 AND !empty($userinfo[ssn])) {
        $punkty++;
        if ($debug == 1)
            echo "2. PESEL OK<br>";
    }
    elseif ($userinfo[type] == 1 AND !empty($userinfo[ten])) {
        $punkty++;
        if ($debug == 1)
            echo "2. NIP OK<br>";
    }

    if ($userinfo[consentdate] > 0) {
        $punkty++;
        if ($debug == 1)
            echo "3. ZGODA OK<br>";
    }

    foreach ($userinfo[contacts] as $item) {

        if (count($item[phone] > 0)) {
            $punkty++;
            if ($debug == 1)
                echo "4. TELEFON OK<br>";
        }
    }

    //pobierz kwote abonamentu
    $taryfa_kwota = $assignments[0][value];

    //pobierz id taryfy
    $taryfa_id = $assignments[0][tariffid];
    //$taryfa_id2 = $assignments[1][tariffid]; //jak ktos ma wiecej niz jedna taryfe
    //echo '<pre>';print_r($assignments);echo '</pre>';    
    //taryfy, ktore sa objete bonusem, czyli bloki na szkle
    $premiowane_taryfy = array(27, 33, 34, 35);

    // sprawdzenie czy obecna taryfa jest taryfa z bonusem
    $taryfy_premium = array(53, 54, 55, 56);

    //if (in_array($taryfa_id2,$premiowane_taryfy))
    //{
//	$taryfa_id=$taryfa_id2; //jak druga taryfa jest w premiowanych to przypisz 
    //}

    if (in_array($taryfa_id, $taryfy_premium)) {
        $taryfa_bonus = true;
        $punkty++;
        $status = 2; //bonus aktywny
        if ($debug == 1)
            echo "5. taryfa OK<br>";
    }
    elseif (in_array($taryfa_id, $premiowane_taryfy)) {
        $taryfa = true;
        $punkty++;
        if ($debug == 1)
            echo "5. taryfa OK<br>";
        //przypisanie taryfy z bonusem w zaleznosci od posiadanej taryfy
        if ($taryfa_id == 27)
            $taryfa_premium = 53; //standard
        if ($taryfa_id == 33)
            $taryfa_premium = 54; //plus
        if ($taryfa_id == 35)
            $taryfa_premium = 55; //max
        if ($taryfa_id == 34)
            $taryfa_premium = 56; //pro
    }


//echo $userinfo[balance];
    if ((date("j") > 15) AND ($userinfo[balance] >= 0)) {
        $punkty++;
        if ($debug == 1)
            echo "6. bilans > 15 OK<br>";
        $brak_regularnych_wplat = 1;
    }
    elseif ((date("j") < 16) AND (($userinfo[balance] + $taryfa_kwota) >= 0)) {
        $punkty++;
        if ($debug == 1)
            echo "6. bilans < 16 OK<br>";
        $brak_regularnych_wplat = 1;
    }


    $miesiecy_wstecz = 6;
    $ilosc_wplat = $DB->GetOne('SELECT COUNT(value) as ile FROM cash WHERE customerid = ? AND value < ?', array($SESSION->id, 0));
    if ($ilosc_wplat >= $miesiecy_wstecz) {
        $punkty++;
        if ($debug == 1)
            echo "7. ZOB OK<br>";
    }

    if (!empty($userinfo[facebook])) {
        //$punkty++;
        if ($debug == 1)
            echo "8. FACEBOOK OK - $userinfo[facebook]<br>";
    }

    //sprawdzanie czy nie odebrac bonusu
    //czyli jesli mial bonus i teraz ma mniej punktow niz punkty_max odbieramy bonus
//echo 'pkt: '.$punkty.' max: '.$punkty_max . ' bonus: '.$taryfa_bonus;
    if ($punkty < $punkty_max AND $taryfa_bonus === true) {
        $bonus = false;
        if ($taryfa_id == 53)
            $taryfa_old_id = 27;
        if ($taryfa_id == 54)
            $taryfa_old_id = 33;
        if ($taryfa_id == 55)
            $taryfa_old_id = 35;
        if ($taryfa_id == 56)
            $taryfa_old_id = 34;

        $status = 0; //bonus nie aktywny	
        $cid = $userinfo['id'];
        if ($taryfa_old_id) {
            //$LMS->DB->Execute('UPDATE assignments SET tariffid = ? WHERE customerid = ?', array($taryfa_old_id, $cid));	
        }
    } elseif ($punkty == $punkty_max) {
        $bonus = true;
        if ($status != 2)
            $status = 1;  //bonus aktywyuj
    }

    $SMARTY->assign('status', $status); // 
//    $SMARTY->assign('suma_wplat',$suma_wplat); // suma wplat od x miesiecy do czasu w zaleznosci od nr dnia    
    $SMARTY->assign('bonus', $bonus); // true or false - czy zostawic bonus
    $SMARTY->assign('uid', $userinfo[id]); // id customer
    $SMARTY->assign('punkty', $punkty); // punkty integer
    $SMARTY->assign('taryfa', $taryfa); // true or false - czy taryfa moze byc z bonusem
    $SMARTY->assign('taryfa_bonus', $taryfa_bonus); // true or false - czy obecna taryfa jest z bonusem
    $SMARTY->assign('taryfa_premium', $taryfa_premium);
    $SMARTY->assign('miesiecy_wstecz', $miesiecy_wstecz);
    $SMARTY->assign('ilosc_wplat', $ilosc_wplat); // ile wystawiono zobowiazan wciagu $miesiecy_wstecz
    $SMARTY->assign('userinfo', $userinfo);
    $SMARTY->assign('miesiac', $miesiac);
    $SMARTY->assign('brak_regularnych_wplat', $brak_regularnych_wplat);
    $SMARTY->assign('bilans', $userinfo[balance]);
    $SMARTY->assign('facebook', $facebookid);
    $SMARTY->assign('facebookid', $userinfo[facebook]);
    $SMARTY->assign('facebook_login_url',$login_url);
    $SMARTY->display('module:hotspot.html');
}

function module_premia() {
    global $LMS, $SMARTY, $SESSION, $DB;

    $userinfo = $LMS->GetCustomer($SESSION->id);

    $taryfa = $_POST['taryfa_premium'];
    $cid = $userinfo['id'];

    // sprawdzamy czy jest ustawiona taryfa i user ID oraz czy zapytanie sql sie wykona
    if ($taryfa > 0 AND $cid > 0 AND $LMS->DB->Execute('UPDATE assignments SET tariffid = ? WHERE customerid = ?', array($taryfa, $cid))) {
        $premia = true;
    }

    $SMARTY->assign('premia', $premia);
    $SMARTY->display('module:bonus_submit.html');
}
?>
