<?php
//TODO: if url fill in var, else keep it clear
$avatarUrl = null;
if (false) {
    $avatarUrl = $user->avatar;
}

echo CHtml::form($this->createUrl('/account'), 'post', array('enctype' => 'multipart/form-data'));
?>
<fieldset>
    <legend>Avatar</legend>
    <p>
        You can use any image that has a public URL or upload your own image. 
        Uploaded images will be resized and all images are constraint to <?php echo $avatarSize; ?>.
    </p>
    <div class="formrow">
        <?php
        echo CHtml::label('URL', 'url'),
        CHtml::textField('Avatar[url]', $avatarUrl, array('maxlength' => 255, 'class' => 'text', 'id' => 'url'));
        ?>
    </div>
    <p>Or</p>
    <div class="formrow">
        <?php
        echo CHtml::label('File Upload', 'upload'),
        CHtml::fileField('Avatar[ulpload]', null, array('id' => 'upload'));
        ?>
    </div>
</fieldset>

<?php if ($user->avatar) { ?> 
    <fieldset>
        <legend>Current</legend>
        <div class="formrow">
            <img src="<?php echo $avatarUrl ? $avatarUrl : ('<some base path>/' . $user->avatar); ?>" />
        </div>
    </fieldset>
<?php } ?>

<div class="buttonrow">
    <?php echo CHtml::submitButton('Save', array('class' => 'button')); ?>
</div>
<?php
echo CHtml::endForm();