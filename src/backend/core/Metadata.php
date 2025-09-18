<?php
namespace app\core;

class Metadata {
    public string $link;
    public string $status;
    public string $message;
    public int $exit_code;

    public function __construct(string $link = '', string $status = 'ok', string $message = '', int $exit_code = 0) {
        $this->link = $link;
        $this->status = $status;
        $this->message = $message;
        $this->exit_code = $exit_code;
    }

    public static function success(string $link = ''): Metadata {
        return new Metadata($link, 'success');
    }
    
    public static function failure(string $message, int $exit_code = 1, string $link = ''): Metadata {
        return new Metadata($link, 'failure', $message, $exit_code);
    }
    /**
     * @return array<string,mixed>
     */
    public function toArray(): array {
        return [
            'link' => $this->link,
            'status' => $this->status,
            'message' => $this->message,
            'exit_code' => $this->exit_code
        ];
    }
}

// TODO: rename to Context
?>

