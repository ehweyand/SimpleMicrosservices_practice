<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use App\Models\Subscription;


class EventController extends Controller
{

    public function index()
    {
        $events = Event::all();
        return response()->json($events);
    }

    public function subscriptionsByUser($id) {
        $subscriptions = Subscription::where('users_id', $id)->get();
        if(!$subscriptions->isEmpty()) {
            return response()->json($subscriptions);
        } else {
            return response()->json(['message' => 'No subscription found.'], 404);
        }
    }

    public function store(Request $request)
    {
        $event = new Event();
        $event->description = $request->description;
        $event->event_date = $request->event_date;
        $event->save();
        return response()->json(['id' => $event->id] + $event->toArray(), 201);
    }

    public function show($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return response()->json(['message' => 'Event not found.'], 404);
        }
        return response()->json($event);
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->description = $request->description;
        $event->event_date = $request->event_date;
        $event->save();
        return response()->json($event);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return response()->json(null, 204);
    }

    public function signUpInEvent(Request $request, $eventId) {
        $userId = $request->input('user_id');

        $user = User::find($userId);
        $event = Event::find($eventId);
        if (!$user || !$event) {
            return response()->json(['message' => 'User or event not found.'], 404);
        }

        // Verifique se o usuário já está inscrito no evento
        $subscription = Subscription::where('users_id', $userId)->where('events_id', $eventId)->first();
        if ($subscription) {
            return response()->json(['message' => 'User is already subscribed to this event.'], 400);
        }

        // Crie uma nova inscrição e salva no banco de dados
        $subscription = new Subscription();
        $subscription->users_id = $userId;
        $subscription->events_id = $eventId;
        $subscription->attendance = false; // O usuário ainda não confirmou presença
        $subscription->save();

        return response()->json($subscription, 201);
    }

    // falta testar
    public function removeSubscription(Request $request, $eventId) {
        $userId = $request->input('user_id');

        $user = User::find($userId);
        $event = Event::find($eventId);
        if (!$user || !$event) {
            return response()->json(['message' => 'User or event not found.'], 404);
        }

        // Verifique se o usuário já está inscrito no evento
        $subscription = Subscription::where('users_id', $userId)->where('events_id', $eventId)->first();

        if (!$subscription) {
            return response()->json(['message' => 'User is not subscribed to this event.'], 400);
        }
        $subscription->delete();

        return response()->json(['message' => 'User unsigned successfully from event.'], 200);
    }


    public function markAttendance(Request $request)
    {
        $subscription = Subscription::with('user')->with('event')->where('users_id', $request->user_id)
            ->where('events_id', $request->event_id)->first();

        if(!$subscription) {
            return response()->json(['message' => 'Subscription not found.'], 404);
        }

        $subscription->attendance = true;
        $subscription->save();

        // Chama o serviço de enviar email para enviar o email com o guzzle
        $headers = [
            'Authorization' => 'Bearer ' . $request->bearerToken(),
        ];

        $client = new Client([
            'base_uri' => 'http://localhost:8001/',
        ]);
        $response = $client->post('api/enviar-email', [
            'headers' => $headers,
            'form_params' => [
                'assunto' => 'Presença confirmada!',
                'mensagem' => 'Sua presença foi confirmada no evento ' . $subscription->event->description,
                'destinatario' => $subscription->user->email,
            ]
        ]);

        return response()->json(['message' => 'Attendance marked successfully.']);
    }
}
