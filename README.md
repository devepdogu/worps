
# About Worps | PHP!

Control all text in multiple file bad words filter with **worps**

If you try online [Click](https://demos.dogukandemir.website/worps/test/) 



## What to do use for worps
- Create new object
- Worps constructor need files. Give files
 - Call **convert** method. Convert method need filter **text**
 - Convert method return filtered text.



## Files Property

Giving files must are **array** and these arrays must be **path** property 
```php
$files = array(
	["path" => "./files/bad.txt"],
	["path" => "./files/empty.txt" , "separator" => ","]
);
```
> If your files in each words not be new lines giving array inside **separator** property

Example File (not need **separator** property because each word new line)
> File *bad.txt*
```text
bad
word
```
Example File (need **separator** property because each word **not** new line and **separator** property  must be value = **" , "** )
> File *empty.txt*
```text
bad,word
```






## Usage Code

```php
require  './worps.php'; //First we need source file.
$files = array(
["path" => "./files/bad.txt"]
);//Give as you want file with array

$worps = new Worps($files); //Create new Worps object
$text = $worps->convert("i am using bad words right now really BAD");
//convert method return filtered text use $text variable 
print($text);//Output : i am using *** words right now really ***
```

## Methods

**setHeader ( $header )**
```php
$worps->setHeader('Content-type: text/html; charset=utf-8')
```

**getFiles**
```php
$worps->getFiles()
```
> getFiles return all giving files

**getRegExp**
```php
$worps->getRegExp()	
```
> getRegExp return Regular expression has value. Default **value** = **/\w+/**

**setRegExp ( $exp)**
```php
$worps->setRegExp('/\w+i/')
```
**setShownText ( $length = null, $specialChar = false , $isShuffle = false)**
```php
$worps->setShownText(5,false,true)
```
> setShownText method works filtered words how looks
>  - **$length** parameter mean the filtered words how many letter hidden 
>  *If you give **null** value filtered until words hidden self letter*
> - **$specialChar** parameter mean the filtered words how look
> *This parameter need **array***
>   ```php
>   $worps->setShownText(null,['!','#','@'],false)
>   ```
>  - **$isShuffle** parameter mean the filtered words is shuffling 

**getText**
```php
$worps->getText()
```
> This methods return giving **not** converted text

**convert ( $text )**
```php
$text = $worps->convert("i am using bad words right now really BAD");
print($text)//i am using *** words right now really ***
```
> This methods return converted (filtered) text

**getConvertedText**
```php
$worps->getConvertedText()
```
> This methods return converted (filtered) text
> *This methods use before call convert method*

**getHiddenWordsGroup**
```php
$text = $worps->convert("i am using bad words right now really BAD");
print($worps->getHiddenWordsGroup())
//Array ( [bad] => 2)
```

**getHiddenWords ( $filter = null )**
```php
$text = $worps->convert("i am using bad words right now really BAD");
print($worps->getHiddenWords())
//Array ( [0] => bad [1] => bad )
```
>- If  **$filter** parameter giving return filtered words
 ```php
		$text = $worps->convert("i am using bad words right now really 	BAD");
		print($worps->getHiddenWords('break'))
		//Array ()
```

**getAllWords ( $filter = null )**
```php
$text = $worps->convert("i am using bad words right now really BAD");
print($worps->getAllWords())
//Array ( [0] => Array ( [0] => damn [1] => bad ) [1] => Array ( [0] => break ) )
```
>- If **$filter** parameter not giving or giving null return all files in words.Else return giving files index words.
> *This parameter accept **file index***.
 ```php
		$text = $worps->convert("i am using bad words right now really 	BAD");
		print($worps->getAllWords(0))
		//Array([0] => damn [1] => bad)
```

## Screen Shoot

![Uygulama Ekran Görüntüsü](https://dogukandemir.website/img/worps.png)

