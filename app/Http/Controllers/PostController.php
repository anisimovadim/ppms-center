<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Models\PostObject;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function show($id)
    {
        $page = Page::query()->where('title', $id)->first();
        $posts = Post::query()->where('page_id', $page->id)->with('post_objects')->get();
        return response()->json($posts);
    }

    public function show_id($id)
    {
        $post = Post::query()->where('id', $id)->with('post_objects')->first();
        return response()->json($post);
    }

    public function create(Request $request, $id)
    {
        $objects = $request->data;
        if ($objects === null) {
            return response()->json('Добавьте хотя бы один объект!', 402);
        }
        $rules = [
            '*.type' => 'required|string|in:title,text,link,image,video,file',
            '*.value' => 'required',
        ];
        $messages = [
            '*.type.required' => 'Необходимо указать тип объекта',
            '*.type.string' => 'Тип объекта должен быть строкой',
            '*.type.in' => 'Тип объекта должен быть одним из: title, text, link, image, video',
            '*.value.required' => 'Поле не должно быть пустым',
        ];
        $validator = Validator::make($objects, $rules, $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        DB::beginTransaction();

        try {
            $page = Page::query()->where('title', $id)->first();
            $post = new Post();
            $post->page_id = $page->id;
            $post->save();
            foreach ($objects as $object) {
                $newObject = new PostObject();
                $newObject->type = $object['type'];
                if ($this->isFile($object['value'])) {
                    $newObject->value = $this->uploadImage($object['value']);
                } else {
                    $newObject->value = $object['value'];
                }
                $newObject->post_id = $post->id;
                $newObject->save();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 500);
        }
        return response()->json('Пост успешно добавлен на страницу!', 200);
    }

    public function edit(Request $request, $id)
    {
        $objects = $request->data;
        if ($objects === null) {
            return response()->json('Добавьте хотя бы один объект!', 402);
        }
        $rules = [
            '*.type' => 'required|string|in:title,text,link,image,video,file',
            '*.value' => 'required',
        ];
        $messages = [
            '*.type.required' => 'Необходимо указать тип объекта',
            '*.type.string' => 'Тип объекта должен быть строкой',
            '*.type.in' => 'Тип объекта должен быть одним из: title, text, link, image, video',
            '*.value.required' => 'Поле не должно быть пустым',
        ];
        $validator = Validator::make($objects, $rules, $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        DB::beginTransaction();
        try {
            $post = Post::query()->find($id);
            foreach ($objects as $key => $object) {
                if (isset($object['id'])) {
                    PostObject::updateOrCreate([
                        'id' => $object['id'],
                        'post_id' => $post->id
                    ], [
                        'value' => $object['value'],
                        'post_id' => $post->id,
                        'type' => $object['type']
                    ]);
                } else {
                    PostObject::create([
                        'value' => $object['value'],
                        'post_id' => $post->id,
                        'type' => $object['type']
                    ]);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        $post = Post::query()->find($id);
        $post_objects = $post->post_objects;
        DB::beginTransaction();

        try {
            foreach ($post_objects as $post_object) {
                if (strpos($post_object['value'], 'storage/') === 0) {
                    $relativePath = substr($post_object['value'], 8);
                    if (Storage::exists($relativePath)) {
                        Storage::delete($relativePath);
                    }
                }
            }
            $post->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 500);
        }

        return response()->json('Удаление произошло успешно!', 200);
    }

    private function isFile($value)
    {
        return $value instanceof UploadedFile && $value->isValid();
    }

    private function uploadImage($file)
    {
        $destinationPath = 'storage/images/';
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        $uniqueName = pathinfo($originalName, PATHINFO_FILENAME) . '_' . time() . '.' . $extension;

        $file->move($destinationPath, $uniqueName);

        return $destinationPath . $uniqueName;
    }
}
