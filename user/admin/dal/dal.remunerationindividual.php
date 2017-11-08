<?php
/**
*  Courseregistration CRUD
*/
require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/connect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/session.php');

class DALRemunerationIndividual
{
	
	function __construct()
	{

		
	}

	// Return all the sessions registerd
	public function getSessions($varsityDeptId)
	{
		global $con;
		$sql = "SELECT DISTINCT(session.id) as sessionId,session.sessionName FROM session,offeredterm WHERE session.id = offeredterm.sessionId && offeredterm.varsityDeptId = $varsityDeptId ORDER BY sessionName DESC";
		$result = mysqli_query($con,$sql);

		return $result;
	}
	public function getSessionName($sessionId)
	{
		global $con;
		$sql = "SELECT * FROM session WHERE session.id = ".$sessionId;
		$result = mysqli_query($con,$sql);

		return $result;
	}
	public function getDeptName($deptId)
	{
		global $con;
		$sql = "SELECT * FROM dept WHERE dept.id = ".$deptId;
		$result = mysqli_query($con,$sql);

		return $result;
	}

	// Return all the offeredTerm.sessionId that are running in that session
	public function getDegrees($varsityDeptId,$sessionId)
	{
		global $con;
		$sql = "SELECT DISTINCT(degree.id) AS degreeId,degree.name as degreeName FROM offeredterm,degree WHERE offeredterm.degreeId = degree.id && offeredterm.varsityDeptId = $varsityDeptId && offeredterm.sessionId = $sessionId";
		$result = mysqli_query($con,$sql);

		return $result;
	}

	// Return all the offeredTerm.yearId that are running in that session
	public function getYears($varsityDeptId,$sessionId,$degreeId)
	{
		global $con;
		$sql = "SELECT offeredterm.yearId,year.year as yearName FROM offeredterm,year WHERE offeredterm.yearId = year.id && offeredterm.sessionId = $sessionId && offeredterm.degreeId = $degreeId && offeredterm.varsityDeptId = $varsityDeptId ORDER BY year ASC";
		$result = mysqli_query($con,$sql);

		return $result;
	}

	// Return all the offeredTerm.termId that are running in that session
	public function getTerms($varsityDeptId,$sessionId,$degreeId,$yearId)
	{
		global $con;
		$sql = "SELECT term.id as termId,term.term AS termName FROM offeredterm,term WHERE offeredterm.termId = term.id && offeredterm.varsityDeptId = $varsityDeptId && offeredterm.degreeId = $degreeId && offeredterm.sessionId = $sessionId && offeredterm.yearId = $yearId ORDER BY term ASC";
		$result = mysqli_query($con,$sql);

		return $result;
	}

	
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
# Remunaration reports 
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	public function getTeachers($varsityDeptId,$sessionId,$degreeId,$yearId,$termId)
	{
		global $con;
		$sql = "SELECT user.fullName,teacher.id as teacherId FROM user,teacher,varsitydept,offeredterm WHERE user.id = teacher.userId && teacher.varsityDeptId = varsitydept.id && offeredterm.varsityDeptId = varsitydept.id && offeredterm.varsityDeptId = $varsityDeptId && offeredterm.degreeId = $degreeId && offeredterm.sessionId = $sessionId && offeredterm.yearId = $yearId && offeredterm.termId = $termId";
		$result = mysqli_query($con,$sql);

		return $result;
	}
	public function getTeacherInfo($teacherId)
	{
		global $con;
		$sql = "SELECT user.fullName,teacher.designation,teacher.address,dept.name as deptName FROM user,teacher,varsitydept,dept WHERE user.id = teacher.userId && teacher.varsityDeptId = varsitydept.id && varsitydept.deptId= dept.id && teacher.id = ".$teacherId;
		$result = mysqli_query($con,$sql);

		return $result;
	}
	public function getTheoryCourses($sessionId,$degreeId,$yearId,$termId,$varsityDeptId)
	{
		global $con;
		$sql = "SELECT COUNT(registeredcourse.id) as noScripts,user.fullName,course.prefix,course.courseNo FROM mark,marksection,section,registeredcourse,offeredcourse,course,offeredterm,offeredteacher,teacher,user WHERE section.id = marksection.sectionId && mark.id = marksection.markId && mark.registeredCourseId = registeredcourse.id && section.type = 'Theory' && section.name = 'Section A' && registeredcourse.offeredCourseId = offeredcourse.id && offeredcourse.courseId = course.id && offeredcourse.offeredTermId = offeredterm.id && offeredteacher.offeredCourseId = offeredcourse.id && offeredteacher.teacherId = teacher.id && teacher.userId = user.id && offeredterm.degreeId = $degreeId && offeredterm.sessionId = $sessionId && offeredterm.yearId = $yearId && offeredterm.termId = $termId && offeredterm.varsityDeptId = $varsityDeptId GROUP BY course.id,user.id";
		$result = mysqli_query($con,$sql);

		return $result;
	}

