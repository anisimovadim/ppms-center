<?php

namespace App\Http\Controllers;

use App\Models\Diagnose;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiagnoseController extends Controller
{
    public function show(){
        return response()->json(Diagnose::all());
    }
    public function change(Request $request)
    {
        DB::beginTransaction();

        try {
            $existingItems = array_filter($request->all(), fn($item) => isset($item['id']));
            $newItems = array_filter($request->all(), fn($item) => !isset($item['id']));

            $existingIds = array_column($existingItems, 'id');

            Diagnose::query()->whereNotIn('id', $existingIds)->delete();

            foreach ($existingItems as $item){
                Diagnose::query()->where('id', $item['id'])->update($item);
            }

            foreach ($newItems as $item) {
                Diagnose::create($item);
            }
            DB::commit();
            return response()->json('Данные успешно сохранены', 200);
        }
        catch (\Exception $e){
            DB::rollBack();
            return response()->json('При попытке сохранить данные, произошла ошибка, перезагрузите страницу и поповторите попытку снова!', 500);
        }
    }
}
