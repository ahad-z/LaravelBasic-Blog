<?php

namespace App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CustomValidator
{
	public static function validate($request, $rules, $customMessages = null)
	{
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			$message = '';
			$errors = $validator->errors()->toArray();

			if ($customMessages != null) {
				foreach ($customMessages as $key => $customMessage) {
					$errors[$key][0] = $customMessage;
				}
			}

			foreach ($errors as $key => $msg) {
				$message .= str_replace(' id', '', $msg[0]) . '<br>';
			}

			return response()->json(['status' => false, 'message' => $message], 200);
		}

		return true;
	}
}


