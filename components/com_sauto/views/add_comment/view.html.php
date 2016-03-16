<?php
/**
 * @package    sauto
 * @subpackage Views
 * @author     Dacian Strain {@link http://shop.elbase.eu}
 * @author     Created on 17-Nov-2013
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');


//jimport('joomla.application.component.view');

/**
 * HTML View class for the sauto Component.
 *
 * @package    sauto
 */
class SautoViewAdd_comment extends JViewLegacy
{
    /**
     * sauto view display method.
     *
     * @param string $tpl The name of the template file to parse;
     *
     * @return void
     */
    public function display($tpl = null)
    {
        parent::display($tpl);
    }//function
    
    
    function uploadImg($time, $uid, $anunt_id, $comm_id) {
		$db = JFactory::getDbo();
		$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
		$db->setQuery($query);
		$sconfig = $db->loadObject();
		$max_size = $sconfig->max_size; 
		
		$base_path = JPATH_COMPONENT.DS.'assets'.DS.'users'.DS;
		$folder_path = $base_path.$uid;
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
	
		for ($i=1;$i<=$sconfig->max_img_anunt;$i++) {
			$var_img = 'image_'.$i;
			$image = JRequest::getVar($var_img, null, 'files','array');
			$var_alt = 'alt_'.$i;
			$alt_img =& JRequest::getVar( $var_alt, '', 'post', 'string' );
			$image['name'] = JFile::makeSafe($image['name']);
			
			if ($image['name'] != '') {
				//verific daca userul are folder creat
				$exista = JFolder::exists($folder_path);
				if ($exista == '') {
					//creaza folderul
					JFolder::create($folder_path);
					$sursa = $base_path.'index.html';
					$destinatie = $base_path.DS.$uid.DS.'index.html';
					JFile::copy($sursa, $destinatie);
				} 
			
				//upload poza
				
				if($image['size'] < $max_size)	{
					//upload imagine
					$upFileName = explode('.',$image['name']);
					$uploadedFileExtension = array_pop($upFileName);
					$valid_ext = $sconfig->valid_ext;
					$validExt = explode(',', $valid_ext);
					$extOk = false;
					foreach($validExt as $key => $value) {
						if( preg_match("/$value/i", $uploadedFileExtension ) ) {
							$extOk = true;
						}
					}
			
					if ($extOk != false) {
						$imageinfo = getimagesize($image['tmp_name']);
						$mime_types = $sconfig->mime_types;
						$okMIMETypes = $mime_types;
						$validFileTypes = explode(",", $okMIMETypes);

						if( is_int($imageinfo[0]) || is_int($imageinfo[1]) ||  in_array($imageinfo['mime'], $validFileTypes) ) {	
							$image['name'] = preg_replace("/[^A-Za-z.0-9]/i", "-", $image['name']);
							$newName = $uid.'-'.$time.'-'.$image['name'];
							$uploadPath = $base_path.$uid.DS.$newName;	
							$file_name = $newName;
							JFile::upload($image['tmp_name'], $uploadPath);
							######adaugare in baza de date
							$query = "INSERT INTO #__sa_poze_comentarii (`anunt_id`, `poza`, `owner`, `com_id`) VALUES ('".$anunt_id."', '".$file_name."', '".$uid."', '".$comm_id."')";
							$db->setQuery($query);
							$db->query();
						}
					}
				}
			}
		}
	}
}//class
