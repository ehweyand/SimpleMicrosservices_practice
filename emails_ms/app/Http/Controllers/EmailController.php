<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function enviarEmail(Request $request)
    {
        $assunto = $request->input('assunto');
        $mensagem = $request->input('mensagem');
        $destinatario = $request->input('destinatario');

        $dados = [
            'assunto' => $assunto,
            'mensagem' => $mensagem,
            'destinatario' => $destinatario
        ];

        Mail::send('emails.novo-email', $dados, function($mensagem) use ($destinatario, $assunto) {
            $mensagem->from(env('MAIL_USERNAME'), 'Tigre Eventos');
            $mensagem->to($destinatario)->subject($assunto);
        });

        return response()->json(['mensagem' => 'E-mail enviado com sucesso!'], 200);
    }
}
