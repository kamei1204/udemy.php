<?php
    /**
     * 後で見返したときに関数の役割がすぐ解るように書いておくのがいい
     * 
     * ログを出力する 
     * 
     * @param string 出力するファイル名
     * @param string 出力するメッセージ
     * @return void
     */
    function writeLog($fileName,$message) {
        $now = date("Y/m/d,H:i:s");
        $log = "{$now} {$message}\n";

        $fp = fopen($fileName, "a");
        fwrite($fp,$log);
        fclose($fp);
    }

?>