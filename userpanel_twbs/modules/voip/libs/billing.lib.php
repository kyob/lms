<?php
global $LMS,$SMARTY,$SESSION,$DB;

class AdescomBillingManagerLocal //extends AdescomBillingManager
{

    public function getBillingForCallerID($callerid, $dateFrom, $dateTo, $options, $zero, $direction,  $connection = null)
    {
        // if no SOAP client - create a new one
        if ($connection == null)
            $connection = AdescomConnection::getConnection();
        // query billing records<------><------><------>
        $response = $connection->getBillingByCallerID($dateFrom, $dateTo, $callerid, $zero, $options, $direction);

        $records = new stdClass();
        // allocate records array
        $records->items = array();

        // store records total count
        if (property_exists($response, 'totalCount'))
            $records->total = $response->totalCount;

        if (property_exists($response, 'totalPrice'))
            $records->totalPrice = $response->totalPrice;

        if (property_exists($response, 'totalDuration'))
            $records->totalDuration = $response->totalDuration;

        // if records array is not empty...
        if (is_array($response->records)) {
            // go through all records...
            foreach ($response->records as $record)
                //tylko numeryczne - jest dużo śmieci "systemowych"
                if (is_numeric($record->destination))
                    {
                    $records->items[] = self::getCDRArray($record);
                    }
        }
        // return result object
        return $records;
    }

 static private function getCDRArray($cdr)
    {
        // check for empty CDR
        if ($cdr == null)
            return null;

        // prepare output array
        $result['id'] = $cdr->id;
        $result['start_date'] = strtotime($cdr->startDate);
        $result['end_date'] = strtotime($cdr->endDate);
        $result['duration'] = $cdr->duration;
        $result['outgoing'] = $cdr->outgoing;
        $result['source'] = $cdr->source;
        $result['destination'] = $cdr->destination;
        $result['price'] = $cdr->price;
        $result['fraction'] = $cdr->fraction;
        $result['prefix'] = $cdr->prefix;
        $result['prefix_name'] = $cdr->prefixName;
        $result['tg_in'] = $cdr->tgInNr;
        $result['tg_out'] = $cdr->tgOutNr;
/*
	if ($cdr->duration>0)
    	    $result['price_per_minute'] = $cdr->price / ($cdr->duration / 60);
	else
	$result['price_per_minute'] = 0;
*/

        // return results array
        return $result;
    }
}




class Billing {

  // error messages
  var $error = null;

  /**
  * class constructor
  */
  function __construct() {

    // instantiate the template object
    $SMARTY = new Smarty;

  }



  /**
  * display the billing  entry form
  *
  * @param array $formvars the form variables
  */
  function displayForm($formvars = array()) {
    global $LMS,$SMARTY,$SESSION;
    $clid=$SESSION->id;
     try {
    $numery = $LMS->GetCustomerVoipAccounts($clid);
    } catch (SoapFault $e) {
        switch ($e->detail->code) {
            case 'client_not_found':
                print 'Nie znaleziono klienta !';
                break;
            default:
                print 'Błąd -->'.$e->detail->code;
                break;
        }
    }
    $SMARTY->assign('numery',$numery);
    // assign the form vars
    $SMARTY->assign('post',$formvars);
    // assign error message
    $SMARTY->assign('error', $this->error);
    $dataTo = date("d.m.Y");
    $dataFrom = date("d.m.Y", strtotime('-30 days') );
    $SMARTY->assign('to', $dataTo);
    $SMARTY->assign('from', $dataFrom);
    $SMARTY->display('module:biling_form.html');
}


  /**
  * fix up form data if necessary
  *
  * @param array $formvars the form variables
  */
  function mungeFormData(&$formvars) {

    // trim off excess whitespace
    $formvars['callerID'] = trim($formvars['callerID']);
    $formvars['from'] = trim($formvars['from']);
    $formvars['to'] = trim($formvars['to']);
  }

