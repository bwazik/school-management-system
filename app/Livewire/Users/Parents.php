<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\Blood;
use App\Models\Nationality;
use App\Models\Religion;
use App\Models\MyParent;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;

class Parents extends Component
{
    use WithFileUploads;

    public $currentStep = 1, $successMessage = '',

    $dataTable = true,

    $email , $password,
    $attachments=[],

    # Father Informations
    $father_name_ar, $father_name_en,
    $father_job_ar, $father_job_en,
    $father_national_id, $father_passport_id,
    $father_phone, $father_address_ar, $father_address_en,
    $father_nationality, $father_blood_type, $father_religion,

    # Mother Informations
    $mother_name_ar, $mother_name_en,
    $mother_job_ar, $mother_job_en,
    $mother_national_id, $mother_passport_id,
    $mother_phone, $mother_address_ar, $mother_address_en,
    $mother_nationality, $mother_blood_type, $mother_religion;

    protected $rules =
    [
        'email' => 'required | email | unique:parents,email',
        'password' => 'required | min:8 | max:50',
        'attachments.*' => 'image | max:1024 | mimes:jpg,jpeg,png',
        'attachments' => 'max:3',

        'father_name_ar' => 'required | max:100',
        'father_name_en' => 'required | max:100',
        'father_job_ar' => 'required | max:100',
        'father_job_en' => 'required | max:100',
        'father_national_id' => 'required | string | min:10 | max:10 | regex:/[0-9]{9}/ | unique:parents,father_national_id',
        'father_passport_id' => 'required | string | min:10 | max:10 | regex:/[0-9]{9}/ | unique:parents,father_passport_id',
        'father_phone' => 'required | string | regex:/^([0-9\s\-\+\(\)]*)$/ | min:10 | unique:parents,father_phone',
        'father_address_ar' => 'required | max:150',
        'father_address_en' => 'required | max:150',
        'father_nationality' => 'required | integer',
        'father_blood_type' => 'required | integer',
        'father_religion' => 'required | integer',

        'mother_name_ar' => 'required | max:100',
        'mother_name_en' => 'required | max:100',
        'mother_job_ar' => 'required | max:100',
        'mother_job_en' => 'required | max:100',
        'mother_national_id' => 'required | string | min:10 | max:10 | regex:/[0-9]{9}/ | unique:parents,mother_national_id',
        'mother_passport_id' => 'required | string | min:10 | max:10 | regex:/[0-9]{9}/ | unique:parents,mother_passport_id',
        'mother_phone' => 'required | string | regex:/^([0-9\s\-\+\(\)]*)$/ | min:10 | unique:parents,mother_phone',
        'mother_address_ar' => 'required | max:150',
        'mother_address_en' => 'required | max:150',
        'mother_nationality' => 'required | integer',
        'mother_blood_type' => 'required | integer',
        'mother_religion' => 'required | integer',
    ];

    protected $fatherRules =
    [
        'email' => 'required | email | unique:parents,email',
        'password' => 'required | min:8 | max:50',

        'father_name_ar' => 'required | max:100',
        'father_name_en' => 'required | max:100',
        'father_job_ar' => 'required | max:100',
        'father_job_en' => 'required | max:100',
        'father_national_id' => 'required | string | min:10 | max:10 | regex:/[0-9]{9}/ | unique:parents,father_national_id',
        'father_passport_id' => 'required | string | min:10 | max:10 | regex:/[0-9]{9}/ | unique:parents,father_passport_id',
        'father_phone' => 'required | string | regex:/^([0-9\s\-\+\(\)]*)$/ | min:10 | unique:parents,father_phone',
        'father_address_ar' => 'required | max:150',
        'father_address_en' => 'required | max:150',
        'father_nationality' => 'required | integer',
        'father_blood_type' => 'required | integer',
        'father_religion' => 'required | integer',
    ];

