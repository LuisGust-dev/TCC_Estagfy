<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use App\Models\Message;
use Illuminate\Http\Request;

class StudentChatController extends Controller
{
    /**
     * Lista conversas do aluno (vagas aprovadas)
     */
    public function index()
    {
        $studentId = auth()->id();

        $conversations = Message::where('student_id', $studentId)
            ->with(['job.company.user'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('job_id');

        return view('student.chat.index', [
            'conversations' => $conversations,
            'job' => null,
            'company' => null,
            'messages' => collect(),
            'canSendMessage' => false,
        ]);
    }

    /**
     * Exibe o chat do aluno com a empresa (vaga aprovada)
     */
    public function show(Job $job)
    {
        $studentId = auth()->id();
        $application = Application::where('job_id', $job->id)
            ->where('student_id', $studentId)
            ->first();
        $canSendMessage = $application?->status === 'aprovado';

        Message::where('job_id', $job->id)
            ->where('student_id', $studentId)
            ->where('sender_id', '!=', $studentId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        // Buscar mensagens desse chat
        $messages = Message::where('job_id', $job->id)
            ->where('student_id', $studentId)
            ->orderBy('created_at')
            ->get();

        $conversations = Message::where('student_id', $studentId)
            ->with(['job.company.user'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('job_id');

        $company = $job->company;

        return view('student.chat.index', compact('conversations', 'job', 'company', 'messages', 'canSendMessage'));
    }

    /**
     * Enviar mensagem (aluno)
     */
    public function send(Request $request, Job $job)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $application = Application::where('job_id', $job->id)
            ->where('student_id', auth()->id())
            ->first();

        if (! $application) {
            return back()->with('error', 'Candidatura não encontrada para esta vaga.');
        }

        if ($application->status === 'finalizado') {
            return back()->with('error', 'Estágio finalizado: o chat está em modo somente leitura.');
        }

        if ($application->status !== 'aprovado') {
            return back()->with('error', 'Só é possível enviar mensagens durante o estágio em andamento.');
        }

        $companyUserId = data_get($job, 'company.user.id');

        if (empty($companyUserId)) {
            return back()->with('error', 'Empresa da vaga não encontrada.');
        }

        Message::create([
            'job_id'     => $job->id,
            'student_id'=> auth()->id(),
            'company_id'=> $companyUserId,
            'sender_id' => auth()->id(),
            'message'   => $request->message,
        ]);

        return back();
    }

    /**
     * 🔄 Polling para buscar novas mensagens (aluno)
     */
    public function poll(Request $request, Job $job)
    {
        $studentId = auth()->id();
        $lastId = (int) $request->query('last_id', 0);

        $messages = Message::where('job_id', $job->id)
            ->where('student_id', $studentId)
            ->when($lastId > 0, function ($query) use ($lastId) {
                $query->where('id', '>', $lastId);
            })
            ->orderBy('created_at')
            ->get();

        $messages->where('sender_id', '!=', $studentId)
            ->whereNull('read_at')
            ->each(function ($message) {
                $message->update(['read_at' => now()]);
            });

        return response()->json([
            'messages' => $messages->map(function ($message) {
                return [
                    'id' => $message->id,
                    'sender_id' => $message->sender_id,
                    'message' => $message->message,
                    'time' => $message->created_at->format('H:i'),
                ];
            }),
        ]);
    }
}