  /**
  * test if form information is valid
  *
  * @param array $formvars the form variables
  */
  function isValidForm($formvars) {

    // reset error message
    $this->error = null;

    // test if "Name" is empty
    if(strlen($formvars['callerID']) == 0) {
      $this->error = 'callerID_empty';
      return false; 
    }

    // test if "Comment" is empty
    if(strlen($formvars['from']) == 0) {
      $this->error = 'from_empty';
      return false; 
    }

    if(strlen($formvars['to']) == 0) {
      $this->error = 'to_empty';
      return false; 
    }
    if( empty($formvars['typpol']) ) {
      $this->error = 'typ_nochecked';
      return false; 
    }

    // form passed validation
    return true;
  }

  function isValidFormDoladuj($formvars) {

    // reset error message
    $this->error = null;

    // test if "callerID" is empty
    if(strlen($formvars['callerID']) == 0) {
      $this->error = 'callerID_empty';
      return false; 
    }

    // test if "kwota" is empty
    if(strlen($formvars['kwota']) == 0) {
      $this->error = 'kwota_empty';
      return false; 
    }
    $kwota = str_replace(',','.',$formvars['kwota']);
    if(!is_numeric($kwota) || $kwota <= 0  ) {
      $this->error = 'kwota_format';
      return false; 
    }
    // form passed validation
    return true;
  }



  function isValidFormUstawienia($formvars) {

    // reset error message
    $this->error = null;

    // test if "passwd" is empty
    if(strlen($formvars['dane']['passwd']) == 0) {
      $this->error = 'passwd_empty';
      return false; 
    }

    // test if "passwd" is too short
    if(strlen($formvars['dane']['passwd']) < 12) {
      $this->error = 'passwd_short';
      return false; 
    }

    // test if "voicemail" is checked & voicemailpasswd is too short
    if(isset($formvars['dane']['voicemail']) && strlen($formvars['dane']['voicemailpassword']) < 4) {
        $this->error = 'voicemailpassword_short';
        return false;
    }


    // test if "voicemailpasswd" is not integer
    if(isset($formvars['dane']['voicemail']) && ctype_digit($formvars['dane']['voicemailpassword'])<>1) {
      $this->error = 'voicemailpassword_nointeger';
      return false; 
    }


    // test if "voicemailattach" is checked & email is valid
      $email_pattern = '/^[A-z0-9_.\-]+[@][A-z0-9_\-.]+([.][A-z0-9_\-]+)+[A-z.]$/';
    if(isset($formvars['dane']['voicemailattach']) &&  !preg_match($email_pattern,$formvars['dane']['email'])) {
        $this->error = 'email_format';
        return false;
    }



    //validate phone numbers
    $reg = '/^[0-9\+]{8,13}$/';

    //hotline
    if(strlen($formvars['uslugi']['hotline']) > 0 &&  !preg_match($reg,$formvars['uslugi']['hotline'])) {
//    if(strlen($formvars['uslugi']['hotline']) > 0 ) {
	      $this->error = 'hotline_error';
	      return false;
	    }




    //cfu
    if(strlen($formvars['uslugi']['cfu']) > 0 &&  !preg_match($reg,$formvars['uslugi']['cfu']) &&  $formvars['uslugi']['cfu'] != '9555') {
      $this->error = 'cfu_error';
      return false; 
    }

    //cfb
    if(strlen($formvars['uslugi']['cfb']) > 0 &&  !preg_match($reg,$formvars['uslugi']['cfb']) &&  $formvars['uslugi']['cfb'] != '9555' ) {
      $this->error = 'cfb_error';
      return false; 
    }

    //cfnr
    if(strlen($formvars['uslugi']['cfnr']) > 0 && !preg_match($reg,$formvars['uslugi']['cfnr']) &&  $formvars['uslugi']['cfnr'] != '9555' ) {
      $this->error = 'cfnr_error';
      return false; 
    }

    //cfur
    if(strlen($formvars['uslugi']['cfur']) > 0 &&  !preg_match($reg,$formvars['uslugi']['cfur']) &&  $formvars['uslugi']['cfur'] != '9555' ) {
      $this->error = 'cfur_error';
      return false; 
    }

//jesli OCB jest inne niz 0 - brak blokady
if($formvars['uslugi']['ocb']<>0) {

    // test if ocb_passwd is too short
    if(strlen($formvars['uslugi']['ocb_password']) < 4) {
        $this->error = 'ocbpassword_short';
        return false;
    }

    // test if "ocb_passwd" is not integer
    if(ctype_digit($formvars['uslugi']['ocb_password'])<>1) {
      $this->error = 'ocbpassword_nointeger';
      return false; 
    }

}


    // form passed validation
    return true;
  }



function getBilling($formvars) {
    $chb = !empty($formvars['zerowe']) ? 1 : 0 ;
    $api = new AdescomBillingManagerLocal();

    try {
        $rows = $api->getBillingForCallerID("".$formvars['callerID']."", "".$formvars['from']." 00:00:00", "".$formvars['to']." 23:59:59", "", $chb , $formvars['typpol']);

    } catch (SoapFault $e) {
        switch ($e->detail->code) {
            case 'clid_not_found':
                print 'Nie znaleziono numeru';
                break;
            default:
               print "Błąd ! --> ".$e->detail->code;
                break;
        }
    }
    return $rows;
    }

