<?php
    //厳格なチェック javascriptで使うuseStrictモードと一緒
    declare(strict_types=1);

    //データベース接続
    $username = "udemy_user";
    $password = "udemy_pass";
    $hostname = "db";
    $db       = "udemy_db";

    $pdo = new PDO("mysql:host={$hostname};dbname={$db};charset=utf8", $username, $password);

    $id = "";
    $nameKana = "";
    $gender = "";
    $whereSql = "";
    $params = [];
    $errorMessage = "";
    $successMessage = "";

    //post送信かつ削除ボタン押下
    if (mb_strtolower($_SERVER["REQUEST_METHOD"]) == "post") {
        //trueなら削除ボタンが押されたとゆうこと
        $isDelete = (isset($_POST["delete"]) && $_POST["delete"] === "1") ? true : false;

        if ($isDelete === true) {
            //postされた社員番号の確認
            $deleteId = isset($_POST["id"]) ? $_POST["id"] : "";
            //空白ではないか？
            if ($deleteId === "") {
                $errorMessage .= "不正な社員番号です <br>";
            } else if (!preg_match('/\A[0-9]{6}\z/',$deleteId)) {
                $errorMessage .= "不正な社員番号です <br>";
            } else {
                //社員番号が正しいか？
                $sql = "SELECT COUNT(*) AS count FROM users WHERE id = :id";
                $param = array("id" => $deleteId);
                $stmt = $pdo -> prepare($sql);
                $stmt -> execute($param);
                $count = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($count["count"] === "0") {
                    $errorMessage .= "不正な社員番号です <br>";
                }
            }
            //入力チェックOK?
            if ($errorMessage === "") {
                echo "エラーなし";
                //トランザクション開始
                $pdo->beginTransaction();
                //社員情報の削除
                $sql = "DELETE FROM users WHERE id = :id";
                $param = array("id" => $deleteId);
                $stmt = $pdo -> prepare($sql);
                $stmt -> execute($param);
                //コミット
                $pdo->commit();

                $successMessage = "削除が完了しました";
            } else {
                //エラーあり
                echo $errorMessage;
            }
        }
    }

    //検索条件が指定されている場合
    if (isset($_GET["id"]) && isset($_GET["name_kana"])) {
        $id = $_GET["id"];
        $nameKana = $_GET["name_kana"];
        $gender = isset($_GET["gender"]) ? $_GET["gender"] : "";
    }

    //社員番号が入力されている場合
    if ($id !== "") {
        //検索条件として社員番号を追加
        // .=（ドット・イコール）は、結合代入演算子となり代入演算子の一つとなります
        //簡単にゆうとどんどん連結させていく
        $whereSql .= "AND id = :id";
        $params["id"] = $id;
    }
    //社員名のカナが入力されている場合
    if ($nameKana !== "") {
        //検索条件として名前のカナを追加
        $whereSql .= "AND name_kana LIKE :name_kana";
        $params["name_kana"] = $nameKana . "%";
    }
    //社員名の性別が入力されている場合
    if ($gender !== "") {
        //検索条件として性別を追加
        $whereSql .= "AND gender = :gender";
        $params["gender"] = $gender;
    }


    //件数取得のSQL
    //変動値がない場合（queryを使う）
    //変動値がある場合（prepare、bindValue、executeを使う）
    $sql = "SELECT COUNT(*) AS count FROM users WHERE 1 = 1 {$whereSql}";
    // $params = [];
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    // var_dump($count);

    //社員情報取得のSQL
    $sql = "SELECT * FROM users WHERE 1 = 1 {$whereSql} ORDER BY id ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    // while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    //     // var_dump($row);
    // }
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>社員検索</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<link rel="stylesheet" type="text/css" href="/css/style.css" />
</head>
<body>

<div id="header">
    <h1>社員管理システム</h1>
</div>

