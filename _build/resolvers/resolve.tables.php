<?php

if ($object->xpdo) {
    /** @var modX $modx */
    $modx =& $object->xpdo;

    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            $modelPath = $modx->getOption('easycomm_core_path', null, $modx->getOption('core_path') . 'components/easycomm/') . 'model/';
            $modx->addPackage('easycomm', $modelPath);

            $manager = $modx->getManager();
            $objects = array(
                'ecThread',
                'ecMessage',
            );
            foreach ($objects as $tmp) {
                $manager->createObjectContainer($tmp);
            }

            $level = $modx->getLogLevel();
            $modx->setLogLevel(xPDO::LOG_LEVEL_FATAL);
            $manager->addField('ecMessage', 'ip');
            $manager->addField('ecMessage', 'rating');

            $manager->addField('ecThread', 'rating_simple');
            $manager->addField('ecThread', 'rating_wilson');
            //$manager->addField('ecThread', 'rating_custom');


            $modx->setLogLevel($level);

            break;

        case xPDOTransport::ACTION_UNINSTALL:
            break;
    }
}
return true;
