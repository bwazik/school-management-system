<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->foreign('stage_id')->references('id')->on('stages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('classrooms', function (Blueprint $table) {
            $table->foreign('stage_id')->references('id')->on('stages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
                $table->foreign('grade_id')->references('id')->on('grades')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('parents', function (Blueprint $table) {
            $table->foreign('father_nationality')->references('id')->on('nationalities')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('father_blood_type')->references('id')->on('blood_type')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('father_religion')->references('id')->on('religions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('mother_nationality')->references('id')->on('nationalities')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('mother_blood_type')->references('id')->on('blood_type')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('mother_religion')->references('id')->on('religions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('teachers', function (Blueprint $table) {
            $table->foreign('subject_id')->references('id')->on('subjects')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('gender_id')->references('id')->on('genders')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('classroom_teacher', function (Blueprint $table) {
            $table->foreign('classroom_id')->references('id')->on('classrooms')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('students', function (Blueprint $table) {
            $table->foreign('stage_id')->references('id')->on('stages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('grade_id')->references('id')->on('grades')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('classroom_id')->references('id')->on('classrooms')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('parent_id')->references('id')->on('parents')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('gender_id')->references('id')->on('genders')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('nationality')->references('id')->on('nationalities')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('blood_type')->references('id')->on('blood_type')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('religion')->references('id')->on('religions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('promotions', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('from_stage')->references('id')->on('stages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('from_grade')->references('id')->on('grades')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('from_classroom')->references('id')->on('classrooms')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('to_stage')->references('id')->on('stages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('to_grade')->references('id')->on('grades')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('to_classroom')->references('id')->on('classrooms')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('fees', function (Blueprint $table) {
            $table->foreign('stage_id')->references('id')->on('stages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('grade_id')->references('id')->on('grades')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->foreign('stage_id')->references('id')->on('stages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('grade_id')->references('id')->on('grades')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('student_id')->references('id')->on('students')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('fee_id')->references('id')->on('fees')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('student_account', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('invoice_id')->references('id')->on('invoices')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('receipt_id')->references('id')->on('receipts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('payment_id')->references('id')->on('payments')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('refund_id')->references('id')->on('refunds')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
        Schema::table('receipts', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
        Schema::table('funds', function (Blueprint $table) {
            $table->foreign('receipt_id')->references('id')->on('receipts')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('payment_id')->references('id')->on('payments')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
        Schema::table('refunds', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
        Schema::table('attendances', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('stage_id')->references('id')->on('stages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('grade_id')->references('id')->on('grades')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('classroom_id')->references('id')->on('classrooms')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('quizzes', function (Blueprint $table) {
            $table->foreign('stage_id')->references('id')->on('stages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('grade_id')->references('id')->on('grades')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('classroom_id')->references('id')->on('classrooms')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('questions', function (Blueprint $table) {
            $table->foreign('quiz_id')->references('id')->on('quizzes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('answers', function (Blueprint $table) {
            $table->foreign('question_id')->references('id')->on('questions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('online_classes', function (Blueprint $table) {
            $table->foreign('stage_id')->references('id')->on('stages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('grade_id')->references('id')->on('grades')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('classroom_id')->references('id')->on('classrooms')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('library', function (Blueprint $table) {
            $table->foreign('stage_id')->references('id')->on('stages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('grade_id')->references('id')->on('grades')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('classroom_id')->references('id')->on('classrooms')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->dropForeign('grades_stage_id_foreign');
        });
        Schema::table('classrooms', function (Blueprint $table) {
            $table->dropForeign('classrooms_stage_id_foreign');
            $table->dropForeign('classrooms_grade_id_foreign');
        });
        Schema::table('parents', function (Blueprint $table) {
            $table->dropForeign('parents_father_nationality_foreign');
            $table->dropForeign('parents_father_blood_type_foreign');
            $table->dropForeign('parents_father_religion_foreign');
            $table->dropForeign('parents_mother_nationality_foreign');
            $table->dropForeign('parents_mother_blood_type_foreign');
            $table->dropForeign('parents_mother_religion_foreign');
        });
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropForeign('teachers_subject_id_foreign');
            $table->dropForeign('teachers_gender_id_foreign');
        });
        Schema::table('classroom_teacher', function (Blueprint $table) {
            $table->dropForeign('classroom_teacher_classroom_id_foreign');
            $table->dropForeign('classroom_teacher_teacher_id_foreign');
        });
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign('students_stage_id_foreign');
            $table->dropForeign('students_grade_id_foreign');
            $table->dropForeign('students_classroom_id_foreign');
            $table->dropForeign('students_parent_id_foreign');
            $table->dropForeign('students_gender_id_foreign');
            $table->dropForeign('students_nationality_foreign');
            $table->dropForeign('students_blood_type_foreign');
            $table->dropForeign('students_religion_foreign');
        });
        Schema::table('promotions', function (Blueprint $table) {
            $table->dropForeign('promotions_student_id_foreign');
            $table->dropForeign('promotions_from_stage_foreign');
            $table->dropForeign('promotions_from_grade_foreign');
            $table->dropForeign('promotions_from_classroom_foreign');
            $table->dropForeign('promotions_to_stage_foreign');
            $table->dropForeign('promotions_to_grade_foreign');
            $table->dropForeign('promotions_to_classroom_foreign');
        });
        Schema::table('fees', function (Blueprint $table) {
            $table->dropForeign('fees_stage_id_foreign');
            $table->dropForeign('fees_grade_id_foreign');
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign('invoices_stage_id_foreign');
            $table->dropForeign('invoices_grade_id_foreign');
            $table->dropForeign('invoices_student_id_foreign');
            $table->dropForeign('invoices_fee_id_foreign');
        });
        Schema::table('student_account', function (Blueprint $table) {
            $table->dropForeign('student_account_student_id_foreign');
            $table->dropForeign('student_account_invoice_id_foreign');
            $table->dropForeign('student_account_receipt_id_foreign');
            $table->dropForeign('student_account_payment_id_foreign');
            $table->dropForeign('student_account_refund_id_foreign');
        });
        Schema::table('receipts', function (Blueprint $table) {
            $table->dropForeign('receipts_student_id_foreign');
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign('payments_student_id_foreign');
        });
        Schema::table('funds', function (Blueprint $table) {
            $table->dropForeign('funds_receipt_id_foreign');
            $table->dropForeign('funds_payment_id_foreign');
        });
        Schema::table('refunds', function (Blueprint $table) {
            $table->dropForeign('refunds_student_id_foreign');
        });
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign('attendances_student_id_foreign');
            $table->dropForeign('attendances_stage_id_foreign');
            $table->dropForeign('attendances_grade_id_foreign');
            $table->dropForeign('attendances_classroom_id_foreign');
            $table->dropForeign('attendances_teacher_id_foreign');
        });
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropForeign('quizzes_stage_id_foreign');
            $table->dropForeign('quizzes_grade_id_foreign');
            $table->dropForeign('quizzes_classroom_id_foreign');
            $table->dropForeign('quizzes_subject_id_foreign');
            $table->dropForeign('quizzes_teacher_id_foreign');
        });
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign('questions_quiz_id_foreign');
        });
        Schema::table('answers', function (Blueprint $table) {
            $table->dropForeign('answers_question_id_foreign');
        });
        Schema::table('online_classes', function (Blueprint $table) {
            $table->dropForeign('online_classes_stage_id_foreign');
            $table->dropForeign('online_classes_grade_id_foreign');
            $table->dropForeign('online_classes_classroom_id_foreign');
            $table->dropForeign('online_classes_teacher_id_foreign');
        });
        Schema::table('library', function (Blueprint $table) {
            $table->dropForeign('library_stage_id_foreign');
            $table->dropForeign('library_grade_id_foreign');
            $table->dropForeign('library_classroom_id_foreign');
            $table->dropForeign('library_teacher_id_foreign');
        });
    }
};
