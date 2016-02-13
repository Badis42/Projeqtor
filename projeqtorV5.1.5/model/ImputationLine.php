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
 * Project is the main object of the project managmement.
 * Almost all other objects are linked to a given project.
 */
require_once('_securityCheck.php');
class ImputationLine {

	// List of fields that will be exposed in general user interface
	//public $id;    // redefine $id to specify its visible place
	public $refType;
	public $refId;
	public $idProject;
	public $idAssignment;
	public $name;
	public $comment;
	public $wbs;
	public $wbsSortable;
	public $topId;
	public $validatedWork;
	public $assignedWork;
	public $plannedWork;
	public $realWork;
	public $leftWork;
	public $imputable;
	public $elementary;
	public $arrayWork;
	public $arrayPlannedWork;
	public $startDate;
	public $endDate;
	public $idle;
	public $locked;
	public $description;
	public $functionName;

	/** ==========================================================================
	 * Constructor
	 * @param $id the id of the object in the database (null if not stored yet)
	 * @return void
	 */
	function __construct($id = NULL, $withoutDependentObjects=false) {
		$arrayWork=array();
	}

	/** ==========================================================================
	 * Return some lines for imputation purpose, including assignment and work
	 * @return void
	 */
	function __destruct() {
	}

	static function getLines($resourceId, $rangeType, $rangeValue, $showIdle, $showPlanned=true, 
		$hideDone=false, $hideNotHandled=false, $displayOnlyCurrentWeekMeetings=false) {
	  SqlElement::$_cachedQuery['Assignment']=array();
	  SqlElement::$_cachedQuery['PlanningElement']=array();
	  SqlElement::$_cachedQuery['WorkElement']=array();
		
		// Insert new lines for admin projects
		Assignment::insertAdministrativeLines($resourceId);
		
		// Initialize parameters
		if (Parameter::getGlobalParameter('displayOnlyHandled')=="YES") {
			$hideNotHandled=1;
		}
		$user=getSessionUser();
		//$user=new User($user->id);

		$result=array();
		if ($rangeType=='week') {
			$nbDays=7;
		}
		$startDate=self::getFirstDay($rangeType, $rangeValue);
		$plus=$nbDays-1;
		$endDate=date('Y-m-d',strtotime("+$plus days", strtotime($startDate)));
		
		// Get All assignments
		$crit=array('idResource' => $resourceId);
		if (! $showIdle) {
		  $crit['idle']='0';
		}
		$ass=new Assignment();
		$assList=$ass->getSqlElementsFromCriteria($crit,false,null,null, true);
		
		// Retrieve realwork and planned work entered for period
		$crit=array('idResource' => $resourceId);
		$crit[$rangeType]=$rangeValue;
		$work=new Work();
		$workList=$work->getSqlElementsFromCriteria($crit,false);
		$plannedWork=new PlannedWork();
	  if ($showPlanned) {
      $plannedWorkList=$plannedWork->getSqlElementsFromCriteria($crit,false);
    }
    
    // Get acces restriction to hide projects dependong on access rights 
		$profile=$user->getProfile(); // Default profile for user
		$listAccesRightsForImputation=$user->getAllSpecificRightsForProfiles('imputation');
		$listAllowedProfiles=array(); // List will contain all profiles with visibility to Others imputation
		if (isset($listAccesRightsForImputation['PRO'])) {
		  $listAllowedProfiles+=$listAccesRightsForImputation['PRO'];
		}
		if (isset($listAccesRightsForImputation['ALL'])) {
		  $listAllowedProfiles+=$listAccesRightsForImputation['ALL'];
		}
		$visibleProjects=array();
		foreach ($user->getSpecificAffectedProfiles() as $prj=>$prf) {
		  if (in_array($prf, $listAllowedProfiles)) {
		    $visibleProjects[$prj]=$prj;
		  }
		}
		// ... and remove assignments not to be shown
		$accessRightRead=securityGetAccessRight('menuActivity', 'read');
		if ($user->id != $resourceId and $accessRightRead!='ALL') {
			foreach ($assList as $id=>$ass) {
				if (! array_key_exists($ass->idProject, $visibleProjects) ) {
					unset ($assList[$id]);
				}
			}
		}

		// Hide some lines depending on user criteria selected on page
		if ($hideNotHandled or $hideDone or $displayOnlyCurrentWeekMeetings) {
			foreach ($assList as $id=>$ass) {
				if ($ass->refType and class_exists($ass->refType))
				$refObj=new $ass->refType($ass->refId, true);
				if ($hideNotHandled and property_exists($refObj,'handled') and ! $refObj->handled) {
					unset ($assList[$id]);
				}
				if ($hideDone and property_exists($refObj,'done') and $refObj->done) {
					unset ($assList[$id]);
				}
				if ($displayOnlyCurrentWeekMeetings and get_class($refObj)=='Meeting') {
					if ($refObj->meetingDate<$startDate or $refObj->meetingDate>$endDate) {
						unset ($assList[$id]);
					}
				}
			}
		}
		// Check if assignment exists for each work (may be closed or not assigned: so make it appear)
		foreach ($workList as $work) {
			if ($work->idAssignment) {
				$found=false;
				// Look into assList
				if (isset($assList['#'.$work->idAssignment])) {
				  $ass=$assList['#'.$work->idAssignment];
				  $found=true;
				}
				if (! $found) {
					$ass=new Assignment($work->idAssignment);
					if ($ass->id) { // Assignment exists, but not retrieve : display but readonly
					  $ass->_locked=true;
						$assList[$ass->id]=$ass;
					} else { // Assignment does not exist : this is an error case as $wor->idAssignment is set !!! SHOULD NOT BE SEEN
						/*$id=$work->refType.'#'.$work->refId;
						if (! isset($assList[$id])) { // neo-assignment do not exist : insert one
						  $ass->id=null;
						  $ass->name='<span style="color:red;"><i>' . i18n('notAssignedWork') . ' (1)</i></span>';
						  if ($work->refType and $work->refId) {
						    $ass->comment=i18n($work->refType) . ' #' . $work->refId;
						  } else {
						    $ass->comment='unexpected case : assignment #' . $work->idAssignment . ' not found';
						  }
						  $ass->realWork=$work->work;
						  $ass->refType=$work->refType;
              $ass->refId=$work->refId;
						} else { // neo-assignment exists : add work (once again ,at this step this should not be displayed, it is an error case
						  $ass=$assList[$id];
						  $ass->realWork+=$work->work;
						}
						$ass->_locked=true;
						$assList[$id]=$ass;*/
					}				
				}
				if ($work->idWorkElement) { // Check idWorkElement : if set, add new line for ticket, locked
				  $acticityAss=$ass; // Save reference to parent activity
				  $ass=new Assignment();
				  $we=new WorkElement($work->idWorkElement);
				  $ass->id=$acticityAss->id;
				  $ass->name=$we->refName;;
				  $ass->refType=$we->refType;
				  $ass->refId=$we->refId;
				  $ass->realWork=$we->realWork;
				  $ass->leftWork=$we->leftWork;
				  $ass->_locked=true;
				  $ass->_topRefType=$acticityAss->refType;
				  $ass->_topRefId=$acticityAss->refId;
				  $ass->_idWorkElement=$work->idWorkElement;
				  $id=$work->refType.'#'.$work->refId.'#'.$work->idWorkElement;
				  $assList[$id]=$ass;				  
				}
			} else { // Work->idAssignment not set (for tickets not linked to Activities for instance)
				$id=$work->refType.'#'.$work->refId;
				if (isset($assList[$id])) {
					$ass=$assList[$id];
				} else {
					$ass=new Assignment();
				}
				if ($work->refType) { // refType exist (Ticket is best case)
					$obj=new $work->refType($work->refId, true);
					if ($obj->name) {
					  $obj->name=htmlEncode($obj->name);
					}
				} else { // refType does not exist : is should not happen (name displayed in red), key ot to avoid errors
					$obj=new Ticket();
          $obj->name='<span style="color:red;"><i>' . i18n('notAssignedWork') . ' (2)</i></span>';
          if (! $ass->comment) {
            $ass->comment='unexpected case : no reference object';
          }
          $ass->_locked=true;
				}
				//$ass->name=$id . " " . $obj->name;
				$ass->name=$obj->name;
			  if (isset($obj->WorkElement)) {
          $ass->realWork=$obj->WorkElement->realWork;
          $ass->leftWork=$obj->WorkElement->leftWork;
        }
				$ass->id=null;
				$ass->refType=$work->refType;
				$ass->refId=$work->refId;
				if ($work->refType) {
					//$ass->comment=i18n($work->refType) . ' #' . $work->refId;
				}
				$assList[$id]=$ass;
			}
		}

		$notElementary=array();
		$cptNotAssigned=0;
		foreach ($assList as $idAss=>$ass) {
			$elt=new ImputationLine();
			$elt->idle=$ass->idle;
			$elt->refType=$ass->refType;
			$elt->refId=$ass->refId;
			$elt->comment=$ass->comment;
			$elt->idProject=$ass->idProject;
			$elt->idAssignment=$ass->id;
			$elt->assignedWork=$ass->assignedWork;
			$elt->plannedWork=$ass->plannedWork;
			$elt->realWork=$ass->realWork;
			$elt->leftWork=$ass->leftWork;
			$elt->arrayWork=array();
			if (isset($ass->_locked)) $elt->locked=true;
			$elt->arrayPlannedWork=array();
			if ($ass->idRole) {
			  $elt->functionName=SqlList::getNameFromId('Role', $ass->idRole);
			}
			$crit=array('refType'=>$elt->refType, 'refId'=>$elt->refId);
			if (isset($ass->_topRefType) and isset($ass->_topRefId)) {
			  $crit=array('refType'=>$ass->_topRefType, 'refId'=>$ass->_topRefId);
			}
			$plan=null;
			if ($ass->id) {
			  $plan=SqlElement::getSingleSqlElementFromCriteria('PlanningElement', $crit);
			}
			if ($plan and $plan->id and isset($ass->_topRefType) and isset($ass->_topRefId)) {
			  $elt->wbs=$plan->wbs.'.'.$elt->refType.'#'.$elt->refId;
			  $elt->wbsSortable=$plan->wbsSortable.'.'.$elt->refType.'#'.$elt->refId;
			  $elt->topId=$plan->id;
			  $elt->elementary=$plan->elementary;
			  $elt->startDate=null;
			  $elt->endDate=null;
			  $elt->elementary=1;
			  $elt->imputable=true;
			  if (isset($ass->_idWorkElement)) {
			    $elt->_idWorkElement=$ass->_idWorkElement;
			  }
			  $elt->name='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$ass->name; 
			  $key=$plan->wbsSortable . ' ' . $ass->_topRefType . '#' . $ass->_topRefId;
			  if (isset($result[$key])) {
			    $result[$key]->elementary=0;
			  } else {
			    $notElementary[$key]=$key;
			  }
			  $elt->locked=true;
			} else if ($plan and $plan->id) {
				$elt->name=htmlEncode($plan->refName);
				$elt->wbs=$plan->wbs;
				$elt->wbsSortable=$plan->wbsSortable;
				$elt->topId=$plan->topId;
				$elt->elementary=$plan->elementary;
				$elt->startDate=($plan->realStartDate)?$plan->realStartDate:$plan->plannedStartDate;
				$elt->endDate=($plan->realEndDate)?$plan->realEndDate:$plan->plannedEndDate;
				$elt->imputable=true;
			} else {
				$cptNotAssigned+=1;
				if (isset($ass->name)) {
					$elt->name=$ass->name;
				} else {
          $elt->name='<span style="color:red;"><i>' . i18n('notAssignedWork') . '</i></span>';
          if ($ass->refType and $ass->refId) {
          	$elt->comment=i18n($ass->refType) . ' #' . $ass->refId;
          } else {
            $elt->comment='unexpected case : no assignment name';
          }
				}
				$elt->wbs='0.'.$cptNotAssigned;
				$elt->wbsSortable='000.'. str_pad($cptNotAssigned, 3, "0", STR_PAD_LEFT);
				$elt->elementary=1;
				$elt->topId=null;
				$elt->imputable=true;
				$elt->idAssignment=null;
				$elt->locked=true;
			}
			//if ( ! ($user->id = $resourceId or $scopeCode!='ALL' or ($scopeCode='PRO' and array_key_exists($ass->idProject, $visibleProjects) ) ) ) {
			//	$elt->locked=true;
			//}
			$key=$elt->wbsSortable . ' ' . $ass->refType . '#' . $ass->refId;
			if (array_key_exists($key,$result)) {
				$key.= '/#' . $ass->id;
			}
			// fetch all work stored in database for this assignment
			foreach ($workList as $work) {
				if ( ($work->idAssignment and $work->idAssignment==$elt->idAssignment and !$work->idWorkElement and !isset($elt->_idWorkElement)) 
				  or (!$work->idAssignment and $work->refType==$elt->refType and $work->refId==$elt->refId) 
			    or ($work->idAssignment and $work->idAssignment==$elt->idAssignment and $work->idWorkElement and isset($elt->_idWorkElement) and $elt->_idWorkElement==$work->idWorkElement)) {
					$workDate=$work->workDate;
					$offset=dayDiffDates($startDate, $workDate)+1;
					if (isset($elt->arrayWork[$offset])) { 
						$elt->arrayWork[$offset]->work+=$work->work;
					} else {
						$elt->arrayWork[$offset]=$work;
					}
				}
			}
			// Fill arrayWork for days without an input
			for ($i=1; $i<=$nbDays; $i++) {
				if ( ! array_key_exists($i, $elt->arrayWork)) {
					$elt->arrayWork[$i]=new Work();
				}
			}
			if ($showPlanned) {
				foreach ($plannedWorkList as $plannedWork) {
					if ($plannedWork->idAssignment==$elt->idAssignment) {
						$workDate=$plannedWork->workDate;
						$offset=dayDiffDates($startDate, $workDate)+1;
						$elt->arrayPlannedWork[$offset]=$plannedWork;
					}
				}
				// Fill arrayWork for days without an input
				for ($i=1; $i<=$nbDays; $i++) {
					if ( ! array_key_exists($i, $elt->arrayPlannedWork)) {
						$elt->arrayPlannedWork[$i]=new PlannedWork();
					}
				}
			}
			$result[$key]=$elt;
		}
		// If some not assigned work exists : add group line
		if ($cptNotAssigned >0) {
			$elt=new ImputationLine();
			$elt->idle=0;
			$elt->arrayWork=array();
			$elt->arrayPlannedWork=array();
			$elt->name=i18n('notAssignedWork');
			$elt->wbs=0;
			$elt->wbsSortable='000';
			$elt->elementary=false;
			$elt->imputable=false;
			$elt->refType='Imputation';
			for ($i=1; $i<=$nbDays; $i++) {
				if ( ! array_key_exists($i, $elt->arrayWork)) {
					$elt->arrayWork[$i]=new Work();
				}
			}
			$result['#']=$elt;
		}
		$act=new Activity();
		$accessRight=securityGetAccessRight($act->getMenuClass(), 'read');
		foreach ($result as $key=>$elt) {
			$result=self::getParent($elt, $result, true, $accessRight);
		}
		ksort($result);
		return $result;
	}

