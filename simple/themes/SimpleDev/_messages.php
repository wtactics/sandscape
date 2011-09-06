<?php
$messages = $this->getMessages();
if (count($messages)) {
    foreach ($messages as $message) {
        if ($message->getType() == Message::$ERROR) {
            ?>
            <p class="ui-state-error">
                <span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span><?php echo $message->getMessage(); ?>
            </p>       
            <?php
        } else if ($message->getType() == Message::$SUCESS) {
            ?>
            <p class="ui-state-highlight">
                <span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-info"></span><?php echo $message->getMessage(); ?>
            </p>
            <?php
        }
    }
}
?>