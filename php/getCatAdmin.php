<?php
    include("php/config.php");
    if(isset($_SESSION['grade'])){
        $sess = $_SESSION['grade'];
        $mail = $_SESSION['mail'];
        $select = '';

        if($sess==3){
            $select = ' <h3>Ajout d\'un theme : </h3>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="InputNomTopic" style="color:white;">Nom du thème</label>
                            <div class="row">
                                <div class="col-6" style="color:white;">
                                    <input type="text" name="nTheme" class="form-control" id="InputNomTopic" placeholder="Nom du thème">
                                    </br>
                                    <button type="Submit" name="ajout" class="btn btn-primary">Ajouter</button>
                                </div>
                                <div class="col-6" style="color:white;">
                                    <select class="form-control" name ="selectCat">';

            $req1 = $conn->prepare("select * from categorie");
            $req1 -> execute();

            if($req1 -> rowCount() > 0){
                while($data1 = $req1 -> fetch(PDO::FETCH_ASSOC)){
                    $catTmp = $data1['nomcat'];
                    $select .= '<option>'.$catTmp.'</option>';
                }
            }

            $select.= '</select>
                                </div>
                            </div>
                        </div>
                    </form>';
        }

    if (isset($_POST['ajout'])&&!empty($_POST['nTheme'])) {

        $nomThemeTMP = stripslashes($_REQUEST['nTheme']);
        $catTMP = stripslashes($_REQUEST['selectCat']);

        echo(" mail " .$mail ."  nomTheme  " .$nomThemeTMP ."  catTMP  " .$catTMP);
        $req1 = $conn->prepare("INSERT into `theme` (nomtheme, mailTheme, nomcat)
            VALUES (:nomThemeTMP,:mail,:catTMP)");

        $req1 -> bindValue(':nomThemeTMP', $nomThemeTMP, PDO::PARAM_STR);
        $req1 -> bindValue(':mail', $mail, PDO::PARAM_STR);
        $req1 -> bindValue(':catTMP', $catTMP, PDO::PARAM_STR);
        $req1 -> execute();
        header("Location: displayAdmin.php");
    }

    echo $select;
    }
    $conn = null;
?>