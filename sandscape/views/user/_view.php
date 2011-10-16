<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('userId')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->userId), array('view', 'id' => $data->userId)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
    <?php echo CHtml::encode($data->email); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('password')); ?>:</b>
    <?php echo CHtml::encode($data->password); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
    <?php echo CHtml::encode($data->name); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('admin')); ?>:</b>
    <?php echo CHtml::encode($data->admin); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('active')); ?>:</b>
    <?php echo CHtml::encode($data->active); ?>
    <br />


</div>