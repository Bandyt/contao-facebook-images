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
 * @package    facebook_image 
 * @license    LGPL 
 * @filesource
 */


/**
 * Class facebook_image
 *
 * @copyright  2011 Andreas Koob 
 * @author     Andreas Koob 
 * @package    Controller
 */
class facebook_images extends Frontend
{

	public function addFBImages(Database_Result $objPage, Database_Result $objLayout, PageRegular $objPageRegular)
	{
		$fbimages = array();
		
		//Check articles for images
		$pageid=$objPage->id;
		$articles=$this->Database->prepare("SELECT * FROM tl_article WHERE pid=?")->execute($pageid);
		while($articles->next()){
			$contentElement=$this->Database->prepare("SELECT * FROM tl_content WHERE pid=?")->execute($articles->id);
			while($contentElement->next()){
				switch ($contentElement->type) {
					case 'image':
						if($contentElement->addtofbimages=="1"){
							$fbimages[]=$href=$this->Environment->url . '/' . $contentElement->singleSRC;
						}
						break;
						
						
					case 'gallery':
						if($contentElement->addtofbimages=="1")
						{
							$files = deserialize($contentElement->multiSRC);
							foreach ($files as $file)
							{
								if (is_file(TL_ROOT . '/' . $file))
								{
									$fbimages[]=$href=$this->Environment->url . '/' . $file;
								}
								else
								{
										$subfiles = scan(TL_ROOT . '/' . $file);
										foreach ($subfiles as $subfile)
										{
											if (is_file(TL_ROOT . '/' . $file . '/' . $subfile))
											{
												$fbimages[]=$href=$this->Environment->url . '/' . $file . '/' . $subfile;
											}
										}
								}
							}
						}
						break;
						
						
					case 'text':
						if($contentElement->addImage=="1" && $contentElement->addtofbimages=="1"){
							$fbimages[]=$href=$this->Environment->url . '/' . $contentElement->singleSRC;
						}
						break;
				}
			}
		}
		
		
		
		//Check news (if existing)
		$objNewsArticle = $this->Database->prepare("select * from tl_news WHERE
		(id=? OR alias=?)
		AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1")
			->limit(1)
			->execute((is_numeric($this->Input->get('items')) ? $this->Input->get('items') : 0), $this->Input->get('items'), $time, $time);
		if($objNewsArticle->addImage=="1")
		{
			$fbimages[]=$href=$this->Environment->url . '/' . $objNewsArticle->singleSRC;
		}
		//end checking news
		
		
		
		//Check events (if existing)
		$objEvent = $this->Database->prepare("select * from tl_calendar_events WHERE
		(id=? OR alias=?)
		AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1")
			->limit(1)
			->execute((is_numeric($this->Input->get('events')) ? $this->Input->get('events') : 0), $this->Input->get('events'), $time, $time);
		if($objEvent->addImage=="1")
		{
			$fbimages[]=$href=$this->Environment->url . '/' . $objEvent->singleSRC;
		}
		//end checking news
		
		
		
		
		//add array of images to header
		foreach($fbimages as $fbimage)
		{
			$GLOBALS['TL_HEAD'][] = '<meta property="og:image" content="' . $fbimage . '" />';
		}
	}//public function addFBImages
	
}

?>