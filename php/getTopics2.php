<?php
    include("config.php");
    $theme = $_POST['theme'];
    $req1 = $conn->prepare("select idtopic, nomtopic, dateajoutTopic from topic where nomtheme ='$theme'");
    $req1 -> execute();

    $select = '<div  class="row" style="margin-top: 20px;">';

    if($req1 -> rowCount() > 0){
        while($data1 = $req1 -> fetch(PDO::FETCH_ASSOC)){
            $nomTopicTmp = $data1['nomtopic'];
            $dateAjoutTopic = $data1['dateajoutTopic'];
            $idTopicTmp = $data1['idtopic'];
            $select .= "<div class='col-12 col-md-6'>
                            <div class='card'>
                                <div class='card-body'>
                                    <p class='card-title'>Topic ouvert le : " . $dateAjoutTopic . "</p>
                                    <a href='#' id='$idTopicTmp' class='stretched-link'>" . $nomTopicTmp . "</a>
                                </div>
                            </div>
                        </div>";
        }
    }
    $select .= "</div>";
    echo $select;
    $conn = null;
?>