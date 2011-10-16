<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('gameId')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->gameId), array('view', 'id' => $data->gameId)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('player1')); ?>:</b>
    <?php echo CHtml::encode($data->player1); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('player2')); ?>:</b>
    <?php echo CHtml::encode($data->player2); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
    <?php echo CHtml::encode($data->created); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('started')); ?>:</b>
    <?php echo CHtml::encode($data->started); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('ended')); ?>:</b>
    <?php echo CHtml::encode($data->ended); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('running')); ?>:</b>
    <?php echo CHtml::encode($data->running); ?>
    <br />

    <?php /*
      <b><?php echo CHtml::encode($data->getAttributeLabel('deck1')); ?>:</b>
      <?php echo CHtml::encode($data->deck1); ?>
      <br />

      <b><?php echo CHtml::encode($data->getAttributeLabel('deck2')); ?>:</b>
      <?php echo CHtml::encode($data->deck2); ?>
      <br />

      <b><?php echo CHtml::encode($data->getAttributeLabel('private')); ?>:</b>
      <?php echo CHtml::encode($data->private); ?>
      <br />

     */ ?>

</div>