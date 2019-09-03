<?php
/**
* Copyright (c) 2012-2016 MADE/YOUR/DAY
*
*	Permission is hereby granted, free of charge, to any person obtaining a copy
*	of this software and associated documentation files (the "Software"), to deal
*	in the Software without restriction, including without limitation the rights
*	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
*	copies of the Software, and to permit persons to whom the Software is furnished
*	to do so, subject to the following conditions:
*
*	The above copyright notice and this permission notice shall be included in all
*	copies or substantial portions of the Software.
*
*	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
*	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
*	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
*	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
*	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
*	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
*	THE SOFTWARE.
*/

namespace leycommediasolutions\FrontendBuilder;

use Symfony\Component\Security\Core\User\UserInterface;

class UserClass extends \BackendUser
{
    /**
	 * @var UserClass Singelton instance
	 */
	protected static $objInstance;

	/**
	 * @var boolean|null Caches the result of \User::authenticate()
	 */
	protected $userClassAuthenticated = null;

	/**
	 * Disable BackendUser authentication redirect and cache the result
	 */
	public function authenticate()
	{
		// Backwards compatibility for Contao 4.4
		if (!$this instanceof UserInterface) {
			if ($this->userClassAuthenticated === null) {
				$this->userClassAuthenticated = \User::authenticate();
			}
			return $this->userClassAuthenticated;
		}

		return $this->username && $this->intId;
	}
	/**
	 * disable session saving
	 */
    public function __destruct(){}
	/**
	 * set all user properties from a database record
	 */
	protected function setUserFromDb()
	{
		$this->intId = $this->id;

		foreach ($this->arrData as $key => $value) {
			if (! is_numeric($value)) {
				$this->$key = \StringUtil::deserialize($value);
			}
		}

		$always = array('alexf');
		$depends = array();

		if (is_array($GLOBALS['TL_PERMISSIONS']) && ! empty($GLOBALS['TL_PERMISSIONS'])) {
			$depends = array_merge($depends, $GLOBALS['TL_PERMISSIONS']);
		}

		if ($this->inherit == 'group') {
			foreach ($depends as $field) {
				$this->$field = array();
			}
		}

		$inherit = in_array($this->inherit, array('group', 'extend')) ? array_merge($always, $depends) : $always;
		$time = time();

		foreach ((array) $this->groups as $id) {

			$objGroup = $this->Database
				->prepare("SELECT * FROM tl_user_group WHERE id=? AND disable!=1 AND (start='' OR start<$time) AND (stop='' OR stop>$time)")
				->limit(1)
				->execute($id);

			if ($objGroup->numRows > 0) {
				foreach ($inherit as $field) {
					$value = \StringUtil::deserialize($objGroup->$field, true);
					if (!empty($value)) {
						$this->$field = array_merge((is_array($this->$field) ? $this->$field : (($this->$field != '') ? array($this->$field) : array())), $value);
						$this->$field = array_unique($this->$field);
					}
				}
			}

		}
	}
}