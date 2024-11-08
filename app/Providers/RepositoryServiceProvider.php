<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Interfaces\SchoolManagement\StageRepositoryInterface;
use App\Interfaces\SchoolManagement\GradeRepositoryInterface;
use App\Interfaces\SchoolManagement\ClassroomRepositoryInterface;
use App\Interfaces\SchoolManagement\SubjectRepositoryInterface;
use App\Interfaces\Users\ParentRepositoryInterface;
use App\Interfaces\Users\TeacherRepositoryInterface;
use App\Interfaces\StudentsManagement\StudentRepositoryInterface;
use App\Interfaces\StudentsManagement\PromotionRepositoryInterface;
use App\Interfaces\StudentsManagement\GraduationRepositoryInterface;
use App\Interfaces\Finance\FeeRepositoryInterface;
use App\Interfaces\Finance\InvoiceRepositoryInterface;
use App\Interfaces\Finance\ReceiptRepositoryInterface;
use App\Interfaces\Finance\PaymentRepositoryInterface;
use App\Interfaces\Finance\RefundRepositoryInterface;
use App\Interfaces\StudentActivities\AttendanceRepositoryInterface;
use App\Interfaces\StudentActivities\QuizRepositoryInterface;
use App\Interfaces\StudentActivities\QuestionRepositoryInterface;
use App\Interfaces\StudentActivities\OnlineClassRepositoryInterface;
use App\Interfaces\StudentActivities\LibraryRepositoryInterface;
use App\Interfaces\Settings\SettingRepositoryInterface;
use App\Repositories\SchoolManagement\StageRepository;
use App\Repositories\SchoolManagement\GradeRepository;
use App\Repositories\SchoolManagement\ClassroomRepository;
use App\Repositories\SchoolManagement\SubjectRepository;
use App\Repositories\Users\ParentRepository;
use App\Repositories\Users\TeacherRepository;
use App\Repositories\StudentsManagement\StudentRepository;
use App\Repositories\StudentsManagement\PromotionRepository;
use App\Repositories\StudentsManagement\GraduationRepository;
use App\Repositories\Finance\FeeRepository;
use App\Repositories\Finance\InvoiceRepository;
use App\Repositories\Finance\ReceiptRepository;
use App\Repositories\Finance\PaymentRepository;
use App\Repositories\Finance\RefundRepository;
use App\Repositories\StudentActivities\AttendanceRepository;
use App\Repositories\StudentActivities\QuizRepository;
use App\Repositories\StudentActivities\QuestionRepository;
use App\Repositories\StudentActivities\OnlineClassRepository;
use App\Repositories\StudentActivities\LibraryRepository;
use App\Repositories\Settings\SettingRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(StageRepositoryInterface::class, StageRepository::class);
        $this->app->bind(GradeRepositoryInterface::class, GradeRepository::class);
        $this->app->bind(ClassroomRepositoryInterface::class, ClassroomRepository::class);
        $this->app->bind(SubjectRepositoryInterface::class, SubjectRepository::class);
        $this->app->bind(ParentRepositoryInterface::class, ParentRepository::class);
        $this->app->bind(TeacherRepositoryInterface::class, TeacherRepository::class);
        $this->app->bind(StudentRepositoryInterface::class, StudentRepository::class);
        $this->app->bind(PromotionRepositoryInterface::class, PromotionRepository::class);
        $this->app->bind(GraduationRepositoryInterface::class, GraduationRepository::class);
        $this->app->bind(FeeRepositoryInterface::class, FeeRepository::class);
        $this->app->bind(InvoiceRepositoryInterface::class, InvoiceRepository::class);
        $this->app->bind(ReceiptRepositoryInterface::class, ReceiptRepository::class);
        $this->app->bind(RefundRepositoryInterface::class, RefundRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);
        $this->app->bind(AttendanceRepositoryInterface::class, AttendanceRepository::class);
        $this->app->bind(QuizRepositoryInterface::class, QuizRepository::class);
        $this->app->bind(QuestionRepositoryInterface::class, QuestionRepository::class);
        $this->app->bind(OnlineClassRepositoryInterface::class, OnlineClassRepository::class);
        $this->app->bind(LibraryRepositoryInterface::class, LibraryRepository::class);
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
