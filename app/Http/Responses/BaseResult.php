<?php
namespace App\Http\Responses;

class BaseResult {
	public $error = 0;
	public $message = '';
	public $data = null;

	public static function withData($data) {
		$instance = new self();
		$instance->data = $data;
		return (array)$instance;
	}

	public static function withJson($json) {
		return (array)$json;
	}

	public static function success($message) {
		$instance = new self();
		$instance->error = 0;
		$instance->message = $message;
		return (array)$instance;
	}

	public static function error($error, $message) {
		$instance = new self();
		$instance->error = $error;
		$instance->message = $message;
		return (array)$instance;
	}
}
