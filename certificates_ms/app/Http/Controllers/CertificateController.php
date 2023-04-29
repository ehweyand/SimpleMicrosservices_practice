<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Event;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Dompdf\Dompdf;

class CertificateController extends Controller
{
    /**
     * Generate the certificate.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function store(Request $request)
    {
        // Cria um novo certificado com base nos dados enviados pelo usuário
        $certificate = new Certificate();
        $certificate->users_id = $request->input('users_id');
        $certificate->events_id = $request->input('events_id');
        $certificate->emission_date = now();
        $certificate->auth_code = uniqid();

        // Gera o arquivo do certificado
        $certificateFile = $this->generateCertificate($certificate);

        $certificate->save();

        // Chama o serviço de enviar email para enviar o email com o guzzle
        $client = new Client([
            'base_uri' => 'http://localhost:8001/',
        ]);

        $headers = [
            'Authorization' => 'Bearer ' . $request->bearerToken(),
        ];

        $response = $client->post('api/enviar-email', [
            'headers' => $headers,
            'form_params' => [
                'assunto' => 'Novo certificado emitido',
                'mensagem' => 'Um novo certificado foi emitido para o evento ' . $certificate->event->description,
                'destinatario' => $certificate->user->email,
            ]
        ]);

        // Retorna o arquivo como resposta da requisição
        return response()->download($certificateFile, 'certificate.pdf');
    }

    /**
     * Generate the certificate and returns it.
     *
     * @param Certificate $certificate
     * @return false|string
     */
    private function generateCertificate(Certificate $certificate)
    {
        $user = User::findOrFail($certificate->users_id);
        $event = Event::findOrFail($certificate->events_id);

        // Renderiza o HTML do certificado usando uma view
        $html = view('certificate', [
            'user' => $user,
            'event' => $event,
            'emission_date' => $certificate->emission_date,
            'auth_code' => $certificate->auth_code,
        ])->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();

        // Obtém o conteúdo do PDF do certificado
        $pdfContent = $dompdf->output();

        // Salva o PDF do certificado em um arquivo temporário
        $certificateFile = tempnam(sys_get_temp_dir(), 'certificate');
        file_put_contents($certificateFile, $pdfContent);
        // Retorna o caminho completo do arquivo do certificado
        return $certificateFile;
    }

    public function authenticateCertificate(Request $request)
    {
        $auth_code = $request->input('auth_code');
        $certificate = Certificate::with(['event', 'user'])->where('auth_code', $auth_code)->first();

        if ($certificate) {
            return response()->json([
                'message' => 'Certificado autenticado com sucesso!',
                'certificate' => [
                    'event_description' => $certificate->event->description,
                    'user_name' => $certificate->user->name,
                    'emission_date' => $certificate->emission_date,
                    'auth_code' => $certificate->auth_code,
                ]
            ], 200);
        } else {
            return response()->json([
                'message' => 'Certificado não encontrado ou código inválido!',
            ], 404);
        }
    }
    public function authenticateCertificatePage(Request $request, $auth = null) {
        $certificate = Certificate::with(['event', 'user'])->where('auth_code', $auth)->first();
        if($certificate == null) {
            return view('certificate-validation-failed');
        }
        return view('certificate-validation', compact('certificate'));
    }
}
