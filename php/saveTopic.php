<?php
    session_start();

	include "config.php";
	$vTitreTopic=$_POST['nomTopic'];
	$vTextArea=$_POST['textTopic'];
	$vTheme=$_POST['theme'];
	$vMail = $_SESSION['mail'];

	//requéte SQL + mot de passe crypté

    $requete = $conn->prepare("INSERT into `topic` (nomtopic, mailTopic, nomtheme, dateajoutTopic)
    VALUES (:vTitreTopic, :vMail, :vTheme, now())");



    //Topic
    $requete -> bindValue(':vTitreTopic', $vTitreTopic, PDO::PARAM_STR);
    $requete -> bindValue(':vMail', $vMail, PDO::PARAM_STR);
    $requete -> bindValue(':vTheme', $vTheme, PDO::PARAM_STR);
    $requete -> execute();
    $idTmp = $conn->lastInsertId();

    $requete2 = $conn->prepare("INSERT into `commentaire` (texte, dateajoutcom, mailCom, idtopic)
    VALUES (:vTextArea, now(), :vMail, :idTmp)");

    //Commentaire
    $requete2 -> bindValue(':vTextArea', $vTextArea, PDO::PARAM_STR);
    $requete2 -> bindValue(':vMail', $vMail, PDO::PARAM_STR);
    $requete2 -> bindValue(':idTmp', $idTmp, PDO::PARAM_INT);
    $requete2 -> execute();

?>