	public function getSessionalCourses($sessionId,$degreeId,$yearId,$termId,$varsityDeptId)
	{
		global $con;
		$sql = "SELECT COUNT(registeredcourse.id) as noScripts,user.fullName,course.prefix,course.courseNo FROM mark,marksection,section,registeredcourse,offeredcourse,course,offeredterm,offeredteacher,teacher,user WHERE section.id = marksection.sectionId && mark.id = marksection.markId && mark.registeredCourseId = registeredcourse.id && section.type = 'Sessional' && (section.name = 'Viva' || section.name = 'Project') && registeredcourse.offeredCourseId = offeredcourse.id && offeredcourse.courseId = course.id && offeredcourse.offeredTermId = offeredterm.id && offeredteacher.offeredCourseId = offeredcourse.id && offeredteacher.teacherId = teacher.id && teacher.userId = user.id && offeredterm.degreeId = $degreeId && offeredterm.sessionId = $sessionId && offeredterm.yearId = $yearId && offeredterm.termId = $termId && offeredterm.varsityDeptId = $varsityDeptId GROUP BY course.id,user.id";
		$result = mysqli_query($con,$sql);

		return $result;
	}
	public function getClassTests($sessionId,$degreeId,$yearId,$termId,$varsityDeptId)
	{
		global $con;
		$sql = "SELECT COUNT(registeredcourse.id) as noScripts,user.fullName,course.prefix,course.courseNo FROM mark,marksection,section,registeredcourse,offeredcourse,course,offeredterm,offeredteacher,teacher,user WHERE section.id = marksection.sectionId && mark.id = marksection.markId && mark.registeredCourseId = registeredcourse.id && section.name = 'Continuous Assessment' && registeredcourse.offeredCourseId = offeredcourse.id && offeredcourse.courseId = course.id && offeredcourse.offeredTermId = offeredterm.id && offeredteacher.offeredCourseId = offeredcourse.id && offeredteacher.teacherId = teacher.id && teacher.userId = user.id && offeredterm.degreeId = $degreeId && offeredterm.sessionId = $sessionId && offeredterm.yearId = $yearId && offeredterm.termId = $termId && offeredterm.varsityDeptId = $varsityDeptId GROUP BY course.id,user.id";
		$result = mysqli_query($con,$sql);

		return $result;
	}


#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
# Question Generation/Composition
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	public function getQuestionsComposition($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		global $con;
			$sql = "SELECT course.prefix,course.courseNo FROM course,offeredcourse,offeredteacher,offeredterm WHERE course.id = offeredcourse.courseId && offeredcourse.id = offeredteacher.offeredCourseId && offeredteacher.teacherId = $teacherId && offeredcourse.offeredTermId = offeredterm.id && offeredterm.degreeId = $degreeId && offeredterm.sessionId = $sessionId && offeredterm.yearId = $yearId && offeredterm.termId = $termId && offeredterm.varsityDeptId = $varsityDeptId && course.courseNo%2";
			$result = mysqli_query($con,$sql);

			return $result;
	}

