<html lang="en">
<head>
    <title>Select Operating System</title>
    <meta charset="utf-8">
    <meta name="author"      content="Jens Kallup [paule32]">
    <meta name="copyright"   content="Jens Kallup">
    <meta name="description" content="Operating System Desktop in HTML, CSS and JavaScript">

    <meta http-equiv="content-type"  content="text/html; charset=utf-8">
    <meta http-equiv="expires"       content="0">
    <meta http-equiv="cache-control" content="max-age=0">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="pragma"        content="no-cache">

    <link rel="stylesheet" type="text/css" href="/tools/web/css/global.css">
    <link rel="stylesheet" type="text/css" href="/index/css/global.css">

    <script language="javascript" type="text/javascript" src="/tools/web/js/jquery/base/jquery-min.1.12.4.js"></script>
    <script language="javascript" type="text/javascript" src="/index/mod/ready.js"></script>
</head>
<body style="width:100%;height:100%;overflow:hidden;" onload="on_ready()">
    <!-- screen -->
    <div id="container">
        <!-- background -->
        <div id="desktop">
	    <!--iframe src="frame.php" height="200px" width="200px" allowfullscreen></iframe-->
            <div id="BannerText">PLEASE SELECT - O.S.</div>
            <div class="vspacer"></div>
                <div id="CenterBannerBox">
                    <div class="choosenbox">
			<div class="selectbox" id="amigaos"></div><div style="width:20px;float:left">&nbsp;</div>
			<div class="selectbox" id="hpc64os"></div>
                    </div>
                    <div class="vspacer"></div>
                    <div class="choosenbox">
                        <div class="cbox RHand_2"></div>
                        <div class="selectbox show-next-on-hover" id="linuxos"></div>
                        <div class="cbox LHand_2"></div>
                    </div>
                    <div class="vspacer"></div>
                    <div class="choosenbox">
                        <div class="cbox RHand_3"></div>
                        <div class="selectbox show-next-on-hover" id="msdosos"></div>
                        <div class="cbox LHand_3"></div>
                    </div>
                    <div class="vspacer"></div>
                    <div class="choosenbox">
                        <div class="cbox RHand_4"></div>
                        <div class="selectbox show-next-on-hover" id="mswinos"></div>
                        <div class="cbox LHand_4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>