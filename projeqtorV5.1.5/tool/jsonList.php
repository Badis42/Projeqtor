<?PHP
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

/** ===========================================================================
 * Get the list of objects, in Json format, to display the grid list
 */
    require_once "../tool/projeqtor.php"; 
scriptLog('   ->/tool/jsonList.php');  
    $type=$_REQUEST['listType'];
    echo '{"identifier":"id",' ;
    echo 'label: "name",';
    echo ' "items":[';
    // If type = 'list' and $dataType = idResource : execute the listResourceProject type
    $required=true; // when directly requesting 'listResourceProject', required is by default
    if ($type=='list'
    and array_key_exists('dataType', $_REQUEST) and $_REQUEST['dataType']=='idResource' 
    and array_key_exists('critField', $_REQUEST) and array_key_exists('critValue', $_REQUEST)
    and $_REQUEST['critField']=='idProject') {
    	$type='listResourceProject';
    	$_REQUEST['idProject']=$_REQUEST['critValue'];
    	$required=array_key_exists('required', $_REQUEST);
    }
    if ($type=='ExpenseDetailType') {
      $type='list';
    }
    
    if ($type=='empty') {
          
    } else if ($type=='object') {    
      $objectClass=$_REQUEST['objectClass'];
      $obj=new $objectClass();
      $nbRows=listFieldsForFilter ($obj,0);
    } else if ($type=='operator') {    
      $dataType=$_REQUEST['dataType'];
      if ($dataType=='int' or $dataType=='date' or $dataType=='datetime' or $dataType=='decimal') {
        echo ' {id:"=", name:"="}';
        echo ',{id:">=", name:">="}';
        echo ',{id:"<=", name:"<="}';
        echo ',{id:"<>", name:"<>"}';
        if ($dataType!='int' and $dataType!='decimal') {
          //echo ',{id:"xx", name:"xx"}';
          echo ',{id:"<=now+", name:"<= ' . i18n('today') . ' + "}';
          echo ',{id:">=now+", name:">= ' . i18n('today') . ' + "}';
          echo ',{id:"isEmpty", name:"' . i18n('isEmpty') . '"}';
          echo ',{id:"isNotEmpty", name:"' . i18n('isNotEmpty') . '"}';
        }
        echo ',{id:"SORT", name:"' . i18n('sortFilter') .'"}';
      } else if ($dataType=='varchar') {
        echo ' {id:"LIKE", name:"' . i18n("contains") . '"}';
        echo ',{id:"NOT LIKE", name:"' . i18n("notContains") . '"}';
        echo ',{id:"isEmpty", name:"' . i18n('isEmpty') . '"}';
        echo ',{id:"isNotEmpty", name:"' . i18n('isNotEmpty') . '"}';
        echo ',{id:"SORT", name:"' . i18n('sortFilter') .'"}';
      } else if ($dataType=='bool') {
        echo ' {id:"=", name:"="}';
        echo ',{id:"SORT", name:"' . i18n('sortFilter') .'"}';
      } else if ($dataType=='list') {
        echo ' {id:"IN", name:"' . i18n("amongst") . '"}';
        echo ',{id:"NOT IN", name:"' . i18n("notAmongst") . '"}';
        echo ',{id:"isEmpty", name:"' . i18n('isEmpty') . '"}';
        echo ',{id:"isNotEmpty", name:"' . i18n('isNotEmpty') . '"}';
        echo ',{id:"SORT", name:"' . i18n('sortFilter') .'"}';
      } else if ($dataType=='refObject') {
        echo ' {id:"LIKE", name:"' . i18n("contains") . '"},';
        echo ' {id:"hasSome", name:"' . i18n("isNotEmpty") . '"}';
        //echo ',{id:"NOT LIKE", name:"' . i18n("notContains") . '"}';
      } else  {
        echo ' {id:"UNK", name:"?"}';
        echo ',{id:"SORT", name:"' . i18n('sortFilter') .'"}';
      }
      
    } else if ($type=='list') {   
      $dataType=$_REQUEST['dataType'];
      $selected="";
      if ( array_key_exists('selected',$_REQUEST) ) {
        $selected=$_REQUEST['selected'];
      }
      if ($dataType=='planning') {
        $class='Project';
      } else {
        $class=substr($dataType,2);
      }
      if ($dataType=='idProject' and securityGetAccessRight('menuProject', 'read')!='ALL') {
      	$user=getSessionUser();
      	$list=$user->getVisibleProjects();
      } else if ($dataType=='planning') {
      	$user=getSessionUser();
      	$list=$user->getVisibleProjects();
      	$restrictArray=$user->getListOfPlannableProjects();
      	foreach ($list as $prj=>$prjname) {
      	  if (! isset($restrictArray[$prj])) {
      	    unset($list[$prj]);
      	  }
      	}
      } else if ($dataType=='idProduct' and array_key_exists('critField', $_REQUEST) and array_key_exists('critValue', $_REQUEST)) {
      	if (trim($_REQUEST['critValue'])) {    	
	        $list=array();
	      	$listProd=SqlList::getList($class);
	      	$versProj=new VersionProject();
	      	$versProjList=$versProj->getSqlElementsFromCriteria(array('idProject'=>$_REQUEST['critValue']));
	      	foreach ($versProjList as $versProj) {
	      		$vers=new Version($versProj->idVersion);
	      		if (isset($listProd[$vers->idProduct])) {
	      			$list[$vers->idProduct]=$listProd[$vers->idProduct];
	      		}
	      	}
      	} else {
      		$list=SqlList::getList($class);
      	}
      } else if (array_key_exists('critField', $_REQUEST) and array_key_exists('critValue', $_REQUEST)) {
        $crit=array( $_REQUEST['critField'] => $_REQUEST['critValue']);
        $list=SqlList::getListWithCrit($class, $crit);
      
      } else {
        $list=SqlList::getList($class);
      }
      if ($selected) {
      	$name=SqlList::getNameFromId($class, $selected);
      	if ($name==$selected and ($class=='Resource' or $class=='User' or $class=='Contact')) {
      		$name=SqlList::getNameFromId('Affectable', $selected);
      	}
        $list[$selected]=$name;
      }
      if ($dataType=="idProject") { $wbsList=SqlList::getList('Project','sortOrder',$selected, true);} 
      $nbRows=0;
      // return result in json format
      if (! array_key_exists('required', $_REQUEST)) {
      	echo '{id:" ", name:""}';
        $nbRows+=1;
      }
      if ($dataType=="idProject") {
        $sepChar=Parameter::getUserParameter('projectIndentChar');
        if (!$sepChar) $sepChar='__';
        $wbsLevelArray=array();
      }
      foreach ($list as $id=>$name) {
        if ($dataType=="idProject" and $sepChar!='no') {
          if (isset($wbsList[$id])) {
        	  $wbs=$wbsList[$id];
          } else {
          	$wbsProj=new Project($id);
          	$wbs=$wbsProj->sortOrder;
          }
          $wbsTest=$wbs;
          $level=1;
          while (strlen($wbsTest)>3) {
            $wbsTest=substr($wbsTest,0,strlen($wbsTest)-4);
            if (array_key_exists($wbsTest, $wbsLevelArray)) {
              $level=$wbsLevelArray[$wbsTest]+1;
              $wbsTest="";
            }
          }
          $wbsLevelArray[$wbs]=$level;
          $sep='';for ($i=1; $i<$level;$i++) {$sep.=$sepChar;}
          //$levelWidth = ($level-1) * 2;
          //$sep=($levelWidth==0)?'':substr('_____________________________________________________',(-1)*($levelWidth));
          $name = $sep.$name;
        }
        if ($nbRows>0) echo ', ';
        echo '{id:"' . $id . '", name:"'. str_replace('"', "''",htmlEncodeJson($name)) . '"}';
        $nbRows+=1;
      }
    } else if ($type=='listResourceProject') {
	      //$obj=$_SESSION['currentObject'];
	      //$prj=new Project($obj->idProject);
	      $idPrj=$_REQUEST['idProject'];
	      $prj=new Project($idPrj);
	      $lstTopPrj=$prj->getTopProjectList(true);
	      $in=transformValueListIntoInClause($lstTopPrj);
	      $where="idle=0 and idProject in " . $in; 
	      $aff=new Affectation();
	      $list=$aff->getSqlElementsFromCriteria(null,null, $where);
	      $nbRows=0;
	      $lstRes=array();
	      if (array_key_exists('selected', $_REQUEST)) {
	        $lstRes[$_REQUEST['selected']]=SqlList::getNameFromId('Affectable', $_REQUEST['selected']);
	      }
	      foreach ($list as $aff) {
	        if (! array_key_exists($aff->idResource, $lstRes)) {
	        	$id=$aff->idResource;
	        	$name=SqlList::getNameFromId('Resource', $id);
	        	if ($name!=$id) {
	            $lstRes[$id]=$name;
	        	}
	        }
	      }
	      asort($lstRes);
	      // return result in json format
        if (! $required) {
          echo '{id:" ", name:""}';
          $nbRows+=1;
        }
	      foreach ($lstRes as $id=>$name) {
	        if ($nbRows>0) echo ', ';
	        echo '{id:"' . $id . '", name:"'. $name . '"}';
	        $nbRows+=1;
	      }
	    } else if ($type=='listTermProject') {
	    	if(!isset($_REQUEST['selected']))	{
	    	  if (isset($_REQUEST['directAccessIndex']) and isset($_SESSION['directAccessIndex'][$_REQUEST['directAccessIndex']])) {
            $obj=$_SESSION['directAccessIndex'][$_REQUEST['directAccessIndex']];
          } else {
          	$obj=$_SESSION['currentObject'];
          }
	        $idPrj=$_REQUEST['idProject'];
	        $prj=new Project($obj->idProject);
	        $lstTopPrj=$prj->getTopProjectList(true);
	        $in=transformValueListIntoInClause($lstTopPrj);
	        $where="idProject in " . $in." AND idBill is null";	       
	        $term=new Term();
	        $list=$term->getSqlElementsFromCriteria(null,null, $where);
	        $listFinal = array();
	        foreach ($list as $term) {
	      	  // on récupère les trigger
	      	  $dep = new Dependency();
	      	  $crit = array("successorRefType"=>"Term","successorRefId"=>$term->id);
	      	  $depList = $dep->getSqlElementsFromCriteria($crit,false);
	      	  $idle = 1;
	      	  foreach ($depList as $dep) {
	      		  switch ($dep->predecessorRefType) {
	      			  case "Activity":
	      				  //$act = new Activity($dep->predecessorRefId);
	      				  //if ($act->idle == 0) $idle = 0;
	      				  break;
	      			  case "Milestone":
	      				  $mil = new Milestone($dep->predecessorRefId);
	      				  if ($mil->idle == 0) $idle = 0;
	      				  break;
	      			  case "Project":
	      				  //$project = new Project($dep->predecessorRefId);
	      				  //if ($project->idle == 0) $idle = 0;
	      				  break;
	      		  }
	      	  }      	
	      	  // si tous les trigger sont clos alors on ajoute le term à la liste des term disponibles
	      	  if($idle==1) {
	      		  if($term->date!=null) {
  	      			$now = date('Y-m-d');
	        			$now = new DateTime($now);
	        			$now = $now->format('Y-m-d');
	        			if ($now >= $term->date) {
	        				$listFinal[$term->id]=$term;
	      	  		}
	      		  } else { 
	      			  $listFinal[$term->id]=$term;
	      		  }
	      	  }
	        }	
	        foreach ($listFinal as $term) {
	          if (! array_key_exists($term->id, $listFinal)) {
	          $listFinal[$term->id]=SqlList::getNameFromId('Term', $term->id);
	          }
	        }
	        
	        asort($listFinal);
	        // return result in json format	      
	        echo '{id:null, name:""}';
	        // $i=0;
	        foreach ($listFinal as $term) {
	      	  //if($i!=0) 
	      	  echo ', ';
	          echo '{id:"' . $term->id . '", name:"'. $term->name . '"}';
	         //$i++;
	        }
	      } else {
	      	echo '{id:'.$_REQUEST['selected'].', name:"' . SqlList::getNameFromId('Term', $_REQUEST['selected']) . '"}';
	      }           
    } else if ($type=='listRoleResource') {
      $ctrl="";
      $idR=$_REQUEST['idResource'];
      $resource=new Resource($idR);
      $nbRows=0;
      if ($resource->idRole) {
        echo '{id:"' . $resource->idRole . '", name:"'. SqlList::getNameFromId('Role', $resource->idRole) . '"}';
        $nbRows+=1;
        $ctrl.='#' . $resource->idRole . '#';
      }

      $where="idResource='" . Sql::fmtId($idR) . "' and endDate is null";
      $where.=" and idRole <>'" . Sql::fmtId($resource->idRole) . "'";
      $rc=new ResourceCost();
      $lstRoles=$rc->getSqlElementsFromCriteria(null, false, $where);
      // return result in json format
      foreach ($lstRoles as $resourceCost) {
        $key='#' . $resource->idRole . '#';
        if (strpos($ctrl,$key)===false) {
          if ($nbRows>0) echo ', ';
          echo '{id:"' . $resourceCost->idRole . '", name:"'. SqlList::getNameFromId('Role', $resourceCost->idRole) . '"}';
          $nbRows+=1;
          $ctrl.=$key;
        }
      }
    } else if ($type=='listStatusDocumentVersion') {
      if (isset($_REQUEST['directAccessIndex']) and isset($_SESSION['directAccessIndex'][$_REQUEST['directAccessIndex']])) {
        $doc=$_SESSION['directAccessIndex'][$_REQUEST['directAccessIndex']];
      } else {
        $doc=$_SESSION['currentObject'];
      }
    	$idDocumentVersion=$_REQUEST['idDocumentVersion'];
      $docVers=new documentVersion($idDocumentVersion);
    	$table=SqlList::getList('Status','name',$docVers->idStatus);
    	if ($docVers->idStatus) {      
	      $profile=getSessionUser()->getProfile($doc);
	      $type=new DocumentType($doc->idDocumentType);
	      $ws=new WorkflowStatus();
	      $crit=array('idWorkflow'=>$type->idWorkflow, 'allowed'=>1, 'idProfile'=>$profile, 'idStatusFrom'=>$docVers->idStatus);
	      $wsList=$ws->getSqlElementsFromCriteria($crit, false);
	      $compTable=array($docVers->idStatus=>'ok');
	      foreach ($wsList as $ws) {
	        $compTable[$ws->idStatusTo]="ok";
	      }
        $table=array_intersect_key($table,$compTable);
      } else {
        reset($table);
        $table=array(key($table)=>current($table));
      }  
      $nbRows=0;
      foreach ($table as $id=>$name) {    
        if ($nbRows>0) echo ', ';
        echo '{id:"' . $id . '", name:"'. $name . '"}';
        $nbRows+=1;
      }
    }
    echo ' ] }';