	public function getNoQuestionsComposition($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		global $con;
			$sql = "SELECT COUNT(course.id) as noQuestions,course.courseNo FROM course,offeredcourse,offeredteacher,offeredterm WHERE course.id = offeredcourse.courseId && offeredcourse.id = offeredteacher.offeredCourseId && offeredteacher.teacherId = $teacherId && offeredcourse.offeredTermId = offeredterm.id && offeredterm.degreeId = $degreeId && offeredterm.sessionId = $sessionId && offeredterm.yearId = $yearId && offeredterm.termId = $termId && offeredterm.varsityDeptId = $varsityDeptId && course.courseNo%2";
			$result = mysqli_query($con,$sql);

			//echo $sql;
			return $result;
	}
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
# Class test 400
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	public function getClassTest($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		global $con;
			$sql = "SELECT COUNT(registeredcourse.id) as noScripts,user.fullName,course.prefix,course.courseNo FROM mark,marksection,section,registeredcourse,offeredcourse,course,offeredterm,offeredteacher,teacher,user WHERE section.id = marksection.sectionId && mark.id = marksection.markId && mark.registeredCourseId = registeredcourse.id && section.name = 'Continuous Assessment' && registeredcourse.offeredCourseId = offeredcourse.id && offeredcourse.courseId = course.id && offeredcourse.offeredTermId = offeredterm.id && offeredteacher.offeredCourseId = offeredcourse.id && offeredteacher.teacherId = $teacherId && offeredterm.degreeId = $degreeId && offeredterm.sessionId = $sessionId && offeredterm.yearId = $yearId && offeredterm.termId = $termId && offeredterm.varsityDeptId = $varsityDeptId && course.courseNo%2";
			$result = mysqli_query($con,$sql);

			return $result;
	}
	public function getNoClassTest($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		global $con;

		return 3;// Default 
	}
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
# Sessional
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	public function getSessional($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		global $con;
			$sql = "SELECT COUNT(registeredcourse.id) as noScripts,course.prefix,course.courseNo FROM mark,marksection,section,registeredcourse,offeredcourse,course,offeredterm,offeredteacher WHERE section.id = marksection.sectionId && mark.id = marksection.markId && mark.registeredCourseId = registeredcourse.id && section.type = 'Sessional' && section.name = 'Project' && registeredcourse.offeredCourseId = offeredcourse.id && offeredcourse.courseId = course.id && offeredcourse.offeredTermId = offeredterm.id && offeredteacher.offeredCourseId = offeredcourse.id && offeredteacher.teacherId = $teacherId && offeredterm.degreeId = $degreeId && offeredterm.sessionId = $sessionId && offeredterm.yearId =$yearId && offeredterm.termId = $termId && offeredterm.varsityDeptId = $varsityDeptId && course.courseNo%2=0";
			$result = mysqli_query($con,$sql);

			return $result;
	}

#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
# Sessional Viva
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	public function getSessionalViva($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)
	{
		global $con;
			$sql = "SELECT COUNT(registeredcourse.id) as noScripts,course.prefix,course.courseNo FROM mark,marksection,section,registeredcourse,offeredcourse,course,offeredterm,offeredteacher WHERE section.id = marksection.sectionId && mark.id = marksection.markId && mark.registeredCourseId = registeredcourse.id && section.type = 'Sessional' && section.name = 'Viva' && registeredcourse.offeredCourseId = offeredcourse.id && offeredcourse.courseId = course.id && offeredcourse.offeredTermId = offeredterm.id && offeredteacher.offeredCourseId = offeredcourse.id && offeredteacher.teacherId = $teacherId && offeredterm.degreeId = $degreeId && offeredterm.sessionId = $sessionId && offeredterm.yearId =$yearId && offeredterm.termId = $termId && offeredterm.varsityDeptId = $varsityDeptId && course.courseNo%2=0";
			$result = mysqli_query($con,$sql);

			return $result;
	}
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
# Rate of payments
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	public function getRate($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId,$fieldName)
	{
		global $con;
			$sql = "SELECT amount FROM paymentrate WHERE paymentrate.fieldName LIKE '%".$fieldName."%'";
			$result = mysqli_query($con,$sql);
			return $result;
	}
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
# No of students
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	public function getNoStudent($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId,$sectionName,$sectionType)
	{
		global $con;
		$sql = "SELECT COUNT(registeredcourse.id) as noStudents FROM mark,marksection,section,registeredcourse,offeredcourse,offeredterm,offeredteacher WHERE section.id = marksection.sectionId && mark.id = marksection.markId && mark.registeredCourseId = registeredcourse.id && section.type = 'Theory' && section.name = 'Section A' && registeredcourse.offeredCourseId = offeredcourse.id && offeredcourse.offeredTermId = offeredterm.id && offeredteacher.offeredCourseId = offeredcourse.id && offeredteacher.teacherId = $teacherId && offeredterm.degreeId = $degreeId && offeredterm.sessionId = $sessionId && offeredterm.yearId = $yearId && offeredterm.termId = $termId && offeredterm.varsityDeptId = $varsityDeptId";
		$result = mysqli_query($con,$sql);
		
		return $result;
	}

}
?>