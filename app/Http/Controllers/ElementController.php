<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Element;
use Illuminate\Http\Request;

class ElementController extends Controller
{
    public function show_desktop($id = null)
    {
        if ($id == null) {
            $blocks = Block::query()
                ->with(['block_elements.element', 'block_elements.media_queries' => function ($query) {
                    $query->where('title', 'desktop')->with('style');
                }])
                ->get();
            return response()->json($blocks);
        } else {
            $block = Block::query()->with(['block_elements.element', 'block_elements.media_queries' => function ($query) {
                $query->where('title', 'desktop')->with('style');
            }])
                ->where('id', $id)
                ->first();
            return response()->json($block);
        }

    }

    public function show_tablet($id = null)
    {
        if ($id == null) {
            $blocks = Block::query()
                ->with(['block_elements.element', 'block_elements.media_queries' => function ($query) {
                    $query->where('title', 'tablet')->with('style');
                }])
                ->get();
            return response()->json($blocks);
        } else {
            $block = Block::query()
                ->with(['block_elements.element', 'block_elements.media_queries' => function ($query) {
                    $query->where('title', 'tablet')->with('style');
                }])
                ->where('id', $id)
                ->first();
            return response()->json($block);
        }

    }

    public function show_mobile($id = null)
    {
        if ($id == null) {
            $blocks = Block::query()
                ->with(['block_elements.element', 'block_elements.media_queries' => function ($query) {
                    $query->where('title', 'mobile')->with('style');
                }])
                ->get();
            return response()->json($blocks);
        } else {
            $block = Block::query()
                ->with(['block_elements.element', 'block_elements.media_queries' => function ($query) {
                    $query->where('title', 'mobile')->with('style');
                }])
                ->where('id', $id)
                ->first();
            return response()->json($block);
        }

    }
}
