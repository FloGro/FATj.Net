#!/usr/bin/env php
<?php
// file_cut.php for data-camp in /Volumes/HOME/raffin_j/SVN/FATj.Net
// 
// Made by Jean-Baptiste RAFFIN
// Login   <raffin_j@etna-alternance.net>
// 
// Started on  Mon Oct 13 14:36:04 2014 Jean-Baptiste RAFFIN
// Last update Wed Oct 15 15:15:09 2014 Jean-Baptiste RAFFIN
//

$fileCut = file_reader($argv[1], $argv[2]);
$fileBuild = file_builder($fileCut);
file_decrypt($fileBuild, $argv[2], $argv[1]);

//Lecture du fichier et chiffrement
function file_reader($file, $password)
{
    $fileOpen = fopen($file, 'r');
    if ((bool) $fileOpen == FALSE || filesize($file) == 0)
        echo "content.php: $argv: Cannot open file\n";
    else
        {
            $stringFile = fread($fileOpen, filesize($file));
            $encryptFile = openssl_encrypt($stringFile, 'aes128', $password);
            $fileCut = file_cutter($encryptFile);
            fclose($fileOpen);
            return($fileCut);
        }
}

//function de découpe du fichier
function file_cutter($fileOpen)
{
    $fileCut = array();
    $fileSize = strlen($fileOpen);
    $oneFileSize = $fileSize / 8 + 1;
    $charPoint = 0;
    $stringTmp;

    for ($i = 0 ; $i < 8 ; $i++)
        {
            $stringTmp = "#-'-".$i."-'-#";
            for ($j = 0 ; $j < $oneFileSize ; $j++)
                {
                    $stringTmp .= $fileOpen[$charPoint];
                    $charPoint++;
                }
            $stringTmp .= "#-'-".$i."-'-#";
            array_push($fileCut, $stringTmp);
            array_push($fileCut, $stringTmp);
        }
    return($fileCut);
}

//function de réasossation
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
    for ($i = 0 ; $fileBuild[$i] != NULL ; $i++)
        $fileEncrypted .= $fileBuild[$i];

    return($fileEncrypted);
}

//foncton de déchiffrage et de comparaison avec l'ancien fichier
function file_decrypt($fileEncrypted, $password, $oldFile)
{
    $fileDecrypt = openssl_decrypt($fileEncrypted, 'aes128', $password);
    $fileOpen = fopen($oldFile, 'r');

    if ($fileDecrypt == NULL)
        echo "error: Cannot decrypt file\n";
    if ((bool) $fileOpen == FALSE || filesize($oldFile) == 0)
        echo "content.php: $argv: Cannot open file\n";
    else
        {
            $OldFileRead = fread($fileOpen, filesize($oldFile));
//            $FilesDiff = xdiff_string_diff($OldFileRead);
            $percentDiff = strlen($fileDecrypt) / strlen($OldFileRead) * 100;
            echo "Concordance de ".$percentDiff."% entre l'original et la copie.\n\n";
        }

    fclose($fileOpen);
    echo $fileDecrypt;
}