<?php

include "Request_form.php";

if ($_POST){
    $form = new Request_form($_POST);

    $form->save();
    header('Location: ../../index.php');
    exit();
}

