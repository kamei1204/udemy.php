<?php

// インポート
    require_once("libraly/log.php");
    $logFile = __DIR__ . "/log/import_users.log";

    writeLog($logFile, "ログ開始");
    $dataCount = 0;

    //データベース接続
    $username = "udemy_user";
    $password = "udemy_pass";
    $hostname = "db";
    $db       = "udemy_db";

    $pdo = new PDO("mysql:host={$hostname};dbname={$db};charset=utf8", $username, $password);
    //社員情報csvオープン(読み込み)
    $fp = fopen(__DIR__. "/import_users.csv","r");
    //トランザクション開始
    $pdo->beginTransaction();
    //一行ずつ読み込み、終端まで繰り返す
    while ($data = fgetcsv($fp)) {
        //社員番号をkeyに社員情報sqlを実行
        $sql = "SELECT COUNT(*) AS count FROM users WHERE id = :id";
        $params = [":id" => $data[0]];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // debug
        // var_dump($data[0]);
        // var_dump($result);
        //sqlの検索結果は0件?
        if($result["count"] === "0") {
            var_dump($data[0]);
            var_dump("登録");
        } else {
            var_dump($data[0]);
            var_dump("更新");
        }
        //社員情報登録のSQLの実行
    
        //社員情報更新のSQLの実行
        $dataCount++;
    }


    //コミット
    $pdo->commit();
    //社員情報csvをクローズ
    fclose($fp);

    writeLog($logFile, "ログ終了{$dataCount}件");

?>