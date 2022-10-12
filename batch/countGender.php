<?php
    // <!-- csvファイルのオープンとくろーず --> 
    // <!-- &fp =fopen("開きたいファイル", "モード").モード:r(読み込み),w(書き込み),a(追記書き込み) -->
    // <!-- __DIR__ = マジカルパス = 現在のフォルダの絶対パスを返してくれる = これがないとエラーになる -->
    // <!-- fgetcsv = csvファイルを取り出す関数 -->
    // input.csvを読み込む
    $fp = fopen(__DIR__."/input.csv","r");
    $lineCount = 0;
    $man = 0;
    $woman = 0;   
    // 読み込んだ情報を一行ずつ取り出す
    while ($data = fgetcsv($fp)) {
        // 一行ずつ読み込む
        $lineCount++;
        if($lineCount === 1) {
            // 次の行へ進む
            continue;
        }
        // var_dump($data);
        // 男性? or 女性?
        if ($data[4] === "男性") {
            $man++;
        } else {
            $woman++;
        }
    }

    // 読み込み終了
    fclose($fp);

    // debug
    echo "{ $man },{ $woman }";

    //出力ファイルオープン
    $fpo = fopen(__DIR__ . "/output.csv","w");

    $header = ["男性","女性"];
    fputcsv($fpo,$header);

    $count = [$man,$woman];
    fputcsv($fpo,$count);

    fclose($fpo);
?>