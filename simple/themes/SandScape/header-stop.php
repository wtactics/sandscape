<title><?php echo Config::getInstance()->get('site.name'); ?></title>
</head>

<body>
    <div id="wrap">
        <div id="top">
            <h2><a href="#" title="Back to main page"><?php echo Config::getInstance()->get('site.name'); ?></a></h2>
            <div id="menu">
                <?php echo $this->getMainMenuSection(); ?>
            </div>
        </div>