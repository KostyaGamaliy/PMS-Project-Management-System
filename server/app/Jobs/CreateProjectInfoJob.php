<?php

namespace App\Jobs;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Pusher\Pusher;
use Pusher\PusherException;

class CreateProjectInfoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function handle(): void
    {
        $pdf = app()->make('dompdf.wrapper');
        $pdf->loadView('pdf.test', ['project' => $this->project]);
        $pdfContent = $pdf->output();
        Storage::put("projects/project_report_{$this->project->id}.pdf", $pdfContent);

        $pusher = new Pusher('0ef8d31fe818b7949d4b', 'd6d3d4062d73d899ced9', '1601138', [
            'cluster' => 'eu',
        ]);

        $pusher->trigger('pms', 'pdf-ready', ['pdf_url' => $this->project->getPdfPath]);
    }
}
