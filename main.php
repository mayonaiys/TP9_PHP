<?php
//EXERCICE  1

include 'connexpdo.php';
$bdd = connexpdo('pgsql:dbname=notes;host=localhost;port=5432','postgres','smic123');

header ("Content-type: image/png");
$image = imagecreate(1000,300);
$gray = imagecolorallocate($image,160,160,160);
$black = imagecolorallocate($image,0,0,0);
$white = imagecolorallocate($image,255,255,255);
$blue = imagecolorallocate($image,0,0,255);
imagestring($image, 6, 375, 5, "Notes des etudiants E1 et E2", $black);

$reponse1 = $bdd->prepare('SELECT * FROM notes where etudiant = ?');
$reponse1->execute(array("E1"));
$moyenneEleve1 = 0;
$div = 0;
$esp = 0;
$last=0;
while ($data = $reponse1->fetch()) {
    if($div==0){
        $last = $data['note'];
    }
    $div++;
    imageline($image, $esp, 100-$last, $esp+100, 100-$data['note'], $white);
    $esp =  $esp + 100;
    $last = $data['note'];
    $moyenneEleve1 = $moyenneEleve1 + $data['note']."<br>";
}
$moyenneEleve1 = $moyenneEleve1/$div;
$str1 = "Moyenne des notes de E1 : ".$moyenneEleve1;

$reponse2 = $bdd->prepare('SELECT * FROM notes where etudiant = ?');
$reponse2->execute(array("E2"));
$moyenneEleve2 = 0;
$div = 0;
$esp = 0;
while ($data = $reponse2->fetch()) {
    if($div==0){
        $last = $data['note'];
    }
    $div++;
    imageline($image, $esp, 120-$last, $esp+100, 120-$data['note'], $blue);
    $esp =  $esp + 100;
    $last = $data['note'];
    $moyenneEleve2 = $moyenneEleve2 + $data['note']."<br>";
}
$moyenneEleve2 = $moyenneEleve2/$div;
$str2 = "Moyenne des notes de E2 : ".$moyenneEleve2;
imagestring($image, 6, 720, 250, $str1, $black);
imagestring($image, 6, 720, 275, $str2, $black);
imagestring($image, 6, 10, 150, "E1", $white);
imagestring($image, 6, 120, 150, "E2", $blue);

imagepng($image);
?>