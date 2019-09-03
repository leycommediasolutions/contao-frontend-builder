<?php
    $GLOBALS['TL_DCA']['tl_user']['palettes']['admin'] = preg_replace('(([,;}]useCE)([,;{]))i', '$1,frontendbuilder$2', $GLOBALS['TL_DCA']['tl_user']['palettes']['admin']);
    $GLOBALS['TL_DCA']['tl_user']['palettes']['default'] = preg_replace('(([,;}]useCE)([,;{]))i', '$1,frontendbuilder$2', $GLOBALS['TL_DCA']['tl_user']['palettes']['default']);
    $GLOBALS['TL_DCA']['tl_user']['palettes']['group'] = preg_replace('(([,;}]useCE)([,;{]))i', '$1,frontendbuilder$2', $GLOBALS['TL_DCA']['tl_user']['palettes']['group']);
    $GLOBALS['TL_DCA']['tl_user']['palettes']['extend'] = preg_replace('(([,;}]useCE)([,;{]))i', '$1,frontendbuilder$2', $GLOBALS['TL_DCA']['tl_user']['palettes']['extend']);
    $GLOBALS['TL_DCA']['tl_user']['palettes']['custom'] = preg_replace('(([,;}]useCE)([,;{]))i', '$1,frontendbuilder$2', $GLOBALS['TL_DCA']['tl_user']['palettes']['custom']);
    $GLOBALS['TL_DCA']['tl_user']['palettes']['login'] = preg_replace('(([,;}]useCE)([,;{]))i', '$1,frontendbuilder$2', $GLOBALS['TL_DCA']['tl_user']['palettes']['login']);
        
    $GLOBALS['TL_DCA']['tl_user']['fields']['frontendbuilder'] = array(
        'label' => &$GLOBALS['TL_LANG']['tl_user']['frontendbuilder'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => array('tl_class' => 'clr w50'),
        'sql' => "char(1) default '0'",
    );
