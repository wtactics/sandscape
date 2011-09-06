<html>
<head>
    <title>Welcome to Rapyd <?php echo RAPYD_VERSION?></title>
    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: "Lucida Grande", Verdana, Geneva, Sans-serif;
            font-size: 14px;
            color: #4F5155;
            background-color: #fff;
        }
        a {
            color: #003399;
            background-color: transparent;
            text-decoration: none;
            font-weight: normal;
        }
        a:visited {
            color: #003399;
            background-color: transparent;
            text-decoration: none;
        }
        a:hover {
            color: #000;
            text-decoration: underline;
            background-color: transparent;
        }
        small {background-color: #ececec; padding: 5px;}
    </style>
		<script language="javascript" type="text/javascript" src="%s"></script>
</head>
<body>
    <h1>Welcome to rapyd-framework <?=RAPYD_VERSION?></h1>
    <p>Congradulations! Rapyd is setup and working correclty.</p>
	<p>See some <a href="<?php echo rpd::url('demo')?>">Demo</a></p>

</body>
</html>
