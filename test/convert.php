<?php

if (isset($_POST["text"])) {
    require '../src/worps.php';

    $files = array(["path" => "../files/bad.txt"], ["path" => "../files/empty.txt", "separator" => ","]);

    $worps = new Worps($files);

    $chars = [];
    if (isset($_POST["char"])) {
        foreach ($_POST["char"]  as $i =>  $item) {
            if (!empty($item)) {
                $chars[$i] = $item;
            }
        }
    }
    $charSize = isset($_POST["shortLength"]) && (int)$_POST["shortLength"] > 0 ? $_POST["shortLength"] : null;
    $isShuffle = isset($_POST["shuffle"]) ? true : false;
    $worps->setShownText($charSize,  count($chars) > 0 ? $chars : false, $isShuffle);
    $text = $worps->convert($_POST["text"]);

    print(json_encode(array(
        "notConvertedText" => $_POST["text"],
        "convertedText" => $text,
        "allWords" => $worps->getAllWords(),
        "hiddenWordsGroup" => $worps->getHiddenWordsGroup(),
        "hiddenWords" => $worps->getHiddenWords(),
        "regExp" => $worps->getRegExp(),
        "files" => $worps->getFiles(),
        "settings" => array(
            'shuffleShownChar' => $isShuffle,
            'shownCharSize' => $charSize,
            'shownChars' => count($chars) > 0 ? $chars : false,
        )
    )));
}
