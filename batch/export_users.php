<?php

    // データベース接続し情報を取得
    $username = "udemy_user";
    $password = "udemy_pass";
    $hostname = "db";
    $db       = "udemy_db";
    // PDO = PHP Data Object
    $pdo = new PDO("mysql:host={$hostname};dbname={$db};charset=utf8", $username, $password);

    // 情報取得のsql分を実行
    //usersからORDER BY(降順)で全てのデータを取得
    $sql = "SELECT * FROM users ORDER BY id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // sqlの結果を一行ずつ読み込んで、終端まで繰り返す
    // 出力データの作成
    // dataを入れる箱
    $outputData = [];
    $outputCount = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $outputData[$outputCount]["id"] = $row["id"];
        $outputData[$outputCount]["name"] = $row["name"];
        $outputData[$outputCount]["name_kana"] = $row["name_kana"];
        $outputData[$outputCount]["birthday"] = $row["birthday"];
        $outputData[$outputCount]["gender"] = $row["gender"];
        $outputData[$outputCount]["organization"] = $row["organization"];
        $outputData[$outputCount]["post"] = $row["post"];
        $outputData[$outputCount]["start_date"] = $row["start_date"];
        $outputData[$outputCount]["tel"] = $row["tel"];
        $outputData[$outputCount]["mail_address"] = $row["mail_address"];
        $outputData[$outputCount]["created"] = $row["created"];
        $outputData[$outputCount]["updated"] = $row["updated"];
        $outputCount++;
        // var_dump($row);
    }

    //debug
    // var_dump($outputData);

    //出力ファイルオープン
    $fpOut = fopen(__DIR__. "/export_users.csv","w");

    // ヘッダー行書き込み
    $header = [
        "番号",
        "社員名",
        "カナ",
        "誕生日",
        "性別",
        "部署",
        "役職",
        "入社日",
        "電話番号",
        "メールアドレス",
        "作成日",
        "更新日",
    ];

    //データ出力
    fputcsv($fpOut,$header);

    //データの繰り返し
    foreach ($outputData as $data) {
        # データの書き込み
        fputcsv($fpOut,$data);
    }

    //出力ファイルを閉じる
    fclose($fpOut);




?>