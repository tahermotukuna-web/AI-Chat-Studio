<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$request = json_decode(file_get_contents('php://input'), true);

if (!isset($request['model']) || !isset($request['message']) || !isset($request['api_key'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required fields: model, message, api_key']);
    exit();
}

$model = sanitize_input($request['model']);
$message = sanitize_input($request['message']);
$api_key = $request['api_key'];
$chat_history = isset($request['history']) ? $request['history'] : [];

try {
    $response = match($model) {
        'gemini' => handle_gemini($message, $api_key, $chat_history),
        'claude' => handle_claude($message, $api_key, $chat_history),
        'gpt' => handle_gpt($message, $api_key, $chat_history),
        'deepseek' => handle_deepseek($message, $api_key, $chat_history),
        default => throw new Exception('Unknown AI model: ' . $model)
    };

    http_response_code(200);
    echo json_encode(['success' => true, 'response' => $response]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

/**
 * Handle Google Gemini API
 */
function handle_gemini($message, $api_key, $chat_history) {
    if (empty($api_key)) {
        throw new Exception('Gemini API key is required');
    }

    $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . urlencode($api_key);

    $contents = [];
    
    // Add chat history
    foreach ($chat_history as $msg) {
        $contents[] = [
            'role' => $msg['role'] === 'user' ? 'user' : 'model',
            'parts' => [['text' => $msg['content']]]
        ];
    }

    // Add current message
    $contents[] = [
        'role' => 'user',
        'parts' => [['text' => $message]]
    ];

    $payload = [
        'contents' => $contents,
        'generationConfig' => [
            'temperature' => 0.7,
            'maxOutputTokens' => 1024,
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code !== 200) {
        $error_data = json_decode($response, true);
        throw new Exception('Gemini API Error: ' . ($error_data['error']['message'] ?? 'Unknown error'));
    }

    $data = json_decode($response, true);
    
    if (!isset($data['candidates'][0]['content']['parts'][0]['text'])) {
        throw new Exception('Invalid response from Gemini API');
    }

    return $data['candidates'][0]['content']['parts'][0]['text'];
}

/**
 * Handle Anthropic Claude API
 */
function handle_claude($message, $api_key, $chat_history) {
    if (empty($api_key)) {
        throw new Exception('Claude API key is required');
    }

    $url = 'https://api.anthropic.com/v1/messages';

    $messages = [];
    foreach ($chat_history as $msg) {
        $messages[] = [
            'role' => $msg['role'],
            'content' => $msg['content']
        ];
    }

    $messages[] = [
        'role' => 'user',
        'content' => $message
    ];

    $payload = [
        'model' => 'claude-3-5-sonnet-20241022',
        'max_tokens' => 1024,
        'messages' => $messages,
        'temperature' => 0.7
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'x-api-key: ' . $api_key,
        'anthropic-version: 2023-06-01'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code !== 200) {
        $error_data = json_decode($response, true);
        throw new Exception('Claude API Error: ' . ($error_data['error']['message'] ?? 'Unknown error'));
    }

    $data = json_decode($response, true);

    if (!isset($data['content'][0]['text'])) {
        throw new Exception('Invalid response from Claude API');
    }

    return $data['content'][0]['text'];
}

/**
 * Handle OpenAI GPT API
 */
function handle_gpt($message, $api_key, $chat_history) {
    if (empty($api_key)) {
        throw new Exception('OpenAI API key is required');
    }

    $url = 'https://api.openai.com/v1/chat/completions';

    $messages = [];
    foreach ($chat_history as $msg) {
        $messages[] = [
            'role' => $msg['role'],
            'content' => $msg['content']
        ];
    }

    $messages[] = [
        'role' => 'user',
        'content' => $message
    ];

    $payload = [
        'model' => 'gpt-4-turbo',
        'messages' => $messages,
        'temperature' => 0.7,
        'max_tokens' => 1024
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $api_key
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code !== 200) {
        $error_data = json_decode($response, true);
        throw new Exception('OpenAI API Error: ' . ($error_data['error']['message'] ?? 'Unknown error'));
    }

    $data = json_decode($response, true);

    if (!isset($data['choices'][0]['message']['content'])) {
        throw new Exception('Invalid response from OpenAI API');
    }

    return $data['choices'][0]['message']['content'];
}

/**
 * Handle DeepSeek API
 */
function handle_deepseek($message, $api_key, $chat_history) {
    if (empty($api_key)) {
        throw new Exception('DeepSeek API key is required');
    }

    $url = 'https://api.deepseek.com/chat/completions';

    $messages = [];
    foreach ($chat_history as $msg) {
        $messages[] = [
            'role' => $msg['role'],
            'content' => $msg['content']
        ];
    }

    $messages[] = [
        'role' => 'user',
        'content' => $message
    ];

    $payload = [
        'model' => 'deepseek-chat',
        'messages' => $messages,
        'temperature' => 0.7,
        'max_tokens' => 1024
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $api_key
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code !== 200) {
        $error_data = json_decode($response, true);
        throw new Exception('DeepSeek API Error: ' . ($error_data['error']['message'] ?? 'Unknown error'));
    }

    $data = json_decode($response, true);

    if (!isset($data['choices'][0]['message']['content'])) {
        throw new Exception('Invalid response from DeepSeek API');
    }

    return $data['choices'][0]['message']['content'];
}

/**
 * Sanitize input
 */
function sanitize_input($input) {
    if (is_array($input)) {
        return array_map('sanitize_input', $input);
    }
    return trim(strip_tags($input));
}
?>