	// Get the parent line for hierarchc display purpose
	private static function getParent($elt, $result, $direct=true, $accessRight){
//scriptLog("      => ImputationLine->getParent($elt->refType#$elt->refId, result[], $direct)");		
		$plan=null;
		$user=getSessionUser();
		$visibleProjectList=$user->getVisibleProjects();

		//$visibleProjectList=explode(', ', getVisibleProjectsList());
		if ($elt->topId) {
			$plan=new PlanningElement($elt->topId);
		}
		if ($plan) {
			$key=$plan->wbsSortable . ' ' . $plan->refType . '#' . $plan->refId;
			if (! array_key_exists($key,$result) 
			and ($plan->refType!='Project' or $direct or $accessRight=='ALL' or array_key_exists($plan->refId,$visibleProjectList))) {
				$top=new ImputationLine();
				$top->idle=$plan->idle;
				$top->imputable=false;
				$top->name=htmlEncode($plan->refName);
				$top->wbs=$plan->wbs;
				$top->wbsSortable=$plan->wbsSortable;
				$top->topId=$plan->topId;
				$top->refType=$plan->refType;
				$top->refId=$plan->refId;
				//$top->assignedWork=$plan->assignedWork;
				//$top->plannedWork=$plan->plannedWork;
				//$top->realWork=$plan->realWork;
				//$top->leftWork=$plan->leftWork;
				$result[$key]=$top;
				$result=self::getParent($top, $result, $direct=false, $accessRight);
			}
		}
scriptLog("      => ImputationLine->getParent()-exit");
		return $result;
	}

