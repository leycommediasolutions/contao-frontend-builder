<?php
/**
 * Copyright (c) 2019 leycom - media solutions
 */
namespace leycommediasolutions\FrontendBuilder;

class BackendHooks
{
    public function __construct()
	{
    }
    public function myGetAttributesFromDca($arrAttributes, $objDca)
    {
        if (TL_MODE !== 'BE') {
			return $content;
        }
        $type = \Input::GET("selectboxvalue");
        if($arrAttributes["name"] == "type" && $type != ""){

            \Database::getInstance()
			->prepare("UPDATE tl_content SET type=?  WHERE id=?")
            ->execute($type , $objDca->id);
        }
        return $arrAttributes;
    }
}