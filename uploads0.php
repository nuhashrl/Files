<?php
include "./connection/dbconn.php";
   if(isset(POST['submit']))
   {    
       include "./uploads.php";
       $quiz = $files['quiz'];
       $lessonplan = $files['lessonplan'];
       $sufo = $files['sufo'];
       $labtuto = $files['labtuto'];
       $tuto = $files['tuto'];
       $final = $files['final'];
       $cdl = $files['cdl'];
       $test = $files['test'];
       $syllabus = $files['syllabus'];
       $assignment = $files['assignment'];
       $attendance = $files['attendance'];
       $material = $files['material'];
       $result = $files['result'];
       $answerscheme = $files['answerscheme'];
       
       $allowformat = ['pdf'];
       
       $dirQuiz = fileProcess($quiz,$allowformat,'quiz');
       $dirTest = fileProcess($test,$allowformat,'test');
       $dirSyllabus = fileProcess($syllabus,$allowformat,'syllabus');
       $dirFinal = fileProcess($final,$allowformat,'final');
       $dirResult = fileProcess($result,$allowformat,'result');
       $dirCDL = fileProcess($cdl,$allowformat,'cdl');
       $dirTuto = fileProcess($tuto,$allowformat,'tuto');
       $dirLab = fileProcess($labtuto,$allowformat,'labtuto');
       $dirAnswer = fileProcess($answerscheme,$allowformat,'answer');
       $dirAttendance = fileProcess($attendance,$allowformat,'attendance');
       $dirMaterial = fileProcess($material,$allowformat,'material');
       $dirLessonPlan = fileProcess($lessonplan,$allowformat,'lessonplan');
       $dirSufo = fileProcess($sufo,$allowformat,'sufo');
       $dirAss = fileProcess($assignment,$allowformat,'assignment');
       
       if($dirQuiz[0] && $dirAss[0] && $dirTest[0] && $dirSyllabus[0]&& $dirFinal[0] &&
           $dirResult[0] && $dirCDL[0] && $dirTuto[0] && $dirLab[0] && $dirAnswer[0] && $dirAttendance[0] && 
         $dirMaterial[0] && $dirLessonPlan[0] && $dirSufo[0] && $dirSufo[0] )
       {
           $sql = "INSERT INTO subject (syllabus,lessonPlan,material,studAttend,sufo,cdl,finalResult,test,quiz,tutorial,labtutorial,finalQuestion,assignment,answerScheme) VALUES 
           ('$dirQuiz[1]','$dirAss[1]','$dirTest[1]','$dirSyllabus[1]','$dirFinal[1]','$dirResult[1]','$dirCDL[1]','$dirTuto[1]',
           '$dirLab[1]','$dirAnswer[1]','$dirAttendance[1]','$dirMaterial[1]','$dirLessonPlan[1]','$dirSufo[1]')";
           if(!mysqli_query($dbconn, $sqlInsertPort)){
                array_push($errors, mysqli_error($dbconn));
            }
           echo "Upload Successful";
       }
       else{
           if (! $dirQuiz[0] )
           {
               echo $dirQuiz[1];
           }
           if (! $dirAss[0] )
           {
               echo $dirAss[1];
           }
           if (! $dirSyllabus[0] )
           {
               echo $dirSyllabus[1];
           }
           if (! $dirFinal[0] )
           {
               echo $dirFinal[1];
           }
           if (! $dirResult[0] )
           {
               echo $dirResult[1];
           }
           if (! $dirCDL[0] )
           {
               echo $dirCDL[1];
           }
           if (! $dirTuto[0] )
           {
               echo $dirTuto[1];
           }
           if (! $dirLab[0] )
           {
               echo $dirLab[1];
           }
           if (! $dirAnswer[0] )
           {
               echo $dirAnswer[1];
           }
           if (! $dirAttendance[0] )
           {
               echo $dirAttendance[1];
           }
           if (! $dirMaterial[0] )
           {
               echo $dirMaterial[1];
           }
            if (! $dirLessonPlan[0] )
           {
               echo $dirLessonPlan[1];
           }
            if (! $dirSufo[0] )
           {
               echo $dirSufo[1];
           }
       }
   }
?>