<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreCompanyRequest;
use App\Http\Requests\Auth\StoreStudentRequest;
use App\Models\City;
use App\Models\College;
use App\Models\Company;
use App\Models\Specialization;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
   public function registerStudent()
    {
        $cities = City::all();
        $colleges = College::all();
        $specializations = Specialization::all();

        return view('front.auth.register-student', compact('cities', 'colleges', 'specializations'));
    }

    public function storeStudent(StoreStudentRequest $request)
{
    DB::beginTransaction();

    try {
        $user = User::create([

            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student',
            'status' => 'active',
        ]);

        Student::create([
            'user_id' => $user->id,
            'city_id' => $request->city_id,
            'college_id' => $request->college_id,
            'specialization_id' => $request->specialization_id,
            'full_name' => $request->full_name,
            'university_number' => $request->university_number,
            'level' => $request->level ?? 'المستوى الأول',
            'general_status' => 'active',
            'address' => $request->address,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'birthdate' => $request->birthdate,
        ]);

        DB::commit();

        return redirect()->route('front.auth.login')->with('success', 'تم إنشاء حساب الطالب بنجاح');
    } catch (\Throwable $e) {
        DB::rollBack();
        dd($e->getMessage(), $e->getLine(), $e->getFile());
    }
}

    public function registerCompany()
    {
        $cities = City::all();

        return view('front.auth.register-company', compact('cities'));
    }

    public function storeCompany(StoreCompanyRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'company',
                'status' => 'active',
            ]);

            Company::create([
                'user_id' => $user->id,
                'city_id' => $request->city_id,
                'name' => $request->name,
                'phone' => $request->phone,
                'status' => 'pending',
                'address' => $request->address,
                'website' => $request->website,
                'field_name' => $request->field_name,
                'description' => $request->description,
            ]);

            DB::commit();

            return redirect()->route('front.auth.login')->with('success', 'تم إنشاء حساب الشركة بنجاح');
        } catch (\Throwable $e) {
    DB::rollBack();
    dd($e->getMessage(), $e->getLine(), $e->getFile());
}
        }
}