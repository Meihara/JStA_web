<?php session_start();
    if(isset($_SESSION["logged-in"])){
        if($_SESSION["logged-in"] == true){
            if($_SESSION["lang"] == 1){
            header("Location: ../../hu/subpages/hu.hiragana.table.php");
            }
        }
    }
include "../../inc/inc.connection.php";
$conn = new Connection();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/common.stylesheet.css">
    <link rel="shortcut icon" href="../../Project-JStA/wip/logo/index_logo.png"/>
    <link href="../../assets/kana_table_format.css" rel="stylesheet" type="text/css">
    <script src="../../scripts/back.js"></script>
<title>JStA Hiragana table</title>
</head>
    <div align="center">
        <div align="center">
            <form action='en.word.practice.tool.php'>
                <input class='actionButton1' type='submit' name='' value='Back'><br>
            </form>
        </div>
        <h3>Click on a character for more details.</h3>
    <table class="kana_tables">
        <caption><h1>Hiragana table</h1></caption>
  <tr>
    <th></th>
    <th>a</th>
    <th>i</th> 
    <th>u</th>
    <th>e</th>
    <th>o</th>
  </tr>
    <tr>
    <th>-</th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.a.php">あ</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.i.php">い</a></th> 
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.u.php">う</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.e.php">え</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.o.php">お</a></th>
  </tr>
    <tr>
    <th>k</th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.ka.php">か</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.ki.php">き</a></th> 
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.ku.php">く</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.ke.php">け</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.ko.php">こ</a></th>
  </tr>
        <tr>
    <th>s</th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.sa.php">さ</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.shi.php">し<sub>shi</sub></a></th> 
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.su.php">す</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.se.php">せ</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.so.php">そ</a></th>
  </tr>
        <tr>
    <th>t</th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.ta.php">た</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.chi.php">ち<sub>chi</sub></a></th> 
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.tsu.php">つ<sub>tsu</sub></a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.te.php">て</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.to.php">と</a></th>
  </tr>
        <tr>
    <th>n</th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.na.php">な</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.ni.php">に</a></th> 
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.nu.php">ぬ</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.ne.php">ね</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.no.php">の</a></th>
  </tr>
        <tr>
    <th>h</th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.ha.php">は</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.hi.php">ひ</a></th> 
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.fu.php">ふ<sub>fu</sub></a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.he.php">へ</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.ho.php">ほ</a></th>
  </tr>
        <tr>
    <th>m</th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.ma.php">ま</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.mi.php">み</a></th> 
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.mu.php">む</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.me.php">め</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.mo.php">も</a></th>
  </tr>
        <tr>
    <th>y</th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.ya.php">や</a></th>
    <th><a href=""></a></th> 
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.yu.php">ゆ</a></th>
    <th><a href=""></a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.yo.php">ほ</a></th>
  </tr>
        <tr>
    <th>r</th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.ra.php">ら</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.ri.php">り</a></th> 
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.ru.php">る</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.re.php">れ</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.ro.php">ろ</a></th>
  </tr>
        <tr>
    <th>w</th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.wa.php">わ</a></th>
    <th><a href=""></a></th> 
    <th><a href=""></a></th>
    <th><a href=""></a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.wo.php">を</a></th>
  </tr>
        <tr>
    <th>-</th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.n.php">ん<sub>-n</sub></a></th>
    <th><a href=""></a></th> 
    <th><a href=""></a></th>
    <th><a href=""></a></th>
    <th><a href=""></a></th>
  </tr>
  <tr>
    <th class="borderline">g</th>
    <th class="borderline"><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.ga.php">が</a></th>
    <th class="borderline"><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.gi.php">ぎ</a></th> 
    <th class="borderline"><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.gu.php">ぐ</a></th>
    <th class="borderline"><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.ge.php">げ</a></th>
    <th class="borderline"><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.go.php">ご</a></th>
  </tr>
    <tr>
    <th>z</th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.za.php">ざ</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.ji.php">じ<sub>ji</sub></a></th> 
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.zu.php">ず</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.ze.php">ぜ</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.zo.php">ぞ</a></th>
  </tr>
    <tr>
    <th>d</th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.da.php">だ</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.dzi.php">ぢ<sub>dzi</sub></a></th> 
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.dzu.php">づ<sub>dzu</sub></a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.de.php">で</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.do.php">ど</a></th>
  </tr>
        <tr>
    <th>b</th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.ba.php">ば</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.bi.php">び</a></th> 
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.bu.php">ぶ</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.be.php">べ</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.bo.php">ぼ</a></th>
  </tr>
        <tr>
    <th>p</th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.pa.php">ぱ</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.pi.php">ぴ</a></th> 
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.pu.php">ぷ</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.pe.php">ぺ</a></th>
    <th><a href="../../inc/kana/hiragana/inc.kana.hiragana.redirect.po.php">ぽ</a></th>
  </tr>
        
</table>
    </div>
<body>
</body>
</html>