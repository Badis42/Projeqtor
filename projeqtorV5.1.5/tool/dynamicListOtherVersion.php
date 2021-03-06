<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2015 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 *
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

/** ============================================================================
 * Save some information to session (remotely).
 */

require_once "../tool/projeqtor.php";
scriptLog('   ->/tool/dynamicLisOtherVersion.php');
$refType=$_REQUEST['otherVersionRefType'];
$refId=$_REQUEST['otherVersionRefId'];
$versionType=$_REQUEST['otherVersionType'];

//otherVersionId
$selected=null;
if (array_key_exists('selected',$_REQUEST)) {
  $selected=$_REQUEST['selected'];
}
$selectedArray=explode('_',$selected);

$obj=new $refType($refId);

$list=array();
$proj=null;
$prod=null;
if (property_exists($refType, "idProject")) {
	$proj=$obj->idProject;
}
if (property_exists($refType, "idProject")) {
  $proj=$obj->idProject;
}
if (property_exists($refType, "idProduct")) {
  $prod=$obj->idProduct;
}
$crit=array();
if ($prod) {
  $crit=array( 'idProduct'=>$prod);
} else if ($proj) { 
	$crit=array( 'idProject'=>$proj);
}  
$list=SqlList::getListWithCrit('Version', $crit);
?>
<select id="otherVersionIdVersion" size="14"" name="otherVersionIdVersion[]" multiple
onchange="selectOtherVersionItem();"  ondblclick="saveOtherVersion();"
class="selectList" >
 <?php
 $found=array();
 foreach ($list as $id=>$lst) {
   $sel="";
   if (in_array($id,$selectedArray)) {
    $sel=" selected='selected' ";
    $found[$id]=true;
   }
   echo "<option value='$id'" . $sel . ">#$id - ".htmlEncode($lst)."</option>";
 }
 foreach ($selectedArray as $selected) {
	 if ($selected and ! isset($found[$selected]) ) {
	   $lstObj=new $versionType($selected);
	   echo "<option value='$lstObj->id' selected='selected' >#".$lstObj->id." - ".htmlEncode($lstObj->name)."</option>";
	 }
 }
 ?>
</select>