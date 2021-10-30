<?php

/**
 * Worps
 * @copyright  2021
 * @link       #link
 * @author     Dogukan <dogukan1636@gmail.com>
 */

class Worps
{
    function __construct($files = null)
    {
        if (count($files) > 0 || $files !== null) {
            $this->regExp = '/\w+/';
            $this->files = $files;
            $this->shownArray = ["*", "@", "!", "#", "$", "?"];
            $this->allWords = array();
            $this->shownText = "*";
            foreach ($this->files as $i => $item) {
                if (!isset($item["path"])) {
                    throw new Exception("File[$i] path index not found");
                    return false;
                }
                if (!isset($item["separator"])) {
                    $filterWords = file( $item["path"], FILE_IGNORE_NEW_LINES);

                    if (isset($filterWords) && count($filterWords) > 0)
                        array_push($this->allWords, $filterWords);
                    else
                        throw new Exception("File[$i] return 0 words");
                } else {
                    $filterWords =   file( $item["path"]);
                    if (isset($filterWords[0])) {
                        $exploder = explode($item["separator"], $filterWords[0]);
                        if (isset($exploder) && count($exploder) > 0)
                            array_push($this->allWords, $exploder);
                    }
                }
            }
        } else {
            throw new Exception('Files not be empty');
            return false;
        }
    }

    public function setHeader($header)
    {
        header($header);
    }

    public function getFiles()
    {

        return $this->files;
    }
    public function getRegExp()
    {
        return $this->regExp;
    }
    public function setRegExp($exp)
    {
        $this->regExp = $exp;
    }
    public function setShownText($length = null,  $specialChar = false, $isShuffle = false)
    {
        if ($length != null)
            $this->length = $length;
        if (isset($isShuffle) && $isShuffle)
            $this->isTextShuffle = true;

        if (isset($specialChar) && $specialChar)
            $this->shownArray = $specialChar;
    }
    public function convert($text)
    {
        $this->text = $text;
        $this->badWords = [];

        $text = preg_replace_callback($this->regExp, function ($ocr) {
            $newstr = false;
            foreach ($this->allWords as $k => $words) {
                foreach ($this->allWords[$k] as $key => $value) {
                    $start = strpos(strtolower($ocr[0]), strtolower($value));
                    if ($start !== false) {
                        $length = isset($this->length) ? $this->length : strlen($value);

                        $shuffleText = [];
                        for ($i = 0; $i < $length; $i++) {
                            if (isset($this->isTextShuffle) && $this->isTextShuffle)
                                shuffle($this->shownArray);
                            $shuffleText[$i] = $this->shownArray[0];
                        }
                        array_push($this->badWords, $value);
                        $newstr = substr_replace($ocr[0], implode($shuffleText), $start, strlen($value));
                    }
                }
            }

            return $newstr ? $newstr :  $ocr[0];
        }, $text);
        $this->convertedText = $text;
        return $text;
    }
    public function getText()
    {
        return $this->text;
    }
    public function getConvertedText()
    {
        if (isset($this->convertedText))
            return $this->convertedText;
        else {
            throw new Exception('First must call convert method');
            return false;
        }
    }
    public function getHiddenWordsGroup()
    {

        $groupedBadWords = array();
        foreach ($this->badWords as $k => $words) {
            if (!key_exists(strtolower($words), $groupedBadWords)) {
                $groupedBadWords[strtolower($words)] = 0;
            }
            $groupedBadWords[strtolower($words)] += 1;
        }

        return $groupedBadWords;
    }
    public function getHiddenWords($filter = null)
    {
        if (isset($filter) || $filter !== null) {
            return (array_filter($this->badWords, fn ($item) => $item == $filter));
        } else
            return ($this->badWords);
    }
    public function getAllWords($filter = null)
    {
        return (isset($filter) || $filter !== null ? $this->allWords[$filter] : $this->allWords);
    }
}
