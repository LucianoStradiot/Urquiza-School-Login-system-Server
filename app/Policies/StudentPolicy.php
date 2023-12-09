<?php

namespace App\Policies;

use App\Models\SuperAdmin;
use App\Models\Student;

class StudentPolicy
{
    public function delete(SuperAdmin $superAdmin, Student $student)
    {
        return $superAdmin->career === 'SA';
    }
}
