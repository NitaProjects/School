<?php
    ini_set('display_errors','On');
    
    require __DIR__.'/vendor/autoload.php';


    use App\School\Student\Student;
    use App\School\Teacher\Teacher;
    use App\School\Course\Course;
    use App\School\Subject\Subject;

    $student=new Student("test@test.com","Alberto");
    $teacher=new Teacher("profe@test.com","Jordi");
    
    $materia1=new Subject("M7");
    $materia2=new Subject("M8");
    $daw_2=new Course("2DAW");
    $daw_2->addSubject($materia1)->addSubject($materia2);

    dd($daw_2);
   