  /**
  * display billing
  *
  * @param array $data the billing data
  */
  function displayBilling($data = array(), $formvars) {
    global $LMS,$SMARTY,$SESSION,$DB;
    $this->displayForm($formvars);
    $SMARTY->assign('post',$formvars);
    $SMARTY->assign('data', $data);
    $SMARTY->assign('error', $this->error);
    $SMARTY->display('module:biling_data.html');
  }


function doladuj($formvars) {

    global $LMS,$SMARTY,$SESSION,$DB;
    $kwota = str_replace(',','.',$formvars['kwota']);
    $api = new AdescomClidLimitManager();
    //najpierw pobieramy obecny stan konta
    $ob = $api->getCLIDsAccountState(array($formvars['callerID']));
    //na pewno zwróci tylko jeden wynik, wiec nie bawie sie w foreach
    $obecnie = $ob[0]['value'];
    try {
    //zakomentowac zeby w czasie testow nie doladowywac konta
    $rows = $api->addCLIDPrepaidAccountState($formvars['callerID'], array('value'=>$kwota) );

    } catch (SoapFault $e) {
        switch ($e->detail->code) {
            case 'clid_not_found':
                print 'Nie znaleziono numeru';
                break;
            default:
               print "Błąd ! --> ".$e->detail->code;
                break;
        }
    exit();
    }
    //sprawdzamy ile jest kasy po wplacie
    $powplacie = $api->getCLIDsAccountState(array($formvars['callerID']));
    $kw = $kwota;

    //sprawdzamy czy stan poczatkowy + wplata = stan po wplacie
    //jesli tak, to dopisujemy klientowi zobowiazanie w LMS i generujemy fakture
    //na koniec do wyniku dopisujemy 1 = ok
    // w innym razie zwracamy w wyniku 0
    //jesli nie udalo sie dopisac faktury to trzeba wykonac rollbacka doladowania

    if ($obecnie + $kw == $powplacie[0]['value'])
    {
    //przeniesiono do funkcji utworzFakture    $wyn = $DB->Execute("INSERT INTO cash (time, type, docid, itemid, value, comment, userid, customerid) VALUES (NOW() , 0, 0, 0, ".$zobow.", 'Doładowanie konta prepaid ".$formvars['callerID']."', 2, ".$SESSION->id.")");
    $wyn = $this->utworzFakture($kwota,$formvars['callerID']);
	if ($wyn=1)
	{
	$res=1;
	}
	else
	{
	$res=-1; //blad dopisania faktury  - zastanowic sie nad AUTOMATYCZNYM rollbackiem dopisania w ADESCOM lub mailem z informacja o bledzie
	$rows = $api->addCLIDPrepaidAccountState($formvars['callerID'], array('value'=>$kwota * -1));
	}
    }
    else
    {
    $res=0;
    }
    
    $wyn = array('obecnie' => $obecnie, 'wplata' => $kwota, 'powplacie' => $powplacie[0]['value'], 'wynik'=>$res);
    return $wyn;
}


