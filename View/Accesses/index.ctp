</div>
<div class="well">
<table class="table table-bordered" >
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<h4>Access Information </h4>
    <tr>
        <?foreach($fields as $field => $fieldoptions): ?>
            <th><?= $field;?></th> 
        <? endforeach ?>
        <th class="actions" ><?php echo __('Actions'); ?></th>
    </tr>
    <?php foreach ($accesses as $access): ?>
    <tr>
        <?foreach($fields as $field => $fieldoptions): ?>
            <td><?=  @$access['Access'][$field]?></td>
        <? endforeach ?>
        <td><?php echo $this->Html->link(__('Edit'),
                                         array('action' => 'edit',
                                               $access['Access']['id']),
                                         array('class'=>'btn btn-warning')); ?>
            <?php echo $this->Html->link(__('Delete'),
                                         array('action' => 'delete_access',
                                               $access['Access']['id']),
                                         array('class'=>'btn btn-info')); ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->link(__('ADD Access info'), array('action' => 'add'), array('class'=>'btn btn-warning')); ?>
</div>