<?php
    /* i-bird 0.2.1 */

    $imageBaseURL = "http://www3.nhk.or.jp/sokuho/jishin/"; 

    $rawReportXML = mb_convert_encoding(file_get_contents("http://www3.nhk.or.jp/sokuho/jishin/data/JishinReport.xml"), "UTF-8", "SJIS"); /* 2 */

    
        $dump = explode("\n", $rawReportXML, 2);
        $rawReportXML = '<?xml version="1.0" encoding="UTF-8" ?>' . $dump[1];
        $xmlData = new SimpleXMLElement($rawReportXML);

    $latestItemURL = $xmlData->record[0]->item[0]["url"]; 

    $rawLatestEarthquake = mb_convert_encoding(file_get_contents($latestItemURL), "UTF-8", "SJIS"); 

    
        $dump = explode("\n", $rawLatestEarthquake, 2);
        $rawLatestEarthquake = '<?xml version="1.0" encoding="UTF-8" ?>' . $dump[1];
        $earthquakeXMLData = new SimpleXMLElement($rawLatestEarthquake);

    $earthquake = $earthquakeXMLData->Earthquake; 
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1;">
        <title>i-bird v.0.2.1</title>
    </head>
    <body>

        <h1><?= $earthquake["Time"] ?>に発生した地震</h1>
        <p>
            震源 : <?= $earthquake["Epicenter"] ?><br />
            震源の深さ : <?= $earthquake["Depth"] ?><br />
            マグニチュード : <?= $earthquake["Magnitude"] ?><br />
            最大震度 : <?= $earthquake["Intensity"] ?>
        </p>

        <h2>震度マップ</h2>
        <img src="<?= $imageBaseURL . $earthquake->Detail ?>" />

        <h2>震度マップ(詳細)</h2>
        <img src="<?= $imageBaseURL . $earthquake->Local ?>" />

        <h2>震度マップ(広域)</h2>
        <img src="<?= $imageBaseURL . $earthquake->Global ?>" />
     
        <p>i-bird v.0.2.1
        <p>(c) 2020 nexryai
    

    </body>
</html>