  /**
  * display doladuj
  *
  * @param array $data the billing data
  */
  function displayDoladuj($formvars) {
    global $LMS,$SMARTY;
//zabezpieczenie przed doladowaniem w razie przeladowania strony - przez 100 sek. nie mozna ponownie doladowac
// na stronie tez zrobic przekierowanie po 10 sek tak aby klient zdazyl przeczytac komunikat
// pomyslec nad lepszym rozwiazaniem

if (count($_POST) > 0) {
    if (isset($_POST['submit_edit']) && $_POST['submit_edit'] == '1'
            && time() - $_SESSION['last_request_time'] < 100
            && count($_SESSION['last_request']) > 0
            && serialize($_SESSION['last_request']) == serialize($_POST)
) {
        $SMARTY->assign('display_time_alert', '1');
        unset($_POST['submit_edit']);
        unset($_REQUEST['submit_edit']);
    } else {
        $_SESSION['last_request_time'] = time();
        $_SESSION['last_request'] = $_POST;
    }
}

if(isset($_POST['submit_edit']) && $_POST['submit_edit'] == '1')
{
$data = $this->doladuj($formvars);
}

    $SMARTY->assign('post',$formvars);
    $SMARTY->assign('data', $data);
    $SMARTY->assign('error', $this->error);
    $SMARTY->display('module:doladuj_data.html');
  }



  /**
  * display report
  *
  * @opts - array, $data - report data
  */

function getReportSum($extID, $dateFrom, $dateTo,  $opts,  $connection = null) {
        // if no SOAP client - create a new one
        if ($connection == null)
            $connection = AdescomConnection::getConnection();
    try {
        $rows = $connection->getReportForClientByExternalID($extID, $dateFrom, $dateTo, $opts);

    } catch (SoapFault $e) {
        switch ($e->detail->code) {
            case 'client_not_found':
    //            print 'Nie znaleziono takiego klienta';
                break;
            default:
    //           print "Błąd ! --> ".$e->detail->code;
                break;
        }
    }

    $miesiac = array('Jun' => 'styczeń', 'Feb' => 'luty', 'Mar' => 'marzec', 'Apr' => 'kwiecień', 'May' => 'maj', 'Jun' => 'czerwiec', 'Jul' => 'lipiec', 'Aug' => 'sierpień', 'Sep' => 'wrzesień', 'Oct'=> 'październik', 'Nov' => 'listopad', 'Dec' => 'grudzień');
      // allocate results array
        $results = array();
        // if records array is not empty...
        if (is_array($rows->items)) {
            // go through all records...
            foreach ($rows->items as $record) {
                $data = $record->date;
		$dateY=date('Y', strtotime($data));
		$dateM=$miesiac[date('M', strtotime($data))];
		$date=$dateM." ".$dateY;
                $count = $record->count;
                $durationTotal = $record->durationTotal;
                $durationAverage = $record->durationAverage;
                $costTotalIncludingTaxes = $record->costTotalIncludingTaxes;
                $costAverageIncludingTaxes = $record->costAverageIncludingTaxes;
                $results[] = array('date' => $date, 'count' => $count, 'durationTotal' => $durationTotal, 'durationAverage' => $durationAverage, 'costTotalIncludingTaxes' => $costTotalIncludingTaxes, 'costAverageIncludingTaxes' => $costAverageIncludingTaxes);
	    }
        }
        return array_values($results);
    }


function getClidsStatus()
{
    global $LMS,$SMARTY,$SESSION;
    $clid=$SESSION->id;
     try {
    $numery = $LMS->GetCustomerVoipAccounts($clid);

    } catch (SoapFault $e) {
        switch ($e->detail->code) {
            case 'client_not_found':
                print 'Nie znaleziono klienta !';
                break;
            default:
                print 'Błąd -->'.$e->detail->code;
                break;
        }
    }

$callerID=array();
foreach ($numery as $nr)
{
 if (count($nr)>0)
 {
    foreach((array)$nr as $n)
    {
	if (isset($n[phone]))
        $callerID[]=$n[phone];
    }
 }
 else
 {
  return $callerID;
 }
}
$api = new AdescomClidLimitManager;
$state = $api->getCLIDsAccountState($callerID);

$api2 = new AdescomClidManager;

$wyn = array();
foreach ($state as $s)
{
$d = $api2->getCLID($s['callerID']);
$stat = $api2->getCLIDStatus($s['callerID']);
$w = array();
$w['callerID'] = $s['callerID'];
$w['valid'] = $s['valid'];
$w['isPrepaid'] = $s['isPrepaid'];
$w['value'] = $s['value'];
$w['passwd'] = $d['passwd'];
$w['status'] = $stat->status;
$wyn[] = $w;
}
return $wyn;
}