	private static function getFirstDay($rangeType, $rangeValue) {
		if ($rangeType=='week') {
			$year=substr($rangeValue,0,4);
			$week=substr($rangeValue,4,2);
			$day=firstDayofWeek($week,$year);
			return date('Y-m-d',$day);
		}
	}

	static function drawLines($resourceId, $rangeType, $rangeValue, $showIdle, $showPlanned=true, $print=false, 
			  $hideDone=false, $hideNotHandled=false, $displayOnlyCurrentWeekMeetings=false) {
		$outMode=(isset($_REQUEST['outMode']))?$_REQUEST['outMode']:'';
//scriptLog("      => ImputationLine->drawLines(resourceId=$resourceId, rangeType=$rangeType, rangeValue=$rangeValue, showIdle=$showIdle, showPlanned=$showPlanned, print=$print, hideDone=$hideDone, hideNotHandled=$hideNotHandled, displayOnlyCurrentWeekMeetings=$displayOnlyCurrentWeekMeetings)");
		$keyDownEventScript=NumberFormatter52::getKeyDownEvent(); // Will add event $commaEvent
		$crit=array('periodRange'=>$rangeType, 'periodValue'=>$rangeValue, 'idResource'=>$resourceId); 
		$period=SqlElement::getSingleSqlElementFromCriteria('WorkPeriod', $crit);
		$user=getSessionUser();		
		$canValidate=false;
		$crit=array('scope'=>'workValid', 'idProfile'=>$user->idProfile);
    $habilitation=SqlElement::getSingleSqlElementFromCriteria('HabilitationOther', $crit);
    $scope=new AccessScope($habilitation->rightAccess);
    if ($scope->accessCode=='NO') {
      $canValidate=false;
    } else if ($scope->accessCode=='ALL') {
      $canValidate=true;
    } else if (($scope->accessCode=='OWN' or $scope->accessCode=='RES') and $user->isResource and $resourceId==$user->id) {
      $canValidate=true;
    } else if ($scope->accessCode=='PRO') {
      $crit='idProject in ' . transformListIntoInClause($user->getVisibleProjects());
      $aff=new Affectation();
      $lstAff=$aff->getSqlElementsFromCriteria(null, false, $crit, null, true);
      $fullTable=SqlList::getList('Resource');
      foreach ($lstAff as $id=>$aff) {
        if ($aff->idResource==$resourceId) {
          $canValidate=true;
          continue;
        }
      }
    }
		$locked=false;		
		$oldValues="";
		$nameWidth=220;
		$dateWidth=80;
		$workWidth=65;
		$inputWidth=55;
		$iconWidth=16;
		if ($outMode=='pdf') {
		  $dateWidth=40;
		  $workWidth=40;
		  $inputWidth=35;
		}
		$resource=new Resource($resourceId);
		$cal=$resource->idCalendarDefinition;
		if (!$cal) $cal=1;
		$capacity=work::getConvertedCapacity($resource->capacity);
		$weekendColor="cfcfcf";
		$currentdayColor="ffffaa";
		$today=date('Y-m-d');
		if ($rangeType=='week') {
			$nbDays=7;
		}
		$startDate=self::getFirstDay($rangeType, $rangeValue);
		$plus=$nbDays-1;
		$endDate=date('Y-m-d',strtotime("+$plus days", strtotime($startDate)));
		$rangeValueDisplay=substr($rangeValue,0,4) . '-' . substr($rangeValue,4);
		$colSum=array();
		for ($i=1; $i<=$nbDays; $i++) {
			$colSum[$i]=0;
		}
		$width=600;
		if (isset($_REQUEST['destinationWidth'])) {
		  $width=($_REQUEST['destinationWidth'])-155-30;
		}
		$tab=ImputationLine::getLines($resourceId, $rangeType, $rangeValue, $showIdle, $showPlanned, $hideDone, $hideNotHandled, $displayOnlyCurrentWeekMeetings);
		
		if (!$print) {
		  echo '<div dojoType="dijit.layout.BorderContainer">';
		  echo '<div dojoType="dijit.layout.ContentPane" region="top" style="overflow-y: scroll; height: auto;">';
		}
		echo '<table class="imputationTable" style="width:100%">';
		echo '<TR class="ganttHeight">';
		echo '<td class="label" ><label for="imputationComment" >'.i18n("colComment").'&nbsp;:&nbsp;</label></td>';
		if (! $print) {
		echo '<td><textarea dojoType="dijit.form.Textarea" id="imputationComment" name="imputationComment"'
		           .' onChange="formChanged();"'
               .' style="width: '.$width.'px;min-height:32px;max-height:32px;" maxlength="4000" class="input">'.$period->comment.'</textarea></td>';
		} else {
			echo htmlEncode($period->comment,'print');
		}
		echo ' </TR>';
		echo '</table>';
		if (! $print) {
		  echo '<input type="hidden" id="resourceCapacity" value="'.$capacity.'" />';
		}
		echo '<table class="imputationTable" style="width:'.(($outMode=='pdf')?'68':'100').'%">';
		echo '<TR class="ganttHeight">';
		echo '  <TD class="ganttLeftTopLine" style="width:'.$iconWidth.'px;"></TD>';
		echo '  <TD class="ganttLeftTopLine" colspan="5">';
		echo '<table style="width:98%"><tr><td style="width:99%">' . htmlEncode($resource->name) . ' - ' . i18n($rangeType) . ' ' . $rangeValueDisplay;
		echo '</td>';
		if ($period->submitted) {		
			$msg='<div class="imputationSubmitted"><nobr>'.i18n('submittedWorkPeriod',array(htmlFormatDateTime($period->submittedDate))).'</nobr></div>';	
			if (!$print and ! $period->validated and ($resourceId==$user->id or $canValidate)) {
				echo '<td style="width:1%">'.$msg.'</td>'; 
				echo '<td style="width:1%">';
			  echo '<button id="unsubmitButton" jsid="unsubmitButton" dojoType="dijit.form.Button" showlabel="true" >'; 
        echo '<script type="dojo/connect" event="onClick" args="evt">submitWorkPeriod("unsubmit");</script>';
        echo i18n('unSubmitWorkPeriod');
        echo '</button>';
        echo '</td>';
        $locked=true;
			} else {
				echo '<td style="width:1%">'.$msg.'</td>'; 
			}
		} else if (!$print and $resourceId==$user->id and ! $period->validated) {
			echo '<td style="width:1%">';
	    echo '<button id="submitButton" dojoType="dijit.form.Button" showlabel="true" >'; 
	    echo '<script type="dojo/connect" event="onClick" args="evt">submitWorkPeriod("submit");</script>';
	    echo i18n('submitWorkPeriod');
	    echo '</button>';
	    echo '</td>'; 
		}
		echo '<td style="width:10px">&nbsp;&nbsp;&nbsp;</td>';		
		if ($period->validated) {
			$locked=true;
			$res=SqlList::getNameFromId('User', $period->idLocker);
			$msg='<div class="imputationValidated"><nobr>'.i18n('validatedWorkPeriod',array(htmlFormatDateTime($period->validatedDate),$res)).'</nobr></div>';
		  if (!$print and $canValidate) {
		  	echo '<td style="width:1%">'.$msg.'</td>';
		  	//echo '<div xdojoType="dijit.Tooltip" xconnectId="unvalidateButton" xposition="above" >'.$msg.'</div>';
		  	echo '<td style="width:1%">';
		  	echo '<button id="unvalidateButton" jsid="unvalidateButton" dojoType="dijit.form.Button" showlabel="true" >'; 
        echo '<script type="dojo/connect" event="onClick" args="evt">submitWorkPeriod("unvalidate");</script>';
        echo i18n('unValidateWorkPeriod');
        echo '</button>';
        echo '</td>'; 
		  } else {
		  	echo '<td style="width:1%">'.$msg.'</td>';
		  }
		} else if (!$print and $canValidate) {
			echo '<td style="width:1%">';
		  echo '<button id="validateButton" dojoType="dijit.form.Button" showlabel="true" >'; 
      echo '<script type="dojo/connect" event="onClick" args="evt">submitWorkPeriod("validate");</script>';
      echo i18n('validateWorkPeriod');
      echo '</button>';
      echo '</td>';
		}
		echo '</tr></table>';
		echo '</TD>';
		echo '  <TD class="ganttLeftTitle" colspan="' . $nbDays . '" '
		. 'style="border-right: 1px solid #ffffff;border-bottom: 1px solid #DDDDDD;">'
		. htmlFormatDate($startDate)
		. ' - '
		. htmlFormatDate($endDate)
		. '</TD>';
		echo '  <TD class="ganttLeftTopLine" colspan="2" style="text-align:center;color: #707070">' .  htmlFormatDate($today) . '</TD>';
		echo '</TR>';
		echo '<TR class="ganttHeight">';
		echo '  <TD class="ganttLeftTitle" style="width:'.$iconWidth.'px;"></TD>';
		echo '  <TD class="ganttLeftTitle" style="text-align: left; '
		. 'border-left:0px; " nowrap>' .  i18n('colTask') . '</TD>';
		echo '  <TD class="ganttLeftTitle" style="width: ' . $dateWidth . 'px;max-width:'.$dateWidth.'px;overflow:hidden;">'
		. i18n('colStart') . '</TD>';
		echo '  <TD class="ganttLeftTitle" style="width: ' . $dateWidth . 'px;max-width:'.$dateWidth.'px;overflow:hidden;">'
		. i18n('colEnd') . '</TD>';
		echo '  <TD class="ganttLeftTitle" style="width: ' . $workWidth . 'px;max-width:'.$workWidth.'px;overflow:hidden;">'
		. i18n('colAssigned') . '</TD>';
		echo '  <TD class="ganttLeftTitle" style="width: ' . $workWidth . 'px;max-width:'.$workWidth.'px;overflow:hidden;">'
		. i18n('colReal') . '</TD>';
		$curDate=$startDate;
		for ($i=1; $i<=$nbDays; $i++) {
			echo '  <TD class="ganttLeftTitle" style="width: ' . $inputWidth . 'px;max-width:'.$inputWidth.'px;overflow:hidden;';
			if ($today==$curDate) {
				echo ' background-color:#' . $currentdayColor . '; color: #aaaaaa;';
			} else if (isOffDay($curDate,$cal)) {
				echo ' background-color:#' . $weekendColor . '; color: #aaaaaa;';
			}
			echo '">';
			if ($rangeType=='week') {
				echo  i18n('colWeekday' . $i) . " "  . date('d',strtotime($curDate)) . '';
			}
			if (! $print) {
				echo ' <input type="hidden" id="day_' . $i . '" name="day_' . $i . '" value="' . $curDate . '" />';
			}
			echo '</TD>';
			$curDate=date('Y-m-d',strtotime("+1 days", strtotime($curDate)));
		}
		echo '  <TD class="ganttLeftTitle" style="width: ' . $workWidth . 'px;max-width:'.$workWidth.'px;overflow:hidden;">'
		. i18n('colLeft') . '</TD>';
		echo '  <TD class="ganttLeftTitle" style="width: ' . $workWidth . 'px;max-width:'.$workWidth.'px;overflow:hidden;">'
		. i18n('colReassessed') . '</TD>';
		echo '</TR>';
		if (! $print) {
			echo '<input type="hidden" id="nbLines" name="nbLines" value="' . count($tab) . '" />';
		}
		if (!$print) {
		  echo '</table>';
		  echo '</div>';
		  echo '<div style="position:relative;overflow-y:scroll;" dojoType="dijit.layout.ContentPane" region="center">';
		  echo '<table class="imputationTable" style="width:'.(($outMode=='pdf')?'68':'100').'%">';
		}
		$nbLine=0;
		$collapsedList=Collapsed::getCollaspedList();
		$closedWbs='';
		$wbsLevelArray=array();
		foreach ($tab as $key=>$line) {
			if ($locked) $line->locked=true;
			$nbLine++;
			if ($line->elementary) {
				$rowType="row";
			} else {
				$rowType="group";
			}
			//if ($closedWbs and strlen($line->wbsSortable)<=strlen($closedWbs)) {
			if ($closedWbs and (strlen($line->wbsSortable)<=strlen($closedWbs) or $closedWbs!=substr($line->wbsSortable,0,strlen($closedWbs)) ) ) {
				$closedWbs="";
			}
			$scope='Imputation_'.$resourceId.'_'.$line->refType.'_'.$line->refId;
			$collapsed=false;
			if ($rowType=="group" and array_key_exists($scope, $collapsedList)) {
				$collapsed=true;
				if (! $closedWbs) {
					$closedWbs=$line->wbsSortable;
				}
			}
			$canRead=false;
			$canGoto=false;
			if ($line->refType and $line->refId) {
			  $obj=new $line->refType($line->refId,true);
			  $canRead=(securityGetAccessRightYesNo('menu' . $line->refType, 'read', $obj)=='YES');
			  $canGoto=($canRead and securityCheckDisplayMenu(null, $line->refType))?true:false;
			}
			
			echo '<tr id="line_' . $nbLine . '"class="ganttTask' . $rowType . '"';
			if ($closedWbs and $closedWbs!=$line->wbsSortable) {
				echo ' style="display:none" ';
			}
			echo '>';
			echo '<td class="ganttName" style="width:'.($iconWidth+1).'px;">';
			if (! $print) {
				echo '<input type="hidden" id="wbs_' . $nbLine . '" '
				. ' value="' . $line->wbsSortable . '"/>';
				echo '<input type="hidden" id="status_' . $nbLine . '" ';
				if ($collapsed) {
					echo   ' value="closed"';
				} else {
					echo   ' value="opened"';
				}
				echo '/>';
				echo '<input type="hidden" id="idAssignment_' . $nbLine . '" name="idAssignment[]"'
				. ' value="' . $line->idAssignment . '"/>';
				echo '<input type="hidden" id="imputable_' . $nbLine . '" name="imputable[]"'
				. ' value="' . (($line->imputable)?'1':'0') . '"/>';
				echo '<input type="hidden" id="locked_' . $nbLine . '" name="locked[]"'
        . ' value="' . (($line->locked)?'1':'0') . '"/>';
			}
			if (! $line->refType) {$line->refType='Imputation';};
			echo '<img src="css/images/icon' . $line->refType . '16.png" ';
			if ($line->refType!='Imputation' and !$print) {
			  echo ' onmouseover="showBigImage(null,null,this,\''.i18n($line->refType).' #'.$line->refId.'<br/>';
			  if ($canRead) echo '<i>'. i18n("clickToView").'</i>';
			  echo '\');" onmouseout="hideBigImage();"';
			}
			if (! $print and $canRead) {
			  echo ' class="pointer" onClick="directDisplayDetail(\''.$line->refType.'\',\''.$line->refId.'\')"';
			}
			echo '/>';
			echo '</td>';
			echo '<td class="ganttName" >';
			// tab the name depending on level
			echo '<table width:"100%"><tr><td>';
		  $wbs=$line->wbsSortable;
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
			//$level=(strlen($line->wbsSortable)+1)/4;
			$levelWidth = ($level-1) * 16;
	    echo '<div style="float: left;width:' . $levelWidth . 'px;">&nbsp;</div>';
			echo '</td>';
			if (! $print) {
				if ($rowType=="group") {
					echo '<td width="16"><span id="group_' . $nbLine . '" ';
					if ($collapsed) {
						echo 'class="ganttExpandClosed"';
					} else {
						echo 'class="ganttExpandOpened"';
					}
					if (! $print) {
						echo 'onclick="workOpenCloseLine(' . $nbLine . ',\''.$scope.'\')"';
					} else {
						echo ' style="cursor:default;"';
					}
					echo '>';
					echo '&nbsp;&nbsp;&nbsp;&nbsp;</span><span>&nbsp</span></td>' ;
				} else {
					echo '<td width="16"><div style="float: left;width:16px;">&nbsp;</div></td>';
				}
			}
			if($line->refType == "Project") {
				$description=null;
				$crit=array();
				$crit['id']=$line->refId;
				$description=SqlElement::getSingleSqlElementFromCriteria('Project', $crit);
				if($description) {
					$line->description=$description->description;
				}
			}
			else if ($line->refType == "Activity")
			{
				$descriptionActivity=null;
				$crit2=array();
				$crit2['id']=$line->refId;
				$crit2['idProject']=$line->idProject;
				$descriptionActivity=SqlElement::getSingleSqlElementFromCriteria('Activity', $crit2);
				if($descriptionActivity)
				{
					$line->description=$descriptionActivity->description;
				}
			}
			echo '<td width="100%" style="position:relative"';
			if (! $print and $canGoto) {
			  echo ' class="pointer" onClick="gotoElement(\''.$line->refType.'\',\''.$line->refId.'\')"';
			}
			echo '>' . $line->name ;
			echo '<div id="extra_'.$nbLine.'" style="position:absolute; top:-2px; right:2px;" ></div>';
				
			if (isset($line->functionName) and $line->functionName and $outMode!="pdf") {
					echo '<div style="float:right; color:#8080DD; font-size:80%;font-weight:normal;">' . $line->functionName . '</div>';
			}
			echo '</td>';
			if ($line->comment and !$print) {
					echo '<td>&nbsp;&nbsp;</td><td>'.formatCommentThumb($line->comment).'</td>';
			}
			echo '</tr></table>';
			echo '</td>';
			//echo '<td class="ganttDetail" align="center">' . $line->description . '</td>';
			echo '<td class="ganttDetail" align="center" width="'.$dateWidth.'px">' . htmlFormatDate($line->startDate) . '</td>';
			echo '<td class="ganttDetail" align="center" width="'.$dateWidth.'px">' . htmlFormatDate($line->endDate) . '</td>';
			echo '<td class="ganttDetail" align="center" width="'.$workWidth.'px">';
			if ($line->imputable) {
				if (!$print) {
					echo '<input type="text" xdojoType="dijit.form.NumberTextBox" ';
					//echo ' constraints="{pattern:\'###0.0#\'}"';
					echo ' style="width: 60px; text-align: center; " ';
					echo ' trim="true" class="input dijitTextBox dijitNumberTextBox dijitValidationTextBox displayTransparent" readOnly="true" tabindex="-1" ';
					echo ' id="assignedWork_' . $nbLine . '"';
					echo ' value="' . htmlDisplayNumericWithoutTrailingZeros(Work::displayImputation($line->assignedWork)) . '" ';
					echo ' />';
					//echo '</div>';
				} else {
					echo  Work::displayImputation($line->assignedWork);
				}
			}
			echo '</td>';
			echo '<td class="ganttDetail" align="center" width="'.$workWidth.'px">';
			if ($line->imputable) {
				if (!$print) {
					echo '<input type="text" xdojoType="dijit.form.NumberTextBox" ';
					//echo ' constraints="{pattern:\'###0.0#\'}"';
					echo ' style="width: 60px; text-align: center;" ';
					echo ' trim="true" class="input dijitTextBox dijitNumberTextBox dijitValidationTextBox displayTransparent" readOnly="true" tabindex="-1" ';
					echo ' id="realWork_' . $nbLine . '"';
					echo ' value="' .  htmlDisplayNumericWithoutTrailingZeros(Work::displayImputation($line->realWork)) . '" ';
					echo ' />';
					//echo '</div>';
				} else {
					echo   Work::displayImputation($line->realWork);
				}
			}
			echo '</td>';
			$curDate=$startDate;
			for ($i=1; $i<=$nbDays; $i++) {
				echo '<td class="ganttDetail" align="center" width="'.$inputWidth.'px;"';
				if ($today==$curDate) {
					echo ' style="background-color:#' . $currentdayColor . ';"';
				} else if (isOffDay($curDate,$cal)) {
					echo ' style="background-color:#' . $weekendColor . '; color: #aaaaaa;"';
				}
				echo '>';
				if ($line->imputable) {
					$valWork=$line->arrayWork[$i]->work;
					$idWork=$line->arrayWork[$i]->id;
					if (! $print) {
						echo '<div style="position: relative">';
						if ($showPlanned and $line->arrayPlannedWork[$i]->work) {
							echo '<div style="display: inline;';
							echo ' position: absolute; right: 10px; top: 0px; text-align: right;';
							echo ' color:#8080DD; font-size:90%;">';
							echo  Work::displayImputation($line->arrayPlannedWork[$i]->work);
							echo '</div>';
						}
						echo '<div type="text" dojoType="dijit.form.NumberTextBox" ';
						echo ' constraints="{min:0}"';
						echo '  style="width: 45px; text-align: center; ' . (($line->idle or $line->locked)?'color:#A0A0A0; xbackground: #EEEEEE;':'') .' " ';
						echo ' trim="true" maxlength="4" class="input" ';
						echo ' id="workValue_' . $nbLine . '_' . $i . '"';
						echo ' name="workValue_' . $i . '[]"';
						echo ' value="' .  Work::displayImputation($valWork) . '" ';
						if ($line->idle or $line->locked) {
							echo ' readOnly="true" ';
						}
						echo ' >';
						//echo '<script type="dojo/method" event="onFocus" args="evt">';
						//echo ' oldImputationWorkValue=this.value;';
						//echo '</script>';
						echo $keyDownEventScript;
						echo '<script type="dojo/method" event="onChange" args="evt">';
						echo '  dispatchWorkValueChange("' . $nbLine . '","' . $i . '");';
						echo '</script>';
						echo '</div>';
						echo '</div>';
						if (! $print) {
								echo '<input type="hidden" id="workId_' . $nbLine . '_' . $i . '"'
								. ' name="workId_' . $i . '[]"'
								. ' value="' . $idWork . '"/>';
							echo '<input type="hidden" id="workOldValue_' . $nbLine . '_' . $i . '"'
							. ' value="' .  Work::displayImputation($valWork) . '"/>';
						}
					} else {
						echo  Work::displayImputation($valWork);
					}
					$colSum[$i]+= Work::displayImputation($valWork);
				} else {
					echo '<input type="hidden" name="workId_' . $i . '[]" />';
					echo '<input type="hidden" name="workValue_' . $i . '[]" />';
				}
				echo '</td>';
				$curDate=date('Y-m-d',strtotime("+1 days", strtotime($curDate)));
			}
			echo '<td class="ganttDetail" align="center" width="'.$workWidth.'px;">';
			if ($line->imputable) {
				if (!$print) {
					echo '<div type="text" dojoType="dijit.form.NumberTextBox" ';
					echo ' constraints="{min:0}"';
					echo '  style="width: 60px; text-align: center;' . (($line->idle or $line->locked)?'color:#A0A0A0; xbackground: #EEEEEE;':'') .' " ';
					echo ' trim="true" class="input" ';
					echo ' id="leftWork_' . $nbLine . '"';
					echo ' name="leftWork[]"';
					echo ' value="' .  Work::displayImputation($line->leftWork) . '" ';
					if ($line->idle or $line->locked) {
						echo ' readOnly="true" ';
					}
					echo ' >';
					echo $keyDownEventScript;
					echo '<script type="dojo/method" event="onChange" args="evt">';
					echo '  dispatchLeftWorkValueChange("' . $nbLine . '");';
					echo '</script>';
					echo '</div>';
				} else {
					echo  Work::displayImputation($line->leftWork);
				}
			} else {
				  echo '<input type="hidden" id="leftWork_' . $nbLine . '" name="leftWork[]" />';
			}
			echo '</td>';
			echo '<td class="ganttDetail" align="center" width="'.$workWidth.'px;">';
			if ($line->imputable) {
				if (!$print) {
					echo '<input type="text" xdojoType="dijit.form.NumberTextBox" ';
					//echo ' constraints="{pattern:\'###0.0#\'}"';
					echo '  style="width: 60px; text-align: center;" ';
					echo ' trim="true" class="input dijitTextBox dijitNumberTextBox dijitValidationTextBox displayTransparent" readOnly="true" tabindex="-1" ';
					echo ' id="plannedWork_' . $nbLine . '"';
					echo ' value="' . htmlDisplayNumericWithoutTrailingZeros(Work::displayImputation($line->plannedWork)) . '" ';
					echo ' />';
					//echo '</div>';
				} else {
					echo  Work::displayImputation($line->plannedWork);
				}
			}
			echo '</td>';
			echo '</tr>';
		}
		if (!$print and count($tab)>20) {
		  echo '</table>';
		  echo '</div>';
		  echo '<div dojoType="dijit.layout.ContentPane" region="bottom" style="overflow-y: scroll; height: auto;">';
		  echo '<table class="imputationTable" style="width:100%">';
		}
		echo '<TR class="ganttDetail" >';
		echo '  <TD class="ganttLeftTopLine" style="width:'.$iconWidth.'px;"></TD>';
		echo '  <TD class="ganttLeftTopLine" colspan="5" style="text-align: left; '
		. 'border-left:0px;" nowrap><NOBR>';
		echo  Work::displayImputationUnit();
		echo '</NOBR></TD>';

		$curDate=$startDate;
		$nbFutureDays=Parameter::getGlobalParameter('maxDaysToBookWork');
		$maxDateFuture=date('Y-m-d',strtotime("+".$nbFutureDays." days", strtotime($today)));
		if (! $print) echo '<input type="hidden" id="nbFutureDays" value="'.$nbFutureDays.'" />';
		if (! $print) echo '<input type="hidden" value="'.$maxDateFuture.'" />';
		for ($i=1; $i<=$nbDays; $i++) {
			echo '  <TD class="ganttLeftTitle" style="width: ' . $inputWidth . 'px;';
			if ($today==$curDate) {
				//echo ' background-color:#' . $currentdayColor . ';';
			}
			echo '"><NOBR>';
			if (!$print) {
				echo '<div type="text" dojoType="dijit.form.NumberTextBox" ';
				//echo ' constraints="{pattern:\'###0.0#\'}"';
				echo ' trim="true" disabled="true" ';
				if (round($colSum[$i],2)>$capacity) {
				  echo ' class="imputationInvalidCapacity"';
				} else if (round($colSum[$i],2)<$capacity) {
					echo ' class="displayTransparent"'; 
				} else  {
					echo ' class="imputationValidCapacity"';
				}
				echo '  style="width: 45px; text-align: center; color: #000000 !important;" ';
				echo ' id="colSumWork_' . $i . '"';
				echo ' value="' . $colSum[$i] . '" ';
				echo ' >';
				echo '</div>';
				echo '<input type="hidden" id="colIsFuture_' . $i . '" value="'.(($curDate>$maxDateFuture)?1:0).'" />';
			} else {
				echo $colSum[$i];
			}
			echo '</NOBR></TD>';
			$curDate=date('Y-m-d',strtotime("+1 days", strtotime($curDate)));
		}
		echo '  <TD class="ganttLeftTopLine" style="width: ' . ($workWidth+1) . 'px;"><NOBR>'
		.  '</NOBR></TD>';
		echo '  <TD class="ganttLeftTopLine" style="width: ' . ($workWidth+1) . 'px;"><NOBR>'
		.  '</NOBR></TD>';
		echo '</TR>';
		echo '</table>';
		if (!$print) {
		  echo '</div>';
		  echo '</div>';
		}

	}
	// ============================================================================**********
	// GET STATIC DATA FUNCTIONS
	// ============================================================================**********



