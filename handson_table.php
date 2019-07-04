<?php
try {
    $pdo = new PDO('sqlite:./db/handson_db.sqlite');

    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $pdo->exec("CREATE TABLE IF NOT EXISTS handson_ita(id INTEGER PRIMARY KEY, myname TEXT, msg TEXT, submit_time TEXT)");
} catch (Exception $e) {
    echo $e->getMessage().PHP_EOL;
}

try {
    echo "<h2><strong>スレッド</strong></h2>";
    foreach($pdo->query("select * from handson_ita order by id desc;") as $a) {
        echo "<div class=\"card mt-3 mb-3\"><div class=\"card-header\">", $a['id'], " 名前: ", $a['myname'], "</div><div class=\"card-body\">", $a['msg'], "</div><div class=\"card-footer\"><small>", $a['submit_time'], "</small></div></div>";
    }
    echo "<hr>";
} catch (Exception $e) {
    echo $e->getMessage().PHP_EOL;
}
?>