  /**
  * display doladuj entry form
  *
  * @param array $formvars the form variables
  */
  function displayFormDoladuj($formvars = array()) {
    global $LMS,$SMARTY,$SESSION;
    $clid=$SESSION->id;
     try {
    $numery = $this->getClidsStatus();
    } catch (SoapFault $e) {
        switch ($e->detail->code) {
            case 'client_not_found':
                print 'Nie znaleziono klienta !';
                break;
            default:
                print 'Błąd -->'.$e->detail->code;
                break;
        }
    }
    $platnosci = $this->platnosci($clid);

    if ($platnosci['blokada']==0)
    {
    $SMARTY->assign('numery',$numery);
    // assign the form vars
    $SMARTY->assign('post',$formvars);
    // assign error message
    $SMARTY->assign('error', $this->error);
    $SMARTY->display('module:doladuj_form.html');
    }
    else
    {
    $SMARTY->assign('platnosci',$platnosci);
    $SMARTY->assign('post',$formvars);
    // assign error message
    $SMARTY->assign('error', $this->error);
    $SMARTY->display('module:doladuj_zaleglosci.html');

    }
}





function platnosci($cid)
{
global $DB;
//czyszczenie zmiennych
$saldo=0;
$zobowiazania=0;
$blokada=0;

// zapytanie do bazy MySQL o aktualne saldo klienta
$saldo_out =  $DB->GetRow("SELECT SUM(value) AS saldo FROM `cash` WHERE customerid = $cid;");
$saldo = $saldo_out["saldo"];

//zapytanie do bazy MySQL o cene OBOWIAZUJACYCH taryf klienta 
//FIX: poprawiono zapytanie dla klientow ktorzy zmienili taryfe
//FIX: poprawiono zapytanie dla klientow bezterminowych
$zobowiazania_out =  $DB->GetRow("SELECT IFNULL(SUM(tariffs.value),0) as value  FROM tariffs LEFT JOIN assignments ON assignments.tariffid = tariffs.id WHERE assignments.customerid = $cid  and  NOW() BETWEEN FROM_UNIXTIME(datefrom) AND IF(dateto = 0,NOW(), FROM_UNIXTIME(dateto))");
$zobowiazania = $zobowiazania_out["value"];

//jesli saldo jest ujemne i jego wartosc bezwzgledna jest wieksza od wartosci zobowiazan + 20 zl, to nie pozwalamy klientowi na doladowania
if ($saldo < 0 && abs($saldo) > $zobowiazania + 20 )
{
$blokada=1;
}

$wyn = array('saldo' => $saldo,'zobowiazania' => $zobowiazania, 'blokada' => $blokada);
return $wyn;
}




