<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/se/user/admin/dal/dal.remunerationindividual.php');


// To activate the constructior crating an object. 
$bllRemunerationIndividual = new BLLRemunerationIndividual;

class BLLRemunerationIndividual
{

	function __construct()
	{

	}
	// Display the remunerationindividual according to user and course
	public function show($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$teacherSelected,$varsityDeptId)
	{
		$dalRemunerationIndividual = new DALRemunerationIndividual;
		$result = $dalRemunerationIndividual->get($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$teacherSelected,$varsityDeptId);

		$data = "";
		while ($res = mysqli_fetch_assoc($result))
		 {	
		 	$data.="<tr>";

		 	$data.="<td>";
		 	$data.= $res['prefix']." ".$res['courseNo'];
		 	$data.="</td>";

		 	$data.="<td colspan='2'>";
		 	$data.= $res['fullName'];
		 	$data.="</td>";
		 	$data.="<td>";
		 	$data.= "01";
		 	$data.="</td>";
		 	$data.="<td>";
		 	$data.= $res['noScripts'];
		 	$data.="</td>";
		 	$data.="</tr>";

		 }
		 echo $data;
	}
	public function getSessionName($sessionId)
	{
		$data = "";
		$dalRemunerationIndividual = new DALRemunerationIndividual();
		$result = $dalRemunerationIndividual->getSessionName($sessionId);
		while ($res = mysqli_fetch_assoc($result))
		{
			$data .= $res['sessionName'];
		}
		return $data;
	}
	public function getDeptName($deptId)
	{
		$data = "";
		$dalRemunerationIndividual = new DALRemunerationIndividual();
		$result = $dalRemunerationIndividual->getDeptName($deptId);
		while ($res = mysqli_fetch_assoc($result))
		{
			$data .= $res['name'];
		}
		return $data;
	}

#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
# Question Generation/Composition
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	public function getQuestionsComposition($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$data = "";
		$dalRemunerationIndividual = new DALRemunerationIndividual();
		$result = $dalRemunerationIndividual->getQuestionsComposition($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
		while($res = mysqli_fetch_assoc($result))
		{
			$data .= $res['prefix']." ".$res['courseNo'].",";
		}
		
		return $data;
	}

	public function getNoQuestionsComposition($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$data =0;
		$dalRemunerationIndividual = new DALRemunerationIndividual();
		$result = $dalRemunerationIndividual->getNoQuestionsComposition($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
		while($res = mysqli_fetch_assoc($result))
		{
			$data += $res['noQuestions'];
		}
		return $data;
	}
	public function getRateQuestionsComposition($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$data = 0;
		$dalRemunerationIndividual = new DALRemunerationIndividual();
		$result = $dalRemunerationIndividual->getRate($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId,"Question Composition");
		while($res = mysqli_fetch_assoc($result))
		{
			$data += $res['amount'];
		}

		return $data;
	}
	public function getTotalQuestionsComposition($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$no = $this->getNoQuestionsComposition($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
	 	$rate = $this->getRateQuestionsComposition($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);

	 	return $no*$rate;
	}

#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
# Question Modaration
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	public function getQuestionsModaration($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$data = '';
	 	return $data;
	}

	public function getNoQuestionsModaration($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$data = '0';
	 	return $data;
	}
	public function getRateQuestionsModaration($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$data = 0;
		$dalRemunerationIndividual = new DALRemunerationIndividual();
		$result = $dalRemunerationIndividual->getRate($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId,"Question Modaration");
		while($res = mysqli_fetch_assoc($result))
		{
			$data += $res['amount'];
		}
		return $data;
	}
	public function getTotalQuestionsModaration($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$no = $this->getNoQuestionsModaration($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
	 	$rate = $this->getRateQuestionsModaration($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);

	 	return $no*$rate;
	}
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
# Answer Script Evaluation 1300
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	public function getAnswerScriptEvaluation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$data = "";
		$dalRemunerationIndividual = new DALRemunerationIndividual();
		$result = $dalRemunerationIndividual->getQuestionsComposition($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
		while($res = mysqli_fetch_assoc($result))
		{
			$data .= $res['prefix']." ".$res['courseNo'].",";
		}
		return $data;
	}

	public function getNoAnswerScriptEvaluation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		
		//noScripts
		$noScripts = 0;
		$dalRemunerationIndividual = new DALRemunerationIndividual();
		$result = $dalRemunerationIndividual->getNoQuestionsComposition($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
		while($res = mysqli_fetch_assoc($result))
		{
			$noScripts += $res['noQuestions'];
		}
		//noStudents
		$noStudents = 0;
		$dalRemunerationIndividual = new DALRemunerationIndividual();
		$result = $dalRemunerationIndividual->getNoStudent($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId,"Section A","Theory");
		while($res = mysqli_fetch_assoc($result))
		{
			$noStudents += $res['noStudents'];
		}

		// No Of courses assigned * no of students on that courses
		return $noStudents*$noScripts;

	}
	public function getRateAnswerScriptEvaluation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$data = 0;
		$dalRemunerationIndividual = new DALRemunerationIndividual();
		$result = $dalRemunerationIndividual->getRate($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId,"Answer Script Evaluation");
		while($res = mysqli_fetch_assoc($result))
		{
			$data += $res['amount'];
		}
		return $data;
	}
	public function getTotalAnswerScriptEvaluation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$no = $this->getNoAnswerScriptEvaluation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
	 	$rate = $this->getRateAnswerScriptEvaluation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);

	 	return $no*$rate;
	}
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
# Class test 400
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	public function getClassTest($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$data = "";
		$dalRemunerationIndividual = new DALRemunerationIndividual();
		$result = $dalRemunerationIndividual->getClassTest($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
		while($res = mysqli_fetch_assoc($result))
		{
			$data .= $res['prefix']." ".$res['courseNo'];
		}
		
		return $data;
	}

	public function getNoClassTest($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$noClassTest = 0;
		$dalRemunerationIndividual = new DALRemunerationIndividual();
		$noClassTest = $dalRemunerationIndividual->getNoClassTest($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);

		// NoStudents
		$noStudents = 0;
		$dalRemunerationIndividual = new DALRemunerationIndividual();
		$result = $dalRemunerationIndividual->getNoStudent($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId,"Continuous Assessment","Theory");
		while($res = mysqli_fetch_assoc($result))
		{
			$noStudents += $res['noStudents'];
		}

		//noScripts
		$noScripts = 0;
		$dalRemunerationIndividual = new DALRemunerationIndividual();
		$result = $dalRemunerationIndividual->getNoQuestionsComposition($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
		while($res = mysqli_fetch_assoc($result))
		{
			$noScripts += $res['noQuestions'];
		}

		

		// noCourse * noClassTest * noStudents
		return $noClassTest*$noScripts*$noStudents;
	}
	public function getRateClassTest($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$data = 0;
		$dalRemunerationIndividual = new DALRemunerationIndividual();
		$result = $dalRemunerationIndividual->getRate($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId,"Class Test");
		while($res = mysqli_fetch_assoc($result))
		{
			$data += $res['amount'];
		}
		
	 	return $data;
	}
	public function getTotalClassTest($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$no = $this->getNoClassTest($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
	 	$rate = $this->getRateClassTest($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);

	 	return $no*$rate;
	}
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
# Sessional 150
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	public function getSessional($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$data = "";
		$dalRemunerationIndividual = new DALRemunerationIndividual();
		$result = $dalRemunerationIndividual->getSessional($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
		while($res = mysqli_fetch_assoc($result))
		{
			$data .= $res['prefix']." ".$res['courseNo'].",";
		}
		
		return $data;
	}

	public function getNoSessional($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$data = 0;
		$dalRemunerationIndividual = new DALRemunerationIndividual();
		$result = $dalRemunerationIndividual->getSessional($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
		while($res = mysqli_fetch_assoc($result))
		{
			$data += $res['noScripts'];
		}
		
		return $data;
	}
	public function getRateSessional($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$data = 0;
		$dalRemunerationIndividual = new DALRemunerationIndividual();
		$result = $dalRemunerationIndividual->getRate($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId,"Sessional");
		while($res = mysqli_fetch_assoc($result))
		{
			$data += $res['amount'];
		}
		return $data;
	}
	public function getTotalSessional($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$no = $this->getNoSessional($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
	 	$rate = $this->getRateSessional($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);

	 	return $no*$rate;
	}

#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
# Sessional Viva 25
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	public function getSessionalViva($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$data = "";
		$dalRemunerationIndividual = new DALRemunerationIndividual();
		$result = $dalRemunerationIndividual->getSessionalViva($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
		while($res = mysqli_fetch_assoc($result))
		{
			$data .= $res['prefix']." ".$res['courseNo'].",";
		}
		
		return $data;
	}

	public function getNoSessionalViva($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$data = 0;
		$dalRemunerationIndividual = new DALRemunerationIndividual();
		$result = $dalRemunerationIndividual->getSessionalViva($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
		while($res = mysqli_fetch_assoc($result))
		{
			$data += $res['noScripts'];
		}
	}
	public function getRateSessionalViva($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$data = 0;
		$dalRemunerationIndividual = new DALRemunerationIndividual();
		$result = $dalRemunerationIndividual->getRate($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId,"Sessional");
		while($res = mysqli_fetch_assoc($result))
		{
			$data += $res['amount'];
		}
		return $data;
	}
	public function getTotalSessionalViva($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$no = $this->getNoSessionalViva($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
	 	$rate = $this->getRateSessionalViva($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);

	 	return $no*$rate;
	}
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
# Industrial 50
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	public function getIndustrial($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$data = '';
	 	return $data;
	}

	public function getNoIndustrial($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$data = 0;
	 	return $data;
	}
	public function getRateIndustrial($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$data = 0;
		$dalRemunerationIndividual = new DALRemunerationIndividual();
		$result = $dalRemunerationIndividual->getRate($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId,"Industrial");
		while($res = mysqli_fetch_assoc($result))
		{
			$data += $res['amount'];
		}
		return $data;
	}
	public function getTotalIndustrial($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$no = $this->getNoIndustrial($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
	 	$rate = $this->getRateIndustrial($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);

	 	return $no*$rate;
	}
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
# Answer Script Examination 
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	public function getAnswerScriptExamination($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$data = '';
	 	return $data;
	}

	public function getNoAnswerScriptExamination($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$data = 0;
	 	return $data;
	}
	public function getRateAnswerScriptExamination($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$data = 0;
		
	 	return $data;
	}
	public function getTotalAnswerScriptExamination($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$no = $this->getNoAnswerScriptExamination($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
	 	$rate = $this->getRateAnswerScriptExamination($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);

	 	return $no*$rate;
	}
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
# Tabulation 200 // 30 
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	public function getTabulation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$data = '';
	 	return $data;
	}

	public function getNoTabulation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$data = 0;
	 	return $data;
	}
	public function getRateTabulation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$data = 0;
		$dalRemunerationIndividual = new DALRemunerationIndividual();
		$result = $dalRemunerationIndividual->getRate($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId,"Tabulation");
		while($res = mysqli_fetch_assoc($result))
		{
			$data += $res['amount'];
		}
		return $data;
	}
	public function getTotalTabulation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$no = $this->getNoTabulation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
	 	$rate = $this->getRateTabulation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);

	 	return $no*$rate;
	}



#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
# Sub total 
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	public function getSubTotal($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$QC = $this->getTotalQuestionsComposition($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
		$QM = $this->getTotalQuestionsModaration($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
		$AEv = $this->getTotalAnswerScriptEvaluation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
		$AEx = $this->getTotalAnswerScriptExamination($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
		$CT = $this->getTotalClassTest($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
		$SE = $this->getTotalSessional($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
		$SV = $this->getTotalSessionalViva($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
		$IN = $this->getTotalIndustrial($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
		$TB = $this->getTotalTabulation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
	 	return $QC + $QM + $AEv + $AEx + $CT + $SE + $SV + $IN + $TB;

	}
	public function getSubTotalInWord($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		$total = $this->getSubTotal($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);

		$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
	 	$f->setTextAttribute(NumberFormatter::DEFAULT_RULESET, "%spellout-numbering-verbose");
	   $word =  $f->format($total);
	   return ucwords($word);
	}
	public function getRate($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		return 0;

	}
}
?>
