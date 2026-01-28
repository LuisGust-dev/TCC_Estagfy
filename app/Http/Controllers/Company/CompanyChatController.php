<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CompanyChatController extends Controller
{
    /**
     * 📌 Lista de conversas da empresa
     * Agrupa por VAGA + ALUNO
     */
    public function index()
{
    $companyId = Auth::user()->company->id;

    $conversations = Message::where('company_id', $companyId)
        ->with(['student', 'job'])
        ->orderBy('created_at', 'desc')
        ->get()
        ->groupBy(fn ($msg) => $msg->job_id . '-' . $msg->student_id);

    return view('company.chat.index', [
        'conversations' => $conversations,
        'job' => null,
        'student' => null,
        'messages' => collect(),
    ]);
}

    /**
     * 💬 Abre uma conversa específica
     */
    public function show($jobId, $studentId)
{
    $companyId = Auth::user()->company->id;

    $job = Job::where('id', $jobId)
        ->where('company_id', $companyId)
        ->firstOrFail();

    $student = User::where('id', $studentId)
        ->where('role', 'student')
        ->firstOrFail();

    $messages = Message::where('job_id', $jobId)
        ->where('student_id', $studentId)
        ->where('company_id', $companyId)
        ->orderBy('created_at')
        ->get();

    // 🔹 REBUSCA AS CONVERSAS (lado esquerdo)
    $conversations = Message::where('company_id', $companyId)
        ->with(['student', 'job'])
        ->orderBy('created_at', 'desc')
        ->get()
        ->groupBy(fn ($msg) => $msg->job_id . '-' . $msg->student_id);

    return view('company.chat.index', compact(
        'conversations',
        'job',
        'student',
        'messages'
    ));
}
 /**
     * ✉️ Enviar mensagem da empresa para o aluno
     */
    public function send($jobId, $studentId)
    {
        Message::create([
            'job_id'     => $jobId,
            'student_id' => $studentId,
            'company_id' => Auth::user()->company->id,
            'sender_id'  => Auth::id(),
            'message'    => request('message'),
        ]);

        return back();
    }
}
