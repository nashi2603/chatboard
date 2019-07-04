<?php
try {
    $pdo = new PDO('sqlite:./db/handson_db.sqlite');

    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $pdo->exec("CREATE TABLE IF NOT EXISTS handson_ita(id INTEGER PRIMARY KEY, myname TEXT, msg TEXT, submit_time TEXT)");
} catch (Exception $e) {
    echo $e->getMessage().PHP_EOL;
}
?>
<html lang="ja">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link href="./css/bootstrap.min.css" rel="stylesheet">
        <script src="./js/jquery-3.4.1.js"></script>
        <script src="./js/bootstrap.min.js"></script>
        <script src="./js/prototype.js"></script>
        <title>Hands-On掲示板</title>
    </head>
    <body>
        <script type="text/javascript" src="./reloadscript.js"></script>
        <nav class="navbar navbar-dark bg-dark fixed-top">
            <a href="#" class="navbar-brand">Hands-On 掲示板</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navmenu1" aria-controls="navmenun1" aria-expanded="false" aria-label="Toggle navigation">
                <span class="text-white m-2">投稿</span>
            </button>
            <div class="collapse navbar-collapse" id="navmenu1">
                <div class="navbar-nav">
                    <form action="./index.php" method="post" class="border border-secondary rounded mr-5 ml-5 mt-2">
                        <div class="form-group mr-3 ml-3">
                            <p class="text-white">名前：</p>
                            <input type="text" class="form-control" name="myname" value="名無しのトラブルシューター">
                        </div>
                        <div class="form-group mr-3 ml-3">
                            <p class="text-white">投稿内容：</p>
                            <textarea class="form-control" name="msg"></textarea>
                        </div>
                        <div class="form-group mr-3 ml-3">
                            <input class="btn btn-primary" type="submit" value="送信">
                            <input class="btn btn-primary" type="reset" value="リセット">
                        </div>
                    </form>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="pt-5 pb-5">
                <h1 class="pt-5 pb-3 text-center">トラブルシューターの集まり</h1>
                <div class="alert alert-info p-3" role="alert">
                    <h2>Hello World!</h2>
                    <hr>
                    <p>トラブルシューターの諸君、掲示板へようこそ。
                    <br>これを表示できたということはネットワークが正しく構築され、通信ができている状態ということだ。
                    <br>すぐ下にある入力フォームから自分の名前と何かメッセージを入力して送信ボタンを押してみたまえ。
                    <br>通信の繋がっている者同士ならばその投稿を共に見ることができるだろう。
                    <br>また、右上の投稿ボタンから入力フォームを出すこともできる。
                    </p>
                </div>
                <div class="pt-3 pb-3">
                    <form action="./index.php" method="post" class="border border-secondary rounded pr-5 pl-5 pt-2" name="inmsg">
                        <div class="form-group">
                            <p>名前：</p>
                            <input type="text" class="form-control" name="myname" value="名無しのトラブルシューター">
                        </div>
                        <div class="form-group">
                            <p>投稿内容</p>
                            <textarea class="form-control" name="msg"></textarea>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" value="送信">
                            <input class="btn btn-primary" type="reset" value="リセット">
                        </div>
                        <?php
                        try {
                            // if ($_POST['myname'] == '') {
                            //     $myname = "名無しのトラブルシューター";
                            // } else {
                            //     $myname = $_POST['myname'];
                            // }
                            if (($_POST['myname'] != '') and ($_POST['msg'] != '')) {
                                $myname = str_ireplace("<script>", "&lt;script&gt;", $_POST['myname']);
                                $myname = str_ireplace("</script>", "&lt;/script&gt;", $myname);
                                $msg = str_ireplace("<script>", "&lt;script&gt;", $_POST['msg']);
                                $msg = str_ireplace("</script>", "&lt;/script&gt;", $msg);
                                date_default_timezone_set('Asia/Tokyo');
                                $s = $pdo->prepare("insert into handson_ita values(NULL, ?, ?, ?);");
                                $s->bindParam(1, $myname);
                                $s->bindParam(2, $msg);
                                $s->bindParam(3, date("Y/m/d H:i:s"));
                                $s->execute() or die("<p>書き込みに失敗しました。</p>");
                                echo "<script>formreset()</script>";
                                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                    header('Location: '.$_SERVER['SCRIPT_NAME'], true, 303);
                                }
                            } elseif (($_POST['myname'] != '') or ($_POST['msg'] != '')) {
                                // echo "<script>alert(\"名前欄もしくは内容欄が未記入です。\")\;</script>";
                                echo "<div class=\"alert alert-danger\"><p>名前欄もしくは内容欄が未記入です。</p></div>";
                                echo "<script>formreset()</script>";
                                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                    header('Location: '.$_SERVER['SCRIPT_NAME'], true, 303);
                                }
                            }
                        } catch (Exception $e) {
                            echo $e->getMessage().PHP_EOL;
                        }
                        ?>
                    </form>
                </div>
                <div class="pr-3 pl-3" id="handsonthreadtable">

                </div>
            </div>
        </div>
    </body>
</html>