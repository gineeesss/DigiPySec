<?php

namespace App\Livewire;

use Livewire\Component;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class Chatbot extends Component
{
    public $messages = [];
    public $userInput = '';
    public $isLoading = false;

    // Servicios de tu empresa (puedes cargarlos de la base de datos)
    protected $services = [
        'Digitalización de documentos',
        'Auditoría de seguridad informática',
        'Pentesting',
        'Cumplimiento normativo',
        'Consultoría en ciberseguridad'
    ];

    protected function getBasePrompt()
    {
        return "Eres un asistente virtual de una empresa especializada en digitalización de documentos y auditorías de ciberseguridad.
                Nuestros servicios principales son: " . implode(', ', $this->services) . ".
                Responde de manera profesional y técnica cuando sea necesario.
                Si el cliente pregunta por servicios no ofrecidos, recomienda alguno de nuestros servicios relacionados.
                Mantén las respuestas concisas pero informativas.
                Pregunta actual: ";
    }

    public function sendMessage()
    {
        if (empty($this->userInput)) return;

        $this->isLoading = true;

        // Agregar mensaje del usuario
        $this->messages[] = [
            'role' => 'user',
            'content' => $this->userInput
        ];

        $userInput = $this->userInput;
        $this->userInput = '';

        try {
            $client = new Client();

            $response = $client->post('https://api.deepseek.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('DEEPSEEK_API_KEY'),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'deepseek-chat',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => $this->getBasePrompt()
                        ],
                        [
                            'role' => 'user',
                            'content' => $userInput
                        ]
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 500
                ]
            ]);

            $responseData = json_decode($response->getBody(), true);
            $aiResponse = $responseData['choices'][0]['message']['content'];

            $this->messages[] = [
                'role' => 'assistant',
                'content' => $aiResponse
            ];

        } catch (\Exception $e) {
            $this->messages[] = [
                'role' => 'assistant',
                'content' => 'Lo siento, hubo un error al procesar tu solicitud. Por favor, inténtalo de nuevo más tarde.'
            ];
        }

        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.chatbot');
    }
}
