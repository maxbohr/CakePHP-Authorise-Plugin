<?= $this->Form->create('Access'); ?>
    <?foreach($fields as $field => $fieldoptions): ?>
        <?= $this->Form->input($field,$fieldoptions);?>
    <? endforeach ?>
    <input type="submit" value="Submit"/>
<?= $this->Form->end() ?>
 