<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\Specialize;
use App\Models\SpecializeEmployer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployerController extends Controller
{
    public function get_special()
    {
        return response()->json(Specialize::all());
    }

    public function get_teachers()
    {
        $teacher = Employer::query()->with('specialize_employers.specialize')->get();
        return response()->json($teacher);
    }

    public function create(Request $request)
    {
        $valid = Validator::make($request->data, [
            'name' => ['required', 'string'],
            'lastName' => ['required', 'string'],
            'patronymic' => ['string'],
            'image' => ['required', 'mimes:jpg,bmp,png,webp'],
        ],
            [
                'required' => 'Обязательное поле',
                'string' => 'Поле должно содержать текст',
                'mimes' => 'Выберите изображение'
            ]);
        if ($valid->fails()) {
            return response()->json($valid->errors(), 500);
        }
        DB::transaction(function () use ($request) {
            $employe = Employer::query()->create([
                'name' => $request->data['name'],
                'lastName' => $request->data['lastName'],
                'patronymic' => $request->data['patronymic'],
                'image' => $this->uploadImage($request->data['image']),
            ]);

            foreach ($request->selectSpecials as $selectSpecial) {
                SpecializeEmployer::query()->create([
                    'employer_id' => $employe->id,
                    'specialize_id' => $selectSpecial,
                ]);
            }
            return response()->json('Специалист цспешно добавлен!', 200);
        });
    }

    public function edit(Request $request)
    {
        $teacher = Employer::query()->find($request->teacher_id);

        $data = [
            'name' => $request->input('data.name'),
            'lastName' => $request->input('data.lastName'),
            'patronymic' => $request->input('data.patronymic')
        ];

        if ($request->file('data.image')) {
            $data['image'] = $this->uploadImage($request->data['image']);
        }

        $teacher->update($data);

        $specializeIds = $request->input('selectSpecials');
        if (is_array($specializeIds)) {
            $teacher->specializes()->sync($specializeIds);
        }
        return response()->json([
            'data' => $teacher,
            'selectSpecials' => $teacher->specializes()->pluck('specializes.id'),
            'teacher_id' => $teacher->teacher_id
        ]);
    }

    public function delete($id){
        $teacher = Employer::query()->find($id);
        $teacher->delete();
        return response()->json('Специалист удален!', 200);
    }

    private function uploadImage($file)
    {
        $filePath = 'storage/images/' . $file->getClientOriginalName();
        $file->move('storage/images/', $file->getClientOriginalName());
        return $filePath;
    }
}
