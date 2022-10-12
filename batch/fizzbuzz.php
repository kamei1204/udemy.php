<?php
    // 入力値を受け取る
    $value = $argv[1];
    
    if ($value % 3 === 0 && $value % 5 === 0) {
        // 3と5で割り切れる場合はFizzBuzzを出力
        echo "FizzBuzz\n";
    }
    else if ($value % 3 === 0) {
        // 3で割り切れる場合はFizzを出力
        echo "Fizz\n";
    }
    else if ($value % 5 === 0) {
        // 5で割り切れる場合はBuzzを出力
        echo "Buzz\n";
    }
    else {
        // 入力値を出力
        echo "$value\n";
    };
?>