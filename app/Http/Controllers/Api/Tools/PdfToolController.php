<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Tools;

use App\Http\Controllers\Controller;
use App\Models\Tools\Tool;
use App\Models\Tools\ToolUsage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PdfToolController extends Controller
{
    public function compress(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'file_path' => ['required', 'string', 'max:500'],
            'quality' => ['nullable', 'integer', 'min:10', 'max:100'],
        ]);

        $tool = Tool::query()->firstOrCreate([
            'slug' => 'pdf-compressor',
        ], [
            'name' => 'PDF Compressor',
            'tool_type' => 'pdf',
            'settings' => ['driver' => 'ghostscript'],
            'is_active' => true,
        ]);

        // ✅ UPDATED: processing stub for queue-based ghostscript compression integration.
        $outputPath = 'compressed/' . basename($validated['file_path']);

        ToolUsage::query()->create([
            'user_id' => $request->user()?->id,
            'tool_id' => $tool->id,
            'input_meta' => $validated,
            'output_meta' => ['output_path' => $outputPath, 'status' => 'queued'],
            'credits_used' => 1,
        ]);

        return response()->json(['status' => 'queued', 'output_path' => $outputPath]);
    }
}
