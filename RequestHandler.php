<?php
class RequestHandler {
    public static function getPostData($fields) {
        $data = [];
        foreach ($fields as $field) {
            $data[$field] = isset($_POST[$field]) ? trim($_POST[$field]) : null;
        }
        return $data;
    }
}