  /**
  * utworz dokumenty w LMS
  *
  * @param  $kwota - kwota doladowania, 4clid - numer telefonu
  */


function utworzFakture($kwota, $clid)
{
global $LMS,$SESSION,$DB;

$document = array();
//$typDok = 1 - faktura
$document['type'] = 1;
//plan numeracji dokumentu (faktura = 1)
$document['numberplanid'] = 1;
//id wystawiajacego fakture, 2 = Karina
$document['userid'] = 2;
//kwota doladowania
$document['kwota'] = $kwota;
//id stawki podatkowej
$document['taxid'] = 2;
//opis pozycji na fakturze - stała ze zmieniającym się numerem telefonu
$document['description'] = 'Doładowanie konta prepaid '.$clid;
//id klienta
$document['customerid'] = $SESSION->id;
//typ platnosci. 2 - przelew
$document['paytype'] = 2;
//termin platnosci - ilosc dni
$document['paytime'] = 14;

// !!!!!!!!!!!!!!!!!
// WAZNE !! Sprawdzic zmienne w lms.ini dla wartosci domyslnych zeby nie bylo duplikowania danych

$time = time();

//pobieramy ostatni numer dokumentu dla danego planu
$tmp = $LMS->GetNewDocumentNumber($document['type'], $document['numberplanid']);
$document['number'] = $tmp ? $tmp : 0;


//rozpoczecie transakcji
$DB->BeginTrans();

//dane klienta
$gencust = $DB->GetRow('SELECT lastname, name, address, city, zip, ssn, ten, countryid, divisionid, paytime FROM customers WHERE id = ?', array($document['customerid']));

//dane firmy wystawiajacej FV przypisane do klienta
$division = $DB->GetRow('SELECT name, shortname, address, city, zip, countryid, ten, regon, account, inv_header, inv_footer, inv_author, inv_cplace FROM divisions WHERE id = ?;', array($gencust['divisionid']));

//tworzenie faktury
$wynFak = $DB->Execute('INSERT INTO documents (type, number, numberplanid, cdate, sdate, paytype, paytime, customerid, userid, divisionid, name, address, zip, city, ten, ssn, closed,
div_name, div_shortname, div_address, div_city, div_zip, div_countryid, div_ten, div_regon,
div_account, div_inv_header, div_inv_footer, div_inv_author, div_inv_cplace)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($document['type'],
$document['number'],
$document['numberplanid'],
$time,
$time,
$document['paytype'],
$document['paytime'],
$document['customerid'],
$document['userid'],
$gencust['divisionid'],
$gencust['lastname'].' '.$gencust['name'],
$gencust['address'] ? $gencust['address'] : '',
$gencust['zip'] ? $gencust['zip'] : '',
$gencust['city'] ? $gencust['city'] : '',
$gencust['ten'] ? $gencust['ten'] : '',
$gencust['ssn'] ? $gencust['ssn'] : '',
!empty($document['closed']) ? 1 : 0,
($division['name'] ? $division['name'] : ''),
($division['shortname'] ? $division['shortname'] : ''),
($division['address'] ? $division['address'] : ''), 
($division['city'] ? $division['city'] : ''), 
($division['zip'] ? $division['zip'] : ''),
($division['countryid'] ? $division['countryid'] : 0),
($division['ten'] ? $division['ten'] : ''), 
($division['regon'] ? $division['regon'] : ''), 
($division['account'] ? $division['account'] : ''),
($division['inv_header'] ? $division['inv_header'] : ''), 
($division['inv_footer'] ? $division['inv_footer'] : ''), 
($division['inv_author'] ? $division['inv_author'] : ''), 
($division['inv_cplace'] ? $division['inv_cplace'] : ''),
));

//pobranie ID utworzonego dokumentu - potrzebne do dopisanie pozycji faktury w 'invoicecontents'
//pobiera max id dla danego kontrahenta - chyba dobrze ;-)
$FaktId = $DB->GetOne('SELECT MAX(id) FROM documents WHERE type = 1 AND customerid = ?', array($document['customerid']));

//tworzenie pozycji na fakturze - ZAWSZE tylko jedna pozycja
$DB->Execute('INSERT INTO invoicecontents (docid, value, taxid, content, count, description, itemid) 
VALUES (?, ?, ?, ?, ?, ?, ?)', array($FaktId, $document['kwota'], $document['taxid'], 'szt.', 1, $document['description'], 1) );

//tworzymy zobowiazanie klienta
$DB->Execute('INSERT INTO cash (time, type, docid, itemid, value, comment, userid, customerid) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', array(time(), 0, $FaktId, 1, $document['kwota'] * -1, $document['description'], $document['userid'] , $document['customerid']));

//sprawdzamy czy sa jakies bledy SQL
$bledyCount = count($DB->GetErrors());

if ($bledyCount===0)
{
//zatwierdzamy transakcje
$DB->CommitTrans();
return 1;
}
else
{
//roolback
$DB->RollbackTrans();
//dane do maila
$data=array();
$data['err'] = $DB->GetErrors();
$data['blad'] = $e;
$data['clid'] = $document['customerid'];
$this->zglosBlad($data);
return 0;
}

}//koniec funkcji utworzFakture

function _czyscDane()
{
$odDaty = strtotime('2015-06-28 00:00:00');
global $LMS,$SESSION,$DB;
//pobierz dokumenty klienta do usuniecia (potrzebna do czyszczenia invoicecontents)
$docs = $DB->GetAll('SELECT id FROM documents where customerid=? and cdate>?', array($SESSION->id, $odDaty));
//wyczysc dokumenty klienta od daty $odDaty
$clDocuments = $DB->Execute('DELETE FROM documents where customerid=? and cdate>?', array($SESSION->id, $odDaty));
$clCash = $DB->Execute('DELETE FROM cash where customerid=? and time>?', array($SESSION->id, $odDaty));


foreach($docs as $value)
{
$clIncCont = $DB->Execute('DELETE FROM invoicecontents where docid=?',array($value['id']));
$clIncContWyn .= "<br>cliCont=".$clIncCont;
}
echo "doc=".$clDocuments."<br>clCash=".$clCash.$clIncContWyn;
}



function zglosBlad($data)
{
global $LMS;
$headers=array();
$headers['From']='bok@alfa-system.pl';
$headers['Subject']="Problem z doladowaniem. KlientID=".$data['clid'];
$body = "Blad:".$data['blad']."\n\n".time()."\n".$data['err'];
$wyn = $LMS->SendMail('t.kaczmarek@alfa-system.pl', $headers, $body);
}





//ustawienia
  /**
  * display ustawienia entry form
  *
  * @param array $formvars the form variables
  */
  function displayFormUstawienia($formvars = array()) {
    global $LMS,$SMARTY,$SESSION;
    $clid=$SESSION->id;
     try {
    $numery = $this->getClidsStatus();
    } catch (SoapFault $e) {
        switch ($e->detail->code) {
            case 'client_not_found':
                print 'Nie znaleziono klienta !';
                break;
            default:
                print 'Błąd -->'.$e->detail->code;
                break;
        }
    }

    if (isset($formvars['callerID']) && !is_null($formvars['callerID']))
    $numer = $formvars['callerID'];
    else
    $numer = $numery[0]['callerID'];

    $uslugi = $this->getUslugi($numer);

    //szczegoly numeru np. haslo
    $api = new AdescomClidManager;
    $dane = $api->getCLID($numer);


    $SMARTY->assign('numery',$numery);
    $SMARTY->assign('numer',$numer);
    $SMARTY->assign('uslugi',$uslugi);
    $SMARTY->assign('dane',$dane);
    // assign the form vars
    $SMARTY->assign('post',$formvars);
    // assign error message
    $SMARTY->assign('error', $this->error);
    $SMARTY->display('module:ustawienia_form.html');
}


