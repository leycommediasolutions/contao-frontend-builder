<?php
$GLOBALS['TL_DCA']['tl_frontendbuilder'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'switchToEdit'                => true,
		'enableVersioning'            => true,
		'markAsCopy'                  => 'title',
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary', 
				'item' => 'unique'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('headline'),
			'flag'                    => 1,
			'panelLayout'             => 'filter;search,limit',
			'headerFields'            => array('item', 'headline', 'author', 'inColumn', 'tstamp', 'showTeaser', 'published', 'start', 'stop'),
		),
		'label' => array
		(
			'fields'                  => array('icon', 'headline', 'item', 'description'),
			'showColumns'             => true,
			'label_callback'          => array('tl_frontendbuilder', 'addIcon')
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            ),
		),
		'operations' => array
		(
			'editheader' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_frontendbuilder']['editheader'],
				'href'                => 'act=edit',
				'icon'                => 'edit.svg',
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_frontendbuilder']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.svg',
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_frontendbuilder']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.svg',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm']  . '\'))return false;Backend.getScrollOffset()"',
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_frontendbuilder']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.svg'
            ),
		)
	),
	// Palettes
	'palettes' => array
	(
		'default'                     => '{type_legend},item,language;{define_legend},headline,description,icon,alt'
    ),
    
	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
		'item' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_frontendbuilder']['item'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'select',
			'options_callback'        => array('tl_frontendbuilder', 'getItem'),
			'reference'               => &$GLOBALS['TL_LANG']['CTE'],
			'eval'                    => array('chosen'=>true, 'tl_class'=>'w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'language' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_frontendbuilder']['language'],
			'default'                 => 'de',
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'select',
			'options_callback' => function ()
			{
				return \System::getLanguages(true);
			},
			'eval'                    => array('chosen'=>true, 'tl_class'=>'w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'headline' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_frontendbuilder']['headline'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
        ),
		'description' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_frontendbuilder']['description'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
        ),  
        'icon' => array
        (
			'label'                   => &$GLOBALS['TL_LANG']['tl_frontendbuilder']['icon'],
			'exclude'                 => true,
            'inputType'               => 'fileTree',
			'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
			'sql'                     => "binary(16) NULL"
        ),
		'alt' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_frontendbuilder']['alt'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
        ),
	)
);

class tl_frontendbuilder extends Backend
{
    public function getItem(DataContainer $dc)
    {
        $groups = array();
        foreach ($GLOBALS['TL_CTE'] as $k=>$v)
		{			
			foreach (array_keys($v) as $kk)
			{
				$groups[$k][] = $kk;
			}
        }
        return $groups;
	}
	/**
	 * Add an image to each record
	 *
	 * @param array         $row
	 * @param string        $label
	 * @param DataContainer $dc
	 * @param array         $args
	 *
	 * @return array
	 */
	public function addIcon($row, $label, DataContainer $dc, $args)
	{	
		if ($args[0] != '')
		{
			$objFile = FilesModel::findByUuid($args[0]);

			if ($objFile !== null)
			{
				$args[0] = Image::getHtml(\System::getContainer()->get('contao.image.image_factory')->create(TL_ROOT . '/' . $objFile->path, array(100, 75, 'center_top'))->getUrl(TL_ROOT), '', 'class="theme_preview titel_elementsets"');
			}
		}
		return $args;
	}
}