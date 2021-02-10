<?php

use Carbon\Carbon;
use Defuse\Crypto\Crypto;

class Secret {
    public $id, $expireTime, $expired, $smallid;
    private $password, $content, $verifiedPassword;

    public function __construct($data) {
        $this->id = $data['id'];
        $this->content = $data['content'];
        $this->password = $data['passphrase'];
        $this->smallid = hash('crc32', $this->id, false);

        $createdAt = Carbon::parse($data['created_at']);
        $this->expireTime = $createdAt->clone()->addDays(7);
        $this->expired = $this->expireTime->isPast();
    }

    public function hasPassword() {
        return !empty($this->password);
    }

    public function verifyPassword($password) {
        if (!$this->hasPassword()) return true;

        $this->verifiedPassword = $password;
        return password_verify($password, $this->password);
    }

    public function getContent() {
        if ($this->hasPassword()) {
            return Crypto::decryptWithPassword($this->content, $this->verifiedPassword);
        }

        return $this->content;
    }

    public function viewUrl() {
        return "{$this->websiteUrl()}/secret?secret={$this->id}";
    }

    public function deleteUrl() {
        return "{$this->websiteUrl()}/delete?secret={$this->id}";
    }

    public function privateUrl() {
        return "{$this->websiteUrl()}/private?secret={$this->id}";
    }

    private static function websiteUrl() {
        return "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s" : "") . "://" . $_SERVER['HTTP_HOST'];
    }
}
