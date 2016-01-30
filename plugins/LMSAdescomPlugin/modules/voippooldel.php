<?php

$id = $_GET['id'];

if ($_GET['is_sure'] == 1 && $id) {
    $ADESCOM_LMS->deletePool($id);
}

$SESSION->redirect('?' . $SESSION->get('backto'));
