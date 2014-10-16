#!/usr/bin/env php
<?php
// file_cut.php for data-camp in /Volumes/HOME/raffin_j/SVN/FATj.Net
// 
// Made by Jean-Baptiste RAFFIN
// Login   <raffin_j@etna-alternance.net>
// 
// Started on  Mon Oct 13 14:36:04 2014 Jean-Baptiste RAFFIN
// Last update Thu Oct 16 17:39:55 2014 Jean-Baptiste RAFFIN
//
//Ces fonctions sont chargées de découper et de chiffrer le fichier d'origine, elles sont ainsi découpé en paquet.
//La fonction fileRaid appelle également la fonction checkSum dans le fichier chekSum.php de facon à creer un sum de deux paquets.

require_once('checkSum.php');
require_once('fileBuilder.php');

$fileCut = file_reader($argv[1], $argv[2]);
unset($fileCut[4]);
unset($fileCut[5]);
sort($fileCut);
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
    $fileCut = fileRaid($fileCut);
    return($fileCut);
}

//fonction de mise en raid
function fileRaid($fileCut)
{
    for($i = 0 , $j = 1 ; $i < 16 ; $i = $i + 4)
        {
            $sum = checkSum($fileCut[$i], $fileCut[$i + 2]); //fichier checkSum.php
            $sum .= "@-'-".$j."-'-@";
            array_push($fileCut, $sum);
            $j = $j + 2;
        }
    return($fileCut);
}