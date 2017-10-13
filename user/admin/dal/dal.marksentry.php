<?php
	/**
	*  Courseregistration CRUD
	*/
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/connect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/session.php');
	
	class DALMarksEntry
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

		public function getOfferedCourses($sessionId,$degreeId,$yearId,$termId,$varsityDeptId)
		{
			global $con;
			$sql = "SELECT offeredcourse.id as offeredCourseId, course.prefix,course.courseNo,course.courseTitle,course.credit FROM offeredcourse,course,offeredterm WHERE course.id = offeredcourse.courseId && offeredcourse.offeredTermId = offeredterm.id && offeredterm.degreeId = $degreeId && offeredterm.sessionId = $sessionId && offeredterm.yearId = $yearId && offeredterm.termId =$termId && offeredterm.varsityDeptId = $varsityDeptId";
			$result = mysqli_query($con,$sql);

			return $result;
		}

		public function getRegisteredCourses($sessionId,$degreeId,$yearId,$termId,$offeredCourseId,$varsityDeptId)
		{
			global $con;
			$sql = "SELECT student.studentId,registeredcourse.id as registeredCourseId FROM student,offeredterm,registeredterm,registeredcourse WHERE student.studentId = registeredterm.studentId && registeredcourse.registeredTermId = registeredterm.id && registeredcourse.offeredCourseId = $offeredCourseId && registeredterm.offeredTermId = offeredterm.id && offeredterm.degreeId = $degreeId && offeredterm.sessionId = $sessionId &&  offeredterm.yearId = $yearId && offeredterm.termId = $termId && offeredterm.varsityDeptId = $varsityDeptId ";
			$result = mysqli_query($con,$sql);

			return $result;
		}
		public function getMarkSections()
		{
			global $con;
			$sql = "SELECT * FROM section ORDER BY name ASC";
			$result = mysqli_query($con,$sql);

			return $result;
		}

		public function createMarksField($sessionId,$degreeId,$yearId,$termId,$offeredCourseId,$sectionIds,$varsityDeptId)
		{
			global $con;
			$returnMessage = "";
			$registeredCourses = $this->getRegisteredCourses($sessionId,$degreeId,$yearId,$termId,$offeredCourseId,$varsityDeptId);

			// Populate marks table
			while ($res = mysqli_fetch_assoc($registeredCourses))
			{
				$registeredCourseId = $res['registeredCourseId'];
				$resultInsert = $this->insertIntoMarks($registeredCourseId);
				$returnMessage .= "Marks Fields Created. <br>";
				
			}

			$registeredCoursesAgain = $this->getRegisteredCourses($sessionId,$degreeId,$yearId,$termId,$offeredCourseId,$varsityDeptId);
			// Get marksId just created befor.
			while ($res = mysqli_fetch_assoc($registeredCoursesAgain))
			{
				$registeredCourseId = $res['registeredCourseId'];
				$sqlMarksId = "SELECT * FROM mark WHERE mark.registeredCourseId = $registeredCourseId";
				$resultMarksId = mysqli_query($con,$sqlMarksId);
				$returnMessage .= "Marks Fields Retrived Successfully. <br>";
				// inner loop
				while ($resMarksId = mysqli_fetch_assoc($resultMarksId))
				{
					$markId = $resMarksId['id'];

					// inner most loop :-P
					foreach($sectionIds as $sectionId)
					{
						$sqlInsertMarkSection = "INSERT INTO marksection VALUES('',".$markId.",".$sectionId.",0)";
						$resultMarkSection = mysqli_query($con,$sqlInsertMarkSection);
					}
					$returnMessage .= "Marks Sections Created <br>";

				}
				
			}
			return $returnMessage;
		}
//------------Helpe functions for createMarksField-----------------------
		public function insertIntoMarks($registeredCourseId)
		{
			global $con;
			$sql_marks = "INSERT INTO mark VALUES('',$registeredCourseId,0)";
			mysqli_query($con,$sql_marks);
		}

		public function getHeaders($offeredCourseId)
		{
			global $con;
			$sql = "SELECT section.name as sectionName,section.id as sectionId,section.percentage FROM section,marksection,mark,registeredcourse WHERE section.id = marksection.sectionId && marksection.markId = mark.id && mark.registeredCourseId = registeredcourse.id && registeredcourse.offeredCourseId = $offeredCourseId";
			$result = mysqli_query($con,$sql);

			return $result;
		}

	}


?>