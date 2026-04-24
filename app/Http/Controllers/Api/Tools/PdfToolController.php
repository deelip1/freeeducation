<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Tools;

use App\Http\Controllers\Controller;
use App\Models\Tools\ToolUsage;
use App\Modules\Tools\Services\ToolsEngineService;
use App\Models\Tools\Tool;
use App\Models\Tools\ToolUsage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PdfToolController extends Controller
{
    public function __construct(private readonly ToolsEngineService $tools)
    {
    }

    public function compress(Request $request): JsonResponse
    {
        $validated = $request->validate([
            // ✅ UPDATED: secure upload validation instead of raw file path.
            'file' => ['required', 'file', 'mimes:pdf', 'max:' . ((int) config('freeeducation.tools.max_upload_mb', 20) * 1024)],
            'quality' => ['nullable', 'integer', 'min:10', 'max:100'],
        ]);

        $tool = $this->tools->getOrCreateTool(
            'pdf-compressor',
            'PDF Compressor',
            'pdf',
            ['driver' => config('freeeducation.tools.pdf_compressor_driver', 'ghostscript')]
        );

        $stored = $validated['file']->store('tools/pdf/input', 'local');
        $outputPath = 'tools/pdf/output/' . basename($stored);
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
            'input_meta' => ['stored' => $stored, 'quality' => $validated['quality'] ?? null],
            'input_meta' => $validated,
            'output_meta' => ['output_path' => $outputPath, 'status' => 'queued'],
            'credits_used' => 1,
        ]);

        return response()->json(['status' => 'queued', 'output_path' => $outputPath]);
    }
}
