<?php
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
?>

<?php
    include("config.php");
    $topic = $_POST['topic'];
    $idTopic = $_POST['idTopic'];

    // Récupère le texte, la date, le pseudo, l'id des commentaires correspondant au topic
    $req1 = $conn -> prepare("select commentaire.texte, commentaire.dateajoutcom, utilisateur.pseudo, commentaire.idcom 
                                    from commentaire left join topic using(idtopic) left join utilisateur 
                                    on commentaire.mailcom=utilisateur.mail where idtopic ='$idTopic' order by dateajoutcom");
    $req1 -> execute();

    $select = '';

    if($req1 -> rowCount() > 0) {
        while($data1 = $req1 -> fetch(PDO::FETCH_ASSOC)) {
            $TxtComTmp = $data1['texte'];
            $DateComTmp = $data1['dateajoutcom'];
            $PseudoUtilTmp = $data1['pseudo'];
            $IdCom = $data1['idcom'];
            $NbLikes = 0;

            $req2 = $conn -> prepare("select commentaire.idcom, count(*) from commentaire join likecom using(idcom) group by idcom");
            $req2 -> execute();
            if($req2 -> rowCount() > 0) {
                while($data2 = $req2 -> fetch(PDO::FETCH_ASSOC)) {
                    if($data2['idcom'] == $data1['idcom']) {
                        $NbLikes = $data2['count(*)'];
                        break;
                    }
                }
            }

            $select .= '<div class="card" style="margin-top: 10px;">
                            <div class="card-body">
                                <div class="card-title" style="background-color: #818182; border-radius: 25px;">
                                    <h3><div class ="pl-3 pt-1 pr-3">' . $PseudoUtilTmp .'</div></h3>
                                </div>
                                <div class="card-text" style="border-radius: 5px; background-color: #d3d9df">
                                    <div class ="pl-3 pt-1 pr-3" style="background-color: #b9bbbe; border-radius: 5px;">' . $TxtComTmp .'</div>
                                    <footer class="blockquote-footer">
                                        <div class ="pl-3 pt-1 pr-3">' . $DateComTmp .'</div>
                                    </footer>
                                    <button type="button" name="nBtnLike" id="btnLikeC" value=' . $IdCom . ' href="#">Likes <span class='. $IdCom .'>' . $NbLikes . '</span></button>
                        ';

        if(isset($_SESSION['grade'])){
            // Si modérateur ou administrateur
            if($_SESSION['grade'] >= 2) {
                $select .= '<form  method ="post" class="form-check-inline" style="float:right;">
                            <button id="btnDelCom" type="button" style="float:right;" name="supprimer" value=' . $IdCom . '> Supprimer </button>
                        </form>';
            }
        }

            $select .= '</div>
                            </div>
                        </div>';
        }
    }

    echo $select;
    $conn = null;
?>
