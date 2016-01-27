<?php
global $SMARTY;


if (isset($_POST['document'])) {
    /* short example of errors handling

      $error['notes'] = 'Error';
      $result = 'Error';
      return;
*/
} else { // AJAX request
    // Variables accessible in AJAX request
    // $customer    - selected customer ID
    // $JSResponse  - xajaxResponse object
}



$result = $SMARTY->fetch(DOC_DIR . '/templates/' . $engine['name'] . '/plugin.html');
?>
