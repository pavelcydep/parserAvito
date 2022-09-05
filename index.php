
<?php
require_once './cache.php';

$parser = new ParserCurl();
$page = $parser->parserQuery("https://www.avito.ru/kazan/avtomobili/s_probegom/audi-ASgBAgICAkSGFMjmAeC2Dd6XKA?cd=1&radius=200");
//echo $page;


require_once 'phpQuery//phpQuery.php';

$host = 'localhost'; // имя хоста
$user = 'root'; // имя пользователя
$pass = 'root'; // пароль
$name = 'avito'; // имя базы данных
$link = mysqli_connect($host, $user, $pass, $name);

$arrResult = array();
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

    foreach ($resDate as $node)
    {

        $resArrDate = iconv("UTF-8", "ISO-8859-1//IGNORE", $node->nodeValue);

    }

    foreach ($resView as $node)
    {

        $resArrView = iconv("UTF-8", "ISO-8859-1//IGNORE", $node->nodeValue);

    }

    foreach ($resUsers as $node)
    {

        $resArrUsers = 'Пользователь:' . (iconv("UTF-8", "ISO-8859-1//IGNORE", $node->nodeValue));

    }

    $arrResult[] = [$resArrDate, $resArrView, $resArrUsers, $avito];

}

foreach ($arrResult as $arr)
{
    $arrDate = $arr[0];
    $arrViews = $arr[1];
    $arrUsers = $arr[2];
    $arrAvito = $arr[3];
    $query = "INSERT INTO baseavito (dates,view,user,link) VALUES ('$arrDate','$arrViews','$arrUsers','$arrAvito')";

    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    require_once './utilite/patchFileExcel.php';

}

?>
