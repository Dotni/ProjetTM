<?php
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }

	include("config.php");
	$vTextArea = strip_tags($_REQUEST['textCom']);
	$vIdTopic = $_POST['idTopic'];
	$vMail = $_SESSION['mail'];

    $requete = $conn -> prepare("INSERT into `commentaire` (texte, dateajoutcom, mailCom, idtopic)
    VALUES (:vTextArea, now(), :vMail, :idTmp)");

    //Commentaire
    $requete -> bindValue(':vTextArea', $vTextArea, PDO::PARAM_STR);
    $requete -> bindValue(':vMail', $vMail, PDO::PARAM_STR);
    $requete -> bindValue(':idTmp', $vIdTopic, PDO::PARAM_INT);
    $requete -> execute();

?>