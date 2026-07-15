<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\MessageRecipient;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::whereHas('recipients', function ($query) {
            $query->where('recipient_id', auth()->id());
        })
            ->with(['sender', 'recipients' => function ($query) {
                $query->where('recipient_id', auth()->id());
            }])
            ->latest()
            ->paginate(20);

        return view('messages.index', compact('messages'));
    }

    public function sent()
    {
        $messages = Message::where('sender_id', auth()->id())
            ->with('recipients.recipient')
            ->latest()
            ->paginate(20);

        return view('messages.sent', compact('messages'));
    }

    public function create()
    {
        $users = User::where('id', '!=', auth()->id())
            ->where('school_id', auth()->user()->school_id)
            ->orderBy('name')
            ->get()
            ->groupBy(function ($user) {
                $roles = $user->getRoleNames();
                if ($roles->contains('admin_ecole')) return 'Administrateurs';
                if ($roles->contains('enseignant')) return 'Enseignants';
                if ($roles->contains('secretaire')) return 'Secretaires';
                if ($roles->contains('parent')) return 'Parents';
                return 'Autres';
            });

        return view('messages.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipient_type' => 'required|in:individual,role',
            'recipients' => 'required_if:recipient_type,individual|array',
            'recipients.*' => 'exists:users,id',
            'role' => 'required_if:recipient_type,role|in:admin_ecole,enseignant,secretaire,parent',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $message = Message::create([
            'school_id' => auth()->user()->school_id,
            'sender_id' => auth()->id(),
            'subject' => $validated['subject'],
            'body' => $validated['body'],
            'is_broadcast' => $validated['recipient_type'] === 'role',
        ]);

        if ($validated['recipient_type'] === 'individual') {
            foreach ($validated['recipients'] as $recipientId) {
                MessageRecipient::create([
                    'message_id' => $message->id,
                    'recipient_id' => $recipientId,
                ]);
            }
        } else {
            $roleUsers = User::where('school_id', auth()->user()->school_id)
                ->where('id', '!=', auth()->id())
                ->role($validated['role'])
                ->get();

            foreach ($roleUsers as $user) {
                MessageRecipient::create([
                    'message_id' => $message->id,
                    'recipient_id' => $user->id,
                ]);
            }
        }

        return redirect()->route('messages.index')
            ->with('success', 'Message envoyé avec succès.');
    }

    public function show(Message $message)
    {
        $user = auth()->user();

        // Vérifier que l'utilisateur est l'expéditeur ou un destinataire
        $isRecipient = $message->recipients()->where('recipient_id', $user->id)->exists();
        $isSender = $message->sender_id === $user->id;

        if (!$isRecipient && !$isSender) {
            abort(403);
        }

        // Marquer comme lu si c'est un destinataire
        if ($isRecipient) {
            $message->recipients()
                ->where('recipient_id', $user->id)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
        }

        $message->load(['sender', 'recipients.recipient']);

        return view('messages.show', compact('message', 'isSender'));
    }

    public function destroy(Message $message)
    {
        $user = auth()->user();

        if ($message->sender_id === $user->id) {
            $message->delete();
        } else {
            // Supprimer uniquement l'entrée recipient pour cet utilisateur
            $message->recipients()->where('recipient_id', $user->id)->delete();
        }

        return redirect()->route('messages.index')
            ->with('success', 'Message supprimé.');
    }
}
