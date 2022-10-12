<?php
    //厳格なチェック
    declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>社員登録</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="header">
        <h1>社内管理システム</h1>
    </div>
    <div class="clearfix">
        <div id="menu">
            <h3>メニュー</h3>
            <div class="sub_menu"><a href="./search.php">社員検索</a></div>
            <div class="sub_menu">社員登録</div>
        </div>

        <div id="main">
            <h3 id="title">社員登録画面</h3>

            <div id="input_area">
                <form action="input.php" method="POST">
                    <p><strong>社員情報を登録してください。全て必須です</strong></p>
                    <?php //メッセージ表示?>
                    <?php //(例)社員名を入力してください?>
                    <?php //(例)社員名を50文字以内で入力してください?>
                    <?php //(例)生年月日を正しく入力してください?>
                    <?php //(例)性別を選択してください?>
                    <?php //(例)xxxxxxを入力してください?>
                    <?php //(例)登録が完了しました?>

                    <?php //各入力項目を表示?>
                    <table>
                        <tbody>
                            <tr>
                                <td>社員番号</td>
                                <td><input type="text" name="id" value=""></td>
                            </tr>
                            <tr>
                                <td>社員名</td>
                                <td><input type="text" name="name" value=""></td>
                            </tr>
                            <tr>
                                <td>社員名カナ</td>
                                <td><input type="text" name="name_kana" value=""></td>
                            </tr>
                            <tr>
                                <td>生年月日</td>
                                <td><input type="date" name="birthday" value=""></td>
                            </tr>
                            <tr>
                                <td>性別</td>
                                <td>
                                    <input type="radio" name="gender" value="男性">男性
                                    <input type="radio" name="gender" value="女性">女性
                                </td>
                            </tr>
                            <tr>
                                <td>部署</td>
                                <td>
                                    <select name="organization">
                                        <option value="営業部">営業部</option>
                                        <option value="人事部">人事部</option>
                                        <option value="総務部">総務部</option>
                                        <option value="システム開発1部">システム開発1部</option>
                                        <option value="システム開発2部">システム開発2部</option>
                                        <option value="システム開発3部">システム開発3部</option>
                                        <option value="システム開発4部">システム開発4部</option>
                                        <option value="システム開発5部">システム開発5部</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>役職</td>
                                <td>
                                    <select name="post">
                                        <option value="部長">部長</option>
                                        <option value="次長">次長</option>
                                        <option value="課長">課長</option>
                                        <option value="一般">一般</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>生年月日</td>
                                <td><input type="date" name="start_date" value=""></td>
                            </tr>
                            <tr>
                                <td>電話番号(ハイフンなし)</td>
                                <td><input type="text" name="tel" value=""></td>
                            </tr>
                            <tr>
                                <td>メールアドレス</td>
                                <td><input type="text" name="mail_address" value=""></td>
                            </tr>
                            <div class="clearfix">
                                <div class="input_area_right">
                                    <input type="hidden" name="save" value="1">
                                    <input type="submit" id="input_button" value="登録">
                                    <input type="button" id="back_button" value="戻る" onClick="location.href='search.php'; return false;">
                                </div>
                            </div>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>