<div class="clearfix">
    <div id="menu">
        <h3>メニュー</h3>
        <div class="sub_menu">社員検索</div>
        <div class="sub_menu"><a href="input.php">社員登録</a></div>
    </div>

    <div id="main">
        <h3 id="title">社員検索画面</h3>
    
        <div id="search_area">
        <div id="sub_title">検索条件</div>
        <form action="search.php" method="GET">
            <div id="form_area">
            <div class="clearfix">
                <div class="input_area">
                <span class="input_label">社員番号(完全一致)</span>
                <!-- ！！！！！htmlspecialchars()これを使うことでクロスサイトスクリプティングを防げるので必ず使用する -->
                <input type="text" name="id" value="<?php echo htmlspecialchars($id); ?>" />
                </div>
                <div class="input_area">
                <span class="input_label">社員名カナ(前方一致)</span>
                <input type="text" name="name_kana" value="<?php echo htmlspecialchars($nameKana); ?>" />
                </div>
                <div class="input_area"><span class="input_label">性別</span>
                <input type="radio" name="gender" value="男性" id="gender_male" <?php echo $gender === "男性" ? "checked" : ""; ?>>
                <label for="gender_male">男性</label>
                <input type="radio" name="gender" value="女性" id="gender_female" <?php echo $gender === "女性" ? "checked" : ""; ?>>
                <label for="gender_female">女性</label>
                </div>
            </div>

            <div class="clearfix">
                <div class="input_area_right"><input type="submit" id="search_button" value="検索"></div>
            </div>
            </div>
        </form>
        </div>

        <?php //メッセージ表示?>

        <?php //(例)社員番号が不正です?>
        <?php if ($errorMessage !== "") { ?>
            <p class="error_message"><?php echo $errorMessage; ?></p>
        <?php }?>

        <?php //(例)削除が完了しました?>
        <?php if($successMessage !== "") {?>
            <p class="success_message"><?php echo $successMessage; ?></p>
        <?php }?>

        <?php //件数表示 ?>
        <div id="page_area">
        <div id="page_count"><?php echo $count["count"];?>件ヒットしました</div>
        </div>

        <div id="search_result">
        <table>
            <thead>
            <tr>
                <th>社員番号</th>
                <th>社員名</th>
                <th>性別</th>
                <th>部署</th>
                <th>役職</th>
                <th>電話番号</th>
                <th>メールアドレス</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php //件数が1件以上 ?>
            <?php if ($count["count"] >= 1) { ?>
            <?php //社員情報取得結果を1行ずつ読込、終端まで繰り返し ?>
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                        <?php //社員情報の表示 ?>
                        <td><?php echo htmlspecialchars($row["id"]); ?></td>
                        <td><?php echo htmlspecialchars($row["name"]);?></td>
                        <td><?php echo htmlspecialchars($row["gender"]);?></td>
                        <td><?php echo $row["organization"] ;?></td>
                        <td><?php echo $row["post"] ;?></td>
                        <td><?php echo $row["tel"] ;?></td>
                        <td><?php echo $row["mail_address"] ;?></td>
                        <td class="button_area">
                        <button class="edit_button">編集</button>
                        <button class="delete_button" onClick="deleteUser('<?php echo htmlspecialchars($row["id"]); ?>');">削除</button>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
        </div>
    </div>
</div>

<form action="search.php" name="delete_form" method="POST">
    <input type="hidden" name="id" value="">
    <input type="hidden" name="delete" value="1">
</form>

<script>
    function deleteUser(id) {
        //削除確認ダイアログの表示
        //Window.confirm() メソッドは、メッセージと、OK, キャンセルの 2 つのボタンを持つモーダルダイアログを表示します。
        if (!window.confirm("社員番号[" + id + "]を削除してもよろしいですか？")) {
            ///キャンセルが押された時処理が終了
            return false;
        }
        //okが押されたらhidden項目[id]に社員番号をセットして送信
            document.delete_form.id.value = id;
            document.delete_form.submit();
    }
</script>
</body>
</html>