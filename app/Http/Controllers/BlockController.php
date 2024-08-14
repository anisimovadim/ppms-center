<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\BlockElement;
use App\Models\Element;
use App\Models\MediaQuery;
use App\Models\Style;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BlockController extends Controller
{
    public function destroy($id){
        DB::transaction(function() use ($id) {
            $block = Block::findOrFail($id);
            $images = [];
            $blockElements = $block->block_elements;
            $elementIds = [];
            $mediaQueryIds = [];
            $styleIds = [];

            foreach ($blockElements as $blockElement) {
                $element = $blockElement->element;

                if ($element->type == 'img') {
                    $images[] = $element->value;
                }

                foreach ($blockElement->media_queries as $mediaQuery) {
                    $mediaQueryIds[] = $mediaQuery->id;
                    $styleIds[] = $mediaQuery->style_id;
                }

                $elementIds[] = $element->id;
            }
            Style::whereIn('id', $styleIds)->delete();
            MediaQuery::whereIn('id', $mediaQueryIds)->delete();
            Element::whereIn('id', $elementIds)->delete();

            $this->deleteUploadedFiles($images);

            $block->delete();
        });
    }
    public function create(Request $request){
        $blocksData = $request->items;
        $uploadedFiles = [];
        DB::beginTransaction();
        try {
            $block = Block::create([
                'title' => $request->titleBlock
            ]);
            foreach ($blocksData as $blockData){
                if ($blockData['element']['type']=='img' && $blockData['element']['value2']){
                    $element = Element::create([
                        'type' => $blockData['element']['type'],
                        'value' => $this->uploadFile($blockData['element']['value2'], $uploadedFiles)
                    ]);
                }else{
                    $element = Element::create([
                        'type' => $blockData['element']['type'],
                        'value' => $blockData['element']['value']
                    ]);
                }
                $blockElement = BlockElement::create([
                    'block_id'=>$block->id,
                    'element_id'=>$element->id
                ]);
                foreach ($blockData['media_queries'] as $mediaQueryData){
                    $classes = '';
                    if (isset($mediaQueryData['style']['classes']) && is_array($mediaQueryData['style']['classes'])){
                        $classes=implode(' ', $mediaQueryData['style']['classes']);
                    }
                    $style = Style::create([
                        'top'=>$mediaQueryData['style']['top'],
                        'left'=>$mediaQueryData['style']['left'],
                        'size'=>$mediaQueryData['style']['size'],
                        'width'=>$mediaQueryData['style']['width'],
                        'classes'=>$classes
                    ]);
                    MediaQuery::create([
                        'title'=>$mediaQueryData['title'],
                        'block_element_id'=>$blockElement->id,
                        'style_id'=>$style->id,
                    ]);
                }
            }
            DB::commit();
            return response()->json(['message'=>'Новость успешно создана'], 200);
        }
        catch (\Exception $e){
            DB::rollBack();
            $this->deleteUploadedFiles($uploadedFiles);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    private function uploadFile($file, &$uploadedFiles){
        $filePath = 'storage/images/' . $file->getClientOriginalName();
        $file->move('storage/images/', $file->getClientOriginalName());
        $uploadedFiles[] = $filePath;
        return $filePath;
    }
    private function deleteUploadedFiles($files)
    {
        if (is_array($files)){
            foreach ($files as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }
        else{
            if (file_exists($files)) {
                unlink($files);
            }
        }

    }
}