    protected $motherRules =
    [
        'mother_name_ar' => 'required | max:100',
        'mother_name_en' => 'required | max:100',
        'mother_job_ar' => 'required | max:100',
        'mother_job_en' => 'required | max:100',
        'mother_national_id' => 'required | string | min:10 | max:10 | regex:/[0-9]{9}/ | unique:parents,mother_national_id',
        'mother_passport_id' => 'required | string | min:10 | max:10 | regex:/[0-9]{9}/ | unique:parents,mother_passport_id',
        'mother_phone' => 'required | string | regex:/^([0-9\s\-\+\(\)]*)$/ | min:10 | unique:parents,mother_phone',
        'mother_address_ar' => 'required | max:150',
        'mother_address_en' => 'required | max:150',
        'mother_nationality' => 'required | integer',
        'mother_blood_type' => 'required | integer',
        'mother_religion' => 'required | integer',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('users.parents.form', [
            'parents' => MyParent::all(),
            'nationalities' => Nationality::select('id', 'name')->orderBy('id')->get(),
            'bloods' => Blood::select('id', 'name')->orderBy('id')->get(),
            'religions' => Religion::select('id', 'name')->orderBy('id')->get(),
        ]);
    }

    public function showAddForm()
    {
        $this -> dataTable = false;
    }

    public function showDataTable()
    {
        $this -> dataTable = true;
    }

    public function firstStepSubmit()
    {
        $this->validate($this -> fatherRules);

        $this -> currentStep = 2;
    }

    public function secondStepSubmit()
    {
        $this->validate($this -> motherRules);

        $this -> currentStep = 3;
    }

    public function back($step)
    {
        $this -> currentStep = $step;
    }

    public function submitForm()
    {
        $this->validate([
            'attachments.*' => 'image | max:1024 | mimes:jpg,jpeg,png',
            'attachments' => 'max:3',
        ]);

        DB::beginTransaction();

        $parent = MyParent::create([
            'email' => $this -> email,
            'password' => Hash::make($this -> password),

            'father_name' => ['en' => $this -> father_name_en, 'ar' => $this -> father_name_ar],
            'father_national_id' => $this -> father_national_id,
            'father_passport_id' => $this -> father_passport_id,
            'father_phone' => $this -> father_phone,
            'father_job' => ['en' => $this -> father_job_en, 'ar' => $this -> father_job_ar],
            'father_nationality' => $this -> father_nationality,
            'father_blood_type' => $this -> father_blood_type,
            'father_religion' => $this -> father_religion,
            'father_address' => ['en' => $this -> father_address_en, 'ar' => $this -> father_address_ar],

            'mother_name' => ['en' => $this -> mother_name_en, 'ar' => $this -> mother_name_ar],
            'mother_national_id' => $this -> mother_national_id,
            'mother_passport_id' => $this -> mother_passport_id,
            'mother_phone' => $this -> mother_phone,
            'mother_job' => ['en' => $this -> mother_job_en, 'ar' => $this -> mother_job_ar],
            'mother_nationality' => $this -> mother_nationality,
            'mother_blood_type' => $this -> mother_blood_type,
            'mother_religion' => $this -> mother_religion,
            'mother_address' => ['en' => $this -> mother_address_en, 'ar' => $this -> mother_address_ar],
        ]);

        if (!empty($this -> attachments)){
            foreach ($this -> attachments as $attachment) {
                $name = $attachment -> getClientOriginalName();
                $attachment -> storeAs($this -> father_national_id, $attachment -> getClientOriginalName(), 'parents');

                Image::create([
                    'file_name' => $name,
                    'imageable_id' => $parent -> id,
                    'imageable_type' => 'App\Models\MyParent',
                ]);
            }
        }

        DB::commit();

        $this -> successMessage = trans('users/parents.added');
        $this -> clearForm();
        $this -> currentStep = 1;

        DB::rollback();
    }

    public function clearForm()
    {
        $this -> email = '';
        $this -> password = '';
        $this -> attachments = '';

        $this -> father_name_ar = '';
        $this -> father_name_en = '';
        $this -> father_national_id = '';
        $this -> father_passport_id = '';
        $this -> father_phone = '';
        $this -> father_job_ar = '';
        $this -> father_job_en = '';
        $this -> father_nationality = '';
        $this -> father_blood_type = '';
        $this -> father_religion = '';
        $this -> father_address_ar = '';
        $this -> father_address_en = '';

        $this -> mother_name_ar = '';
        $this -> mother_name_en = '';
        $this -> mother_national_id = '';
        $this -> mother_passport_id = '';
        $this -> mother_phone = '';
        $this -> mother_job_ar = '';
        $this -> mother_job_en = '';
        $this -> mother_nationality = '';
        $this -> mother_blood_type = '';
        $this -> mother_religion = '';
        $this -> mother_address_ar = '';
        $this -> mother_address_en = '';
    }
}