function listFieldsForFilter ($obj,$nbRows, $included=false) {
  // return result in json format
  foreach ($obj as $col=>$val) {
    if (substr($col, 0,1) <> "_" 
    and substr($col, 0,1) <> ucfirst(substr($col, 0,1))
    and ! $obj->isAttributeSetToField($col,'hidden')
    and ! $obj->isAttributeSetToField($col,'calculated')
    and (!$included or ($col!='id' and $col!='refType' and $col!='refId' and $col!='idle')  )) { 
      if ($nbRows>0) echo ', ';
      $dataType = $obj->getDataType($col);
      $dataLength = $obj->getDataLength($col);
      if ($dataType=='int' and $dataLength==1) { 
        $dataType='bool'; 
      } else if ($dataType=='datetime') { 
        $dataType='date'; 
      } else if ((substr($col,0,2)=='id' and $dataType=='int' and strlen($col)>2 
              and substr($col,2,1)==strtoupper(substr($col,2,1)))) { 
        $dataType='list'; 
      }
      $colName=$obj->getColCaption($col);
      if (substr($col,0,9)=='idContext') {
        $colName=SqlList::getNameFromId('ContextType',substr($col,9));
      }
      echo '{id:"' . ($included?get_class($obj).'_':'') . $col . '", name:"'. $colName .'", dataType:"' . $dataType . '"}';
      $nbRows++;
    } else if (substr($col, 0,1)<>"_" and substr($col, 0,1) == ucfirst(substr($col, 0,1)) ) {
    	$sub=new $col();
      $nbRows=listFieldsForFilter ($sub,$nbRows,true);
    }
  }
  if (isset($obj->_Note)) {
  	if ($nbRows>0) echo ', ';
  	echo '{id:"Note", name:"'. i18n('colNote') .'", dataType:"refObject"}';
  	$nbRows++;
  }  
  return $nbRows;
}
?>