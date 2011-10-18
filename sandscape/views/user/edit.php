<div class="span-24">
    <h2><?php echo ($user->isNewRecord ? 'Create User' : 'Edit User'); ?></h2>
    <?php echo $this->renderPartial('_form', array('user' => $user)); ?>
</div>