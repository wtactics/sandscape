</div>
<div id="footer">
    <p>
        &copy <?php echo date('Y'), '&nbsp;', $this->getSiteTitle(); ?>, <?php echo $this->getTranslatedString('STAY_GENERAL_USING'); ?> <a href="http://code.google.com/p/stay-simple-cms/" target="_blank">StaySimple</a> <?php echo SSVERSION; ?>.&nbsp;<a href="http://code.google.com/p/stay-simple-cms/wiki/AdministrationUI" target="_blank"><?php echo $this->getTranslatedString('STAY_GENERAL_DOCUMENTATION'); ?></a>.
    </p>
    <!-- //TODO: add version check -->
    <?php if(false) { ?>
    <p class="ui-corner-all ui-state-highlight">
        <?php echo $this->getTranslatedString('STAY_GENERAL_NEW_VERSION_AVAILABLE'); ?> <a href="#"><?php echo $this->getTranslatedString('STAY_GENERAL_NEW_VERSION_DOWNLOAD'); ?></a>
    </p>
    <?php } ?>
</div>
</body>
</html>