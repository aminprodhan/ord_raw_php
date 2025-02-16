<?php
class JsonResponse
{
    //send with cookie
    public static function sendWithCookie(int $statusCode = 200, array $data = []){
        // Set the Content-Type to application/json
        header('Content-Type: application/json');
        setcookie(
            $data['cookie_name'],
            $data['cookie_value'], 
            $data['cookie_expire'], 
            $data['cookie_path'], 
            $data['cookie_domain'], 
            $data['cookie_secure'],
            $data['cookie_httponly']
        );
        // Set the HTTP status code
        http_response_code($statusCode);
        // Send the JSON-encoded response
        echo json_encode($data['data'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        // Exit to prevent further output
        exit;
    }
    /**
     * Send a JSON response.
     *
     * @param int $statusCode HTTP status code
     * @param array $data The data to send
     * @return void
     */
    public static function send(int $statusCode = 200, array $data = [])
    {
        // Set the Content-Type to application/json
        header('Content-Type: application/json');
        // Set the HTTP status code
        http_response_code($statusCode);
        // Send the JSON-encoded response
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        // Exit to prevent further output
        exit;
    }

    /**
     * Send a success response.
     *
     * @param array $data The data to send
     * @param string $message Success message
     * @return void
     */
    public static function success(array $data = [], string $message = 'Success')
    {
        self::send(200, [
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ]);
    }

    /**
     * Send an error response.
     *
     * @param string $message Error message
     * @param int $statusCode HTTP status code
     * @param array $errors Optional detailed errors
     * @return void
     */
    public static function error(string $message, int $statusCode = 400, array $errors = [])
    {
        self::send($statusCode, [
            'status' => 'error',
            'message' => $message,
            'errors' => $errors
        ]);
    }
}

