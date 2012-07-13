XOOPSに適切なメタ情報とOGPを付加するカスタマイズ

================================================================
説明
================================================================
OGPというのはThe Open Graph protocolの略でフェイスブックを始めmixiやGoogle＋等のSNSとウェブページを連携させるための情報をコンピュータが読めるように記述したものだそうで、従来から言われるメタ情報とともに適切に設定することで、そのサイトの情報を正確に伝えることが出来るため、最近とみに重要度が増しているものです。

しかし、XOOPS Cube では、管理画面でサイト統一の固定した内容をメタ情報として設定できるだけで、ページごとに適した内容を付加することはできませんでしたし、OGPについては設定することすらできない状況です。

Wordpressなどでは、プラグインを追加するだけで、OGPを適切に追記できるような機能があるようですので、何とかならないかと考えて作ったのが、今回のカスタマイズです。

プラグインを追加してとか、プリロードだけでできないかと、考えてみたのですが、そこまでの簡易化はちょっとできなかったものの、何とか使えるものが出来たように思うので、今回公開することとしました。


================================================================
インストール＋カスタマイズ
================================================================
利用するには、まず、解凍してできあがったディレクトリにある html/common/ogp ディレクトリをサイトのhtml側にコピーしてください。

お使いのテーマ（theme.html）のメタ情報部分等を下記要領で書き換えて下さい。もちろん、何かあったときのために、あらかじめカスタマイズするテーマのバックアップを取ることをお忘れなく。

★１ <html>の書き換え

★★HTML5の場合
<html>
を
<html lang="<{$xoops_langcode}>" prefix="og: http://ogp.me/ns#">
に書き換える。


★★それ以外の場合は、
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<{$xoops_langcode}>" lang="<{$xoops_langcode}>">
を
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" version="XHTML+RDFa 1.0" xml:lang="<{$xoops_langcode}>" dir="ltr" xmlns:fb="https://www.facebook.com/2008/fbml">
に書き換える。


★２ metaタグ等の書き換え

<head>より下にある metaタグ（keywords,robots,description,rating,author,copyright)と<title>記述部分を削除して、次の1行を挿入してください。

<{include file="`$smarty.const.XOOPS_ROOT_PATH`/common/ogp/meta_add.html"}>


また、解凍したディレクトリの html/common/ogp には、OGPのimage 情報として表示される user.gif のサンプル画像入っていますが、この画像について、あなたのサイトを特徴づける画像と差し替えてください。できればサイズは、200ピクセル四方のものが良いようです。（サンプルは小さいものとなっていますが）
画像について、違うファイル名の場合は、テーマに記述する当該画像部分のファイル名称を変更してください。


メタ情報とOGPについては、meta_info.html 内にてモジュールごとの表示分岐を設定しておりますが、基本設定として
	<{$xoops_pagetitle}> と <{$xoops_meta_keywords}> と <{$xoops_meta_description}>
などのsmarty変数を利用しているため、場合によってはページに適さないものとなる場合があると思います。
その場合には、meta_info.html を編集していただき、モジュールやページにふさわしいキーワードなどを直接記述していただくことで対応可能となります。

メタ情報の書き方は，区切り文字 || を挟んで，「ページタイトル」||「METAタグ（キーワード）」||「METAタグ（Description）説明」の順を守って記述してください。情報記入のない場合は、XOOPSの管理画面で設定した内容が入ります。モジュールによっては、descriptionに記事に応じた内容が入るものもあります。

例えば、bulletinなどでは、個別記事を表示した場合には、記事のタイトルと本文が <{$xoops_pagetitle}> と <{$xoops_meta_description}> などに入りますので、適切な表示となると思いますが、トップページ表示の場合は、XOOPSの管理画面で設定した内容が入るため、bulletinのトップページとしてふさわしくない場合があります。meta_info.html には、とりあえず説明サンプルを記入していますが、貴方のサイトに合うような内容に変更してご利用ください。

<{elseif $xoops_dirname == "bulletin"}>
	<{if substr($xoops_requesturi,-9) == '/index.php' or substr($xoops_requesturi,-1) == '/'}>
		ここはお知らせのトップページです。||ここはお知らせのキーワード||ここにはお知らせの説明を書きましょう
	<{else}><{* bulletinは、トップページ以外は本文がdescriptionに挿入される *}>
		<{$xoops_pagetitle}>||<{$xoops_meta_keywords}>||<{$xoops_meta_description}>
	<{/if}>

