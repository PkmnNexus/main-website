<?php

namespace App\Services;

use App\Models\VideoScript;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VideoScriptPdfService
{
    public function download(VideoScript $script): StreamedResponse
    {
        $script->loadMissing('category');

        $platformLabels = collect($script->platforms ?? [])
            ->map(fn (string $platform) => match ($platform) {
                'youtube' => 'YouTube',
                'youtube_shorts' => 'YouTube Shorts',
                'tiktok' => 'TikTok',
                default => $platform,
            })
            ->values()
            ->all();

        $pdf = Pdf::loadView('pdf.video-scripts.show', [
            'script' => $script,
            'platformLabels' => $platformLabels,
            'estimatedDuration' => $this->formatDuration(
                $script->estimated_duration
            ),
        ])->setPaper('a4', 'portrait');

        // Render the PDF before adding the page numbers.
        $dompdf = $pdf->getDomPDF();
        $dompdf->render();

        $canvas = $dompdf->getCanvas();

        $font = $dompdf->getFontMetrics()->getFont(
            'DejaVu Sans',
            'normal'
        );

        $canvas->page_text(
            $canvas->get_width() - 125,
            $canvas->get_height() - 35,
            'Page {PAGE_NUM} of {PAGE_COUNT}',
            $font,
            8,
            [0.545, 0.58, 0.647]
        );

        $filename = 'pkmnnexus-script-' . Str::slug($script->title) . '.pdf';

        return response()->streamDownload(
            function () use ($pdf): void {
                echo $pdf->output();
            },
            $filename,
            [
                'Content-Type' => 'application/pdf',
            ],
        );
    }

    protected function formatDuration(?int $seconds): string
    {
        if (! $seconds) {
            return '-';
        }

        return sprintf(
            '%d:%02d',
            intdiv($seconds, 60),
            $seconds % 60
        );
    }
}