  /**
  * display ustawienia
  *
  * @param array $data the ustawienia data
  */
  function displayUstawienia($data = array(), $formvars) {
    global $LMS,$SMARTY,$SESSION;
    $SMARTY->assign('post',$formvars);
    $SMARTY->assign('data', $data);
    $SMARTY->assign('error', $this->error);
    $SMARTY->display('module:ustawienia_data.html');
  }



function getUslugi($clid)
{
$api = new AdescomClidServiceManager;
$usl = $api->getCLIDServices($clid);
return $usl;
}


function zmienUstawienia($formvars) {
    global $LMS,$SMARTY,$SESSION,$DB;
    $api = new AdescomClidManager;
    $daneRO = $api->getCLID($formvars['numer']);
    $uslugiRO = $this->getUslugi($formvars['numer']);

$clid = array();
$clid['phoneid'] = $daneRO['phoneid'];
$clid['passwd'] = $formvars['dane']['passwd'];
$clid['context'] = $daneRO['context'];
$clid['emergencycontext'] = $daneRO['emergencycontext'];
$clid['host'] = $daneRO['host'];
$clid['voicemail'] = (boolean) $formvars['dane']['voicemail'];
$clid['voicemailpassword'] = $formvars['dane']['voicemailpassword'];
$clid['tariffid'] = $daneRO['tariffid'];
$clid['countrycode'] = $formvars['dane']['countrycode'];
$clid['areacode'] = $formvars['dane']['areacode'];
$clid['shortclid'] = $formvars['dane']['shortclid'];
$clid['is_prepaid'] = $daneRO['is_prepaid'];
$clid['line'] = $daneRO['line'];
//$clid['ctmid'] = $daneRO['ctmid'];
$clid['registration_type'] = $daneRO['registration_type'];
$clid['clir'] = (boolean) $formvars['uslugi']['clir'];
$clid['acrej'] = (boolean) $formvars['uslugi']['acrej'];
$clid['hotline'] =  $formvars['uslugi']['hotline'];
$clid['cw'] = $formvars['uslugi']['cw'];
$clid['cfu'] = $formvars['uslugi']['cfu'];
$clid['cfb'] = $formvars['uslugi']['cfb'];
$clid['cfnr'] = $formvars['uslugi']['cfnr'];
$clid['cfur'] = $formvars['uslugi']['cfur'];
$clid['ocb'] = $formvars['uslugi']['ocb'];
$clid['ocb_password'] = $formvars['uslugi']['ocb_password'];
$clid['login'] = $formvars['numer'];
$clid['email'] = $formvars['dane']['email'];
$clid['voicemailattach'] = $formvars['dane']['voicemailattach'];
$clid['phone'] = $formvars['numer'];
$clid['ownerid'] = $SESSION->id;


//parametry ktorych klient nie zmienia, ale trzeba je przekazac do funkcji modyfikujacej bo inaczej ustawia sie na false
//w przyszlosci gdyby byla opcja rozbudowy ustawien wystarczy ustawic pobieranie z formvars
$clid['clip'] = $uslugiRO['clip'];
$clid['clir_allowed'] = $uslugiRO['clir_allowed'];
$clid['acrej_allowed'] = $uslugiRO['acrej_allowed'];
$clid['clirovr'] = $uslugiRO['clirovr'];
$clid['dnd'] = $uslugiRO['dnd'];
$clid['dnd_allowed'] = $uslugiRO['dnd_allowed'];
$clid['hotline_allowed'] = $uslugiRO['hotline_allowed'];
$clid['cw_allowed'] = $uslugiRO['cw_allowed'];
$clid['nway'] = $uslugiRO['nway'];
$clid['alarm'] = $uslugiRO['alarm'];
$clid['forwarding'] = $uslugiRO['forwarding'];
$clid['f2m'] = $uslugiRO['f2m'];
$clid['f2m_xfer'] = $uslugiRO['f2m_xfer'];
$clid['uf2m'] = $uslugiRO['uf2m'];
$clid['nrf2m'] = $uslugiRO['nrf2m'];
$clid['blind_xfer'] = $uslugiRO['blind_xfer'];
$clid['at_xfer'] = $uslugiRO['at_xfer'];
$clid['ocb_allowed'] = $uslugiRO['ocb_allowed'];
//$clid['ocb'] = $uslugiRO['ocb'];
//$clid['ocb_password'] = $uslugiRO['ocb_password'];

$dane = $api->modifyCLID($formvars['numer'], $clid);

$api2 = new AdescomClidServiceManager();
$uslugi = $api2->saveCLIDServices($formvars['numer'], $clid);
//Aktualizuj voipaccounts - aby mieć w LMS aktualne haslo klienta
$upVoipaccounts = $DB->Execute('UPDATE voipaccounts set passwd=? where phone=?', array($formvars['dane']['passwd'], $formvars['numer']));


}







}
?>



