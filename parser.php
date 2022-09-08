<?php
require_once './cache.php';
require_once 'phpQuery//phpQuery.php';
$linkAvito=$_POST['link'];
$host = 'localhost'; // имя хоста
$user = 'root'; // имя пользователя
$pass = 'root'; // пароль
$name = 'avito'; // имя базы данных
$link = mysqli_connect($host, $user, $pass, $name);

$query ="CREATE TABLE `avitotable` (
    `id` int(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `dates` text NOT NULL,
    `view` text NOT NULL,
    `user` text NOT NULL,
    `link` text NOT NULL
  )";
$result=mysqli_query($link, $query) or die(mysqli_error($link));

$parser = new ParserCurl();
$page = $parser->parserQuery("$linkAvito");
$pq = phpQuery::newDocument($page);
$links = $pq->find('.iva-item-sliderLink-uLz1v');
$linksPaginations=$pq->find('.pagination-page');
//ВЫЗЫВАЮ ССЫЛКИ ИЗ ПАГИНАЦИИ
foreach($linksPaginations as $arr)
{
    $pqArr = pq($arr);
    $results[] = $pqArr->html();
    $srcPagination[] = $pqArr->attr('href');
}

foreach( $srcPagination as $src)
{
    $pagePagination = $parser->parserQuery('https://www.avito.ru' . $src);
    activateParser($pagePagination,$parser);
    
}


function activateParser($page,$parser){
   
    $host = 'localhost'; // имя хоста
    $user = 'root'; // имя пользователя
    $pass = 'root'; // пароль
    $name = 'avito'; // имя базы данных
    $link = mysqli_connect($host, $user, $pass, $name); 


$pq = phpQuery::newDocument($page);
$links = $pq->find('.iva-item-sliderLink-uLz1v');
foreach ($links as $arr)
{
    $pqArr = pq($arr);
    $results[] = $pqArr->html();
    $src[] = $pqArr->attr('href');
}

foreach ($src as $item)
{

    $avito = 'https://www.avito.ru' . $item;
    $dom = new DomDocument('1.0', 'UTF-8');
    $internalErrors = libxml_use_internal_errors(true);
    $htm = $parser->parserQuery($avito);
    $dom->loadHTML($htm);
    libxml_use_internal_errors($internalErrors);
    $xpath = new DomXPath($dom);
    $resDate = $xpath->query('//span[@class="text-text-1PdBw text-size-s-1PUdo" and @data-marker="item-view/item-date"]');
    $resView = $xpath->query('//span[@class="text-text-1PdBw text-size-s-1PUdo" and @data-marker="item-view/total-views"]');
    $resUsers = $xpath->query('//div[@data-marker="seller-info/label"]');


 
    $resArrDate=addRes($resDate);
    $resArrView=addRes($resView);
    $resArrUsers=addRes($resUsers);
    $arrResult[] = [$resArrDate, $resArrView, $resArrUsers, $avito];

}
foreach ($arrResult as $arr)
{
    $arrDate = $arr[0];
    $arrDates = substr($arrDate, 4); ;
    $arrViews = $arr[1];
    $arrUsers = $arr[2];
    $arrAvito = $arr[3];
    $query = "INSERT INTO avitotable (dates,view,user,link) VALUES ('$arrDates','$arrViews','$arrUsers','$arrAvito')";
    $result=mysqli_query($link, $query) or die(mysqli_error($link));
}
require_once './utilite/patchFileExcel.php';
}
function addRes($arrs)
{
    foreach ($arrs as $node)
    {
        $resArr = iconv("UTF-8", "ISO-8859-1//IGNORE", $node->nodeValue);
    }
    return $resArr;
}

