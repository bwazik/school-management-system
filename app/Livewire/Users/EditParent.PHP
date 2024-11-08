<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\Blood;
use App\Models\Nationality;
use App\Models\Religion;
use App\Models\MyParent;
use Illuminate\Support\Facades\Hash;

class EditParent extends Component
{
    public $currentStep = 1, $successMessage = '',

    $id, $email , $password, $delete_selected_id,

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

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'email' => 'required | email | unique:parents,email,' . $this->id,
            'password' => 'max:50',

            'father_name_ar' => 'required | max:100',
            'father_name_en' => 'required | max:100',
            'father_job_ar' => 'required | max:100',
            'father_job_en' => 'required | max:100',
            'father_national_id' => 'required | string | min:10 | max:10 | regex:/[0-9]{9}/ | unique:parents,father_national_id,'.$this->id,
            'father_passport_id' => 'required | string | min:10 | max:10 | regex:/[0-9]{9}/ | unique:parents,father_passport_id,'.$this->id,
            'father_phone' => 'required | string | regex:/^([0-9\s\-\+\(\)]*)$/ | min:10 | unique:parents,father_phone,'.$this->id,
            'father_address_ar' => 'required | max:150',
            'father_address_en' => 'required | max:150',
            'father_nationality' => 'required | integer',
            'father_blood_type' => 'required | integer',
            'father_religion' => 'required | integer',

            'mother_name_ar' => 'required | max:100',
            'mother_name_en' => 'required | max:100',
            'mother_job_ar' => 'required | max:100',
            'mother_job_en' => 'required | max:100',
            'mother_national_id' => 'required | string | min:10 | max:10 | regex:/[0-9]{9}/ | unique:parents,mother_national_id,'.$this->id,
            'mother_passport_id' => 'required | string | min:10 | max:10 | regex:/[0-9]{9}/ | unique:parents,mother_passport_id,'.$this->id,
            'mother_phone' => 'required | string | regex:/^([0-9\s\-\+\(\)]*)$/ | min:10 | unique:parents,mother_phone,'.$this->id,
            'mother_address_ar' => 'required | max:150',
            'mother_address_en' => 'required | max:150',
            'mother_nationality' => 'required | integer',
            'mother_blood_type' => 'required | integer',
            'mother_religion' => 'required | integer',
        ]);
    }

    public function mount($id)
    {
        $parent = MyParent::findOrFail($id);

        $this -> id = $parent -> id;
        $this -> email = $parent -> email;

        $this -> father_name_ar = $parent -> getTranslation('father_name', 'ar');
        $this -> father_name_en = $parent -> getTranslation('father_name', 'en');
        $this -> father_national_id = $parent -> father_national_id;
        $this -> father_passport_id = $parent -> father_passport_id;
        $this -> father_phone = $parent -> father_phone;
        $this -> father_job_ar = $parent -> getTranslation('father_job', 'ar');;
        $this -> father_job_en = $parent -> getTranslation('father_job', 'en');
        $this -> father_nationality = $parent -> father_nationality;
        $this -> father_blood_type = $parent -> father_blood_type;
        $this -> father_religion = $parent -> father_religion;
        $this -> father_address_ar = $parent -> getTranslation('father_address', 'ar');
        $this -> father_address_en = $parent -> getTranslation('father_address', 'en');

        $this -> mother_name_ar = $parent -> getTranslation('mother_name', 'ar');
        $this -> mother_name_en = $parent -> getTranslation('mother_name', 'en');
        $this -> mother_national_id = $parent -> mother_national_id;
        $this -> mother_passport_id = $parent -> mother_passport_id;
        $this -> mother_phone = $parent -> mother_phone;
        $this -> mother_job_ar = $parent -> getTranslation('mother_job', 'ar');;
        $this -> mother_job_en = $parent -> getTranslation('mother_job', 'en');
        $this -> mother_nationality = $parent -> mother_nationality;
        $this -> mother_blood_type = $parent -> mother_blood_type;
        $this -> mother_religion = $parent -> mother_religion;
        $this -> mother_address_ar = $parent -> getTranslation('mother_address', 'ar');
        $this -> mother_address_en = $parent ->getTranslation('mother_address', 'en');
    }

    public function render()
    {
        return view('users.parents.edit.form', [
            'nationalities' => Nationality::select('id', 'name')->orderBy('id')->get(),
            'bloods' => Blood::select('id', 'name')->orderBy('id')->get(),
            'religions' => Religion::select('id', 'name')->orderBy('id')->get(),
        ]);
    }

    public function firstStepSubmit()
    {
        $this->validate([
            'email' => 'required | email | unique:parents,email,'.$this->id,
            'password' => 'max:50',

            'father_name_ar' => 'required | max:100',
            'father_name_en' => 'required | max:100',
            'father_job_ar' => 'required | max:100',
            'father_job_en' => 'required | max:100',
            'father_national_id' => 'required | string | min:10 | max:10 | regex:/[0-9]{9}/ | unique:parents,father_national_id,'.$this->id,
            'father_passport_id' => 'required | string | min:10 | max:10 | regex:/[0-9]{9}/ | unique:parents,father_passport_id,'.$this->id,
            'father_phone' => 'required | string | regex:/^([0-9\s\-\+\(\)]*)$/ | min:10 | unique:parents,father_phone,'.$this->id,
            'father_address_ar' => 'required | max:150',
            'father_address_en' => 'required | max:150',
            'father_nationality' => 'required | integer',
            'father_blood_type' => 'required | integer',
            'father_religion' => 'required | integer',
        ]);

        $this -> currentStep = 2;
    }

    public function secondStepSubmit()
    {
        $this->validate([
            'mother_name_ar' => 'required | max:100',
            'mother_name_en' => 'required | max:100',
            'mother_job_ar' => 'required | max:100',
            'mother_job_en' => 'required | max:100',
            'mother_national_id' => 'required | string | min:10 | max:10 | regex:/[0-9]{9}/ | unique:parents,mother_national_id,'.$this->id,
            'mother_passport_id' => 'required | string | min:10 | max:10 | regex:/[0-9]{9}/ | unique:parents,mother_passport_id,'.$this->id,
            'mother_phone' => 'required | string | regex:/^([0-9\s\-\+\(\)]*)$/ | min:10 | unique:parents,mother_phone,'.$this->id,
            'mother_address_ar' => 'required | max:150',
            'mother_address_en' => 'required | max:150',
            'mother_nationality' => 'required | integer',
            'mother_blood_type' => 'required | integer',
            'mother_religion' => 'required | integer',
        ]);

        $this -> currentStep = 3;
    }

    public function back($step)
    {
        $this -> currentStep = $step;
    }

    public function submitForm()
    {
        if ($this -> id){
            $parent = MyParent::findOrFail($this -> id);

            if(!empty($this -> password))
            {
                $parent->update([
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

                $this -> password = '';
            }
            else
            {
                $parent->update([
                    'email' => $this -> email,

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

                $this -> password = '';
            }
        }

        return redirect()->route('editParent', $this -> id)->with('edited', trans('users/parents.edited'));
    }
}
