<?php
/** @var array $scriptProperties */
/** @var easyComm $easyComm */
if (!$easyComm = $modx->getService('easyComm', 'easyComm', $modx->getOption('ec_core_path', null, $modx->getOption('core_path') . 'components/easycomm/') . 'model/easycomm/', $scriptProperties)) {
    return 'Could not load easyComm class!';
}
$easyComm->initialize($modx->context->key, $scriptProperties);

$tplForm = $modx->getOption('tplForm', $scriptProperties, 'tpl.ecForm');
$formId = $modx->getOption('formId', $scriptProperties, '');
$thread = $modx->getOption('thread', $scriptProperties, '');
if(empty($thread)) {
    $thread = 'resource-'.$modx->resource->get('id');
    $scriptProperties['thread'] = $thread;
}
if(empty($formId)) {
    $formId = $thread;
    $scriptProperties['formId'] = $formId;
}

// Prepare ecThread
/** @var ecThread $thread */
if (!$thread = $modx->getObject('ecThread', array('name' => $thread))) {
    $thread = $modx->newObject('ecThread');
    $thread->fromArray(array(
        'resource' => $modx->resource->id,
        'name' => $thread,
        'title' => $modx->getOption('threadTitle', $scriptProperties, ''),
    ));
}
$thread->set('properties', $scriptProperties);
$thread->save();

$data = array(
    'fid' => $formId,
    'thread' => $thread->get('name'),
    'antispam_field' => $modx->getOption('antispamField', $scriptProperties)
);


return $modx->getChunk($tplForm, $data);