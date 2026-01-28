<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
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
            ->with(['job.company'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('job_id');

        return view('student.chat.index', [
            'conversations' => $conversations,
            'job' => null,
            'company' => null,
            'messages' => collect(),
        ]);
    }

    /**
     * Exibe o chat do aluno com a empresa (vaga aprovada)
     */
    public function show(Job $job)
    {
        $studentId = auth()->id();

        // Buscar mensagens desse chat
        $messages = Message::where('job_id', $job->id)
            ->where('student_id', $studentId)
            ->orderBy('created_at')
            ->get();

        $conversations = Message::where('student_id', $studentId)
            ->with(['job.company'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('job_id');

        $company = $job->company;

        return view('student.chat.index', compact('conversations', 'job', 'company', 'messages'));
    }

    /**
     * Enviar mensagem (aluno)
     */
    public function send(Request $request, Job $job)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        Message::create([
            'job_id'     => $job->id,
            'student_id'=> auth()->id(),
            'company_id'=> $job->company_id,
            'sender_id' => auth()->id(),
            'message'   => $request->message,
        ]);

        return back();
    }
}
