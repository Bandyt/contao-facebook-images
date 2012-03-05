<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  2011 Andreas Koob 
 * @author     Andreas Koob 
 * @package    facebook_images 
 * @license    LGPL 
 * @filesource
 */


/**
 * Table tl_content 
 */

// Palettes
$GLOBALS['TL_DCA']['tl_content']['palettes']['image'] = str_replace('caption;', 'caption;{addimagetofb},addtofbimages;', $GLOBALS['TL_DCA']['tl_content']['palettes']['image']);
$GLOBALS['TL_DCA']['tl_content']['palettes']['gallery'] = str_replace('fullsize;', 'fullsize;{addimagetofb},addtofbimages;', $GLOBALS['TL_DCA']['tl_content']['palettes']['gallery']);
$GLOBALS['TL_DCA']['tl_content']['palettes']['text'] = str_replace('addImage;', 'addImage;{addimagetofb},addtofbimages;', $GLOBALS['TL_DCA']['tl_content']['palettes']['text']);

$GLOBALS['TL_DCA']['tl_content']['fields']['addtofbimages'] = array
(
	'label'									=> &$GLOBALS['TL_LANG']['tl_content']['addtofbimages'],
	'inputType'								=> 'checkbox',
	'eval'									=> array()
);
?>