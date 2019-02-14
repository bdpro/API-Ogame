<?php
$titrePage = "Détails Alliance Univers Himalia 160";
   
    include ('includes/header.php');
    include ('includes/navbar.php');
$idalli = $_GET['id'];

?>




<?php

$urlalli = 'https://s160-fr.ogame.gameforge.com/api/alliances.xml';
$allis  = simplexml_load_file($urlalli);
$alli = $allis->xpath("/alliances/alliance[@id='$idalli']")[0];
$alliname = $alli->attributes()->name;
$tag = $alli->attributes()->tag;
$hp = $alli->attributes()->homepage;
$ts = ($allis->attributes()->timestamp);
$mj = (string) $ts;
$players = $alli->player;
$founder = $alli->attributes()->founder;
$datfound = $alli->attributes()->founder;
$datefound = (string) $datfound;
$urlplayers = 'https://s160-fr.ogame.gameforge.com/api/players.xml';   
$nomplayers = simplexml_load_file($urlplayers);
$nomfound = $nomplayers->xpath("/players/player[@id='$founder']")[0]->attributes()->name;


 echo '<p class="text-primary">Mise à jour Le '.date('d/m/Y', $mj).' &agrave; '.date('H:i', $mj).'</p>';


?>
<div class="text-center">

    <?php 
        echo "<h2>".$alliname." <font class='text-success'> [".$tag."]</h2></font><a href='".$hp."'>Site Web</a>";
        ?>
</div>
<div class="container-fluid card">
    <div class="row">

        <div class="col-md-6 ">
            <?php 
        echo "<h5>Fondateur : ".$nomfound."</h5><p>Crée le ".date('d/m/Y', $datefound).' &agrave; '.date('H:i', $datefound)."</p>";
?>
            <h4 class="card-header">Joueurs</h4>
            <table class="table table-striped alltable">
                <thead class="thead  text-white">
                    <tr>
                        <th scope="col">Joueurs</th>
                        <th scope="col">Classements</th>
                        <th scope="col">Points</th>



                    </tr>
                </thead>
                <?php

        foreach ($players as $player){
        
       
    
        $idplayer = ($player->attributes()->id);
        $nomplayer = $nomplayers->xpath("/players/player[@id='$idplayer']")[0]->attributes()->name;
        $scorjoueur = "https://s160-fr.ogame.gameforge.com/api/highscore.xml?category=1&type=0";
        $scorj  = simplexml_load_file($scorjoueur);
        $sj = $scorj->xpath("/highscore/player[@id='$idplayer']")[0];
        $pointj = $sj->attributes()->score;
        $posj = $sj->attributes()->position;
            
 
        echo "<tr><td> <a  href='player.php?id=".$idplayer."'>".$nomplayer."</a></td><td>".$posj."</td><td>".$pointj."</td></tr>";
  
                                    }
    
    ?>
            </table>
        </div>
        <div class="col-md-6 ">
            <h4 class="card-header">Classement Alliance</h4>
            <table class="table table-striped alltable">
                <thead class="thead  text-white">
                    <tr>
                        <th scope="col">Catégories</th>
                        <th scope="col">Classements</th>
                        <th scope="col">Points</th>


                    </tr>
                </thead>




                <?php
    $categories = array('<img src="img/point.gif" width="35" height="35"> Points ','<img src="img/eco.gif" width="35" height="35"> Economie','<img src="img/recherche.gif" width="35" height="35"> Recherche', '<img src="img/flotte.gif" width="35" height="35"> Militaire','<img src="img/pmc.png" width="35" height="35"> Points militaires construits','<img src="img/pmd.png" width="35" height="35"> Points militaires détruits','<img src="img/pmp.png" width="35" height="35"> Points militaires perdus','<img src="img/ph.png" width="35" height="35"> Points Honorifiques');
    $c = 0;

    foreach ($categories as $categorie){
        $scoralli = "https://s160-fr.ogame.gameforge.com/api/highscore.xml?category=2&type=".$c++."";
        $scores  = simplexml_load_file($scoralli);
        
        $score = $scores->xpath("/highscore/alliance[@id='$idalli']")[0];
        $point = $score->attributes()->score;
        $position = $score->attributes()->position;

        
  
    
        echo "<tr><td>".$categorie."</td><td>".$position."</td><td>".$point."</td></tr>";
    }
 

?>

            </table>
        </div>
    </div>
</div>

<script type="text/javascript" src="js/script.js"></script>

<?php include ('includes/footer.php') ?>