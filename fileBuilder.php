#!/usr/bin/env php
<?php
// fileBuilder.php for data-camp in /Volumes/HOME/raffin_j/SVN/FATj.Net
// 
// Made by Jean-Baptiste RAFFIN
// Login   <raffin_j@etna-alternance.net>
// 
// Started on  Thu Oct 16 09:39:08 2014 Jean-Baptiste RAFFIN
// Last update Thu Oct 16 18:48:34 2014 Jean-Baptiste RAFFIN
//
//Ces fonctions sont chargées de reconstruire, de vérifier et de déchiffrer les paquets.
//
require_once('checkSum.php');
//function de réasossation des paquets
function file_builder($fileUnBuild)
{
    $fileTmp = array();
    $fileBuild = array();
    $fileInt = array();

    for ($i = 0 ; $fileUnBuild[$i] != NULL ; $i++)
        {
            preg_match("/\A#-'-(\d)-'-#/", $fileUnBuild[$i], $fileInt);
            $var = intval($fileInt[1]);
            preg_match('/[^#-][a-zA-Z0-9\/\+]+[^#]/' ,$fileUnBuild[$i], $fileTmp);
            if ($fileBuild[$var] == NULL)
                $fileBuild[$var] = $fileTmp[0];
        }
   $fileSearch = file_checker($fileBuild, $fileUnBuild);
    for ($i = 0 ; $fileSearch[$i] != NULL ; $i++)
        $fileEncrypted .= $fileSearch[$i];

    file_decrypt($fileEncrypted);
//    return($fileEncrypted);
}

//foncton de déchiffrage et de comparaison avec l'ancien fichier
function file_decrypt($fileEncrypted)
{
    echo "Veuillez entrer le mot de passe:\n";
    $password = trim(fgets(STDIN));
    echo $password;
    $fileDecrypt = openssl_decrypt($fileEncrypted, 'aes128', $password);
    // $fileOpen = fopen($oldFile, 'r');

    if ($fileDecrypt == NULL)
        echo "error: Cannot decrypt file\n";
//    if ((bool) $fileOpen == FALSE || filesize($oldFile) == 0)
    //      echo "content.php: $argv: Cannot open file\n";
    // else
    //  {
            //$OldFileRead = fread($fileOpen, filesize($oldFile));
//            $FilesDiff = xdiff_string_diff($OldFileRead);
            //$percentDiff = strlen($fileDecrypt) / strlen($OldFileRead) * 100;
            //echo "Concordance de ".$percentDiff."% entre l'original et la copie.\n\n";
    //  }

    //fclose($fileOpen);
    echo $fileDecrypt;
}

//fonction de vérification de l'intégrité du fichier. Si manquant, regarde si le raid est présent
function file_checker($file, $fileUnBuild)
{
    for ($i = 0 ; $i < 19 ; $i++)
        {
            if (preg_match("/@-'-(\d)-'-@/", $fileUnBuild[$i], $fileInt) != NULL)
                {
                    $var = intval($fileInt[1]);
                    preg_match('/[0-9.]+[^@-]/' ,$fileUnBuild[$i], $fileTmp);
                    $raid[$var] = $fileTmp[0];
                }
        }
    $file = file_restaured($file, $raid);
    for ($i = 0 ; $i < 8 ; $i++)
        {
            echo $i;
            if ($file[$i] == "")
                {
                    if ($file[$i - 1] == "")
                        $file[$i] .= $file[$i + 1];
                    else
                        $file[$i] = $file[$i - 1];
                }
        }
    var_dump($file);
    return($file);
}

//fonction de restauration
function file_restaured($file, $raid)
{
    var_dump($file);
   for ($i = 0 ; $i < 8 ; $i++)
        {
            if(!isset($file[$i]))
                {
                    if($i % 2 == 0)
                        {
                            preg_match("/.70.90.78.90.[0-9]+.90.78.90.70/", $raid[$i + 1], $tab);
                            $string = str_replace($tab[0], "", $raid[$i + 1]);
                            $restaured = missingPacket($file[$i + 1], $string);
                        }
                    else
                        {
                            preg_match("/.70.90.78.90.[0-9]+.90.78.90.70/", $raid[$i], $tab);
                            $string = str_replace($tab[0], "", $raid[$i]);
                            $restaured = missingPacket($file[$i - 1], $string);
                        }
                    $file[$i] = $restaured;
                }
        }
   return($file);
}
