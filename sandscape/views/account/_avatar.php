<?php
//TODO: if url fill in var, else keep it clear
$avatarUrl = null;
if (false) {
    $avatarUrl = $user->avatar;
}

echo CHtml::form($this->createUrl('/account'), 'post', array('enctype' => 'multipart/form-data'));
?>

<div style="float: left; width: 60%;">
    <fieldset>
        <legend>Avatar</legend>
        <div class="formrow">
            You can use any image that has a public URL or upload your own image. 
            Uploaded images will be resized and all images are constraint to <?php echo $avatarSize; ?>.
        </div>
        <div class="formrow">
            <?php
            echo CHtml::label('URL', 'url'),
            CHtml::textField('Avatar[url]', $avatarUrl, array('maxlength' => 255, 'class' => 'large', 'id' => 'url'));
            ?>
        </div>
        <div class="formrow">
            <?php
            echo CHtml::label('File Upload', 'upload'),
            CHtml::fileField('Avatar[ulpload]', null, array('id' => 'upload'));
            ?>
        </div>
    </fieldset>
</div>

<div style="float:right; width: 38%;text-align: center;">
    <fieldset>
        <legend>Current</legend>
        <div class="formrow">
            <?php if ($user->avatar) { ?> 
                <img src="<?php echo $avatarUrl ? $avatarUrl : ('<some base path>/' . $user->avatar); ?>" />
            <?php } ?>
        </div>
    </fieldset>
</div>
<div class="clearfix"></div>

<div class="buttonrow">
    <?php echo CHtml::submitButton('Save', array('class' => 'button')); ?>
</div>
<?php
echo CHtml::endForm();