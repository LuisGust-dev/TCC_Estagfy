<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Message;
use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CompanyChatController extends Controller
{
    /**
     * 📌 Lista de conversas da empresa
     * Agrupa por VAGA + ALUNO
     */
    public function index()
{
    $companyUserId = Auth::id();

    $conversations = Message::where('company_id', $companyUserId)
        ->with(['student', 'job'])
        ->orderBy('created_at', 'desc')
        ->get()
        ->groupBy(fn ($msg) => $msg->job_id . '-' . $msg->student_id);

    return view('company.chat.index', [
        'conversations' => $conversations,
        'job' => null,
        'student' => null,
        'messages' => collect(),
        'canSendMessage' => false,
    ]);
}

    /**
     * 💬 Abre uma conversa específica
     */
public function show($jobId, $studentId)
{
    $companyProfileId = Auth::user()->company->id;
    $companyUserId = Auth::id();

    $job = Job::where('id', $jobId)
        ->where('company_id', $companyProfileId)
        ->firstOrFail();

    $student = User::where('id', $studentId)
        ->where('role', 'student')
        ->firstOrFail();
    $application = Application::where('job_id', $jobId)
        ->where('student_id', $studentId)
        ->first();
    $canSendMessage = $application?->status === 'aprovado';

    $messages = Message::where('job_id', $jobId)
        ->where('student_id', $studentId)
        ->where('company_id', $companyUserId)
        ->orderBy('created_at')
        ->get();

    Message::where('job_id', $jobId)
        ->where('student_id', $studentId)
        ->where('company_id', $companyUserId)
        ->where('sender_id', '!=', Auth::id())
        ->whereNull('read_at')
        ->update(['read_at' => now()]);

    // 🔹 REBUSCA AS CONVERSAS (lado esquerdo)
    $conversations = Message::where('company_id', $companyUserId)
        ->with(['student', 'job'])
        ->orderBy('created_at', 'desc')
        ->get()
        ->groupBy(fn ($msg) => $msg->job_id . '-' . $msg->student_id);

    return view('company.chat.index', compact(
        'conversations',
        'job',
        'student',
        'messages',
        'canSendMessage'
    ));
}
 /**
     * ✉️ Enviar mensagem da empresa para o aluno
     */
    public function send($jobId, $studentId)
    {
        $companyProfileId = Auth::user()->company->id;

        Job::where('id', $jobId)
            ->where('company_id', $companyProfileId)
            ->firstOrFail();

        request()->validate([
            'message' => 'required|string|max:2000',
        ]);

        $application = Application::where('job_id', $jobId)
            ->where('student_id', $studentId)
            ->first();

        if (! $application) {
            return back()->with('error', 'Candidatura não encontrada para esta conversa.');
        }

        if ($application->status === 'finalizado') {
            return back()->with('error', 'Estágio finalizado: o chat está em modo somente leitura.');
        }

        if ($application->status !== 'aprovado') {
            return back()->with('error', 'Só é possível enviar mensagens durante o estágio em andamento.');
        }

        Message::create([
            'job_id'     => $jobId,
            'student_id' => $studentId,
            'company_id' => Auth::id(),
            'sender_id'  => Auth::id(),
            'message'    => request('message'),
        ]);

        return back();
    }

    /**
     * 🔄 Polling para buscar novas mensagens (empresa)
     */
    public function poll(Request $request, $jobId, $studentId)
    {
        $companyUserId = Auth::id();
        $currentUserId = Auth::id();
        $lastId = (int) $request->query('last_id', 0);

        $messages = Message::where('job_id', $jobId)
            ->where('student_id', $studentId)
            ->where('company_id', $companyUserId)
            ->when($lastId > 0, function ($query) use ($lastId) {
                $query->where('id', '>', $lastId);
            })
            ->orderBy('created_at')
            ->get();

        $messages->where('sender_id', '!=', $currentUserId)
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