	// ============================================================================**********
	// GET VALIDATION SCRIPT
	// ============================================================================**********

	/** ==========================================================================
	 * Return the validation sript for some fields
	 * @return the validation javascript (for dojo frameword)
	 */
	public function getValidationScript($colName) {
		$colScript = parent::getValidationScript($colName);

		if ($colName=="idle") {
			$colScript .= '<script type="dojo/connect" event="onChange" >';
			$colScript .= '  if (this.checked) { ';
			$colScript .= '    if (dijit.byId("PlanningElement_realEndDate").get("value")==null) {';
			$colScript .= '      dijit.byId("PlanningElement_realEndDate").set("value", new Date); ';
			$colScript .= '    }';
			$colScript .= '  } else {';
			$colScript .= '    dijit.byId("PlanningElement_realEndDate").set("value", null); ';
			//$colScript .= '    dijit.byId("PlanningElement_realDuration").set("value", null); ';
			$colScript .= '  } ';
			$colScript .= '  formChanged();';
			$colScript .= '</script>';
		}
		return $colScript;
	}

	// ============================================================================**********
	// MISCELLANOUS FUNCTIONS
	// ============================================================================**********

	public function save() {
		$finalResult="";
		foreach($this->arrayWork as $work) {
			$result="";
			if ($work->work) {
				//echo "save";
				$result=$work->save();
			} else {
				if ($work->id) {
					//echo "delete";
					$result=$work->delete();
				}
			}
			if (stripos($result,'id="lastOperationStatus" value="ERROR"')>0 ) {
				$status='ERROR';
				$finalResult=$result;
				break;
			} else if (stripos($result,'id="lastOperationStatus" value="OK"')>0 ) {
				$status='OK';
				$finalResult=$result;
			} else {
				if ($finalResult=="") {
					$finalResult=$result;
				}
			}
		}
		return $finalResult;
	}
}
?>